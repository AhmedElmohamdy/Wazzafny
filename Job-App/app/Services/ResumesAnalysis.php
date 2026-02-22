<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ResumesAnalysis
{
    /**
     * Analyze resume AND match to job in ONE OpenAI call
     * This saves API calls and avoids rate limits
     */
    public function analyzeAndMatchResume(string $fileUrl, $jobVacancy): ?array
    {
        try {
            // Extract text from PDF
            $resumeText = $this->extractTextFromPdf($fileUrl);

            if (empty($resumeText)) {
                Log::warning('No text extracted from resume', ['url' => $fileUrl]);
                return null;
            }

            Log::info('PDF text extracted successfully', [
                'url' => $fileUrl,
                'text_length' => strlen($resumeText),
                'preview' => substr($resumeText, 0, 200)
            ]);

            // Build job description
            $jobDescription = $this->buildJobDescription($jobVacancy);

            // Call OpenAI ONCE with combined prompt
            $result = $this->analyzeAndMatchWithOpenAI($resumeText, $jobDescription);

            return $result;
        } catch (\Exception $e) {
            Log::error('Resume analysis and matching failed', [
                'url' => $fileUrl,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return null;
        }
    }

    /**
     * SINGLE OpenAI call that returns EVERYTHING
     */
    private function analyzeAndMatchWithOpenAI(string $resumeText, string $jobDescription): ?array
    {
        $prompt = <<<EOT
You are an expert HR recruiter and resume analyzer. Perform TWO tasks in ONE response:

TASK 1: ANALYZE THE RESUME
Extract structured information from the resume.

TASK 2: MATCH RESUME TO JOB
Evaluate how well the candidate matches the job requirements and provide a score (0-100).

JOB DESCRIPTION:
{$jobDescription}

CANDIDATE RESUME:
{$resumeText}

SCORING CRITERIA:
- 90-100: Excellent match, highly qualified
- 70-89: Good match, qualified with minor gaps
- 50-69: Moderate match, some qualifications missing
- 30-49: Weak match, significant gaps
- 0-29: Poor match, not qualified

Return ONLY valid JSON (no markdown, no code blocks, no extra text) with these EXACT keys:

{
  "summary": "A brief 2-3 sentence professional summary of the candidate",
  "skills": ["skill1", "skill2", "skill3"],
  "experience": [
    {
      "title": "Job Title",
      "company": "Company Name",
      "duration": "Start Date - End Date",
      "description": "Brief description"
    }
  ],
  "education": [
    {
      "degree": "Degree Name",
      "institution": "University Name",
      "year": "Graduation Year"
    }
  ],
  "score": 85,
  "feedback": "Detailed 3-5 sentence explanation of match quality, strengths, gaps, and recommendation"
}

Return ONLY the JSON object above, nothing else.
EOT;

        // Retry logic
        $maxRetries = 3;
        $retryDelay = 2;

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                Log::info("OpenAI combined analysis attempt {$attempt}/{$maxRetries}");

                $response = OpenAI::chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert resume analyzer and HR recruiter. Extract structured resume data AND evaluate job match quality. Return only valid JSON with all required fields. No markdown formatting or code blocks.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 2500, // Increased for combined response
                ]);

                $content = $response->choices[0]->message->content;

                Log::info('OpenAI combined response received', [
                    'response_length' => strlen($content),
                    'attempt' => $attempt
                ]);

                // Clean the response
                $content = preg_replace('/```json\s*|\s*```/', '', $content);
                $content = trim($content);

                // Try to parse JSON
                $parsed = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
                    Log::info('Combined JSON parsed successfully (direct)');
                    return $this->validateCombinedResult($parsed);
                }

                // Try extracting JSON from text
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    $parsed = json_decode($matches[0], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
                        Log::info('Combined JSON parsed successfully (extracted)');
                        return $this->validateCombinedResult($parsed);
                    }
                }

                Log::warning('Combined JSON parsing failed', [
                    'attempt' => $attempt,
                    'response' => substr($content, 0, 500)
                ]);
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
                Log::error("OpenAI combined exception (attempt {$attempt}/{$maxRetries})", [
                    'error' => $errorMsg,
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);

                // Check for rate limit
                if (str_contains($errorMsg, 'rate limit') || str_contains($errorMsg, 'Rate limit')) {
                    if ($attempt < $maxRetries) {
                        $delay = $retryDelay * $attempt;
                        Log::info("Rate limit hit, waiting {$delay} seconds before retry...");
                        sleep($delay);
                        continue;
                    } else {
                        Log::error('Max retries reached for rate limit');
                    }
                } else {
                    break;
                }
            }
        }

        // Fallback
        Log::warning('Returning fallback empty result');
        return null;
    }

    /**
     * Validate and structure the combined result
     */
    private function validateCombinedResult(array $data): array
    {
        // Ensure all required keys exist
        return [
            'summary' => $data['summary'] ?? '',
            'skills' => is_array($data['skills'] ?? null) ? $data['skills'] : [],
            'experience' => is_array($data['experience'] ?? null) ? $data['experience'] : [],
            'education' => is_array($data['education'] ?? null) ? $data['education'] : [],
            'score' => max(0, min(100, (int) ($data['score'] ?? 0))),
            'feedback' => $data['feedback'] ?? 'No detailed feedback available.'
        ];
    }

    /**
     * Extract text from PDF - supports both Spatie and smalot/pdfparser
     */
    private function extractTextFromPdf(string $fileUrl): string
    {
        try {
            Log::info('Downloading PDF from Cloudinary', ['url' => $fileUrl]);

            $response = Http::timeout(30)->get($fileUrl);

            if (!$response->successful()) {
                Log::error('Failed to download PDF', [
                    'url' => $fileUrl,
                    'status' => $response->status()
                ]);
                return '';
            }

            $pdfContent = $response->body();
            $tempFile = tempnam(sys_get_temp_dir(), 'resume_');
            file_put_contents($tempFile, $pdfContent);

            Log::info('PDF downloaded successfully', [
                'temp_file' => $tempFile,
                'size' => filesize($tempFile)
            ]);

            $text = '';

            // Try Spatie first
            if (class_exists('\Spatie\PdfToText\Pdf')) {
                try {
                    Log::info('Attempting text extraction with Spatie PdfToText');
                    // Specify explicit path to pdftotext binary
                    $text = \Spatie\PdfToText\Pdf::getText(
                        $tempFile,
                        'C:\Users\win10\Downloads\poppler-25.12.0\Library\bin\pdftotext.exe'
                    );
                    Log::info('Spatie extraction successful', ['length' => strlen($text)]);
                } catch (\Exception $e) {
                    Log::warning('Spatie extraction failed, trying fallback', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Fallback to smalot/pdfparser
            if (empty($text) && class_exists('\Smalot\PdfParser\Parser')) {
                try {
                    Log::info('Attempting text extraction with smalot/pdfparser');
                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile($tempFile);
                    $text = $pdf->getText();
                    Log::info('Smalot extraction successful', ['length' => strlen($text)]);
                } catch (\Exception $e) {
                    Log::warning('Smalot extraction failed', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            @unlink($tempFile);

            if (!empty($text)) {
                $text = preg_replace('/\s+/', ' ', $text);
                $text = trim($text);
            }

            return $text;
        } catch (\Exception $e) {
            Log::error('PDF text extraction exception', [
                'url' => $fileUrl,
                'error' => $e->getMessage()
            ]);
            return '';
        }
    }

    /**
     * Build job description string
     */
    private function buildJobDescription($jobVacancy): string
    {
        $parts = [];
        $parts[] = "Job Title: " . ($jobVacancy->title ?? 'N/A');

        if (!empty($jobVacancy->description)) {
            $parts[] = "Description: " . $jobVacancy->description;
        }
        if (!empty($jobVacancy->requirements)) {
            $parts[] = "Requirements: " . $jobVacancy->requirements;
        }
        if (!empty($jobVacancy->location)) {
            $parts[] = "Location: " . $jobVacancy->location;
        }
        if (!empty($jobVacancy->type)) {
            $parts[] = "Job Type: " . $jobVacancy->type;
        }
        if (!empty($jobVacancy->salary)) {
            $parts[] = "Salary: $" . number_format($jobVacancy->salary);
        }

        return implode("\n\n", $parts);
    }
}
