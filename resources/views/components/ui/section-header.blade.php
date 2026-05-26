@props([
    'eyebrow' => '',
    'title'   => '',
    'subtitle' => '',
    'align'   => 'left',
])

<div @class(['mb-10', 'text-center' => $align === 'center'])>
    @if($eyebrow)
        <p class="section-eyebrow mb-2">{{ $eyebrow }}</p>
    @endif

    <h2 @class(['section-title text-[2rem]', 'mb-3' => $subtitle, 'mb-0' => ! $subtitle])>
        {{ $title }}
    </h2>

    @if($subtitle)
        <p @class(['text-base text-ink-secondary max-w-[560px] leading-[1.7]', 'mx-auto' => $align === 'center'])>
            {{ $subtitle }}
        </p>
    @endif
</div>
