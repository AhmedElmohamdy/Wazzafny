<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;
use App\Models\Company;
use App\Models\JobCategory;
use Illuminate\Validation\Rule;

class JobVacanceiesController extends Controller
{
    public function index()
    {
        $query = JobVacancy::with('company', 'category')->latest();

        // Company Owner only sees their company's job vacancies
        if (auth()->user()->role === 'company-owner') {
            $company = auth()->user()->companies; 

            if ($company) {
                $query->where('company_id', $company->id);
            } else {
                // No company yet → return empty result
                $query->whereRaw('0 = 1');
            }
        }

        // Show archived jobs if requested
        if (request()->boolean('Archived')) {
            $query = JobVacancy::onlyTrashed()->with('company', 'category')->latest();
        }

        $JobVacancies = $query->paginate(10)->onEachSide(1);

        return view('JobVacancies.Index', compact('JobVacancies'));
    }


    public function details(string $id)
    {
        $jobVacancy = JobVacancy::with('company', 'category', 'jobApplications')->findOrFail($id);
        return view('JobVacancies.Details', compact('jobVacancy'));
    }
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('JobVacancies.Edit', compact('jobVacancy', 'companies', 'jobCategories'));
    }


    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('JobVacancies.Create', compact('companies', 'jobCategories'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                'max:30',
                // Rule::unique('job_vacancies', 'title')->ignore($request->id),
            ],
            'description' => 'required|string|max:1000',
            'location' => 'required|max:100',
            'salary' => 'nullable|numeric|min:0',
            'type' => 'required|in:full-time,part-time,contract,internship,hybrid',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:job_categories,id',
        ], [
            'title.required' => 'The Job title is required.',
            'title.max' => 'The Job title must not exceed 30 characters.',
            'description.required' => 'The Job description is required.',
            'description.max' => 'The Job description must not exceed 1000 characters.',
            'location.required' => 'The Job location is required.',
            'location.max' => 'The Job location must not exceed 100 characters.',
            'salary.numeric' => 'The Salary must be a valid number.',
            'salary.min' => 'The Salary must be at least 0.',
            'type.required' => 'The Job type is required.',
            'type.in' => 'The selected Job type is invalid.',
            'company_id.required' => 'The Company is required.',
            'company_id.exists' => 'The selected Company is invalid.',
            'category_id.required' => 'The Category is required.',
            'category_id.exists' => 'The selected Category is invalid.',
        ]);


        // Update
        if ($request->filled('id')) {
            $jobVacancy = JobVacancy::findOrFail($request->id);
            $jobVacancy->update([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'salary' => $request->salary,
                'type' => $request->type,
                'company_id' => $request->company_id,
                'category_id' => $request->category_id,
            ]);


            return redirect()
                ->route('job-vacanceies.index')
                ->with('success', 'Job updated successfully!');
        }

        // Create
        JobVacancy::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary' => $request->salary,
            'type' => $request->type,
            'company_id' => $request->company_id,
            'category_id' => $request->category_id,
        ]);

        return redirect()
            ->route('job-vacanceies.index')
            ->with('success', 'Job added successfully!');
    }

    public function archive(String $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacanceies.index')->with('success', 'Job archived successfully!');
    }


    public function restore(String $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-vacanceies.index', ['Archived' => 'true'])->with('success', 'Job restored successfully!');
    }
}
