<?php

use App\Models\Trip;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component
{
    #[Locked]
    public Trip $trip;

    public bool $wishlisted = false;

    public function mount(): void
    {
        if (auth()->check()) {
            $this->wishlisted = auth()->user()
                ->wishlistedTrips()
                ->where('trip_id', $this->trip->id)
                ->exists();
        }
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: false);

            return;
        }

        if ($this->wishlisted) {
            auth()->user()->wishlistedTrips()->detach($this->trip->id);
            $this->wishlisted = false;
        } else {
            auth()->user()->wishlistedTrips()->syncWithoutDetaching([$this->trip->id]);
            $this->wishlisted = true;
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.wishlist-toggle');
    }
}; ?>

<button
    wire:click="toggle"
    title="{{ $wishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}"
    class="btn btn-ghost btn-sm w-full justify-center gap-1.5 transition-colors
        {{ $wishlisted ? 'text-danger' : 'text-ink-secondary' }}"
>
    <x-lucide-heart
        class="w-4 h-4 transition-all {{ $wishlisted ? 'fill-current' : '' }}"
    />
    {{ $wishlisted ? 'Tersimpan di Wishlist' : 'Simpan ke Wishlist' }}
</button>
