<x-layouts.app title="TripKuy — Open Trip Terbaik Indonesia">

    {{-- ============================================================ --}}
    {{-- SECTION 1: HERO                                              --}}
    {{-- ============================================================ --}}
    <x-partials::home.hero-section :$categories />

    {{-- ============================================================ --}}
    {{-- SECTION 2: KATEGORI                                          --}}
    {{-- ============================================================ --}}
    <x-partials::home.category-section :$categories />

    {{-- ============================================================ --}}
    {{-- SECTION 3: TRIP TERPOPULER                                   --}}
    {{-- ============================================================ --}}
    <x-partials::home.popular-trip-section :$popularTrips />

    {{-- ============================================================ --}}
    {{-- SECTION 4: MENGAPA TRIPKUY?                                  --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-brand-900">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-[0.75rem] font-bold tracking-widest uppercase text-teal-400 mb-3">
                    Mengapa TripKuy?
                </p>
                <h2 class="font-display text-2xl md:text-3xl font-bold text-white leading-snug">
                    Alasan Ribuan Traveler Percaya Kami
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/15 flex items-center justify-center shrink-0">
                        <x-lucide-users class="w-6 h-6 text-teal-300" />
                    </div>
                    <div>
                        <div class="font-display font-bold text-white mb-1">Guide Lokal Berpengalaman</div>
                        <div class="text-sm text-brand-300 leading-relaxed">Setiap trip dipandu guide lokal bersertifikat yang paham medan dan budaya setempat.</div>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-coral-500/15 flex items-center justify-center shrink-0">
                        <x-lucide-banknote class="w-6 h-6 text-coral-300" />
                    </div>
                    <div>
                        <div class="font-display font-bold text-white mb-1">Harga Transparan</div>
                        <div class="text-sm text-brand-300 leading-relaxed">Tidak ada biaya tersembunyi. Semua sudah termasuk dalam harga yang tertera di halaman trip.</div>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/20 flex items-center justify-center shrink-0">
                        <x-lucide-zap class="w-6 h-6 text-brand-300" />
                    </div>
                    <div>
                        <div class="font-display font-bold text-white mb-1">Booking 5 Menit</div>
                        <div class="text-sm text-brand-300 leading-relaxed">Daftar, pilih trip, dan selesaikan pembayaran — semua bisa dilakukan dalam hitungan menit.</div>
                    </div>
                </div>

                <div class="flex flex-col items-center text-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/15 flex items-center justify-center shrink-0">
                        <x-lucide-shield-check class="w-6 h-6 text-teal-300" />
                    </div>
                    <div>
                        <div class="font-display font-bold text-white mb-1">Refund 100% Terjamin</div>
                        <div class="text-sm text-brand-300 leading-relaxed">Jika trip dibatalkan dari pihak kami, dana kamu dikembalikan penuh tanpa pertanyaan.</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- SECTION 5: DESTINASI POPULER                                 --}}
    {{-- ============================================================ --}}
    @if($destinations->isNotEmpty())
    <section class="py-20 px-6 bg-surface">
        <div class="max-w-7xl mx-auto">
            <x-ui.section-header
                eyebrow="Jelajahi Destinasi"
                title="Kemana Kamu Mau Pergi?"
                subtitle="Dari sabang sampai merauke, ribuan destinasi menanti petualanganmu."
            />

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($destinations as $dest)
                    <a href="{{ route('trips.index', ['destination' => $dest->destination]) }}"
                       class="group relative overflow-hidden rounded-xl aspect-4/3 block shadow-card no-underline">
                        <img
                            src="{{ $dest->cover_image_url }}"
                            alt="{{ $dest->destination }}"
                            class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <div class="font-display text-[1.0625rem] font-bold text-white mb-1">
                                {{ $dest->destination }}
                            </div>
                            <div class="flex items-center gap-1">
                                <x-lucide-map-pin class="w-3 h-3 text-teal-300 shrink-0" />
                                <span class="text-[0.78rem] text-white/75">Lihat trip tersedia</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================================ --}}
    {{-- SECTION 6: CARA KERJA                                        --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 bg-surface-sunken">
        <div class="max-w-7xl mx-auto">
            <x-ui.section-header
                eyebrow="Mudah & Cepat"
                title="Cara Kerja TripKuy"
                subtitle="Booking trip impianmu dalam 3 langkah mudah."
                align="center"
            />

            @php
            $steps = [
                ['icon' => 'search',      'bg' => 'bg-brand-100', 'text' => 'text-brand-600', 'num' => '01', 'title' => 'Pilih Trip',       'desc' => 'Telusuri ratusan open trip dari berbagai destinasi. Filter berdasarkan kategori, tanggal, dan budget.'],
                ['icon' => 'credit-card', 'bg' => 'bg-coral-100', 'text' => 'text-coral-600', 'num' => '02', 'title' => 'Booking & Bayar',  'desc' => 'Isi data peserta, konfirmasi booking, dan lakukan pembayaran. Proses cepat dalam hitungan menit.'],
                ['icon' => 'tent',        'bg' => 'bg-teal-100',  'text' => 'text-teal-600',  'num' => '03', 'title' => 'Berangkat!',       'desc' => 'Terima konfirmasi, siapkan perlengkapan, dan nikmati petualangan bersama guide lokal terpercaya.'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                @foreach($steps as $step)
                <div class="text-center">
                    <div class="relative inline-block mb-6">
                        <div class="w-18 h-18 {{ $step['bg'] }} rounded-xl flex items-center justify-center mx-auto {{ $step['text'] }}">
                            <x-dynamic-component :component="'lucide-' . $step['icon']" class="w-7 h-7" />
                        </div>
                        <div class="absolute -top-2 -right-2 w-7 h-7 bg-brand-600 rounded-full flex items-center justify-center border-[2.5px] border-surface-sunken">
                            <span class="text-[0.65rem] font-extrabold text-white">{{ $step['num'] }}</span>
                        </div>
                    </div>
                    <h3 class="font-display text-[1.0625rem] font-bold text-ink mb-2.5">
                        {{ $step['title'] }}
                    </h3>
                    <p class="text-sm text-ink-secondary leading-[1.7] max-w-60 mx-auto">
                        {{ $step['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- SECTION 7: TESTIMONIAL                                       --}}
    {{-- ============================================================ --}}
    @if($latestReviews->isNotEmpty())
    <section class="py-20 px-6 bg-surface">
        <div class="max-w-7xl mx-auto">
            <x-ui.section-header
                eyebrow="Dipercaya Traveler"
                title="Cerita Mereka"
                subtitle="Ribuan traveler telah merasakan pengalaman tak terlupakan bersama TripKuy."
                align="center"
            />

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($latestReviews as $review)
                <div class="card-flat p-6 border-l-4 border-coral-400 flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <div class="stars text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                        <span class="text-[0.8rem] font-semibold text-ink-secondary">{{ $review->rating }}/5</span>
                    </div>

                    <p class="text-[0.9rem] text-ink-secondary leading-[1.7] italic m-0 line-clamp-3">
                        "{{ $review->comment }}"
                    </p>

                    @if($review->trip)
                        <div class="flex items-center gap-1.5 text-[0.8rem]">
                            <x-lucide-map-pin class="w-3.5 h-3.5 text-brand-500 shrink-0" />
                            <span class="text-brand-600 font-medium">{{ $review->trip->title }}</span>
                        </div>
                    @endif

                    <hr class="divider my-0">

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
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================================ --}}
    {{-- SECTION 8: BLOG                                              --}}
    {{-- ============================================================ --}}
    @if($latestPosts->isNotEmpty())
    <section class="py-20 px-6 bg-surface-sunken">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between gap-4 flex-wrap mb-10">
                <x-ui.section-header
                    eyebrow="Dari Blog Kami"
                    title="Inspirasi Perjalananmu"
                />
                <a href="{{ route('blog.index') }}" class="btn btn-ghost btn-sm shrink-0">
                    Semua Artikel
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestPosts as $post)
                    <x-ui.post-card :post="$post" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ============================================================ --}}
    {{-- SECTION 9: CTA BANNER                                        --}}
    {{-- ============================================================ --}}
    <section class="relative overflow-hidden py-20 px-6 bg-linear-to-br from-teal-700 to-brand-700">
        <div class="max-w-2xl mx-auto text-center relative z-1">
            <p class="text-[0.75rem] font-bold tracking-widest uppercase text-teal-300 mb-3">
                Mulai Sekarang
            </p>
            <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-extrabold text-white leading-[1.15] mb-5">
                Siap Berpetualang?
            </h2>
            <p class="text-[1.0625rem] text-white/80 leading-[1.7] mb-10">
                Bergabung bersama ribuan traveler yang sudah merasakan petualangan tak terlupakan. Daftar gratis dan temukan trip impianmu sekarang.
            </p>

            @guest
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-coral btn-xl">
                            <x-lucide-user-plus class="w-5 h-5" />
                            Daftar Gratis
                        </a>
                    @endif
                    <a href="{{ route('trips.index') }}" class="btn btn-ghost btn-lg text-white border-white/35">
                        Lihat Trip Dulu
                    </a>
                </div>
                <p class="text-[0.8125rem] text-white/60 mt-5">
                    Gratis · Tidak perlu kartu kredit · Batalkan kapan saja
                </p>
            @endguest

            @auth
                <a href="{{ route('trips.index') }}" class="btn btn-coral btn-xl">
                    <x-lucide-compass class="w-5 h-5" />
                    Temukan Trip Sekarang
                </a>
            @endauth
        </div>
    </section>

</x-layouts.app>
