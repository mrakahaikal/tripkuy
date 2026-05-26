<?php

use App\Models\Booking;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Url(as: 'tab', except: 'all')]
    public string $tab = 'all';

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    /** @return \Illuminate\Contracts\Pagination\LengthAwarePaginator<Booking> */
    private function bookings(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Booking::query()
            ->where('user_id', auth()->id())
            ->with(['trip.category', 'payments'])
            ->when($this->tab === 'active', function ($q): void {
                $q->whereIn('status', ['pending', 'confirmed'])
                    ->whereHas('trip', fn ($q) => $q->where('start_date', '>=', now()));
            })
            ->when($this->tab === 'completed', function ($q): void {
                $q->where('status', 'confirmed')
                    ->whereHas('trip', fn ($q) => $q->where('end_date', '<', now()));
            })
            ->when($this->tab === 'cancelled', fn ($q) => $q->where('status', 'cancelled'))
            ->latest()
            ->paginate(10);
    }

    private function tabCount(string $tab): int
    {
        return Booking::query()
            ->where('user_id', auth()->id())
            ->when($tab === 'active', function ($q): void {
                $q->whereIn('status', ['pending', 'confirmed'])
                    ->whereHas('trip', fn ($q) => $q->where('start_date', '>=', now()));
            })
            ->when($tab === 'completed', function ($q): void {
                $q->where('status', 'confirmed')
                    ->whereHas('trip', fn ($q) => $q->where('end_date', '<', now()));
            })
            ->when($tab === 'cancelled', fn ($q) => $q->where('status', 'cancelled'))
            ->count();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.dashboard.booking-list', [
            'bookings' => $this->bookings(),
            'counts'   => [
                'all'       => Booking::where('user_id', auth()->id())->count(),
                'active'    => $this->tabCount('active'),
                'completed' => $this->tabCount('completed'),
                'cancelled' => $this->tabCount('cancelled'),
            ],
        ]);
    }
}; ?>

<div class="space-y-5">

    {{-- Page header --}}
    <div>
        <h1 class="font-display text-xl font-bold text-ink">Booking Saya</h1>
        <p class="text-sm text-ink-muted mt-0.5">Riwayat dan status semua pemesanan tripmu.</p>
    </div>

    {{-- Filter tabs --}}
    <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5">
        @foreach([
            ['key' => 'all',       'label' => 'Semua'],
            ['key' => 'active',    'label' => 'Aktif'],
            ['key' => 'completed', 'label' => 'Selesai'],
            ['key' => 'cancelled', 'label' => 'Dibatalkan'],
        ] as $item)
            <button
                wire:click="setTab('{{ $item['key'] }}')"
                class="chip shrink-0 {{ $tab === $item['key'] ? 'selected' : '' }}"
            >
                {{ $item['label'] }}
                @if($counts[$item['key']] > 0)
                    <span class="ml-1 text-[0.65rem] font-bold {{ $tab === $item['key'] ? 'opacity-80' : 'text-ink-muted' }}">
                        {{ $counts[$item['key']] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    {{-- Booking list --}}
    @if($bookings->isEmpty())
        <div class="bg-white border border-border rounded-2xl px-6 py-16 text-center">
            <x-lucide-map class="w-12 h-12 mx-auto mb-4 text-ink-subtle" />
            <p class="text-base font-semibold text-ink-secondary">
                @if($tab === 'all') Belum ada booking
                @elseif($tab === 'active') Tidak ada trip aktif
                @elseif($tab === 'completed') Belum ada trip yang selesai
                @else Tidak ada booking yang dibatalkan
                @endif
            </p>
            <p class="text-sm text-ink-muted mt-1.5 mb-5">
                @if($tab === 'all') Kamu belum memesan trip apapun. Mulai petualanganmu sekarang!
                @else Coba lihat semua booking kamu.
                @endif
            </p>
            @if($tab === 'all')
                <a href="{{ route('trips.index') }}" class="btn btn-primary btn-sm">
                    Temukan Trip
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            @else
                <button wire:click="setTab('all')" class="btn btn-secondary btn-sm">
                    Lihat Semua Booking
                </button>
            @endif
        </div>
    @else
        <div class="flex flex-col gap-3">
            @foreach($bookings as $booking)
                @php
                    $pendingPayment = $booking->payments->firstWhere('status', 'pending');
                    $verifiedPayment = $booking->payments->firstWhere('status', 'verified');
                    $rejectedPayment = $booking->payments->firstWhere('status', 'rejected');
                @endphp
                <a href="{{ route('bookings.show', $booking->booking_code) }}"
                   class="bg-white border border-border rounded-2xl overflow-hidden hover:border-brand-300 hover:shadow-md transition-all duration-150 no-underline group">

                    <div class="flex items-start gap-0">

                        {{-- Cover image --}}
                        <div class="w-28 sm:w-36 shrink-0 self-stretch">
                            @if($booking->trip->cover_image)
                                <img src="{{ $booking->trip->cover_image_url }}"
                                     alt="{{ $booking->trip->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-brand-50 flex items-center justify-center min-h-[5rem]">
                                    <x-lucide-map class="w-8 h-8 text-brand-200" />
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0 p-4 flex flex-col gap-2">

                            {{-- Top row: title + status --}}
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs text-ink-muted">{{ $booking->trip->category->name }}</div>
                                    <div class="font-display font-bold text-ink text-sm leading-snug group-hover:text-brand-700 transition-colors">
                                        {{ $booking->trip->title }}
                                    </div>
                                </div>
                                @php
                                    [$badgeClass, $badgeLabel] = match($booking->status) {
                                        'pending'   => ['badge-warning', 'Pending'],
                                        'confirmed' => ['badge-success', 'Confirmed'],
                                        'cancelled' => ['badge-danger', 'Cancelled'],
                                        default     => ['badge-neutral', $booking->status],
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} shrink-0">{{ $badgeLabel }}</span>
                            </div>

                            {{-- Trip meta --}}
                            <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs text-ink-muted">
                                <span class="flex items-center gap-1">
                                    <x-lucide-map-pin class="w-3 h-3" />
                                    {{ $booking->trip->destination }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-lucide-calendar class="w-3 h-3" />
                                    {{ $booking->trip->start_date->translatedFormat('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <x-lucide-users class="w-3 h-3" />
                                    {{ $booking->participant_count }} peserta
                                </span>
                            </div>

                            {{-- Bottom row: price + payment status --}}
                            <div class="flex items-center justify-between gap-2 mt-0.5">
                                <span class="font-display font-bold text-base text-ink">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </span>

                                @if($booking->status === 'pending')
                                    @if($verifiedPayment)
                                        <span class="text-xs text-success font-medium flex items-center gap-1">
                                            <x-lucide-check-circle class="w-3 h-3" />
                                            Pembayaran terverifikasi
                                        </span>
                                    @elseif($pendingPayment)
                                        <span class="text-xs text-warning font-medium flex items-center gap-1">
                                            <x-lucide-clock class="w-3 h-3" />
                                            Menunggu verifikasi
                                        </span>
                                    @elseif($rejectedPayment)
                                        <span class="text-xs text-danger font-medium flex items-center gap-1">
                                            <x-lucide-x-circle class="w-3 h-3" />
                                            Pembayaran ditolak
                                        </span>
                                    @else
                                        <span class="text-xs text-ink-muted flex items-center gap-1">
                                            <x-lucide-upload class="w-3 h-3" />
                                            Belum bayar
                                        </span>
                                    @endif
                                @endif

                                <x-lucide-chevron-right class="w-4 h-4 text-ink-subtle group-hover:text-brand-500 transition-colors shrink-0 ml-auto" />
                            </div>

                        </div>
                    </div>

                    {{-- Deadline bar for pending bookings --}}
                    @if($booking->status === 'pending' && $booking->payment_deadline && !$verifiedPayment)
                        <div class="px-4 py-2.5 border-t border-border bg-warning-surface flex items-center gap-2 text-xs text-ink-secondary">
                            <x-lucide-clock class="w-3.5 h-3.5 text-warning shrink-0" />
                            Batas pembayaran:
                            <strong class="text-ink">{{ $booking->payment_deadline->translatedFormat('d M Y, H:i') }} WIB</strong>
                            @if($booking->isPaymentOverdue())
                                <span class="badge badge-danger ml-auto">Kedaluwarsa</span>
                            @endif
                        </div>
                    @endif

                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="mt-2">
                {{ $bookings->links() }}
            </div>
        @endif
    @endif

</div>
