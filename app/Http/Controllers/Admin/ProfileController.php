<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Debug logging
        \Log::info('Profile update request', [
            'has_file' => $request->hasFile('profile_image'),
            'file_info' => $request->hasFile('profile_image') ? [
                'name' => $request->file('profile_image')->getClientOriginalName(),
                'size' => $request->file('profile_image')->getSize(),
                'mime' => $request->file('profile_image')->getMimeType(),
            ] : null
        ]);

        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // Max 2MB
        ];

        // Only require current password if user is trying to change password
        if ($request->filled('password')) {
            $validationRules['current_password'] = ['required', 'current_password'];
            $validationRules['password'] = ['required', Password::defaults()];
        }

        $request->validate($validationRules);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            \Log::info('Processing profile image upload');
            
            // Delete old profile image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                \Log::info('Deleting old profile image: ' . $user->profile_image);
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new profile image
            $path = $request->file('profile_image')->store('profile-images', 'public');
            \Log::info('New profile image stored at: ' . $path);
            $updateData['profile_image'] = $path;
        }

        $user->update($updateData);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }
} 