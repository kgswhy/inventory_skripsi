<header class="bg-[#1e2a3a] shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-18">
        <div class="flex items-center">
            <span class="text-white font-bold text-lg uppercase">
                @yield('header-title', 'Dashboard')
            </span>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div id="profileDropdownToggle" class="flex items-center cursor-pointer select-none">
                    <div class="inline-block w-9 h-9 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="ml-2 leading-tight">
                        <div class="text-white text-sm font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-gray-300 text-xs">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                    </div>
                    <div class="ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-40 bg-white rounded shadow-lg py-2 z-50 hidden">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
@push('scripts')
<script>
(function() {
    const toggle = document.getElementById('profileDropdownToggle');
    const menu = document.getElementById('profileDropdownMenu');
    let open = false;
    toggle.addEventListener('click', function(e) {
        e.stopPropagation();
        open = !open;
        menu.classList.toggle('hidden', !open);
    });
    document.addEventListener('click', function(e) {
        if (open) {
            menu.classList.add('hidden');
            open = false;
        }
    });
})();
</script>
@endpush