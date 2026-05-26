@props(['trip'])

@php
    $difficultyBadge = match($trip->difficulty_level) {
        'easy'     => ['class' => 'badge-success', 'label' => 'Mudah'],
        'moderate' => ['class' => 'badge-warning', 'label' => 'Sedang'],
        'hard'     => ['class' => 'badge-danger',  'label' => 'Sulit'],
        default    => ['class' => 'badge-neutral', 'label' => $trip->difficulty_level],
    };
    $avgRating   = round($trip->reviews_avg_rating ?? 0, 1);
    $reviewCount = $trip->reviews_count ?? 0;
@endphp

<div class="relative overflow-hidden min-h-72 md:min-h-96 flex items-end">

    @if($trip->cover_image_url)
        <img
            src="{{ $trip->cover_image_url }}"
            alt="{{ $trip->title }}"
            class="absolute inset-0 size-full object-cover"
        >
    @else
        <div class="absolute inset-0 bg-linear-to-br from-brand-800 to-teal-700"></div>
    @endif

    <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/40 to-black/10"></div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 pb-8 pt-20">

        <nav class="flex items-center gap-1.5 text-xs text-white/60 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <x-lucide-chevron-right class="w-3 h-3" />
            <a href="{{ route('trips.index') }}" class="hover:text-white transition-colors">Semua Trip</a>
            <x-lucide-chevron-right class="w-3 h-3" />
            <span class="text-white/90 truncate max-w-48">{{ $trip->title }}</span>
        </nav>

        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if($trip->category)
                <span class="badge badge-solid-brand text-[0.7rem]">{{ $trip->category->name }}</span>
            @endif
            <span class="badge {{ $difficultyBadge['class'] }} text-[0.7rem] bg-white/15 backdrop-blur-sm text-white border border-white/25">
                {{ $difficultyBadge['label'] }}
            </span>
        </div>

        <h1 class="font-display text-2xl md:text-4xl font-extrabold text-white leading-tight mb-3 max-w-3xl">
            {{ $trip->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-sm text-white/75">
            @if($reviewCount > 0)
                <span class="flex items-center gap-1.5">
                    <span class="text-yellow-400">★</span>
                    <span class="font-semibold text-white">{{ $avgRating }}</span>
                    <span>({{ $reviewCount }} ulasan)</span>
                </span>
                <span class="text-white/30">·</span>
            @endif
            <span class="flex items-center gap-1">
                <x-lucide-map-pin class="w-3.5 h-3.5 text-teal-300 shrink-0" />
                {{ $trip->destination }}
            </span>
            <span class="text-white/30">·</span>
            <span class="flex items-center gap-1">
                <x-lucide-clock class="w-3.5 h-3.5 shrink-0" />
                {{ $trip->duration_days }} hari
            </span>
        </div>
    </div>
</div>
