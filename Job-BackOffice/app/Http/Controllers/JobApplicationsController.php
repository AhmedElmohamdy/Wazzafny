<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationsController extends Controller
{
    public function index()
    {
        $query = JobApplication::with('jobVacancy', 'user')->latest();

        // Company Owner only sees their company's job applications
        if (auth()->user()->role === 'company-owner') {
            $company = auth()->user()->companies ;

            if ($company) {
                $query->whereHas('jobVacancy', function ($q) use ($company) {
                    $q->where('company_id', $company->id); 
                });
            } else {
                // If the company-owner has no company, return empty result
                $query->whereRaw('0 = 1');
            }
        }

        // Show archived if requested
        if (request()->boolean('Archived')) {
            $query->onlyTrashed();
        }

        $JobApplications = $query->paginate(10)->onEachSide(1);

        return view('JobApplications.Index', compact('JobApplications'));
    }





    public function details(string $id)
    {
        $JobApplication = JobApplication::with('resume', 'user', 'jobVacancy')->findOrFail($id);
        return view('JobApplications.Details', compact('JobApplication'));
    }


    public function archive(String $id)
    {
        $JobApplication = JobApplication::findOrFail($id);
        $JobApplication->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job Application  archived successfully!');
    }


    public function restore(String $id)
    {
        $JobApplication = JobApplication::withTrashed()->findOrFail($id);
        $JobApplication->restore();

        return redirect()->route('job-applications.index', ['Archived' => 'true'])->with('success', 'Job Category restored successfully!');
    }
}
