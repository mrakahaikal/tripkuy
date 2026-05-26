@props(['post'])

@php
    $imageUrl = $post->cover_image
        ? (str_starts_with($post->cover_image, 'http') ? $post->cover_image : Storage::url($post->cover_image))
        : null;
@endphp

<a href="{{ route('blog.show', $post->slug) }}" wire:navigate class="card group flex flex-col no-underline text-ink overflow-hidden">

    {{-- Cover image --}}
    <div class="relative overflow-hidden aspect-video shrink-0">
        @if($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $post->title }}"
                class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
            >
        @else
            <div class="size-full bg-linear-to-br from-teal-800 to-brand-700 flex items-center justify-center">
                <x-lucide-book-open class="w-10 h-10 text-white/30" />
            </div>
        @endif

        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent"></div>

        @if($post->category)
            <div class="absolute top-3 left-3">
                <span class="badge badge-solid-brand text-[0.7rem]">{{ $post->category->name }}</span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-[1.125rem] flex flex-col gap-2.5 flex-1">
        <h3 class="font-display text-[0.9375rem] font-bold text-ink leading-[1.4] m-0 line-clamp-2">
            {{ $post->title }}
        </h3>

        @if($post->excerpt)
            <p class="text-[0.8125rem] text-ink-secondary leading-[1.6] m-0 line-clamp-2">
                {{ $post->excerpt }}
            </p>
        @endif

        <hr class="divider mt-auto">

        <div class="flex items-center justify-between mt-0.5">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                    <span class="text-[0.7rem] font-bold text-brand-600">
                        {{ strtoupper(substr($post->author->name, 0, 1)) }}
                    </span>
                </div>
                <span class="text-[0.8rem] font-medium text-ink-secondary">{{ $post->author->name }}</span>
            </div>
            <span class="text-[0.75rem] text-ink-muted">{{ $post->published_at->diffForHumans() }}</span>
        </div>
    </div>
</a>
