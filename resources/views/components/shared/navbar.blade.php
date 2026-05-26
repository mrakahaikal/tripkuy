<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 0 }, { passive: true })"
    :class="scrolled ? 'shadow-md' : ''"
    class="sticky top-0 z-50 bg-white border-b border-border transition-shadow duration-200"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="h-16 flex items-center justify-between gap-8">

            {{-- Logo --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5 no-underline shrink-0">
                <div class="w-9 h-9 bg-linear-to-br from-brand-600 to-teal-500 rounded-md flex items-center justify-center">
                    <x-lucide-plane class="w-4 h-4 text-white" />
                </div>
                <span class="font-display font-extrabold text-xl text-ink">TripKuy</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-1 flex-1">
                <a href="{{ route('trips.index') }}" wire:navigate class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}">
                    Trips
                </a>
                <a href="{{ route('blog.index') }}" wire:navigate class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    Blog
                </a>
                <a href="{{ route('about.index') }}" wire:navigate class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">
                    Tentang
                </a>
                <a href="{{ route('contact.index') }}" wire:navigate class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                    Kontak
                </a>
            </nav>

            {{-- Desktop right --}}
            <div class="hidden md:flex items-center gap-2.5 shrink-0">
                @guest
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" wire:navigate class="btn btn-ghost btn-sm">Masuk</a>
                    @endif
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="btn btn-primary btn-sm">Daftar Gratis</a>
                    @endif
                @endguest

                @auth
                    <div x-data="{ userOpen: false }" class="relative">
                        <button
                            @click="userOpen = !userOpen"
                            @click.outside="userOpen = false"
                            class="flex items-center gap-2 py-1.5 pl-1.5 pr-3 rounded-full border border-border bg-surface-raised cursor-pointer transition-all duration-150"
                            :class="userOpen ? 'border-brand-400 ring-[3px] ring-brand-400/15' : ''"
                        >
                            @if(auth()->user()->avatar_url)
                                <img
                                    src="{{ auth()->user()->avatar_url }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-7 h-7 rounded-full object-cover"
                                >
                            @else
                                <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                                    <span class="text-xs font-bold text-brand-600">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <span class="text-sm font-semibold text-ink">
                                {{ Str::words(auth()->user()->name, 1, '') }}
                            </span>
                            <span
                                class="inline-flex transition-transform duration-200 text-ink-muted"
                                :class="userOpen ? 'rotate-180' : ''"
                            >
                                <x-lucide-chevron-down class="w-3.5 h-3.5" />
                            </span>
                        </button>

                        <div
                            x-show="userOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="absolute right-0 top-[calc(100%+0.5rem)] min-w-55 bg-white rounded-xl shadow-lg border border-border z-50 overflow-hidden"
                        >
                            <div class="px-4 py-3.5 border-b border-border">
                                <div class="text-sm font-semibold text-ink">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-ink-muted mt-0.5">{{ auth()->user()->email }}</div>
                            </div>

                            <div class="p-1.5">
                                @if(Route::has('dashboard'))
                                    <a href="{{ route('dashboard') }}" wire:navigate class="dropdown-item">
                                        <x-lucide-layout-dashboard class="w-4 h-4" />
                                        Dashboard
                                    </a>
                                @endif
                                @if(Route::has('dashboard.bookings'))
                                    <a href="{{ route('dashboard.bookings') }}" wire:navigate class="dropdown-item">
                                        <x-lucide-ticket class="w-4 h-4" />
                                        Booking Saya
                                    </a>
                                @endif
                                @if(Route::has('dashboard.wishlist'))
                                    <a href="{{ route('dashboard.wishlist') }}" wire:navigate class="dropdown-item">
                                        <x-lucide-heart class="w-4 h-4" />
                                        Wishlist
                                    </a>
                                @endif
                                @if(Route::has('dashboard.profile'))
                                    <a href="{{ route('dashboard.profile') }}" wire:navigate class="dropdown-item">
                                        <x-lucide-user class="w-4 h-4" />
                                        Profil
                                    </a>
                                @endif
                            </div>

                            <div class="p-1.5 border-t border-border">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-danger">
                                        <x-lucide-log-out class="w-4 h-4" />
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="open = !open"
                class="md:hidden btn btn-ghost btn-icon shrink-0"
                aria-label="Toggle menu"
            >
                <x-lucide-menu x-show="!open" class="w-5 h-5" />
                <x-lucide-x x-show="open" x-cloak class="w-5 h-5" />
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="md:hidden bg-white border-t border-border shadow-lg"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-4 pb-6">

            <nav class="flex flex-col gap-1 mb-5">
                <a
                    href="{{ route('trips.index') }}"
                    class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }} flex items-center gap-2.5"
                    @click="open = false"
                >
                    <x-lucide-map class="w-4 h-4" />
                    Trips
                </a>
                <a
                    href="{{ route('blog.index') }}"
                    class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }} flex items-center gap-2.5"
                    @click="open = false"
                >
                    <x-lucide-book-open class="w-4 h-4" />
                    Blog
                </a>
                <a
                    href="{{ route('about.index') }}"
                    class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }} flex items-center gap-2.5"
                    @click="open = false"
                >
                    <x-lucide-info class="w-4 h-4" />
                    Tentang
                </a>
                <a
                    href="{{ route('contact.index') }}"
                    class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }} flex items-center gap-2.5"
                    @click="open = false"
                >
                    <x-lucide-mail class="w-4 h-4" />
                    Kontak
                </a>
            </nav>

            <hr class="border-t border-border mb-5">

            @guest
                <div class="flex flex-col gap-2.5">
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" wire:navigate class="btn btn-ghost btn-md justify-center">Masuk</a>
                    @endif
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" wire:navigate class="btn btn-primary btn-md justify-center">Daftar Gratis</a>
                    @endif
                </div>
            @endguest

            @auth
                <div class="flex items-center gap-3 p-3.5 bg-surface-sunken rounded-lg mb-4">
                    @if(auth()->user()->avatar_url)
                        <img
                            src="{{ auth()->user()->avatar_url }}"
                            alt="{{ auth()->user()->name }}"
                            class="w-11 h-11 rounded-full object-cover shrink-0"
                        >
                    @else
                        <div class="w-11 h-11 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                            <span class="text-lg font-bold text-brand-600">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <div class="min-w-0">
                        <div class="text-[0.9375rem] font-semibold text-ink truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-ink-muted truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <nav class="flex flex-col gap-1 mb-4">
                    @if(Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}" wire:navigate class="nav-link flex items-center gap-2.5" @click="open = false">
                            <x-lucide-layout-dashboard class="w-4 h-4" /> Dashboard
                        </a>
                    @endif
                    @if(Route::has('dashboard.bookings'))
                        <a href="{{ route('dashboard.bookings') }}" wire:navigate class="nav-link flex items-center gap-2.5" @click="open = false">
                            <x-lucide-ticket class="w-4 h-4" /> Booking Saya
                        </a>
                    @endif
                    @if(Route::has('dashboard.wishlist'))
                        <a href="{{ route('dashboard.wishlist') }}" wire:navigate class="nav-link flex items-center gap-2.5" @click="open = false">
                            <x-lucide-heart class="w-4 h-4" /> Wishlist
                        </a>
                    @endif
                    @if(Route::has('dashboard.profile'))
                        <a href="{{ route('dashboard.profile') }}" wire:navigate class="nav-link flex items-center gap-2.5" @click="open = false">
                            <x-lucide-user class="w-4 h-4" /> Profil
                        </a>
                    @endif
                </nav>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-md w-full justify-center text-danger">
                        <x-lucide-log-out class="w-4 h-4" />
                        Keluar
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>
