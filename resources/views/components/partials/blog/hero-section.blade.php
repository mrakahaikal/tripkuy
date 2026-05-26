@props(['post'])

@php
    $imageUrl = $post->cover_image
        ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : Storage::url($post->cover_image))
        : null;
    $readingTime = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 200));
@endphp

<div class="relative overflow-hidden min-h-80 md:min-h-[28rem] flex items-end">

    @if($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $post->title }}"
             class="absolute inset-0 size-full object-cover">
    @else
        <div class="absolute inset-0 bg-linear-to-br from-teal-900 via-brand-800 to-brand-900"></div>
    @endif

    <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/50 to-black/15"></div>

    <div class="relative w-full max-w-3xl mx-auto px-4 sm:px-6 pb-10 pt-24">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs text-white/55 mb-5">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
            <x-lucide-chevron-right class="w-3 h-3 shrink-0" />
            <a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
            @if($post->category)
                <x-lucide-chevron-right class="w-3 h-3 shrink-0" />
                <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
                   class="hover:text-white transition-colors">{{ $post->category->name }}</a>
            @endif
        </nav>

        @if($post->category)
            <span class="badge badge-solid-brand text-[0.7rem] mb-3 inline-block">{{ $post->category->name }}</span>
        @endif

        <h1 class="font-display text-2xl md:text-[2rem] font-extrabold text-white leading-tight mb-5 max-w-2xl">
            {{ $post->title }}
        </h1>

        <div class="flex flex-wrap items-center justify-between gap-4">
            {{-- Author + meta --}}
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-sm text-white/70">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                        <span class="text-[0.65rem] font-bold text-white">{{ strtoupper(substr($post->author->name, 0, 1)) }}</span>
                    </div>
                    <span class="font-medium text-white/90">{{ $post->author->name }}</span>
                </div>
                <span class="text-white/30">·</span>
                <span>{{ $post->published_at->translatedFormat('d F Y') }}</span>
                <span class="text-white/30">·</span>
                <span class="flex items-center gap-1">
                    <x-lucide-clock class="w-3.5 h-3.5" />
                    {{ $readingTime }} menit baca
                </span>
            </div>

            {{-- Share button --}}
            <div x-data="{ copied: false }">
                <button
                    @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                    class="flex items-center gap-1.5 text-xs text-white/60 hover:text-white transition-colors"
                >
                    <template x-if="!copied">
                        <x-lucide-share-2 class="w-3.5 h-3.5" />
                    </template>
                    <template x-if="copied">
                        <x-lucide-check class="w-3.5 h-3.5 text-teal-400" />
                    </template>
                    <span x-text="copied ? 'Tersalin!' : 'Bagikan'"></span>
                </button>
            </div>
        </div>

    </div>
</div>
