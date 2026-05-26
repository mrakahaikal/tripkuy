@props(['trip', 'slots'])

<div class="sticky top-24 flex flex-col gap-4">

    <div class="bg-surface-raised border border-border rounded-2xl p-5 shadow-card flex flex-col gap-4">

        <div>
            <div class="text-xs text-ink-muted mb-0.5">mulai dari</div>
            <div class="flex items-baseline gap-1">
                <span class="text-sm font-semibold text-coral-600">Rp</span>
                <span class="font-display text-3xl font-extrabold text-ink">{{ number_format($trip->price, 0, ',', '.') }}</span>
                <span class="text-sm text-ink-muted">/orang</span>
            </div>
        </div>

        <hr class="divider my-0">

        <div class="flex flex-col gap-3 text-sm">
            <div class="flex items-start gap-2.5">
                <x-lucide-calendar class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                <div>
                    <div class="text-xs text-ink-muted mb-0.5">Tanggal</div>
                    <div class="font-medium text-ink">
                        {{ $trip->start_date->translatedFormat('d M') }} –
                        {{ $trip->end_date->translatedFormat('d M Y') }}
                    </div>
                </div>
            </div>
            <div class="flex items-start gap-2.5">
                <x-lucide-clock class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                <div>
                    <div class="text-xs text-ink-muted mb-0.5">Durasi</div>
                    <div class="font-medium text-ink">{{ $trip->duration_days }} hari {{ $trip->duration_days - 1 }} malam</div>
                </div>
            </div>
            <div class="flex items-start gap-2.5">
                <x-lucide-users class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                <div>
                    <div class="text-xs text-ink-muted mb-0.5">Ketersediaan</div>
                    <div class="font-medium {{ $slots <= 3 ? 'text-coral-600' : 'text-ink' }}">
                        {{ $slots }} dari {{ $trip->quota }} slot tersisa
                    </div>
                    @if($slots <= 3 && $slots > 0)
                        <div class="text-[0.7rem] text-coral-500 mt-0.5">⚠ Hampir penuh, segera booking!</div>
                    @endif
                </div>
            </div>
            <div class="flex items-start gap-2.5">
                <x-lucide-map-pin class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                <div>
                    <div class="text-xs text-ink-muted mb-0.5">Keberangkatan</div>
                    <div class="font-medium text-ink">{{ $trip->departure_city }}</div>
                </div>
            </div>
            @if($trip->meeting_point)
                <div class="flex items-start gap-2.5">
                    <x-lucide-navigation class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                    <div>
                        <div class="text-xs text-ink-muted mb-0.5">Meeting Point</div>
                        <div class="font-medium text-ink">{{ $trip->meeting_point }}</div>
                    </div>
                </div>
            @endif
            @if($trip->min_participants > 1)
                <div class="flex items-start gap-2.5">
                    <x-lucide-user-check class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
                    <div>
                        <div class="text-xs text-ink-muted mb-0.5">Min. Peserta</div>
                        <div class="font-medium text-ink">{{ $trip->min_participants }} orang</div>
                    </div>
                </div>
            @endif
        </div>

        <hr class="divider my-0">

        @if($slots > 0)
            @auth
                <a href="{{ route('bookings.create', $trip) }}" class="btn btn-primary btn-lg w-full justify-center">
                    <x-lucide-shopping-bag class="w-4 h-4" />
                    Booking Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-full justify-center">
                    <x-lucide-log-in class="w-4 h-4" />
                    Login untuk Booking
                </a>
            @endauth
        @else
            <button disabled class="btn btn-secondary btn-lg w-full justify-center opacity-60 cursor-not-allowed">
                <x-lucide-x-circle class="w-4 h-4" />
                Kuota Penuh
            </button>
        @endif

        <livewire:wishlist-toggle :trip="$trip" />

        <div
            x-data="{ copied: false }"
            x-on:click="
                navigator.clipboard.writeText('{{ url()->current() }}');
                copied = true;
                setTimeout(() => copied = false, 2000);
            "
            class="relative"
        >
            <button class="btn btn-ghost btn-sm w-full justify-center text-ink-secondary">
                <x-lucide-share-2 x-show="!copied" class="w-3.5 h-3.5" />
                <x-lucide-check x-show="copied" x-cloak class="w-3.5 h-3.5 text-teal-500" />
                <span x-text="copied ? 'Link Tersalin!' : 'Bagikan Trip Ini'"
                      :class="copied ? 'text-teal-600' : ''"></span>
            </button>
        </div>
    </div>

    <div class="bg-brand-50 border border-brand-100 rounded-xl p-4 flex gap-3">
        <x-lucide-headphones class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" />
        <p class="text-xs text-brand-700 leading-relaxed">
            Ada pertanyaan? Hubungi kami via WhatsApp atau cek FAQ di bawah.
        </p>
    </div>
</div>
