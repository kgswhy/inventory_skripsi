/**
 * Global Error Handler for Inventory Management System
 * Handles all types of errors including AJAX, form submissions, and JavaScript errors
 */

class ErrorHandler {
    constructor() {
        this.init();
    }

    init() {
        // Handle uncaught JavaScript errors
        window.addEventListener('error', this.handleGlobalError.bind(this));
        
        // Handle unhandled promise rejections
        window.addEventListener('unhandledrejection', this.handlePromiseRejection.bind(this));
        
        // Setup AJAX error handling
        this.setupAjaxErrorHandling();
        
        // Setup form error handling
        this.setupFormErrorHandling();
        
        // Setup CSRF token for all AJAX requests
        this.setupCSRFToken();
    }

    handleGlobalError(event) {
        console.error('Global JavaScript Error:', event.error);
        
        if (window.ToastManager) {
            window.ToastManager.error(
                'Terjadi Kesalahan',
                'Terjadi kesalahan tidak terduga. Silakan refresh halaman.',
                10000
            );
        }
        
        // Hide any loading overlays
        if (window.LoadingManager) {
            window.LoadingManager.hideAll();
        }
    }

    handlePromiseRejection(event) {
        console.error('Unhandled Promise Rejection:', event.reason);
        
        if (window.ToastManager) {
            window.ToastManager.error(
                'Terjadi Kesalahan',
                'Operasi gagal dijalankan. Silakan coba lagi.',
                8000
            );
        }
        
        // Hide any loading overlays
        if (window.LoadingManager) {
            window.LoadingManager.hideAll();
        }
    }

    setupCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            // Setup for jQuery if available
            if (window.$) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.getAttribute('content')
                    }
                });
            }
            
            // Setup for fetch API
            window.csrfToken = token.getAttribute('content');
        }
    }

    setupAjaxErrorHandling() {
        // jQuery AJAX error handling
        if (window.$) {
            $(document).ajaxError((event, xhr, settings, thrownError) => {
                this.handleAjaxError(xhr, settings, thrownError);
            });
        }
    }

    setupFormErrorHandling() {
        // Handle form submissions with error states
        document.addEventListener('submit', (event) => {
            const form = event.target;
            if (form.tagName === 'FORM') {
                this.handleFormSubmission(form);
            }
        });
    }

    handleFormSubmission(form) {
        const submitButton = form.querySelector('button[type="submit"]');
        
        if (submitButton && window.LoadingManager) {
            // Set loading state
            window.LoadingManager.setButtonLoading(submitButton, true);
            
            // Remove loading state after a timeout (fallback)
            setTimeout(() => {
                window.LoadingManager.setButtonLoading(submitButton, false);
            }, 30000); // 30 seconds timeout
        }
    }

    handleAjaxError(xhr, settings = {}, thrownError = '') {
        // Hide loading overlays
        if (window.LoadingManager) {
            window.LoadingManager.hideAll();
        }

        let title = 'Terjadi Kesalahan';
        let message = 'Operasi gagal dijalankan. Silakan coba lagi.';
        
        switch (xhr.status) {
            case 0:
                title = 'Koneksi Terputus';
                message = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                break;
                
            case 400:
                title = 'Permintaan Tidak Valid';
                message = 'Data yang dikirim tidak valid. Periksa kembali formulir Anda.';
                break;
                
            case 401:
                title = 'Sesi Berakhir';
                message = 'Sesi Anda telah berakhir. Silakan login kembali.';
                this.handleUnauthorized();
                break;
                
            case 403:
                title = 'Akses Ditolak';
                message = 'Anda tidak memiliki izin untuk melakukan operasi ini.';
                break;
                
            case 404:
                title = 'Tidak Ditemukan';
                message = 'Halaman atau data yang diminta tidak ditemukan.';
                break;
                
            case 422:
                // Validation errors
                this.handleValidationErrors(xhr);
                return;
                
            case 429:
                title = 'Terlalu Banyak Permintaan';
                message = 'Anda melakukan terlalu banyak permintaan. Silakan tunggu sebentar.';
                break;
                
            case 500:
                title = 'Kesalahan Server';
                message = 'Terjadi kesalahan di server. Tim teknis telah diberitahu.';
                break;
                
            case 503:
                title = 'Layanan Tidak Tersedia';
                message = 'Server sedang dalam pemeliharaan. Silakan coba lagi nanti.';
                break;
                
            default:
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            message = response.message;
                        }
                    } catch (e) {
                        // Use default message
                    }
                }
                break;
        }
        
        if (window.ToastManager) {
            window.ToastManager.error(title, message);
        }
    }

    handleValidationErrors(xhr) {
        if (xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            let errorMessage = 'Terdapat kesalahan pada formulir:';
            
            // Build error message from validation errors
            Object.keys(errors).forEach(field => {
                if (errors[field] && errors[field].length > 0) {
                    errorMessage += '\n• ' + errors[field][0];
                }
            });
            
            if (window.ToastManager) {
                window.ToastManager.error('Validasi Gagal', errorMessage, 10000);
            }
            
            // Highlight form fields with errors
            this.highlightErrorFields(errors);
        } else {
            if (window.ToastManager) {
                window.ToastManager.error(
                    'Validasi Gagal',
                    'Terdapat kesalahan pada formulir. Periksa kembali data yang Anda masukkan.'
                );
            }
        }
    }

    highlightErrorFields(errors) {
        // Remove existing error classes
        document.querySelectorAll('.error-field').forEach(field => {
            field.classList.remove('error-field');
        });
        
        // Add error classes to fields with errors
        Object.keys(errors).forEach(fieldName => {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.add('error-field');
                
                // Add error styling
                field.style.borderColor = '#ef4444';
                field.style.boxShadow = '0 0 0 1px #ef4444';
                
                // Remove error styling on focus
                field.addEventListener('focus', function() {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                    this.classList.remove('error-field');
                });
            }
        });
    }

    handleUnauthorized() {
        // Redirect to login page after a short delay
        setTimeout(() => {
            window.location.href = '/login';
        }, 3000);
    }

    // Public method for handling API calls
    async handleApiCall(apiCall, options = {}) {
        const {
            loadingId = 'api-call',
            loadingText = 'Memproses...',
            successTitle = 'Berhasil',
            successMessage = 'Operasi berhasil dilakukan',
            showSuccess = true
        } = options;

        try {
            // Show loading
            if (window.LoadingManager) {
                window.LoadingManager.show(loadingId, loadingText);
            }

            const result = await apiCall();

            // Hide loading
            if (window.LoadingManager) {
                window.LoadingManager.hide(loadingId);
            }

            // Show success message
            if (showSuccess && window.ToastManager) {
                window.ToastManager.success(successTitle, successMessage);
            }

            return result;

        } catch (error) {
            // Hide loading
            if (window.LoadingManager) {
                window.LoadingManager.hide(loadingId);
            }

            // Handle the error
            if (error.response) {
                // HTTP error response
                this.handleAjaxError(error.response);
            } else if (error.message) {
                // JavaScript error
                if (window.ToastManager) {
                    window.ToastManager.error('Error', error.message);
                }
            } else {
                // Unknown error
                if (window.ToastManager) {
                    window.ToastManager.error(
                        'Terjadi Kesalahan',
                        'Operasi gagal dijalankan. Silakan coba lagi.'
                    );
                }
            }

            throw error; // Re-throw for caller to handle if needed
        }
    }

    // Helper method for making safe fetch requests
    async safeFetch(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        const mergedOptions = {
            ...defaultOptions,
            ...options,
            headers: {
                ...defaultOptions.headers,
                ...options.headers
            }
        };

        const response = await fetch(url, mergedOptions);
        
        if (!response.ok) {
            const errorData = {
                status: response.status,
                statusText: response.statusText,
                url: response.url
            };
            
            try {
                errorData.responseJSON = await response.json();
            } catch (e) {
                errorData.responseText = await response.text();
            }
            
            this.handleAjaxError(errorData);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        return response;
    }
}

// Initialize the error handler when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.ErrorHandler = new ErrorHandler();
});

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ErrorHandler;
} 