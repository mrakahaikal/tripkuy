@props(['title' => null])

@php
$navItems = [
    [
        'route'   => 'dashboard',
        'active'  => request()->routeIs('dashboard') && !request()->routeIs('dashboard.*'),
        'icon'    => 'layout-dashboard',
        'label'   => 'Dashboard',
    ],
    [
        'route'   => 'dashboard.bookings',
        'active'  => request()->routeIs('dashboard.bookings'),
        'icon'    => 'ticket',
        'label'   => 'Booking Saya',
    ],
    [
        'route'   => 'dashboard.wishlist',
        'active'  => request()->routeIs('dashboard.wishlist'),
        'icon'    => 'heart',
        'label'   => 'Wishlist',
    ],
    [
        'route'   => 'dashboard.profile',
        'active'  => request()->routeIs('dashboard.profile'),
        'icon'    => 'user',
        'label'   => 'Profil & Akun',
    ],
];

$user = auth()->user();
@endphp

<x-layouts.app :title="$title">
    <div class="bg-surface-sunken min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-7">

            {{-- Mobile: horizontal scrollable tab bar --}}
            <div class="lg:hidden -mx-4 sm:-mx-6 px-4 sm:px-6 mb-6">

                {{-- User info strip --}}
                <div class="flex items-center gap-3 mb-4 pt-1">
                    <div class="w-9 h-9 rounded-full bg-brand-100 overflow-hidden flex items-center justify-center shrink-0">
                        @if($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-brand-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-ink truncate">{{ $user->name }}</div>
                        <div class="text-xs text-ink-muted truncate">{{ $user->email }}</div>
                    </div>
                </div>

                {{-- Scrollable tabs --}}
                <div class="flex gap-1.5 overflow-x-auto pb-1 scrollbar-none">
                    @foreach($navItems as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-sm font-medium whitespace-nowrap shrink-0 transition-all duration-150 no-underline
                                {{ $item['active']
                                    ? 'bg-brand-600 text-white'
                                    : 'bg-white border border-border text-ink-secondary hover:text-ink' }}"
                            wire:navigate
                        >
                            <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-3.5 h-3.5" />
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Desktop: sidebar + content --}}
            <div class="flex items-start gap-6">

                {{-- Sidebar (desktop only) --}}
                <aside class="hidden lg:block w-60 shrink-0 sticky top-24">
                    <div class="bg-white border border-border rounded-2xl overflow-hidden">

                        {{-- User card --}}
                        <div class="px-5 pt-5 pb-4 border-b border-border">
                            <div class="w-14 h-14 rounded-full bg-brand-100 overflow-hidden flex items-center justify-center mb-3">
                                @if($user->avatar_url)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-bold text-brand-600">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="font-display font-bold text-ink text-[0.9375rem] leading-snug">
                                {{ $user->name }}
                            </div>
                            <div class="text-xs text-ink-muted mt-0.5 truncate">{{ $user->email }}</div>
                            <a href="{{ route('dashboard.profile') }}" wire:navigate
                               class="inline-flex items-center gap-1 text-xs text-brand-600 font-medium mt-2.5 hover:underline no-underline">
                                Edit profil
                                <x-lucide-arrow-right class="w-3 h-3" />
                            </a>
                        </div>

                        {{-- Navigation --}}
                        <nav class="p-2">
                            @foreach($navItems as $item)
                                <a
                                    href="{{ route($item['route']) }}"
                                    class="sidebar-link {{ $item['active'] ? 'active' : '' }}"
                                    wire:navigate
                                >
                                    <x-dynamic-component
                                        :component="'lucide-' . $item['icon']"
                                        class="w-4 h-4 shrink-0"
                                    />
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </nav>

                        {{-- Logout --}}
                        <div class="p-2 border-t border-border">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="sidebar-link text-danger hover:bg-danger/5 hover:text-danger">
                                    <x-lucide-log-out class="w-4 h-4 shrink-0" />
                                    Keluar
                                </button>
                            </form>
                        </div>

                    </div>
                </aside>

                {{-- Main content --}}
                <main class="flex-1 min-w-0">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </div>
</x-layouts.app>
