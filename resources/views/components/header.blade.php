<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header-title', 'Dashboard')</h1>
            </div>
            
            <div class="flex items-center">
                <div class="ml-3 relative">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.profile') }}" class="text-gray-600 hover:text-gray-900">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header> 