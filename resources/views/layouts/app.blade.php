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
            
            <!-- Main Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Loading Component (can be included globally) -->
    <x-loading overlay="false" style="display: none;" id="global-loading" />

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script src="{{ asset('js/error-handler.js') }}"></script>
    @stack('scripts')
    
    <!-- Global JavaScript for Error Handling -->
    <script>
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