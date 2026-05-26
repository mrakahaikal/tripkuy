<x-layouts.app title="Hubungi Kami — TripKuy">

    {{-- ============================================================ --}}
    {{-- HERO                                                          --}}
    {{-- ============================================================ --}}
    <section class="bg-brand-900 py-16 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-xs font-bold tracking-widest uppercase text-teal-400 mb-3">Bantuan & Pertanyaan</p>
            <h1 class="font-display text-[clamp(2rem,4vw,2.75rem)] font-extrabold text-white leading-snug mb-4">
                Hubungi Kami
            </h1>
            <p class="text-white/70 text-[1.0625rem] leading-relaxed max-w-lg mx-auto">
                Ada pertanyaan, masukan, atau butuh bantuan? Tim kami siap membantu kamu secepatnya.
            </p>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- MAIN: INFO + FORM                                             --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-surface-sunken">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-[380px_1fr] gap-10 items-start">

                {{-- ---- LEFT: Contact info ---- --}}
                <div class="flex flex-col gap-4">

                    @php
                    $contacts = [
                        [
                            'icon'    => 'mail',
                            'label'   => 'Email',
                            'value'   => 'halo@tripkuy.id',
                            'sub'     => 'Balas dalam 1×24 jam',
                            'href'    => 'mailto:halo@tripkuy.id',
                            'iconBg'  => 'bg-brand-100',
                            'iconTxt' => 'text-brand-600',
                        ],
                        [
                            'icon'    => 'message-circle',
                            'label'   => 'WhatsApp',
                            'value'   => '+62 812-3456-7890',
                            'sub'     => 'Senin–Jumat, 08.00–17.00 WIB',
                            'href'    => 'https://wa.me/6281234567890',
                            'iconBg'  => 'bg-teal-100',
                            'iconTxt' => 'text-teal-600',
                        ],
                        [
                            'icon'    => 'map-pin',
                            'label'   => 'Kantor',
                            'value'   => 'Jakarta Selatan, Indonesia',
                            'sub'     => 'Jl. Sudirman No. 12, DKI Jakarta',
                            'href'    => null,
                            'iconBg'  => 'bg-coral-100',
                            'iconTxt' => 'text-coral-600',
                        ],
                        [
                            'icon'    => 'clock',
                            'label'   => 'Jam Operasional',
                            'value'   => 'Senin – Jumat',
                            'sub'     => '08.00 – 17.00 WIB',
                            'href'    => null,
                            'iconBg'  => 'bg-brand-100',
                            'iconTxt' => 'text-brand-600',
                        ],
                    ];
                    @endphp

                    @foreach($contacts as $item)
                        @if($item['href'])
                            <a href="{{ $item['href'] }}"
                               target="{{ str_starts_with($item['href'], 'http') ? '_blank' : '_self' }}"
                               rel="noopener noreferrer"
                               class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-border shadow-xs no-underline group hover:border-brand-300 hover:shadow-sm transition-all duration-150">
                        @else
                            <div class="flex items-start gap-4 p-5 bg-white rounded-2xl border border-border shadow-xs">
                        @endif
                                <div class="w-11 h-11 {{ $item['iconBg'] }} {{ $item['iconTxt'] }} rounded-xl flex items-center justify-center shrink-0">
                                    <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-5 h-5" />
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-semibold uppercase tracking-wider text-ink-muted mb-0.5">
                                        {{ $item['label'] }}
                                    </div>
                                    <div class="text-[0.9375rem] font-semibold text-ink group-hover:text-brand-600 transition-colors">
                                        {{ $item['value'] }}
                                    </div>
                                    <div class="text-sm text-ink-muted mt-0.5">{{ $item['sub'] }}</div>
                                </div>
                                @if($item['href'])
                                    <x-lucide-arrow-up-right class="w-4 h-4 text-ink-subtle group-hover:text-brand-500 shrink-0 mt-0.5 transition-colors" />
                                @endif
                        @if($item['href'])
                            </a>
                        @else
                            </div>
                        @endif
                    @endforeach

                    {{-- Social media --}}
                    <div class="p-5 bg-white rounded-2xl border border-border shadow-xs">
                        <div class="text-xs font-semibold uppercase tracking-wider text-ink-muted mb-4">
                            Ikuti Kami
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="#" aria-label="Instagram"
                               class="w-10 h-10 rounded-xl bg-surface-sunken hover:bg-brand-50 hover:text-brand-600 flex items-center justify-center text-ink-muted transition-colors no-underline">
                                <x-lucide-instagram class="w-4.5 h-4.5" />
                            </a>
                            <a href="#" aria-label="TikTok"
                               class="w-10 h-10 rounded-xl bg-surface-sunken hover:bg-brand-50 hover:text-brand-600 flex items-center justify-center text-ink-muted transition-colors no-underline">
                                <x-lucide-music-2 class="w-4.5 h-4.5" />
                            </a>
                            <a href="#" aria-label="YouTube"
                               class="w-10 h-10 rounded-xl bg-surface-sunken hover:bg-brand-50 hover:text-brand-600 flex items-center justify-center text-ink-muted transition-colors no-underline">
                                <x-lucide-youtube class="w-4.5 h-4.5" />
                            </a>
                            <a href="#" aria-label="Twitter / X"
                               class="w-10 h-10 rounded-xl bg-surface-sunken hover:bg-brand-50 hover:text-brand-600 flex items-center justify-center text-ink-muted transition-colors no-underline">
                                <x-lucide-twitter class="w-4.5 h-4.5" />
                            </a>
                        </div>
                    </div>

                </div>

                {{-- ---- RIGHT: Contact form ---- --}}
                <div
                    x-data="{
                        form: { name: '', email: '', subject: '', message: '' },
                        sent: false,
                        loading: false,
                        async submit() {
                            this.loading = true;
                            await new Promise(r => setTimeout(r, 900));
                            this.sent = true;
                            this.loading = false;
                        }
                    }"
                    class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden"
                >

                    <div class="px-7 py-5 border-b border-border">
                        <h2 class="font-display font-bold text-ink text-lg">Kirim Pesan</h2>
                        <p class="text-sm text-ink-muted mt-0.5">Ceritakan kebutuhanmu dan kami akan segera merespons.</p>
                    </div>

                    {{-- Success state --}}
                    <div x-show="sent" x-cloak class="px-7 py-14 flex flex-col items-center text-center gap-4">
                        <div class="w-16 h-16 bg-success-surface rounded-full flex items-center justify-center">
                            <x-lucide-check class="w-8 h-8 text-success" />
                        </div>
                        <div>
                            <div class="font-display font-bold text-ink text-lg mb-1">Pesan Terkirim!</div>
                            <p class="text-sm text-ink-muted leading-relaxed max-w-xs mx-auto">
                                Terima kasih sudah menghubungi kami. Tim TripKuy akan membalas dalam 1×24 jam kerja.
                            </p>
                        </div>
                        <button type="button" @click="sent = false; form = { name: '', email: '', subject: '', message: '' }"
                                class="btn btn-ghost btn-sm mt-2">
                            Kirim pesan lain
                        </button>
                    </div>

                    {{-- Form --}}
                    <form x-show="!sent" @submit.prevent="submit" class="px-7 py-7">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>
                                <label class="block text-sm font-semibold text-ink mb-1.5">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    x-model="form.name"
                                    required
                                    placeholder="Nama kamu"
                                    class="input"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-ink mb-1.5">
                                    Alamat Email <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="email"
                                    x-model="form.email"
                                    required
                                    placeholder="email@contoh.com"
                                    class="input"
                                >
                            </div>

                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Topik <span class="text-danger">*</span>
                            </label>
                            <select x-model="form.subject" required class="input">
                                <option value="" disabled selected>Pilih topik pertanyaan</option>
                                <option value="booking">Bantuan Booking</option>
                                <option value="payment">Pembayaran</option>
                                <option value="refund">Refund & Pembatalan</option>
                                <option value="trip">Informasi Trip</option>
                                <option value="partnership">Kerjasama / Partnership</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-7">
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Pesan <span class="text-danger">*</span>
                            </label>
                            <textarea
                                x-model="form.message"
                                required
                                rows="5"
                                placeholder="Ceritakan kebutuhanmu secara detail…"
                                class="input resize-none"
                            ></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                :disabled="loading"
                                class="btn btn-primary btn-md"
                            >
                                <span x-show="!loading" class="flex items-center gap-2">
                                    <x-lucide-send class="w-4 h-4" />
                                    Kirim Pesan
                                </span>
                                <span x-show="loading" x-cloak class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                    Mengirim…
                                </span>
                            </button>
                            <p class="text-xs text-ink-muted">
                                Kami membalas dalam <span class="font-medium text-ink">1×24 jam</span>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FAQ STRIP                                                     --}}
    {{-- ============================================================ --}}
    <section class="py-16 px-6 bg-surface">
        <div class="max-w-3xl mx-auto">
            <x-ui.section-header
                eyebrow="Pertanyaan Umum"
                title="Yang Sering Ditanyakan"
                align="center"
            />

            @php
            $faqs = [
                ['q' => 'Berapa lama proses konfirmasi booking?',      'a' => 'Konfirmasi booking dikirimkan ke email dalam 1×24 jam setelah pembayaran diterima dan diverifikasi oleh tim kami.'],
                ['q' => 'Bagaimana cara mengajukan refund?',           'a' => 'Hubungi kami melalui email atau WhatsApp dengan menyertakan kode booking. Refund diproses dalam 3–7 hari kerja.'],
                ['q' => 'Apakah bisa custom itinerary untuk grup?',    'a' => 'Bisa! Kami melayani private trip dan custom itinerary untuk grup minimal 5 orang. Hubungi kami untuk penawaran khusus.'],
                ['q' => 'Apa yang harus dibawa saat trip?',            'a' => 'Setiap trip memiliki daftar perlengkapan berbeda. Detail perlengkapan tersedia di halaman masing-masing trip.'],
            ];
            @endphp

            <div class="flex flex-col divide-y divide-border" x-data="{ open: null }">
                @foreach($faqs as $i => $faq)
                    <div class="py-5">
                        <button
                            type="button"
                            @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="w-full flex items-center justify-between gap-4 text-left"
                        >
                            <span class="font-semibold text-ink text-[0.9375rem]">{{ $faq['q'] }}</span>
                            <span class="shrink-0 text-ink-muted transition-transform duration-200"
                                  :class="open === {{ $i }} ? 'rotate-180' : ''">
                                <x-lucide-chevron-down class="w-4.5 h-4.5" />
                            </span>
                        </button>
                        <div
                            x-show="open === {{ $i }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="text-sm text-ink-secondary leading-relaxed pt-3 pr-8"
                        >
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</x-layouts.app>
