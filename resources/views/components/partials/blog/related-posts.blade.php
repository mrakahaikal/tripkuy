@props(['relatedPosts'])

@if($relatedPosts->isNotEmpty())
    <div class="bg-surface-sunken border-t border-border py-14 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between gap-4 flex-wrap mb-8">
                <div>
                    <p class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-brand-500 mb-1">Baca Selanjutnya</p>
                    <h2 class="font-display text-xl font-bold text-ink">Artikel Terkait</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="btn btn-ghost btn-sm shrink-0">
                    Semua Artikel
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <x-ui.post-card :post="$related" />
                @endforeach
            </div>
        </div>
    </div>
@endif
