<?php

use App\Models\Trip;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function removeFromWishlist(int $tripId): void
    {
        auth()->user()->wishlistedTrips()->detach($tripId);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $trips = auth()->user()
            ->wishlistedTrips()
            ->with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', 'published')
            ->latest('trip_wishlists.created_at')
            ->paginate(9);

        return view('livewire.dashboard.wishlist', compact('trips'));
    }
}; ?>

<div class="space-y-5">

    {{-- Page header --}}
    <div>
        <h1 class="font-display text-xl font-bold text-ink">Wishlist</h1>
        <p class="text-sm text-ink-muted mt-0.5">Trip yang kamu simpan untuk nanti.</p>
    </div>

    @if($trips->isEmpty())
        <div class="bg-white border border-border rounded-2xl px-6 py-16 text-center">
            <x-lucide-heart class="w-12 h-12 mx-auto mb-4 text-ink-subtle" />
            <p class="text-base font-semibold text-ink-secondary">Wishlist masih kosong</p>
            <p class="text-sm text-ink-muted mt-1.5 mb-5">
                Simpan trip favoritmu agar tidak kehabisan slot!
            </p>
            <a href="{{ route('trips.index') }}" class="btn btn-primary btn-sm">
                Jelajahi Trip
                <x-lucide-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($trips as $trip)
                @php $slots = $trip->availableSlots(); @endphp
                <div class="bg-white border border-border rounded-2xl overflow-hidden flex flex-col group">

                    {{-- Cover --}}
                    <a href="{{ route('trips.show', $trip) }}" class="block relative overflow-hidden aspect-[16/9]">
                        @if($trip->cover_image)
                            <img src="{{ $trip->cover_image_url }}"
                                 alt="{{ $trip->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-brand-50 flex items-center justify-center">
                                <x-lucide-map class="w-10 h-10 text-brand-200" />
                            </div>
                        @endif

                        {{-- Slots badge --}}
                        @if($slots <= 3 && $slots > 0)
                            <span class="absolute top-2.5 left-2.5 badge badge-coral">{{ $slots }} slot tersisa</span>
                        @elseif($slots === 0)
                            <span class="absolute top-2.5 left-2.5 badge badge-neutral">Penuh</span>
                        @endif

                        {{-- Remove button --}}
                        <button
                            wire:click.stop="removeFromWishlist({{ $trip->id }})"
                            wire:confirm="Hapus trip ini dari wishlist?"
                            class="absolute top-2.5 right-2.5 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-danger hover:bg-white hover:scale-110 transition-all shadow-sm"
                            title="Hapus dari wishlist"
                        >
                            <x-lucide-heart class="w-4 h-4 fill-current" />
                        </button>
                    </a>

                    {{-- Content --}}
                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div>
                            <div class="text-xs text-ink-muted mb-0.5">{{ $trip->category->name }}</div>
                            <a href="{{ route('trips.show', $trip) }}"
                               class="font-display font-bold text-ink text-sm leading-snug hover:text-brand-700 transition-colors no-underline line-clamp-2">
                                {{ $trip->title }}
                            </a>
                        </div>

                        <div class="flex items-center gap-1 text-xs text-ink-muted">
                            <x-lucide-map-pin class="w-3 h-3 shrink-0" />
                            {{ $trip->destination }}
                        </div>

                        <div class="flex items-center gap-1 text-xs text-ink-muted">
                            <x-lucide-calendar class="w-3 h-3 shrink-0" />
                            {{ $trip->start_date->translatedFormat('d M Y') }}
                            · {{ $trip->duration_days }} hari
                        </div>

                        @if($trip->reviews_avg_rating)
                            <div class="flex items-center gap-1 text-xs text-ink-muted">
                                <x-lucide-star class="w-3 h-3 text-warning fill-current" />
                                <span class="font-medium text-ink">{{ number_format($trip->reviews_avg_rating, 1) }}</span>
                                <span>({{ $trip->reviews_count }})</span>
                            </div>
                        @endif

                        <div class="mt-auto pt-2 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-ink-muted">mulai dari</span>
                                <div class="font-display font-extrabold text-base text-ink">
                                    Rp {{ number_format($trip->price, 0, ',', '.') }}
                                </div>
                            </div>

                            @if($slots > 0)
                                <a href="{{ route('bookings.create', $trip) }}"
                                   class="btn btn-primary btn-sm">
                                    Pesan
                                </a>
                            @else
                                <span class="text-xs text-ink-muted font-medium">Kuota penuh</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($trips->hasPages())
            <div>{{ $trips->links() }}</div>
        @endif
    @endif

</div>
