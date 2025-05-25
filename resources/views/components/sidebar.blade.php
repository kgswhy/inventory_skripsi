<aside class="w-64 min-h-screen bg-white shadow-lg">
    <!-- Header -->
    <div class="flex flex-col justify-center items-center text-white bg-gray-800 h-18">
        <h2 class="text-lg font-bold">BonsMerch</h2>
        <span class="text-xs tracking-wide">Point of Sales</span>
    </div>

    <!-- Navigation -->
    <nav class="mt-4">
        <div class="px-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all
               {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex justify-center items-center w-6 h-6 bg-gray-200 rounded-full">
                    🏠
                </div>
                Beranda
            </a>

            <!-- Section label -->
            <div class="px-2 mt-6 mb-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                Inventori
            </div>

            <!-- User Manager -->
            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all
               {{ request()->routeIs('admin.staff.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex justify-center items-center w-6 h-6 bg-gray-200 rounded-full">
                    👥
                </div>
                Manajemen Pengguna
            </a>

            <!-- Profile -->
            <a href="{{ route('admin.profile') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all
               {{ request()->routeIs('admin.profile') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="flex justify-center items-center w-6 h-6 bg-gray-200 rounded-full">
                    🗂️
                </div>
                Profil
            </a>
        </div>
    </nav>
</aside>
