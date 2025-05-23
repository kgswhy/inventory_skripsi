<aside class="w-64 bg-white shadow-lg min-h-screen">
    <!-- Header -->
    <div class="bg-gray-800 text-white h-18 flex flex-col items-center justify-center">
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
                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200">
                    🏠
                </div>
                Dashboard
            </a>

            <!-- Section label -->
            <div class="mt-6 mb-1 px-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                Inventory
            </div>

            <!-- User Manager -->
            <a href="{{ route('admin.staff.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all
               {{ request()->routeIs('admin.staff.*') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200">
                    👥
                </div>
                User Manager
            </a>

            <!-- Profile -->
            <a href="{{ route('admin.profile') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all
               {{ request()->routeIs('admin.profile') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200">
                    🗂️
                </div>
                Profile
            </a>
        </div>
    </nav>
</aside>
