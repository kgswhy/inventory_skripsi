@extends('layouts.app')

@section('title', 'Profile')
@section('header-title', 'Profile')

@section('content')
<div class="h-full w-full bg-white rounded-lg shadow">
    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Personal Information</h3>
        
        <div class="flex items-center mb-8">
            <div class="relative">
                <img src="{{ auth()->user()->profile_image ?? asset('images/default-avatar.jpg') }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover">
                <div class="absolute bottom-0 right-0 bg-green-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                <p class="text-green-500">{{ auth()->user()->role ?? 'Manager' }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Name and Username --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ auth()->user()->username }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('username')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Email and Phone --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone }}"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ auth()->user()->address }}</textarea>
                @error('address')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Passwords --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('current_password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Discard Changes
                </button>
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection