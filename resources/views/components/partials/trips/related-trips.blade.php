@props(['relatedTrips'])

@if($relatedTrips->isNotEmpty())
    <div class="bg-surface-sunken border-t border-border py-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-display text-xl font-bold text-ink mb-6">Trip Serupa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($relatedTrips as $related)
                    <x-ui.trip-card :trip="$related" />
                @endforeach
            </div>
        </div>
    </div>
@endif
