<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex space-x-2 sm:-my-px sm:ms-6 items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('contents.index') }}" :active="request()->routeIs('contents.*')">
                        {{ __('Content Manager') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('doctors.index') }}" :active="request()->routeIs('doctors.*')">
                        {{ __('Doctor Record') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('onlineAppointment.index') }}" :active="request()->routeIs('onlineAppointment.*')">
                        {{ __('Appointment') }}
                    </x-nav-link>

                    <x-dropdown>
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-1.5 rounded-md border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-300 focus:outline-none transition ease-in-out duration-150">
                                    Settings
                                    <svg class="ms-1.5 -me-0.5 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('organization.index') }}">
                                {{ __('Organization Setup') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-700 hover:bg-indigo-50 focus:outline-none transition ease-in-out duration-150">
                                        <span class="inline-flex items-center justify-center size-7 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs">
                                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                        </span>
                                        {{ Auth::user()->name ?? null }}
                                        <svg class="-me-0.5 size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif
                            <div class="border-t border-gray-200"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger (mobile only) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">

        <!-- Mobile Nav Links -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('contents.index') }}" :active="request()->routeIs('contents.*')">
                {{ __('Content Manager') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('doctors.index') }}" :active="request()->routeIs('doctors.*')">
                {{ __('Doctor Record') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('onlineAppointment.index') }}" :active="request()->routeIs('onlineAppointment.*')">
                {{ __('Online Appointment') }}
            </x-responsive-nav-link>

            <!-- Settings sub-links -->
            <div class="border-t border-gray-200 pt-1">
                <div class="block px-4 py-1 text-xs text-gray-400 uppercase tracking-wider">Settings</div>
                <x-responsive-nav-link href="{{ route('organization.index') }}" :active="request()->routeIs('organization.*')">
                    {{ __('Organization Setup') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Mobile User Info + Account Links -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name ?? null }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email ?? null }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
