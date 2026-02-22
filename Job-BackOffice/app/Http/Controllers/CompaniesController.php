<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function index()
    {
        $query = Company::with('owner')->latest();

        if (request()->boolean('Archived')) {
            $query = Company::onlyTrashed()->with('owner')->latest();
        }

        $Companies = $query->paginate(10)->onEachSide(1);

        return view('Companies.Index', compact('Companies'));
    }



    public function create()
    {
        $owner = User::all();
        return view('Companies.Create', compact('owner'));
    }

    public function edit(string $id = null)
    {
        if ($id) {
            // Admin editing any company
            $company = Company::with('owner')->findOrFail($id);
        } else {
            // Company Owner editing their own company
            $company = Company::with('owner')
                ->where('owner_id', auth()->user()->id)
                ->firstOrFail();
        }


        $owner = $company->owner;

        return view('Companies.Edit', compact('company', 'owner'));
    }

    public function details(string $id = null)
    {
        if ($id) {
            // Admin viewing specific company
            $company = Company::with('owner')->findOrFail($id);
        } else {
            // Company Owner viewing their own company
            $company = Company::with('owner')
                ->where('owner_id', auth()->user()->id)->firstOrFail();
        }

        return view('Companies.Details', compact('company'));
    }

    /**
     * Create OR Update Company
     */
    public function save(Request $request)
    {
        $id = $request->input('id'); 

        $rules = [
            'name' => [
                'required',
                'max:30',
                Rule::unique('companies', 'name')->ignore($id),
            ],
            'address' => 'required|max:100',
            'website' => 'nullable|url|max:100',
            'industry' => 'required|max:50',

            'owner_name' => 'required|max:100',
            'owner_email' => 'required|email|max:100',
        ];

        // Password rules
        $rules['owner_password'] = $id === null
            ? 'required|string|min:8|max:255'
            : 'nullable|string|min:8|max:255';

        $messages = [
            'name.required' => 'The Company name is required.',
            'address.required' => 'The Company address is required.',
            'website.url' => 'The Company website must be a valid URL.',
            'industry.required' => 'The Company industry is required.',
            'owner_name.required' => 'The Owner name is required.',
            'owner_email.required' => 'The Owner email is required.',
            'owner_email.email' => 'The Owner email must be a valid email address.',
        ];

        $request->validate($rules, $messages);

        /**
         * ================= UPDATE =================
         */
        if ($id !== null) {
            $company = Company::with('owner')->findOrFail($id);

            // Security: company-owner can only edit his company
            if (auth()->user()->role === 'company-owner' && $company->owner_id !== auth()->id()) {
                abort(403);
            }

            $company->update([
                'name' => $request->name,
                'address' => $request->address,
                'website' => $request->website,
                'industry' => $request->industry,
            ]);

            $ownerData = [
                'name' => $request->owner_name,
            ];

            // Only Admin can change owner email
            if (auth()->user()->role === 'admin') {
                $ownerData['email'] = $request->owner_email;
            }

            if ($request->filled('owner_password')) {
                $ownerData['password'] = Hash::make($request->owner_password);
            }

            $company->owner->update($ownerData);

            return redirect()
                ->route(auth()->user()->role === 'admin' ? 'companies.index' : 'My-Company.details')
                ->with('success', 'Company updated successfully!');
        }

        /**
         * ================= CREATE =================
         */

        // Prevent company-owner from creating more than one company
        if (auth()->user()->role === 'company-owner') {
            $existingCompany = Company::where('owner_id', auth()->id())->first();

            if ($existingCompany) {
                return redirect()
                    ->route('My-Company.edit')
                    ->with('warning', 'You already have a company.');
            }
        }

        // Admin creating new company → create owner
        $owner = User::create([
            'name' => $request->owner_name,
            'email' => $request->owner_email,
            'password' => Hash::make($request->owner_password),
            'role' => 'company-owner',
        ]);

        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'website' => $request->website,
            'industry' => $request->industry,
            'owner_id' => $owner->id,
        ]);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company added successfully!');
    }



    /**
     * Soft Delete (Archive)
     */
    public function archive(String $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company archived successfully!');
    }


    public function restore(String $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('companies.index', ['Archived' => 'true'])->with('success', 'Company restored successfully!');
    }
}
