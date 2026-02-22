<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('Admins.Index', compact('admins'));
    }

    public function create()
    {
        return view('Admins.Create');
    }

    public function save(Request $request)
    {
        // Validation Rules
        
        $rules = [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($request->id),
            ],
        ];

        // Create password required
        if (!$request->filled('id')) {
            $rules['password'] = 'required|string|min:8|max:255';
        }
        // Update password optional
        else {
            $rules['password'] = 'nullable|string|min:8|max:255';
        }

        $request->validate($rules);

        // UPDATE ADMIN
        
        
        if ($request->filled('id')) {

            $admin = User::findOrFail($request->id);

            $adminData = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $adminData['password'] = Hash::make($request->password);
            }

            $admin->update($adminData);

            return redirect()
                ->route('admins.index')
                ->with('success', 'Admin updated successfully!');
        }

        // CREATE ADMIN
        
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()
            ->route('admins.index')
            ->with('success', 'Admin created successfully!');
    }

    public function edit(string $id)
    {
        $admin = User::findOrFail($id);
        return view('Admins.Edit', compact('admin'));
    }
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()
            ->route('admins.index')
            ->with('success', 'Admin deleted successfully!');
    }
}
