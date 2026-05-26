<x-layouts.app title="Semua Trip — TripKuy">

    {{-- Page header --}}
    <div class="bg-surface-sunken border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
            <nav class="flex items-center gap-1.5 text-xs text-ink-muted mb-3">
                <a href="{{ route('home') }}" class="hover:text-ink transition-colors">Beranda</a>
                <x-lucide-chevron-right class="w-3 h-3" />
                <span class="text-ink">Semua Trip</span>
            </nav>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-ink leading-snug">
                Jelajahi Semua Trip
            </h1>
            <p class="text-sm text-ink-muted mt-1.5">
                Temukan open trip yang sempurna untuk petualangan berikutmu.
            </p>
        </div>
    </div>

    {{-- Livewire component --}}
    <livewire:trip-list />

</x-layouts.app>
