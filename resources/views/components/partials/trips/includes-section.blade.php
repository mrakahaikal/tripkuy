@props(['trip'])

@if($trip->includes || $trip->excludes)
    <div>
        <h2 class="font-display text-lg font-bold text-ink mb-4">Yang Sudah Termasuk</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @if($trip->includes)
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-success mb-3">Termasuk</p>
                    <ul class="flex flex-col gap-2">
                        @foreach($trip->includes as $item)
                            <li class="flex items-start gap-2 text-sm text-ink-secondary">
                                <x-lucide-check class="w-4 h-4 text-success mt-0.5 shrink-0" />
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($trip->excludes)
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-danger mb-3">Tidak Termasuk</p>
                    <ul class="flex flex-col gap-2">
                        @foreach($trip->excludes as $item)
                            <li class="flex items-start gap-2 text-sm text-ink-secondary">
                                <x-lucide-x class="w-4 h-4 text-danger mt-0.5 shrink-0" />
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endif
