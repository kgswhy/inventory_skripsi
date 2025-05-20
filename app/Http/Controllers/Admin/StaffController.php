<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function edit(User $staff)
    {
        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'password' => ['required', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff added successfully.');
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $staff->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
        ]);

        $staff->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => [Password::defaults()],
            ]);

            $staff->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
} 