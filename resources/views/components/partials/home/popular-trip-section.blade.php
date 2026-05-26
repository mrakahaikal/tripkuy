@props(['popularTrips'])

<section class="py-16 px-6 bg-surface-sunken">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-end justify-between gap-4 flex-wrap mb-10">
            <x-ui.section-header
                eyebrow="Trip Populer"
                title="Yang Paling Banyak Dipilih"
            />
            <a href="{{ route('trips.index') }}" class="btn btn-secondary btn-sm shrink-0">
                Lihat Semua Trip
                <x-lucide-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>

        @if($popularTrips->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularTrips as $trip)
                    <x-ui.trip-card :trip="$trip" />
                @endforeach
            </div>
        @else
            <div class="text-center py-16 px-8 text-ink-muted">
                <x-lucide-map class="w-12 h-12 mx-auto mb-4 opacity-40" />
                <p class="text-base">Belum ada trip yang tersedia saat ini.</p>
                <p class="text-sm mt-1.5">Cek kembali nanti ya!</p>
            </div>
        @endif
    </div>
</section>
