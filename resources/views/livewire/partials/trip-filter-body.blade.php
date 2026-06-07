{{-- Keyword search --}}
<div class="flex flex-col gap-1.5">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Cari Trip</label>
    <div class="relative">
        <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-ink-muted pointer-events-none" />
        <input
            wire:model.live.debounce.400ms="search"
            type="text"
            placeholder="Judul atau destinasi..."
            class="input input-sm pl-8 w-full"
        >
    </div>
</div>

{{-- Kategori --}}
<div class="flex flex-col gap-2">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Kategori</label>
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-2 cursor-pointer group">
            <input
                wire:model.live="category"
                type="radio"
                value=""
                class="radio radio-sm"
            >
            <span class="text-sm text-ink group-has-[:checked]:font-medium">Semua Kategori</span>
        </label>
        @foreach($categories as $cat)
            <label class="flex items-center justify-between gap-2 cursor-pointer group">
                <div class="flex items-center gap-2">
                    <input
                        wire:model.live="category"
                        type="radio"
                        value="{{ $cat->slug }}"
                        class="radio radio-sm"
                    >
                    <span class="text-sm text-ink group-has-[:checked]:font-medium">{{ $cat->name }}</span>
                </div>
                <span class="text-xs text-ink-muted">{{ $cat->trips_count }}</span>
            </label>
        @endforeach
    </div>
</div>

{{-- Destinasi --}}
<div class="flex flex-col gap-1.5">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Destinasi</label>
    <input
        wire:model.live.debounce.400ms="destination"
        type="text"
        placeholder="Contoh: Bromo, Lombok..."
        class="input input-sm w-full"
    >
</div>

{{-- Tanggal keberangkatan --}}
<div class="flex flex-col gap-1.5">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Tanggal Berangkat</label>
    <div class="grid grid-cols-2 gap-2">
        <div class="flex flex-col gap-1">
            <span class="text-xs text-ink-muted">Dari</span>
            <input
                wire:model.live="dateFrom"
                type="date"
                class="input input-sm w-full"
            >
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-xs text-ink-muted">Sampai</span>
            <input
                wire:model.live="dateTo"
                type="date"
                class="input input-sm w-full"
            >
        </div>
    </div>
</div>

{{-- Rentang harga --}}
<div class="flex flex-col gap-1.5">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Harga (Rp)</label>
    <div class="flex items-center gap-2">
        <input
            wire:model.live.debounce.600ms="minPrice"
            type="number"
            placeholder="Min"
            min="0"
            step="50000"
            class="input input-sm w-full"
        >
        <span class="text-ink-muted text-xs shrink-0">–</span>
        <input
            wire:model.live.debounce.600ms="maxPrice"
            type="number"
            placeholder="Max"
            min="0"
            step="50000"
            class="input input-sm w-full"
        >
    </div>
</div>

{{-- Tingkat kesulitan --}}
<div class="flex flex-col gap-2">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Tingkat Kesulitan</label>
    <div class="flex flex-wrap gap-2">
        @foreach([['easy', 'Mudah', 'badge-success'], ['moderate', 'Sedang', 'badge-warning'], ['hard', 'Sulit', 'badge-danger']] as [$val, $label, $badge])
            <label class="flex items-center gap-1.5 cursor-pointer">
                <input
                    wire:model.live="difficulty"
                    type="checkbox"
                    value="{{ $val }}"
                    class="checkbox checkbox-sm"
                >
                <span class="badge {{ $badge }} text-[0.7rem]">{{ $label }}</span>
            </label>
        @endforeach
    </div>
</div>

{{-- Durasi --}}
<div class="flex flex-col gap-2">
    <label class="text-xs font-semibold text-ink-secondary uppercase tracking-wide">Durasi Trip</label>
    <div class="flex flex-wrap gap-x-4 gap-y-2">
        @foreach([['1-3', '1–3 hari'], ['4-7', '4–7 hari'], ['8+', '8+ hari']] as [$val, $label])
            <label class="flex items-center gap-2 cursor-pointer">
                <input
                    wire:model.live="duration"
                    type="checkbox"
                    value="{{ $val }}"
                    class="checkbox checkbox-sm"
                >
                <span class="text-sm text-ink">{{ $label }}</span>
            </label>
        @endforeach
    </div>
</div>

{{-- Reset button (mobile only — desktop has the header link) --}}
@if($this->hasActiveFilters())
    <div class="lg:hidden pt-2 border-t border-border">
        <button wire:click="resetFilters" class="btn btn-secondary btn-sm w-full">
            Reset Semua Filter
        </button>
    </div>
@endif
