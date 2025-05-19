<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role', 'staff')->get();
        return view('admin.manage_staff', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'status' => 'active',
        ]);

        return redirect()->route('admin.manage-staff')
            ->with('success', 'Staff member added successfully.');
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $staff->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $staff->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        if ($request->filled('password')) {
            $staff->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.manage-staff')
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('admin.manage-staff')
            ->with('success', 'Staff member deleted successfully.');
    }
} 