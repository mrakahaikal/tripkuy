<x-layouts.app :title="$trip->title . ' — TripKuy'">

    @php $slots = $trip->availableSlots(); @endphp

    {{-- ============================================================ --}}
    {{-- SECTION 1: HERO                                              --}}
    {{-- ============================================================ --}}
    <x-partials::trips.hero-section :$trip />

    {{-- ============================================================ --}}
    {{-- SECTION 2: MAIN CONTENT + SIDEBAR                           --}}
    {{-- ============================================================ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Left column --}}
            <div class="flex-1 min-w-0 flex flex-col gap-10">
                <x-partials::trips.quick-stats :$trip :$slots />
                <x-partials::trips.description-section :$trip />
                <x-partials::trips.itinerary-section :$trip />
                <x-partials::trips.includes-section :$trip />
                <x-partials::trips.gallery-section :$trip />
                <x-partials::trips.faq-section :$trip />
                <x-partials::trips.reviews-section :$trip />
            </div>

            {{-- Sticky sidebar --}}
            <div class="w-full lg:w-80 xl:w-88 shrink-0">
                <x-partials::trips.booking-sidebar :$trip :$slots />
            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SECTION 3: RELATED TRIPS                                    --}}
    {{-- ============================================================ --}}
    <x-partials::trips.related-trips :$relatedTrips />

</x-layouts.app>
