<?php

use App\Models\Booking;
use Livewire\Component;

new class extends Component
{
    public function render(): \Illuminate\Contracts\View\View
    {
        $user = auth()->user();

        $totalBookings = Booking::where('user_id', $user->id)->count();

        $upcomingTrips = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereHas('trip', fn ($q) => $q->where('start_date', '>=', now()))
            ->count();

        $wishlistCount = $user->wishlistedTrips()->count();

        $recentBookings = Booking::where('user_id', $user->id)
            ->with(['trip.category', 'payments'])
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.dashboard.overview', compact(
            'totalBookings',
            'upcomingTrips',
            'wishlistCount',
            'recentBookings',
        ));
    }
}; ?>

<div class="space-y-6">

    {{-- Page header --}}
    <div>
        <h1 class="font-display text-xl font-bold text-ink">
            Halo, {{ Str::words(auth()->user()->name, 1, '') }}!
        </h1>
        <p class="text-sm text-ink-muted mt-0.5">Selamat datang di dashboard perjalananmu.</p>
    </div>

    {{-- Quick stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-border rounded-2xl px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center shrink-0">
                <x-lucide-ticket class="w-5 h-5 text-brand-600" />
            </div>
            <div>
                <div class="text-2xl font-bold text-ink font-display">{{ $totalBookings }}</div>
                <div class="text-xs text-ink-muted">Total Booking</div>
            </div>
        </div>

        <div class="bg-white border border-border rounded-2xl px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center shrink-0">
                <x-lucide-calendar-check class="w-5 h-5 text-teal-600" />
            </div>
            <div>
                <div class="text-2xl font-bold text-ink font-display">{{ $upcomingTrips }}</div>
                <div class="text-xs text-ink-muted">Trip Mendatang</div>
            </div>
        </div>

        <div class="bg-white border border-border rounded-2xl px-5 py-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-coral-50 flex items-center justify-center shrink-0">
                <x-lucide-heart class="w-5 h-5 text-coral-500" />
            </div>
            <div>
                <div class="text-2xl font-bold text-ink font-display">{{ $wishlistCount }}</div>
                <div class="text-xs text-ink-muted">Tersimpan di Wishlist</div>
            </div>
        </div>
    </div>

    {{-- Recent bookings --}}
    <div class="bg-white border border-border rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-border">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Booking Terbaru</h2>
            @if($recentBookings->isNotEmpty())
                <a href="{{ route('dashboard.bookings') }}" class="text-xs text-brand-600 font-medium hover:underline">
                    Lihat semua
                </a>
            @endif
        </div>

        @if($recentBookings->isEmpty())
            <div class="px-5 py-12 text-center">
                <x-lucide-ticket class="w-10 h-10 mx-auto mb-3 text-ink-subtle" />
                <p class="text-sm font-medium text-ink-secondary">Belum ada booking</p>
                <p class="text-xs text-ink-muted mt-1 mb-4">Yuk temukan trip impianmu dan mulai petualangan!</p>
                <a href="{{ route('trips.index') }}" class="btn btn-primary btn-sm">
                    Jelajahi Trip
                    <x-lucide-arrow-right class="w-3.5 h-3.5" />
                </a>
            </div>
        @else
            <div class="divide-y divide-border">
                @foreach($recentBookings as $booking)
                    @php
                        $pendingPayment  = $booking->payments->firstWhere('status', 'pending');
                        $verifiedPayment = $booking->payments->firstWhere('status', 'verified');
                        $rejectedPayment = $booking->payments->firstWhere('status', 'rejected');
                    @endphp
                    <a href="{{ route('bookings.show', $booking->booking_code) }}"
                       class="flex items-center gap-4 px-5 py-3.5 hover:bg-surface-sunken transition-colors no-underline group">

                        {{-- Cover --}}
                        <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-brand-50">
                            @if($booking->trip->cover_image)
                                <img src="{{ $booking->trip->cover_image_url }}"
                                     alt="{{ $booking->trip->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <x-lucide-map class="w-5 h-5 text-brand-200" />
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-sm text-ink truncate group-hover:text-brand-700 transition-colors">
                                {{ $booking->trip->title }}
                            </div>
                            <div class="flex items-center gap-2 mt-0.5 text-xs text-ink-muted">
                                <span>{{ $booking->trip->start_date->translatedFormat('d M Y') }}</span>
                                <span>·</span>
                                <span>{{ $booking->participant_count }} peserta</span>
                            </div>
                        </div>

                        {{-- Right: price + status --}}
                        <div class="text-right shrink-0">
                            <div class="font-display font-bold text-sm text-ink">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </div>
                            <div class="mt-0.5">
                                @if($booking->status === 'cancelled')
                                    <span class="badge badge-danger">Dibatalkan</span>
                                @elseif($verifiedPayment || $booking->status === 'confirmed')
                                    <span class="badge badge-success">Confirmed</span>
                                @elseif($pendingPayment)
                                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                                @elseif($rejectedPayment)
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Belum Bayar</span>
                                @endif
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
