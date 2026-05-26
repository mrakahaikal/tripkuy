<div>

    {{-- Toolbar: search + sort --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-5">

        {{-- Search --}}
        <div class="relative flex-1">
            <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-ink-muted pointer-events-none" />
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Cari judul atau topik artikel..."
                class="input input-sm pl-9 pr-9 w-full"
            >
            @if($search)
                <button
                    wire:click="$set('search', '')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted hover:text-ink transition-colors"
                    aria-label="Hapus pencarian"
                >
                    <x-lucide-x class="w-3.5 h-3.5" />
                </button>
            @endif
        </div>

        {{-- Sort --}}
        <div class="relative shrink-0">
            <x-lucide-arrow-up-down class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-ink-muted pointer-events-none" />
            <select wire:model.live="sortBy" class="input input-sm pl-8 pr-8 appearance-none cursor-pointer min-w-[140px]">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>
            <x-lucide-chevron-down class="absolute right-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-ink-muted pointer-events-none" />
        </div>

    </div>

    {{-- Category filter pills --}}
    @if($categories->isNotEmpty())
        <div class="flex gap-2 mb-5 overflow-x-auto pb-1 scrollbar-none -mx-0.5 px-0.5">
            <button
                wire:click="$set('category', '')"
                class="chip shrink-0 {{ $category === '' ? 'selected' : '' }}"
            >
                Semua
            </button>
            @foreach($categories as $cat)
                <button
                    wire:click="$set('category', '{{ $cat->slug }}')"
                    class="chip shrink-0 {{ $category === $cat->slug ? 'selected' : '' }}"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Result info + active filter tags --}}
    @if($this->hasActiveFilters() || $posts->isNotEmpty())
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6 min-h-[1.5rem]">

            {{-- Result count --}}
            <p class="text-sm text-ink-muted">
                <span class="font-semibold text-ink">{{ $posts->total() }}</span> artikel ditemukan
            </p>

            {{-- Active chips + reset --}}
            @if($this->hasActiveFilters())
                <div class="flex flex-wrap items-center gap-1.5">
                    @if($search)
                        <button
                            wire:click="$set('search', '')"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-medium hover:bg-brand-200 transition-colors"
                        >
                            <x-lucide-search class="w-3 h-3" />
                            "{{ Str::limit($search, 20) }}"
                            <x-lucide-x class="w-3 h-3" />
                        </button>
                    @endif
                    @if($category)
                        @php $activeCat = $categories->firstWhere('slug', $category) @endphp
                        <button
                            wire:click="$set('category', '')"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-medium hover:bg-brand-200 transition-colors"
                        >
                            <x-lucide-tag class="w-3 h-3" />
                            {{ $activeCat?->name ?? $category }}
                            <x-lucide-x class="w-3 h-3" />
                        </button>
                    @endif
                    <button
                        wire:click="resetFilters"
                        class="text-xs text-ink-muted hover:text-danger transition-colors"
                    >
                        Reset
                    </button>
                </div>
            @endif

        </div>
    @endif

    @if($posts->isNotEmpty())

        {{-- Featured post — only on page 1 with no active filters --}}
        @if($posts->currentPage() === 1 && !$this->hasActiveFilters())
            @php $featured = $posts->first(); @endphp
            @php $rest = $posts->slice(1); @endphp

            <a href="{{ route('blog.show', $featured->slug) }}" class="group flex flex-col md:flex-row gap-0 card overflow-hidden no-underline mb-8">
                {{-- Image --}}
                <div class="relative overflow-hidden md:w-1/2 aspect-video md:aspect-auto shrink-0">
                    @php
                        $featuredImg = $featured->cover_image
                            ? (str_starts_with($featured->cover_image, 'http') ? $featured->cover_image : Storage::url($featured->cover_image))
                            : null;
                    @endphp
                    @if($featuredImg)
                        <img src="{{ $featuredImg }}" alt="{{ $featured->title }}"
                             class="size-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="size-full bg-linear-to-br from-brand-800 to-teal-700 flex items-center justify-center">
                            <x-lucide-book-open class="w-12 h-12 text-white/30" />
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-linear-to-t from-black/30 to-transparent md:hidden"></div>
                </div>
                {{-- Content --}}
                <div class="p-6 md:p-8 flex flex-col justify-center gap-3 flex-1">
                    @if($featured->category)
                        <span class="badge badge-brand w-fit text-[0.7rem]">{{ $featured->category->name }}</span>
                    @endif
                    <h2 class="font-display text-xl md:text-2xl font-bold text-ink leading-snug m-0">
                        {{ $featured->title }}
                    </h2>
                    @if($featured->excerpt)
                        <p class="text-sm text-ink-secondary leading-relaxed m-0 line-clamp-3">{{ $featured->excerpt }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-1">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
                                <span class="text-[0.7rem] font-bold text-brand-600">{{ strtoupper(substr($featured->author->name, 0, 1)) }}</span>
                            </div>
                            <span class="text-sm font-medium text-ink-secondary">{{ $featured->author->name }}</span>
                        </div>
                        <span class="text-ink-muted">·</span>
                        <span class="text-sm text-ink-muted">{{ $featured->published_at->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
            </a>

            {{-- Rest of posts --}}
            @if($rest->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($rest as $post)
                        <x-ui.post-card :post="$post" />
                    @endforeach
                </div>
            @endif

        @else
            {{-- Normal grid (paginated pages or with filters active) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <x-ui.post-card :post="$post" />
                @endforeach
            </div>
        @endif

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif

    @else
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center text-center py-24 px-8">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center mb-5">
                <x-lucide-file-search class="w-8 h-8 text-brand-400" />
            </div>
            <h3 class="font-display font-bold text-lg text-ink mb-2">Artikel tidak ditemukan</h3>
            <p class="text-sm text-ink-muted max-w-xs leading-relaxed">
                Tidak ada artikel yang cocok. Coba kata kunci atau kategori yang berbeda.
            </p>
            @if($this->hasActiveFilters())
                <button wire:click="resetFilters" class="btn btn-secondary btn-sm mt-5">
                    Reset Filter
                </button>
            @endif
        </div>
    @endif

</div>
