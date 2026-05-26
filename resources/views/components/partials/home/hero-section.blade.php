@props(['categories'])

<section class="relative overflow-hidden pt-20 pb-28 px-6">

    {{-- Background photo --}}
    <img
        src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=1920&q=80"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 size-full object-cover object-center"
        loading="eager"
    >

    {{-- Brand gradient overlay --}}
    <div class="absolute inset-0 bg-linear-to-br from-brand-900/90 via-brand-800/75 to-teal-700/60"></div>

    <div class="max-w-7xl mx-auto relative z-1">

        {{-- Hero copy --}}
        <div class="max-w-160 mb-12">
            <p class="text-[0.8rem] font-bold tracking-widest uppercase text-teal-300 mb-4">
                Platform Open Trip Indonesia #1
            </p>
            <h1 class="font-display text-[clamp(2.5rem,5vw,4rem)] font-extrabold text-white leading-[1.12] mb-5">
                Temukan Trip<br>Impianmu
            </h1>
            <p class="text-lg text-brand-200 leading-[1.7] mb-9 max-w-120">
                Ratusan open trip ke destinasi terbaik Indonesia bersama guide lokal terpercaya. Aman, mudah, dan berkesan.
            </p>
            <div class="flex items-center gap-3.5 flex-wrap">
                <a href="{{ route('trips.index') }}" class="btn btn-coral btn-lg">
                    <x-lucide-compass class="w-5 h-5" />
                    Jelajahi Trip
                </a>
                <a href="{{ route('trips.index') }}" class="btn btn-ghost btn-lg text-white border-white/35">
                    Lihat Semua
                    <x-lucide-arrow-right class="w-4 h-4" />
                </a>
            </div>
        </div>

        {{-- Search widget --}}
        <div class="search-widget max-w-190 relative z-10 -mb-14">
            <form action="{{ route('trips.index') }}" method="GET">
                <div class="mb-4.5">
                    <p class="font-display font-bold text-[1.0625rem] text-ink mb-0.5">
                        Cari Trip
                    </p>
                    <p class="text-[0.8125rem] text-ink-muted">Temukan trip yang sesuai dengan keinginanmu</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <div>
                        <label class="block text-[0.8125rem] font-semibold text-ink-secondary mb-1.5">
                            Destinasi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-ink-muted flex pointer-events-none">
                                <x-lucide-map-pin class="w-4 h-4" />
                            </span>
                            <input
                                class="input pl-9.5"
                                name="destination"
                                placeholder="Contoh: Bali, Bromo..."
                                value="{{ request('destination') }}"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-[0.8125rem] font-semibold text-ink-secondary mb-1.5">
                            Tanggal Keberangkatan
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-ink-muted flex pointer-events-none">
                                <x-lucide-calendar class="w-4 h-4" />
                            </span>
                            <input
                                class="input pl-9.5"
                                type="date"
                                name="date"
                                value="{{ request('date') }}"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-[0.8125rem] font-semibold text-ink-secondary mb-1.5">
                            Kategori
                        </label>
                        <select class="input" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-md w-full justify-center">
                    <x-lucide-search class="w-4 h-4" />
                    Cari Trip Sekarang
                </button>
            </form>
        </div>
    </div>
</section>
