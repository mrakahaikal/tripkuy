@props(['trip'])

@if($trip->reviews->isNotEmpty())
    @php
        $reviewCount = $trip->reviews_count ?? $trip->reviews->count();
        $avgRating   = round($trip->reviews_avg_rating ?? $trip->reviews->avg('rating'), 1);
    @endphp

    <div>
        <div class="flex items-end justify-between gap-4 mb-5">
            <h2 class="font-display text-lg font-bold text-ink">
                Ulasan Peserta
                <span class="text-sm font-normal text-ink-muted ml-1">({{ $reviewCount }})</span>
            </h2>
            <div class="flex items-center gap-1.5 shrink-0">
                <span class="text-yellow-400 text-lg">★</span>
                <span class="font-display font-bold text-xl text-ink">{{ $avgRating }}</span>
                <span class="text-sm text-ink-muted">/ 5</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($trip->reviews as $review)
                <div class="card-flat p-5 flex flex-col gap-3">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-brand-600">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-ink">{{ $review->user->name }}</div>
                                <div class="text-xs text-ink-muted">{{ $review->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-ink-subtle' }} text-sm">★</span>
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-ink-secondary leading-relaxed line-clamp-4 italic">
                            "{{ $review->comment }}"
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif
