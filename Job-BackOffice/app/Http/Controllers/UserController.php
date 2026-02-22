<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use  Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //Active
        $quary = User::latest();

        //Archived
        if (request()->input('Archived') == 'true') {
            $quary =  User::onlyTrashed()->latest();
        }


        $User = $quary->paginate(10)->onEachSide(1);

        return view('users.Index', compact('User'));
    }


    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view('users.Edit', compact('users'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($request->id),
            ],
            'role' => 'required|string',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'The name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be valid.',
            'email.max' => 'The email must not exceed 150 characters.',
            'role.required' => 'The role is required.',
            'password.required' => 'The password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $user = User::findOrFail($request->id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    public function archive(String $id)
    {
        $Users = User::findOrFail($id);
        $Users->delete();

        return redirect()  ->route('users.index')->with('success', 'User archived successfully!');
    }


    public function restore(String $id)
    {
        $Users = User::withTrashed()->findOrFail($id);
        $Users->restore();

        return redirect()  ->route('users.index',['Archived' => 'true'])->with('success', 'User restored successfully!');
    }
}
