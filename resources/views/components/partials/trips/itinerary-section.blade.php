@props(['trip'])

@if($trip->itineraries->isNotEmpty())
    <div>
        <h2 class="font-display text-lg font-bold text-ink mb-4">Itinerary Perjalanan</h2>
        <div class="flex flex-col gap-2" x-data="{ open: 0 }">
            @foreach($trip->itineraries as $item)
                <div class="border border-border rounded-xl overflow-hidden">
                    <button
                        class="w-full flex items-center justify-between gap-3 px-4 py-3.5 text-left hover:bg-surface-sunken transition-colors"
                        @click="open = open === {{ $item->day }} ? null : {{ $item->day }}"
                    >
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-brand-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                {{ $item->day }}
                            </span>
                            <span class="font-semibold text-sm text-ink">{{ $item->title }}</span>
                        </div>
                        <x-lucide-chevron-down
                            class="w-4 h-4 text-ink-muted shrink-0 transition-transform duration-200"
                            x-bind:class="open === {{ $item->day }} ? 'rotate-180' : ''"
                        />
                    </button>
                    <div
                        x-show="open === {{ $item->day }}"
                        x-collapse
                        class="px-4 pb-4 pt-1 border-t border-border"
                    >
                        <p class="text-sm text-ink-secondary leading-relaxed">{{ $item->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
