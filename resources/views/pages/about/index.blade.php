<x-layouts.app title="Tentang Kami — TripKuy">

    {{-- ============================================================ --}}
    {{-- HERO                                                          --}}
    {{-- ============================================================ --}}
    <section class="relative overflow-hidden bg-brand-950 py-24 px-6">

        {{-- Background image --}}
        <img
            src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&h=800&fit=crop&q=80"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 size-full object-cover opacity-20"
        >

        <div class="relative max-w-7xl mx-auto text-center">
            <p class="text-xs font-bold tracking-widest uppercase text-teal-400 mb-4">Tentang TripKuy</p>
            <h1 class="font-display text-[clamp(2.25rem,5vw,3.5rem)] font-extrabold text-white leading-[1.15] mb-5">
                Kami Ada untuk Membawamu<br class="hidden sm:block"> ke Tempat Impianmu
            </h1>
            <p class="text-white/65 text-[1.0625rem] leading-[1.8] max-w-2xl mx-auto">
                TripKuy lahir dari semangat petualangan dan kepercayaan bahwa setiap orang berhak merasakan
                keindahan Indonesia — mudah, aman, dan berkesan.
            </p>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- STATS                                                         --}}
    {{-- ============================================================ --}}
    <section class="bg-white border-b border-border py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

                @php
                $stats = [
                    ['value' => '10.000+', 'label' => 'Traveler Puas',     'icon' => 'users',       'color' => 'text-brand-600'],
                    ['value' => '500+',    'label' => 'Trip Tersedia',      'icon' => 'map',         'color' => 'text-teal-600'],
                    ['value' => '120+',    'label' => 'Guide Bersertifikat','icon' => 'shield-check', 'color' => 'text-coral-600'],
                    ['value' => '4.9',     'label' => 'Rating Rata-rata',   'icon' => 'star',        'color' => 'text-brand-600'],
                ];
                @endphp

                @foreach($stats as $stat)
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-11 h-11 bg-surface-sunken rounded-xl flex items-center justify-center {{ $stat['color'] }} mb-1">
                            <x-dynamic-component :component="'lucide-' . $stat['icon']" class="w-5 h-5" />
                        </div>
                        <div class="font-display text-[2rem] font-extrabold text-ink leading-none">{{ $stat['value'] }}</div>
                        <div class="text-sm text-ink-muted">{{ $stat['label'] }}</div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CERITA KAMI                                                   --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 bg-surface-sunken">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

                {{-- Image --}}
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden aspect-4/3 shadow-lg">
                        <img
                            src="https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=800&h=600&fit=crop&q=80"
                            alt="Tim TripKuy di lapangan"
                            class="size-full object-cover"
                        >
                    </div>
                    {{-- Floating badge --}}
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-lg border border-border px-5 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center shrink-0">
                            <x-lucide-calendar class="w-5 h-5 text-brand-600" />
                        </div>
                        <div>
                            <div class="font-display font-bold text-ink text-[0.9375rem]">Berdiri Sejak</div>
                            <div class="text-sm text-ink-muted">2020 · Jakarta</div>
                        </div>
                    </div>
                </div>

                {{-- Text --}}
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-brand-500 mb-3">Cerita Kami</p>
                    <h2 class="font-display text-[clamp(1.75rem,3vw,2.5rem)] font-extrabold text-ink leading-snug mb-5">
                        Dimulai dari Satu Pendakian, Lahir Sebuah Platform
                    </h2>
                    <div class="flex flex-col gap-4 text-[0.9375rem] text-ink-secondary leading-[1.8]">
                        <p>
                            TripKuy bermula dari frustrasi pendirinya saat mencari open trip yang terpercaya.
                            Proses yang ribet, informasi yang tidak jelas, dan sulitnya menemukan guide lokal yang
                            berkualitas mendorong lahirnya ide sederhana: <em>bikin platform yang benar-benar memihak traveler.</em>
                        </p>
                        <p>
                            Sejak 2020, kami tumbuh dari sebuah grup WhatsApp kecil menjadi platform open trip
                            terdepan di Indonesia. Ribuan petualangan telah lahir dari sini — dari pendakian
                            Rinjani hingga menyelam di Raja Ampat.
                        </p>
                        <p>
                            Hari ini, TripKuy menghubungkan traveler dengan ratusan guide lokal bersertifikat
                            di seluruh nusantara. Misi kami sederhana: buat petualangan jadi lebih mudah,
                            aman, dan berkesan untuk semua orang.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- NILAI KAMI                                                    --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 bg-surface">
        <div class="max-w-7xl mx-auto">

            <x-ui.section-header
                eyebrow="Nilai Kami"
                title="Apa yang Kami Percaya"
                subtitle="Prinsip-prinsip ini memandu setiap keputusan yang kami buat untuk traveler dan mitra kami."
                align="center"
            />

            @php
            $values = [
                [
                    'icon'    => 'heart',
                    'bg'      => 'bg-coral-100',
                    'color'   => 'text-coral-600',
                    'title'   => 'Traveler First',
                    'desc'    => 'Setiap fitur, kebijakan, dan keputusan bisnis kami dimulai dari satu pertanyaan: apa yang terbaik bagi traveler?',
                ],
                [
                    'icon'    => 'shield-check',
                    'bg'      => 'bg-teal-100',
                    'color'   => 'text-teal-600',
                    'title'   => 'Keamanan & Kepercayaan',
                    'desc'    => 'Semua guide kami terverifikasi dan bersertifikat. Dana traveler terlindungi dengan jaminan refund penuh jika trip dibatalkan.',
                ],
                [
                    'icon'    => 'globe',
                    'bg'      => 'bg-brand-100',
                    'color'   => 'text-brand-600',
                    'title'   => 'Dampak Lokal',
                    'desc'    => 'Kami berkomitmen memberdayakan komunitas lokal. Setiap booking yang kamu lakukan membantu ekonomi guide dan daerah tujuan.',
                ],
                [
                    'icon'    => 'sparkles',
                    'bg'      => 'bg-coral-100',
                    'color'   => 'text-coral-600',
                    'title'   => 'Pengalaman Tak Terlupakan',
                    'desc'    => 'Kami tidak sekadar menjual trip. Kami merancang momen yang akan kamu ceritakan bertahun-tahun ke depan.',
                ],
                [
                    'icon'    => 'zap',
                    'bg'      => 'bg-teal-100',
                    'color'   => 'text-teal-600',
                    'title'   => 'Kemudahan Akses',
                    'desc'    => 'Dari pencarian hingga booking selesai dalam 5 menit. Kami percaya petualangan tidak harus diawali dengan proses yang rumit.',
                ],
                [
                    'icon'    => 'leaf',
                    'bg'      => 'bg-brand-100',
                    'color'   => 'text-brand-600',
                    'title'   => 'Perjalanan Bertanggung Jawab',
                    'desc'    => 'Kami mendorong pariwisata yang berkelanjutan — menghormati alam, budaya lokal, dan generasi mendatang.',
                ],
            ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($values as $val)
                    <div class="bg-white rounded-2xl border border-border p-6 flex flex-col gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-11 h-11 {{ $val['bg'] }} {{ $val['color'] }} rounded-xl flex items-center justify-center shrink-0">
                            <x-dynamic-component :component="'lucide-' . $val['icon']" class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-display font-bold text-ink text-[1.0625rem] mb-1.5">{{ $val['title'] }}</h3>
                            <p class="text-sm text-ink-secondary leading-[1.7] m-0">{{ $val['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TIM                                                           --}}
    {{-- ============================================================ --}}
    <section class="py-20 px-6 bg-surface-sunken">
        <div class="max-w-7xl mx-auto">

            <x-ui.section-header
                eyebrow="Tim Kami"
                title="Orang-orang di Balik TripKuy"
                subtitle="Kami adalah tim kecil yang bersemangat dan mencintai petualangan."
                align="center"
            />

            @inject('about', 'App\Settings\AboutSettings')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @forelse($about->team as $index => $member)
                    <div class="bg-white rounded-2xl border border-border overflow-hidden text-center group">
                        <div class="aspect-square overflow-hidden">
                            <img
                                src="{{ $member['avatar'] ? Storage::url($member['avatar']) : "https://ui-avatars.com/api/?name={$member['name']}" }}"
                                alt="{{ $member['name'] }}"
                                class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >
                        </div>
                        <div class="p-5">
                            <div class="font-display font-bold text-ink text-[1.0625rem]">{{ $member['name'] }}</div>
                            <div class="text-xs font-semibold text-brand-600 uppercase tracking-wider mt-0.5 mb-3">{{ $member['nim'] }}</div>
                        </div>
                    </div>
                @empty
                    <p>Ups, belum ada tim</p>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- BERGABUNG JADI GUIDE                                          --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-white border-y border-border">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-teal-600 mb-3">Bergabung Bersama Kami</p>
                    <h2 class="font-display text-[clamp(1.5rem,3vw,2.25rem)] font-extrabold text-ink leading-snug mb-4">
                        Kamu Seorang Guide Lokal?
                    </h2>
                    <p class="text-[0.9375rem] text-ink-secondary leading-[1.8] mb-6">
                        Bergabunglah dengan jaringan 120+ guide bersertifikat TripKuy dan jangkau ribuan traveler
                        dari seluruh Indonesia. Kami menyediakan platform, dukungan, dan perlindungan yang kamu butuhkan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-md">
                            <x-lucide-send class="w-4 h-4" />
                            Daftar Jadi Guide
                        </a>
                        <a href="{{ route('trips.index') }}" class="btn btn-ghost btn-md">
                            Lihat Trip Kami
                            <x-lucide-arrow-right class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @php
                    $perks = [
                        ['icon' => 'trending-up',  'bg' => 'bg-brand-50',  'color' => 'text-brand-600',  'title' => 'Penghasilan Lebih',   'desc' => 'Atur harga sendiri dan dapatkan lebih banyak pelanggan'],
                        ['icon' => 'users',        'bg' => 'bg-teal-50',   'color' => 'text-teal-600',   'title' => 'Komunitas Solid',     'desc' => 'Bergabung dengan komunitas guide yang saling mendukung'],
                        ['icon' => 'shield',       'bg' => 'bg-coral-50',  'color' => 'text-coral-600',  'title' => 'Terlindungi Penuh',   'desc' => 'Asuransi perjalanan dan dukungan operasional 24/7'],
                        ['icon' => 'bar-chart-2',  'bg' => 'bg-brand-50',  'color' => 'text-brand-600',  'title' => 'Dashboard Lengkap',   'desc' => 'Kelola booking dan pantau pendapatanmu dengan mudah'],
                    ];
                    @endphp
                    @foreach($perks as $perk)
                        <div class="flex flex-col gap-3 p-4 {{ $perk['bg'] }} rounded-xl">
                            <div class="{{ $perk['color'] }}">
                                <x-dynamic-component :component="'lucide-' . $perk['icon']" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="font-semibold text-ink text-sm mb-0.5">{{ $perk['title'] }}</div>
                                <div class="text-xs text-ink-muted leading-relaxed">{{ $perk['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA                                                           --}}
    {{-- ============================================================ --}}
    <section class="relative overflow-hidden py-20 px-6 bg-linear-to-br from-teal-700 to-brand-700">
        <div class="max-w-2xl mx-auto text-center relative z-1">
            <p class="text-xs font-bold tracking-widest uppercase text-teal-300 mb-3">Mulai Sekarang</p>
            <h2 class="font-display text-[clamp(2rem,4vw,3rem)] font-extrabold text-white leading-[1.15] mb-5">
                Siap Memulai Petualanganmu?
            </h2>
            <p class="text-white/75 text-[1.0625rem] leading-[1.8] mb-10">
                Temukan ratusan open trip pilihan dan mulai perjalanan impianmu bersama guide lokal terpercaya kami.
            </p>
            <div class="flex items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('trips.index') }}" class="btn btn-coral btn-xl">
                    <x-lucide-compass class="w-5 h-5" />
                    Jelajahi Trip
                </a>
                <a href="{{ route('contact.index') }}" class="btn btn-ghost btn-lg text-white border-white/35">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
