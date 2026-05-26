@props(['trip', 'slots'])

<div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
    <div class="bg-surface-raised border border-border rounded-xl p-3.5 flex flex-col gap-1">
        <x-lucide-calendar class="w-4 h-4 text-brand-500 mb-0.5" />
        <div class="text-xs text-ink-muted">Tanggal Berangkat</div>
        <div class="text-sm font-semibold text-ink">{{ $trip->start_date->translatedFormat('d M Y') }}</div>
    </div>
    <div class="bg-surface-raised border border-border rounded-xl p-3.5 flex flex-col gap-1">
        <x-lucide-clock class="w-4 h-4 text-brand-500 mb-0.5" />
        <div class="text-xs text-ink-muted">Durasi</div>
        <div class="text-sm font-semibold text-ink">{{ $trip->duration_days }} hari</div>
    </div>
    <div class="bg-surface-raised border border-border rounded-xl p-3.5 flex flex-col gap-1">
        <x-lucide-users class="w-4 h-4 text-brand-500 mb-0.5" />
        <div class="text-xs text-ink-muted">Kuota Tersisa</div>
        <div class="text-sm font-semibold {{ $slots <= 3 ? 'text-coral-600' : 'text-ink' }}">
            {{ $slots }} slot
            @if($slots <= 3 && $slots > 0)
                <span class="text-[0.7rem] text-coral-500 font-normal">hampir penuh!</span>
            @endif
        </div>
    </div>
    <div class="bg-surface-raised border border-border rounded-xl p-3.5 flex flex-col gap-1">
        <x-lucide-map-pin class="w-4 h-4 text-brand-500 mb-0.5" />
        <div class="text-xs text-ink-muted">Kota Keberangkatan</div>
        <div class="text-sm font-semibold text-ink">{{ $trip->departure_city }}</div>
    </div>
</div>
