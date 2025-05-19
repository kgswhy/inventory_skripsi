<aside class="w-64 bg-white shadow-lg">
    <div class="h-16 flex items-center justify-center border-b">
        <h2 class="text-xl font-bold text-gray-800">{{ config('app.name', 'BonsMerch') }}</h2>
    </div>
    
    <nav class="mt-6">
        <div class="px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                Dashboard
            </a>
            
            <a href="{{ route('admin.manage-staff') }}" 
               class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.manage-staff') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                Manage Staff
            </a>
            
            <a href="{{ route('admin.profile') }}" 
               class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.profile') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50' }}">
                Profile
            </a>
        </div>
    </nav>
</aside> 