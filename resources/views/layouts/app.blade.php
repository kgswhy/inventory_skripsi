<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    
    <!-- Styles -->
    @vite('resources/css/app.css')
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Error Handler CSS -->
    <style>
        .error-field {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 1px #ef4444 !important;
        }
        
        .toast-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .toast-enter-active {
            transition: all 0.3s ease-out;
        }
        
        .toast-leave-active {
            transition: all 0.2s ease-in;
            transform: translateX(100%);
            opacity: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('components.header')
            
            <!-- Global Alert Messages -->
            <div class="p-6 pb-0">
                @if (session('success'))
                    <x-alert type="success" class="mb-4">
                        {{ session('success') }}
                    </x-alert>
                @endif

                @if (session('error'))
                    <x-alert type="error" class="mb-4">
                        {{ session('error') }}
                    </x-alert>
                @endif

                @if (session('warning'))
                    <x-alert type="warning" class="mb-4">
                        {{ session('warning') }}
                    </x-alert>
                @endif

                @if (session('info'))
                    <x-alert type="info" class="mb-4">
                        {{ session('info') }}
                    </x-alert>
                @endif

                @if ($errors->any())
                    <x-alert type="error" title="Terdapat kesalahan:" class="mb-4">
                        <ul class="mt-2 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif
            </div>
            
            <!-- Main Content -->
            <main class="flex-1 p-6 pt-0">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    <x-toast />
    
    <!-- Loading Component (can be included globally) -->
    <x-loading overlay="false" style="display: none;" id="global-loading" />

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script src="{{ asset('js/error-handler.js') }}"></script>
    @stack('scripts')
    
    <!-- Global JavaScript for Error Handling -->
    <script>
        // Show Laravel session messages as toasts
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                window.ToastManager?.success('Berhasil', '{{ session('success') }}');
            @endif

            @if (session('error'))
                window.ToastManager?.error('Error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                window.ToastManager?.warning('Peringatan', '{{ session('warning') }}');
            @endif

            @if (session('info'))
                window.ToastManager?.info('Informasi', '{{ session('info') }}');
            @endif
        });
        
        // Enhanced form submission handling
        function handleFormSubmit(form, options = {}) {
            const {
                confirmMessage = null,
                loadingText = 'Processing...',
                successMessage = 'Operation completed successfully',
                preventMultipleSubmit = true
            } = options;
            
            // Confirmation dialog
            if (confirmMessage && !confirm(confirmMessage)) {
                return false;
            }
            
            // Prevent multiple submissions
            if (preventMultipleSubmit) {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    if (submitButton.disabled) {
                        return false; // Already submitting
                    }
                    
                    // Set loading state
                    window.LoadingManager?.setButtonLoading(submitButton, true);
                    
                    // Reset after timeout (fallback)
                    setTimeout(() => {
                        window.LoadingManager?.setButtonLoading(submitButton, false);
                    }, 30000);
                }
            }
            
            return true;
        }
        
        // Global utility functions
        window.showSuccess = function(message, title = 'Berhasil') {
            window.ToastManager?.success(title, message);
        };
        
        window.showError = function(message, title = 'Error') {
            window.ToastManager?.error(title, message);
        };
        
        window.showWarning = function(message, title = 'Peringatan') {
            window.ToastManager?.warning(title, message);
        };
        
        window.showInfo = function(message, title = 'Informasi') {
            window.ToastManager?.info(title, message);
        };
        
        window.showLoading = function(text = 'Loading...', id = 'default') {
            window.LoadingManager?.show(id, text);
        };
        
        window.hideLoading = function(id = 'default') {
            window.LoadingManager?.hide(id);
        };
    </script>
</body>
</html> 