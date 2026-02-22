<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index(Request $request)
{
    $query = JobVacancy::with('company')->latest();

    // Search by title, location, or company name
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhereHas('company', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Filter by Job Type
    if ($type = $request->input('type')) {
        $query->where('type', $type);
    }

    $jobVacancies = $query
        ->paginate(9)
        ->withQueryString()
        ->onEachSide(2);

    return view('dashboard', compact('jobVacancies'));
}




}
