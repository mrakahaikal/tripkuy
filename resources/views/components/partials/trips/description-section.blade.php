@props(['trip'])

@if($trip->highlight)
    <div class="border-l-4 border-brand-500 pl-5">
        <p class="text-lg font-display font-semibold text-ink leading-relaxed italic">
            "{{ $trip->highlight }}"
        </p>
    </div>
@endif

@if($trip->description)
    <div>
        <h2 class="font-display text-lg font-bold text-ink mb-3">Deskripsi Trip</h2>
        <div class="prose prose-sm max-w-none text-ink-secondary leading-relaxed">
            {!! nl2br(e($trip->description)) !!}
        </div>
    </div>
@endif
