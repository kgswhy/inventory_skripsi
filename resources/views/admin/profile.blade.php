@extends('layouts.app')

@section('title', 'Profile')
@section('header-title', 'Profile')

@section('content')
<div class="w-full h-full bg-white rounded-lg shadow">
    <div class="p-6">
        <h3 class="mb-6 text-xl font-semibold text-gray-800">Personal Information</h3>
        
        {{-- Single Alert Container --}}
        <div id="alertContainer" class="hidden relative px-4 py-3 mb-4 rounded border" role="alert">
            <span id="alertMessage" class="block sm:inline"></span>
            <button type="button" onclick="hideAlert()" class="absolute top-0 right-0 p-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Session Success Message --}}
        @if(session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-0 right-0 p-1 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Image Section --}}
            <div class="flex items-center mb-8">
                <div class="relative">
                    <img id="profilePreview" src="{{ auth()->user()->profile_image_url }}" alt="Profile Picture" class="object-cover w-24 h-24 rounded-full border-4 border-gray-200">
                    <label for="profile_image" class="absolute right-0 bottom-0 p-1 bg-green-500 rounded-full transition-colors cursor-pointer hover:bg-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden" onchange="previewImage(this)">
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                    <p class="text-green-500">{{ ucfirst(auth()->user()->role) ?? 'Manager' }}</p>
                    <p class="mt-1 text-sm text-gray-500">Click the edit icon to change profile picture</p>
                </div>
            </div>

            {{-- Name and Username --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username" value="{{ auth()->user()->username }}" required
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            {{-- Email and Phone --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone }}"
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            {{-- Birth Date --}}
            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                <input type="date" name="birth_date" id="birth_date" value="{{ auth()->user()->birth_date ? auth()->user()->birth_date->format('Y-m-d') : '' }}"
                    class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" id="address" rows="3"
                    class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ auth()->user()->address }}</textarea>
            </div>

            {{-- Passwords --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password <span class="text-gray-500">(only if changing password)</span></label>
                    <input type="password" name="current_password" id="current_password"
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Leave empty if you don't want to change your password</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password <span class="text-gray-500">(optional)</span></label>
                    <input type="password" name="password" id="password"
                        class="block p-2 mt-1 w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current password</p>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Discard Changes
                </button>
                <button type="submit" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-green-500 rounded-md border border-transparent shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Single Alert System
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alertContainer');
    const alertMessage = document.getElementById('alertMessage');
    
    // Set message
    alertMessage.textContent = message;
    
    // Set colors based on type
    alertContainer.className = 'relative px-4 py-3 mb-4 rounded border';
    if (type === 'success') {
        alertContainer.classList.add('text-green-700', 'bg-green-100', 'border-green-400');
    } else if (type === 'error') {
        alertContainer.classList.add('text-red-700', 'bg-red-100', 'border-red-400');
    } else if (type === 'warning') {
        alertContainer.classList.add('text-yellow-700', 'bg-yellow-100', 'border-yellow-400');
    } else {
        alertContainer.classList.add('text-blue-700', 'bg-blue-100', 'border-blue-400');
    }
    
    // Show alert
    alertContainer.classList.remove('hidden');
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        hideAlert();
    }, 5000);
}

function hideAlert() {
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.classList.add('hidden');
}

function previewImage(input) {
    console.log('previewImage called', input.files);
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        console.log('File selected:', {
            name: file.name,
            size: file.size,
            type: file.type
        });
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            console.log('File reader loaded, updating preview');
            document.getElementById('profilePreview').src = e.target.result;
        }
        
        reader.readAsDataURL(file);
    } else {
        console.log('No file selected');
    }
}

// Initialize alerts on page load
document.addEventListener('DOMContentLoaded', function() {
    // Show validation errors if they exist
    @if($errors->any())
        @foreach($errors->all() as $error)
            showAlert('{{ $error }}', 'error');
        @endforeach
    @endif
    
    // Form submit handling
    const form = document.querySelector('form[action*="profile"]');
    const fileInput = document.getElementById('profile_image');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitting...');
            console.log('File input has file:', fileInput.files.length > 0);
            if (fileInput.files.length > 0) {
                console.log('File details:', {
                    name: fileInput.files[0].name,
                    size: fileInput.files[0].size,
                    type: fileInput.files[0].type
                });
            }
        });
    }
});
</script>
@endsection