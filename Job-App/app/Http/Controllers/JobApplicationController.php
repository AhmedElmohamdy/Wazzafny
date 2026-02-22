<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jobApplication;

class JobApplicationController extends Controller
{
     public function index()
    {
        $JobApplications = JobApplication::with([
                'jobVacancy.company',  // Load job and company info
                'resume'                // Load resume info
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('Job-Application.index', compact('JobApplications'));
    }
}
