<header class="bg-[#1e2a3a] shadow">
    <div class="flex justify-between items-center px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 h-18">
        <div class="flex items-center">
            <span class="text-lg font-bold text-white uppercase">
                @yield('header-title', 'Dashboard')
            </span>
        </div>
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div id="profileDropdownToggle" class="flex items-center cursor-pointer select-none">
                    <div class="inline-block overflow-hidden w-9 h-9 rounded-full border-2 border-green-500">
                        <img src="{{ auth()->user()->profile_image_url }}" alt="Profile" class="object-cover w-full h-full">
                    </div>
                    <div class="ml-2 leading-tight">
                        <div class="text-sm font-semibold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-300">{{ ucfirst(auth()->user()->role ?? 'User') }}</div>
                    </div>
                    <div class="ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div id="profileDropdownMenu" class="hidden absolute right-0 z-50 py-2 mt-2 w-40 bg-white rounded shadow-lg">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block px-4 py-2 w-full text-left text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
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
