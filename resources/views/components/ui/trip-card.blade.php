@props(['trip'])

@php
    $difficultyBadge = match($trip->difficulty_level) {
        'easy'     => ['class' => 'badge-success', 'label' => 'Mudah'],
        'moderate' => ['class' => 'badge-warning', 'label' => 'Sedang'],
        'hard'     => ['class' => 'badge-danger',  'label' => 'Sulit'],
        default    => ['class' => 'badge-neutral', 'label' => $trip->difficulty_level],
    };
    $imageUrl = $trip->cover_image_url;
@endphp

<a href="{{ route('trips.show', $trip->slug) }}" wire:navigate class="card group flex flex-col no-underline text-ink">

    {{-- Cover image --}}
    <div class="relative overflow-hidden aspect-video shrink-0">
        @if($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $trip->title }}"
                class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
            >
        @else
            <div class="size-full bg-linear-to-br from-brand-800 to-teal-700 flex items-center justify-center">
                <x-lucide-mountain class="w-12 h-12 text-white/30" />
            </div>
        @endif

        <div class="absolute inset-0 bg-linear-to-t from-black/55 to-transparent"></div>

        <div class="absolute top-3 left-3 flex gap-1.5">
            @if($trip->category)
                <span class="badge badge-solid-brand text-[0.7rem]">{{ $trip->category->name }}</span>
            @endif
        </div>
        <div class="absolute top-3 right-3">
            <span class="badge {{ $difficultyBadge['class'] }} text-[0.7rem] bg-white/15 backdrop-blur-sm text-white border border-white/25">
                {{ $difficultyBadge['label'] }}
            </span>
        </div>

        <div class="absolute bottom-3 left-3.5 flex items-center gap-1">
            <x-lucide-map-pin class="w-3.5 h-3.5 text-brand-300 shrink-0" />
            <span class="text-[0.8rem] text-white font-medium">{{ $trip->destination }}</span>
        </div>
    </div>

    {{-- Card content --}}
    <div class="p-[1.125rem] flex flex-col gap-2.5 flex-1">
        <h3 class="font-display text-base font-bold text-ink leading-[1.35] m-0">
            {{ $trip->title }}
        </h3>

        @if($trip->highlight)
            <p class="text-[0.8125rem] text-ink-secondary leading-[1.55] m-0 line-clamp-2">
                {{ $trip->highlight }}
            </p>
        @endif

        <div class="flex items-center gap-3.5 text-[0.8rem] text-ink-muted">
            <span class="flex items-center gap-1">
                <x-lucide-calendar class="w-3.5 h-3.5" />
                {{ $trip->start_date->translatedFormat('d M Y') }}
            </span>
            <span class="flex items-center gap-1">
                <x-lucide-clock class="w-3.5 h-3.5" />
                {{ $trip->duration_days }} hari
            </span>
        </div>

        @if($trip->reviews_count > 0)
            <div class="flex items-center gap-1.5">
                <div class="stars text-[0.75rem]">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= round($trip->reviews_avg_rating) ? '★' : '☆' }}
                    @endfor
                </div>
                <span class="text-[0.8rem] text-ink-secondary">
                    {{ number_format($trip->reviews_avg_rating, 1) }}
                    <span class="text-ink-muted">({{ $trip->reviews_count }})</span>
                </span>
            </div>
        @endif

        <hr class="divider mt-auto">

        <div class="flex items-center justify-between mt-0.5">
            <div>
                <div class="text-[0.75rem] text-ink-muted">mulai dari</div>
                <div class="price-tag">
                    <span class="text-[0.8rem] text-coral-600 font-semibold">Rp</span>
                    <span class="price-main text-lg">{{ number_format($trip->price, 0, ',', '.') }}</span>
                    <span class="text-[0.75rem] text-ink-muted">/orang</span>
                </div>
            </div>
            <span class="btn btn-primary btn-sm pointer-events-none">Lihat</span>
        </div>
    </div>
</a>
