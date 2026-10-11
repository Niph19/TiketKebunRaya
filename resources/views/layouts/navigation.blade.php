<nav x-data="{ open: false }" class="sticky top-0 z-20 border-b border-emerald-100 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between">

            {{-- Logo --}}
            <a
                href="{{ Auth::user()->role === 'admin' ? route('admin.index') : route('dashboard.index') }}"
                class="font-bold text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700"
            >
                Tiket Kebun Raya
            </a>

            {{-- Desktop nav --}}
            <div class="hidden sm:flex sm:items-center sm:gap-1">
                <x-nav-link
                    :href="Auth::user()->role === 'admin' ? route('admin.index') : route('dashboard.index')"
                    :active="request()->routeIs('dashboard.*', 'admin.*')"
                >
                    {{ Auth::user()->role === 'admin' ? 'Dashboard Admin' : 'Pesanan Saya' }}
                </x-nav-link>

                {{-- User dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="ms-3 inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-700 transition duration-150">
                            {{ Auth::user()->name }}
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <button
                @click="open = !open"
                class="-me-2 flex items-center justify-center rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition sm:hidden"
                aria-label="Buka menu"
            >
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden border-t border-slate-100 sm:hidden">
        <div class="space-y-1 px-4 pb-3 pt-2">
            <x-responsive-nav-link
                :href="Auth::user()->role === 'admin' ? route('admin.index') : route('dashboard.index')"
                :active="request()->routeIs('dashboard.*', 'admin.*')"
            >
                {{ Auth::user()->role === 'admin' ? 'Dashboard Admin' : 'Pesanan Saya' }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-100 pb-2 pt-4">
            <div class="px-4 pb-3">
                <div class="font-semibold text-sm text-slate-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
