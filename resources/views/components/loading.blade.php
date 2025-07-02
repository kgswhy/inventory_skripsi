@props([
    'size' => 'md',
    'overlay' => false,
    'text' => 'Loading...',
    'color' => 'teal'
])

@php
    $sizes = [
        'sm' => 'h-4 w-4',
        'md' => 'h-8 w-8', 
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16'
    ];

    $colors = [
        'teal' => 'text-teal-600',
        'blue' => 'text-blue-600',
        'red' => 'text-red-600',
        'green' => 'text-green-600',
        'yellow' => 'text-yellow-600',
        'gray' => 'text-gray-600'
    ];
@endphp

@if($overlay)
    <!-- Full screen overlay -->
    <div {{ $attributes->merge(['class' => 'fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50']) }}>
        <div class="bg-white rounded-lg p-6 flex flex-col items-center space-y-4">
            <svg class="animate-spin {{ $sizes[$size] ?? $sizes['md'] }} {{ $colors[$color] ?? $colors['teal'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            @if($text)
                <span class="text-gray-700 text-sm font-medium">{{ $text }}</span>
            @endif
        </div>
    </div>
@else
    <!-- Inline loading -->
    <div {{ $attributes->merge(['class' => 'flex items-center space-x-2']) }}>
        <svg class="animate-spin {{ $sizes[$size] ?? $sizes['md'] }} {{ $colors[$color] ?? $colors['teal'] }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        @if($text)
            <span class="text-gray-700 text-sm">{{ $text }}</span>
        @endif
    </div>
@endif

<script>
// Global Loading Manager
window.LoadingManager = {
    overlays: new Set(),
    
    show(id = 'default', text = 'Loading...') {
        const existingOverlay = document.getElementById(`loading-overlay-${id}`);
        if (existingOverlay) return;
        
        const overlay = document.createElement('div');
        overlay.id = `loading-overlay-${id}`;
        overlay.className = 'fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50';
        overlay.innerHTML = `
            <div class="bg-white rounded-lg p-6 flex flex-col items-center space-y-4">
                <svg class="animate-spin h-8 w-8 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 text-sm font-medium">${text}</span>
            </div>
        `;
        
        document.body.appendChild(overlay);
        this.overlays.add(id);
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    },
    
    hide(id = 'default') {
        const overlay = document.getElementById(`loading-overlay-${id}`);
        if (overlay) {
            overlay.remove();
            this.overlays.delete(id);
        }
        
        // Restore body scroll if no overlays remain
        if (this.overlays.size === 0) {
            document.body.style.overflow = '';
        }
    },
    
    hideAll() {
        this.overlays.forEach(id => {
            const overlay = document.getElementById(`loading-overlay-${id}`);
            if (overlay) overlay.remove();
        });
        this.overlays.clear();
        document.body.style.overflow = '';
    },
    
    // Button loading states
    setButtonLoading(button, loading = true, originalText = null) {
        if (loading) {
            if (!button.dataset.originalText) {
                button.dataset.originalText = button.innerHTML;
            }
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        } else {
            button.disabled = false;
            button.innerHTML = originalText || button.dataset.originalText || button.innerHTML;
        }
    }
};
</script> 