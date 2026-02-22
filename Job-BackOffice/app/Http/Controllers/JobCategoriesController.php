<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobCategoriesController extends Controller
{
    public function index()
    {
        //Active
        $quary = JobCategory::latest();

        //Archived
        if (request()->input('Archived') == 'true') {
            $quary =  JobCategory::onlyTrashed()->latest();
        }


        $jobCategories = $quary->paginate(10)->onEachSide(1);

        return view('JobCategories.Index', compact('jobCategories'));
    }

    public function create()
    {
        return view('JobCategories.Create');
    }

    public function edit(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        return view('JobCategories.Edit', compact('jobCategory'));
    }

    /**
     * Create OR Update Job Category
     */
    public function save(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:30',
                Rule::unique('job_categories', 'name')->ignore($request->id),
                'messages' => [
                    'name.required' => 'The Job Category name is required.',
                    'name.max' => 'The Job Category name must not exceed 30 characters.',
                ],
            ],
        ]);

        // Update
        if ($request->filled('id')) {
            $jobCategory = JobCategory::findOrFail($request->id);
            $jobCategory->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('job-categories.index')
                ->with('success', 'Job Category updated successfully!');
        }

        // Create
        JobCategory::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('job-categories.index')
            ->with('success', 'Job Category added successfully!');
    }

    /**
     * Soft Delete (Archive)
     */
    public function archive(String $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();

        return redirect()  ->route('job-categories.index')->with('success', 'Job Category archived successfully!');
    }


    public function restore(String $id)
    {
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();

        return redirect()  ->route('job-categories.index',['Archived' => 'true'])->with('success', 'Job Category restored successfully!');
    }
}
