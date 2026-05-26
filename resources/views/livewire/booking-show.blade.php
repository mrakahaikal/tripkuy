<?php

use App\Models\Booking;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public Booking $booking;

    public function mount(Booking $booking): void
    {
        abort_if($booking->user_id !== auth()->id(), 403);

        $this->booking = $booking;
        $this->loadRelations();
    }

    #[On('payment-proof-uploaded')]
    public function refreshBooking(): void
    {
        $this->booking->refresh();
        $this->loadRelations();
    }

    private function loadRelations(): void
    {
        $this->booking->load(['trip.category', 'participants', 'payments']);
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    {{-- Success flash --}}
    @if(session('success'))
        <div class="flex items-start gap-3 bg-success-surface border border-success/20 text-success rounded-xl px-4 py-3 mb-6 text-sm font-medium">
            <x-lucide-check-circle class="w-4 h-4 mt-0.5 shrink-0" />
            {{ session('success') }}
        </div>
    @endif

    {{-- Page header --}}
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <div class="text-xs text-ink-muted mb-0.5">Kode Booking</div>
            <h1 class="font-display text-2xl font-extrabold text-ink tracking-tight">
                {{ $booking->booking_code }}
            </h1>
        </div>
        <div class="shrink-0">
            @php
                $statusBadge = match($booking->status) {
                    'pending'   => 'badge-warning',
                    'confirmed' => 'badge-success',
                    'cancelled' => 'badge-danger',
                    default     => 'badge-neutral',
                };
                $statusLabel = match($booking->status) {
                    'pending'   => 'Menunggu Pembayaran',
                    'confirmed' => 'Dikonfirmasi',
                    'cancelled' => 'Dibatalkan',
                    default     => $booking->status,
                };
            @endphp
            <span class="badge {{ $statusBadge }} text-sm px-3 py-1">{{ $statusLabel }}</span>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ── Left: details ── --}}
        <div class="flex-1 min-w-0 flex flex-col gap-5">

            {{-- Trip summary --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Detail Trip</h2>
                </div>
                <div class="px-5 py-5 flex gap-4">
                    @if($booking->trip->cover_image)
                        <img src="{{ $booking->trip->cover_image_url }}"
                             alt="{{ $booking->trip->title }}"
                             class="w-20 h-20 object-cover rounded-xl shrink-0">
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-ink-muted mb-0.5">{{ $booking->trip->category->name }}</div>
                        <div class="font-display font-bold text-ink">{{ $booking->trip->title }}</div>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 mt-2 text-xs text-ink-muted">
                            <span class="flex items-center gap-1">
                                <x-lucide-map-pin class="w-3 h-3" />
                                {{ $booking->trip->destination }}
                            </span>
                            <span class="flex items-center gap-1">
                                <x-lucide-calendar class="w-3 h-3" />
                                {{ $booking->trip->start_date->translatedFormat('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <x-lucide-clock class="w-3 h-3" />
                                {{ $booking->trip->duration_days }} hari {{ $booking->trip->duration_days - 1 }} malam
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Participants --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-border flex items-center justify-between">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Data Peserta</h2>
                    <span class="badge badge-brand">{{ $booking->participant_count }} orang</span>
                </div>
                <div class="divide-y divide-border">
                    @foreach($booking->participants as $i => $participant)
                        <div class="px-5 py-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-brand-600">Peserta {{ $i + 1 }}</span>
                                @if($i === 0)
                                    <span class="badge badge-neutral">Pemesan</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-2 text-sm">
                                <div>
                                    <div class="text-xs text-ink-muted">Nama</div>
                                    <div class="font-medium text-ink">{{ $participant->name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-ink-muted">No. Identitas</div>
                                    <div class="font-medium text-ink">{{ $participant->id_number }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-ink-muted">Tgl. Lahir</div>
                                    <div class="font-medium text-ink">{{ $participant->date_of_birth->translatedFormat('d M Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-ink-muted">Jenis Kelamin</div>
                                    <div class="font-medium text-ink">{{ $participant->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                                @if($participant->phone)
                                    <div>
                                        <div class="text-xs text-ink-muted">Telepon</div>
                                        <div class="font-medium text-ink">{{ $participant->phone }}</div>
                                    </div>
                                @endif
                                @if($participant->emergency_contact_name)
                                    <div class="sm:col-span-2">
                                        <div class="text-xs text-ink-muted">Kontak Darurat</div>
                                        <div class="font-medium text-ink">
                                            {{ $participant->emergency_contact_name }}
                                            @if($participant->emergency_contact_phone)
                                                · {{ $participant->emergency_contact_phone }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Notes --}}
            @if($booking->notes)
                <div class="bg-white border border-border rounded-2xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-border">
                        <h2 class="font-display font-bold text-ink text-[0.9375rem]">Catatan</h2>
                    </div>
                    <div class="px-5 py-4 text-sm text-ink-secondary">{{ $booking->notes }}</div>
                </div>
            @endif

        </div>

        {{-- ── Right: payment ── --}}
        <div class="w-full lg:w-72 shrink-0">
            <div class="sticky top-24 flex flex-col gap-4">

                {{-- Order summary --}}
                <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-3">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Ringkasan Pembayaran</h2>

                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between text-ink-muted">
                            <span>Harga per orang</span>
                            <span>Rp {{ number_format($booking->trip->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-ink-muted">
                            <span>× {{ $booking->participant_count }} peserta</span>
                        </div>
                    </div>

                    <hr class="divider my-0">

                    <div class="flex justify-between items-baseline">
                        <span class="text-sm font-semibold text-ink">Total</span>
                        <span class="font-display font-extrabold text-xl text-ink">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($booking->payment_deadline && $booking->status === 'pending')
                        <div class="bg-warning-surface border border-warning/20 rounded-lg p-3 flex gap-2 text-xs text-ink-secondary">
                            <x-lucide-clock class="w-3.5 h-3.5 text-warning mt-0.5 shrink-0" />
                            <span>
                                Batas pembayaran:<br>
                                <strong class="text-ink">{{ $booking->payment_deadline->translatedFormat('d M Y, H:i') }} WIB</strong>
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Payment upload / status --}}
                <livewire:payment-upload :booking="$booking" />

                <a href="{{ route('dashboard.bookings') }}" class="btn btn-ghost btn-sm w-full justify-center">
                    <x-lucide-arrow-left class="w-3.5 h-3.5" />
                    Lihat Semua Booking
                </a>

            </div>
        </div>

    </div>

</div>
