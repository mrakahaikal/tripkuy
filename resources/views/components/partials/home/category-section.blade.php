@props(['categories'])

<section class="pt-28 pb-16 px-6 bg-surface">
    <div class="max-w-7xl mx-auto">
        <x-ui.section-header
            eyebrow="Pilih Sesuai Minatmu"
            title="Jelajahi Berdasarkan Kategori"
            subtitle="Dari hiking menantang hingga diving eksotis — temukan pengalaman yang tepat untukmu."
        />
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @forelse($categories as $cat)
                <a href="{{ route('trips.index', ['category' => $cat->slug]) }}"
                   class="group relative overflow-hidden rounded-2xl aspect-3/4 block shadow-card">
                    @if($cat->image)
                        <img
                            src="{{ $cat->image }}"
                            alt="{{ $cat->name }}"
                            class="absolute inset-0 size-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        >
                    @else
                        <div class="absolute inset-0 bg-linear-to-br from-brand-700 to-teal-500"></div>
                    @endif
                    <div class="absolute inset-0 bg-linear-to-t from-black/75 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        @if($cat->icon)
                            <x-dynamic-component
                                :component="'lucide-' . $cat->icon"
                                class="w-5 h-5 text-white/80 mb-2"
                            />
                        @endif
                        <div class="font-display font-bold text-white text-sm leading-tight">
                            {{ $cat->name }}
                        </div>
                        <div class="text-white/60 text-xs mt-0.5">
                            {{ $cat->trips_count }} trip
                        </div>
                    </div>
                </a>
            @empty
                <p>Ups, belum ada data apapun di sini</p>
            @endforelse
        </div>
    </div>
</section>
