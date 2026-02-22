<nav class="w-[250px] h-screen bg-white border-r border-gray-200 ">

    <div class="flex items-center px-6 h-16 border-b border-gray-200 py-4">

        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <x-application-logo class="h-6 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Wazzafny</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <ul class="flex flex-col px-4 py-6  space-y-2">


        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>


        @if (auth()->user()->role === 'admin')
          <x-nav-link href="{{ route('companies.index') }}" :active="request()->routeIs('companies.index')">
            Companies
        </x-nav-link>
        @endif

        @if (auth()->user()->role === 'company-owner')
          <x-nav-link href="{{ route('My-Company.details') }}" :active="request()->routeIs('My-Company.details')">
            My Company
        </x-nav-link>
        @endif

      

        <x-nav-link href="{{ route('job-vacanceies.index') }}" :active="request()->routeIs('job-vacanceies.index')">
            Jobs
        </x-nav-link>

        <x-nav-link href="{{ route('job-applications.index') }}" :active="request()->routeIs('job-applications.index')">
            Applications
        </x-nav-link>

        @auth
            @if (auth()->user()->role === 'admin')
                <x-nav-link href="{{ route('admins.index') }}" :active="request()->routeIs('admins.index')">
                    Admins
                </x-nav-link>

                <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                    Users
                </x-nav-link>

                <x-nav-link href="{{ route('job-categories.index') }}" :active="request()->routeIs('job-categories.index')">
                    Job Categories
                </x-nav-link>
            @endif
        @endauth




        <hr />

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="text-red-600 hover:text-red-800">
                Logout
            </button>
        </form>

    </ul>







</nav>
