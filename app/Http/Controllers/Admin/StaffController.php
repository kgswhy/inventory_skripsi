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

    public function show(User $staff)
    {
        return response()->json([
            'id' => $staff->id,
            'name' => $staff->name,
            'username' => $staff->username,
            'email' => $staff->email,
            'phone' => $staff->phone,
            'birth_date' => $staff->birth_date,
            'address' => $staff->address,
            'role' => $staff->role,
            'created_at' => $staff->created_at ? $staff->created_at->format('d/m/Y H:i') : null,
            'updated_at' => $staff->updated_at ? $staff->updated_at->format('d/m/Y H:i') : null,
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Staff creation attempt', [
            'request_data' => $request->only(['name', 'username', 'email', 'phone', 'birth_date', 'address']),
            'has_password' => $request->has('password'),
            'has_password_confirmation' => $request->has('password_confirmation'),
        ]);

        try {
            $request->validate([
                'name' => ['required', 'string', 'min:2', 'max:255'],
                'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users', 'alpha_dash'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\(\)\s]+$/'],
                'birth_date' => ['nullable', 'date', 'before:today'],
                'address' => ['nullable', 'string', 'max:500'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.min' => 'Nama lengkap minimal 2 karakter.',
                'username.required' => 'Username wajib diisi.',
                'username.min' => 'Username minimal 3 karakter.',
                'username.unique' => 'Username sudah digunakan.',
                'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'phone.regex' => 'Format nomor telepon tidak valid.',
                'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
                'address.max' => 'Alamat maksimal 500 karakter.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter dan harus mengandung huruf dan angka.',
            ]);

            \Log::info('Validation passed, creating user');

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'role' => 'staff',
            ]);

            \Log::info('Staff created successfully', ['user_id' => $user->id]);

            return redirect()->route('admin.staff.index')
                ->with('success', 'Staff berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->only(['name', 'username', 'email', 'phone', 'birth_date', 'address'])
            ]);

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Error creating staff', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan staff: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username,' . $staff->id, 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\+\-\(\)\s]+$/'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 2 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter dan harus mengandung huruf dan angka.',
        ]);

        try {
            $staff->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
            ]);

            if ($request->filled('password')) {
                $staff->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            return redirect()->route('admin.staff.index')
                ->with('success', 'Staff berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui staff. Silakan coba lagi.');
        }
    }

    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
}