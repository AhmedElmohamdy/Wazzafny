<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Services\ResumesAnalysis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Cloudinary\Cloudinary;

class JobVacanciesController extends Controller
{
    protected $resumeAnalyzer;
    protected $cloudinary;

    public function __construct(ResumesAnalysis $resumeAnalyzer)
    {
        $this->resumeAnalyzer = $resumeAnalyzer;

        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key'    => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true]
        ]);
    }

    public function show($id)
    {
        $jobVacancy = JobVacancy::with('company')->findOrFail($id);
        return view('Job-Vacancies.Details', compact('jobVacancy'));
    }

    public function apply($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('Job-Vacancies.Apply', compact('jobVacancy'));
    }

    public function store(Request $request, string $id)
    {
        $request->validate([
            'resume_file' => 'required|mimes:pdf|max:5120',
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);

        $file = $request->file('resume_file');
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $publicId = 'resumes/' . $originalFileName . '_' . time();

        $tempPath = sys_get_temp_dir() . '/' . $originalFileName . '_' . time() . '.pdf';
        copy($file->getRealPath(), $tempPath);

        try {
            
            // STEP 1: Upload Resume to Cloudinary
            $uploadResult = $this->cloudinary->uploadApi()->upload(
                $tempPath,
                [
                    'public_id' => $publicId,
                    'resource_type' => 'image',
                    'access_mode' => 'public',
                    'type' => 'upload'
                ]
            );

            @unlink($tempPath);

            $cloudinaryPublicId = $uploadResult['public_id'];
            $fileUrl = $uploadResult['secure_url'] ?? $uploadResult['url'];

            Log::info('Resume uploaded to Cloudinary', [
                'user_id'   => Auth::id(),
                'job_id'    => $id,
                'file_url'  => $fileUrl,
                'public_id' => $cloudinaryPublicId
            ]);

            // STEP 2: AI Analysis + Job Matching
            $aiResult = $this->resumeAnalyzer->analyzeAndMatchResume($fileUrl, $jobVacancy);

            if (!$aiResult) {
                Log::warning('AI analysis returned null', ['file_url' => $fileUrl]);
                // Fallback values
                $aiResult = [
                    'summary'    => '',
                    'skills'     => [],
                    'experience' => [],
                    'education'  => [],
                    'score'      => 0,
                    'feedback'   => 'Unable to generate analysis at this time.',
                ];
            }

            // STEP 3: Save Resume with AI Analysis
            DB::beginTransaction();

            $resume = Resume::where('user_id', Auth::id())->first();

            if ($resume) {
                $resume->update([
                    'file_name'            => $originalFileName,
                    'file_url'             => $fileUrl,
                    'cloudinary_public_id' => $cloudinaryPublicId,
                    'summary'              => $aiResult['summary'] ?? '',
                    'skills'               => $aiResult['skills'] ?? [],
                    'experience'           => $aiResult['experience'] ?? [],
                    'education'            => $aiResult['education'] ?? [],
                ]);
            } else {
                $resume = Resume::create([
                    'user_id'              => Auth::id(),
                    'file_name'            => $originalFileName,
                    'file_url'             => $fileUrl,
                    'cloudinary_public_id' => $cloudinaryPublicId,
                    'contact_info'         => [
                        'email' => Auth::user()->email,
                        'name'  => Auth::user()->name,
                    ],
                    'summary'              => $aiResult['summary'] ?? '',
                    'skills'               => $aiResult['skills'] ?? [],
                    'experience'           => $aiResult['experience'] ?? [],
                    'education'            => $aiResult['education'] ?? [],
                ]);
            }

            // STEP 4: Create Job Application with AI Score
            $application = JobApplication::create([
                'user_id'             => Auth::id(),
                'job_vacancy_id'      => $id,
                'resume_id'           => $resume->id,
                'cover_letter'        => $request->input('cover_letter'),
                'status'              => 'pending',
                'aiGeneratedScore'    => $aiResult['score'] ?? 0,
                'aigeneratedFeedback' => $aiResult['feedback'] ?? '',
            ]);

            DB::commit();

            Log::info('Job application submitted successfully', [
                'application_id' => $application->id,
                'user_id'        => Auth::id(),
                'job_id'         => $id,
                'ai_score'       => $aiResult['score'] ?? 0,
            ]);

            return redirect()
                ->route('Job-Application.index', $id)
                ->with('success', 'Your application has been submitted successfully! ');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Job application submission failed', [
                'user_id' => Auth::id(),
                'job_id'  => $id,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            if (isset($cloudinaryPublicId)) {
                try {
                    $this->cloudinary->uploadApi()->destroy($cloudinaryPublicId, ['resource_type' => 'image']);
                } catch (\Exception $deleteException) {
                    Log::error('Failed to delete uploaded file during cleanup', [
                        'public_id' => $cloudinaryPublicId,
                        'error'     => $deleteException->getMessage(),
                    ]);
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'There was an error submitting your application. Please try again.');
        }
    }
}