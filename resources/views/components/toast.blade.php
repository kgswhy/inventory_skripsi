<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<!-- Toast Template (hidden) -->
<template id="toast-template">
    <div class="toast-item transform transition-all duration-300 ease-in-out translate-x-full opacity-0 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <!-- Icon will be inserted here -->
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="toast-title text-sm font-medium text-gray-900"></p>
                    <p class="toast-message mt-1 text-sm text-gray-500"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button class="toast-close bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
window.ToastManager = {
    container: null,
    template: null,

    init() {
        this.container = document.getElementById('toast-container');
        this.template = document.getElementById('toast-template');
    },

    show(type, title, message, duration = 5000) {
        if (!this.container || !this.template) {
            this.init();
        }

        const toast = this.template.content.cloneNode(true);
        const toastElement = toast.querySelector('.toast-item');
        
        // Set content
        toast.querySelector('.toast-title').textContent = title;
        toast.querySelector('.toast-message').textContent = message;
        
        // Set icon based on type
        const iconContainer = toast.querySelector('.flex-shrink-0');
        iconContainer.innerHTML = this.getIcon(type);
        
        // Add type-specific classes
        this.applyTypeStyles(toastElement, type);
        
        // Add close functionality
        const closeButton = toast.querySelector('.toast-close');
        closeButton.addEventListener('click', () => {
            this.remove(toastElement);
        });
        
        // Add to container
        this.container.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => {
            toastElement.classList.remove('translate-x-full', 'opacity-0');
            toastElement.classList.add('translate-x-0', 'opacity-100');
        }, 100);
        
        // Auto remove
        if (duration > 0) {
            setTimeout(() => {
                this.remove(toastElement);
            }, duration);
        }
        
        return toastElement;
    },

    remove(toastElement) {
        toastElement.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => {
            if (toastElement.parentNode) {
                toastElement.parentNode.removeChild(toastElement);
            }
        }, 300);
    },

    getIcon(type) {
        const icons = {
            success: `<div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                      </div>`,
            error: `<div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                      <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </div>`,
            warning: `<div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                      </div>`,
            info: `<div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                     <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                     </svg>
                   </div>`
        };
        return icons[type] || icons.info;
    },

    applyTypeStyles(element, type) {
        const styles = {
            success: 'border-l-4 border-green-500',
            error: 'border-l-4 border-red-500',
            warning: 'border-l-4 border-yellow-500',
            info: 'border-l-4 border-blue-500'
        };
        element.classList.add(...(styles[type] || styles.info).split(' '));
    },

    // Convenience methods
    success(title, message, duration) {
        return this.show('success', title, message, duration);
    },

    error(title, message, duration) {
        return this.show('error', title, message, duration);
    },

    warning(title, message, duration) {
        return this.show('warning', title, message, duration);
    },

    info(title, message, duration) {
        return this.show('info', title, message, duration);
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.ToastManager.init();
});
</script> 