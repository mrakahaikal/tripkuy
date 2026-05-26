<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300..700;1,9..40,300..700&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        <style>[x-cloak] { display: none !important; }</style>
    </head>
    <body>
        <div class="min-h-screen lg:grid lg:grid-cols-[44%_56%]">

            {{-- Left: brand panel (desktop only) --}}
            <div class="hidden lg:flex flex-col justify-between p-12 relative overflow-hidden">

                {{-- Background image --}}
                <img
                    src="https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1200&q=80"
                    alt=""
                    aria-hidden="true"
                    class="absolute inset-0 size-full object-cover"
                >

                {{-- Dark overlay so text stays readable --}}
                <div class="absolute inset-0 bg-linear-to-t from-black/85 via-black/50 to-black/40"></div>

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="relative flex items-center gap-2.5 no-underline w-fit">
                    <div class="w-9 h-9 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center shrink-0">
                        <x-lucide-plane class="w-4 h-4 text-white" />
                    </div>
                    <span class="font-display font-extrabold text-xl text-white">TripKuy</span>
                </a>

                {{-- Tagline + features --}}
                <div class="relative">
                    <h2 class="font-display text-[1.875rem] font-bold text-white leading-snug mb-3">
                        Petualangan terbaik<br>dimulai dari sini.
                    </h2>
                    <p class="text-white/55 text-sm leading-relaxed mb-10">
                        Ribuan traveler telah mempercayakan perjalanan impian mereka bersama TripKuy.
                    </p>

                    <div class="flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <x-lucide-shield-check class="w-4 h-4 text-white" />
                            </div>
                            <span class="text-white/70 text-sm">Refund 100% jika trip dibatalkan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <x-lucide-users class="w-4 h-4 text-white" />
                            </div>
                            <span class="text-white/70 text-sm">Guide lokal bersertifikat & berpengalaman</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-white/15 backdrop-blur-sm flex items-center justify-center shrink-0">
                                <x-lucide-zap class="w-4 h-4 text-white" />
                            </div>
                            <span class="text-white/70 text-sm">Booking mudah, selesai dalam 5 menit</span>
                        </div>
                    </div>
                </div>

                {{-- Copyright --}}
                <p class="relative text-white/30 text-xs">&copy; {{ date('Y') }} TripKuy. Semua hak dilindungi.</p>
            </div>

            {{-- Right: form panel --}}
            <div class="flex flex-col min-h-screen lg:min-h-0 bg-surface-sunken">

                {{-- Mobile top bar --}}
                <div class="flex items-center justify-between p-5 border-b border-border bg-white lg:hidden">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 bg-gradient-to-br from-brand-600 to-teal-500">
                            <x-lucide-plane class="w-3.5 h-3.5 text-white" />
                        </div>
                        <span class="font-display font-extrabold text-lg text-ink">TripKuy</span>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        <x-lucide-arrow-left class="w-3.5 h-3.5" />
                        Kembali
                    </a>
                </div>

                {{-- Centered form area --}}
                <div class="flex-1 flex flex-col justify-center items-center px-6 py-12">
                    <div class="w-full max-w-sm">
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>

        @livewireScripts
    </body>
</html>
