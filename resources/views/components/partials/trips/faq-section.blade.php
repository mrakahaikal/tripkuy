@props(['trip'])

@if($trip->faqs->isNotEmpty())
    <div>
        <h2 class="font-display text-lg font-bold text-ink mb-4">Pertanyaan Umum</h2>
        <div class="flex flex-col gap-2" x-data="{ open: null }">
            @foreach($trip->faqs as $i => $faq)
                <div class="border border-border rounded-xl overflow-hidden">
                    <button
                        class="w-full flex items-center justify-between gap-3 px-4 py-3.5 text-left hover:bg-surface-sunken transition-colors"
                        @click="open = open === {{ $i }} ? null : {{ $i }}"
                    >
                        <span class="text-sm font-semibold text-ink">{{ $faq->question }}</span>
                        <x-lucide-chevron-down
                            class="w-4 h-4 text-ink-muted shrink-0 transition-transform duration-200"
                            x-bind:class="open === {{ $i }} ? 'rotate-180' : ''"
                        />
                    </button>
                    <div
                        x-show="open === {{ $i }}"
                        x-collapse
                        class="px-4 pb-4 pt-1 border-t border-border"
                    >
                        <p class="text-sm text-ink-secondary leading-relaxed">{{ $faq->answer }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
