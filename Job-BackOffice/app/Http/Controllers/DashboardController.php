<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $data = $this->AdminAnalytics();
        } else {
            $data = $this->CompanyOwnerAnalytics();
        }

        return view('Dashboard.index', $data);
    }


    private function AdminAnalytics()
    {
        // Active users in last 30 days with role 'job-seeker'
        $activeUsers = User::where('role', 'job-seeker')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Total jobs (not archived)
        $totalJobs = JobVacancy::count(); // SoftDeletes automatically handled if using $dates/SoftDeletes

        // Total job applications (not archived)
        $totalApplications = JobApplication::count(); // same for soft deletes

        // --- Most Applied Jobs ---
        $mostAppliedJobs = JobVacancy::with('company')
            ->withCount('jobApplications') // adds job_applications_count
            ->orderByDesc('job_applications_count')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                return [
                    'title' => $job->title,
                    'company' => $job->company->name ?? 'N/A',
                    'applications' => $job->job_applications_count,
                ];
            });

        // --- Conversion Rate (Views vs Applications) ---
        $conversionJobs = JobVacancy::withCount('jobApplications')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $views = $job->views ?? 0;
                $applications = $job->job_applications_count;
                $conversion = $views > 0 ? round(($applications / $views) * 100) . '%' : '0%';

                return [
                    'title' => $job->title,
                    'views' => $views,
                    'applications' => $applications,
                    'conversion' => $conversion,
                ];
            });
        return compact(
            'activeUsers',
            'totalJobs',
            'totalApplications',
            'mostAppliedJobs',
            'conversionJobs'
        );
    }

   private function CompanyOwnerAnalytics()
{
    $user = auth()->user();

    // IDs of companies owned by this user
    $companyIds = $user->companies()->pluck('id');

    // Job IDs belonging to his companies
    $jobIds = JobVacancy::whereIn('company_id', $companyIds)
        ->pluck('id');

    // Total jobs
    $totalJobs = $jobIds->count();

    // Total applications for his jobs
    $totalApplications = JobApplication::whereIn(
        'job_vacancy_id',
        $jobIds
    )->count();

     //  Active users = logged in last 30 days AND applied to his jobs
    $activeUsers = User::where('role', 'job-seeker')
        ->whereNotNull('last_login_at')
        ->where('last_login_at', '>=', now()->subDays(30))
        ->whereHas('jobApplications', function ($query) use ($jobIds) {
            $query->whereIn('job_vacancy_id', $jobIds);
        })
        ->count();

    // Most Applied Jobs (his jobs only)
    $mostAppliedJobs = JobVacancy::whereIn('company_id', $companyIds)
        ->with('company')
        ->withCount('jobApplications')
        ->orderByDesc('job_applications_count')
        ->limit(5)
        ->get()
        ->map(function ($job) {
            return [
                'title' => $job->title,
                'company' => $job->company->name ?? 'N/A',
                'applications' => $job->job_applications_count,
            ];
        });

    // Conversion Rate
    $conversionJobs = JobVacancy::whereIn('company_id', $companyIds)
        ->withCount('jobApplications')
        ->limit(5)
        ->get()
        ->map(function ($job) {
            $views = $job->views ?? 0;
            $applications = $job->job_applications_count;

            $conversion = $views > 0
                ? round(($applications / $views) * 100) . '%'
                : '0%';

            return [
                'title' => $job->title,
                'views' => $views,
                'applications' => $applications,
                'conversion' => $conversion,
            ];
        });

    return compact(
        'activeUsers',
        'totalJobs',
        'totalApplications',
        'mostAppliedJobs',
        'conversionJobs'
    );
}


}
