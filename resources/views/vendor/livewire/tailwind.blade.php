@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4 flex-wrap">

    {{-- Result info --}}
    <p class="text-sm text-ink-muted">
        Menampilkan
        <span class="font-semibold text-ink">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-ink">{{ $paginator->lastItem() }}</span>
        dari <span class="font-semibold text-ink">{{ $paginator->total() }}</span> trip
    </p>

    {{-- Page buttons --}}
    <div class="flex items-center gap-1">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-ghost btn-sm opacity-40 cursor-not-allowed" aria-disabled="true">
                <x-lucide-chevron-left class="w-4 h-4" />
            </span>
        @else
            <button
                type="button"
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="btn btn-ghost btn-sm"
                aria-label="{{ __('pagination.previous') }}"
            >
                <x-lucide-chevron-left class="w-4 h-4" />
            </button>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-sm text-ink-muted">…</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                        @if ($page == $paginator->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-brand-600 text-white text-sm font-semibold" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <button
                                type="button"
                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-ink-secondary hover:bg-surface-sunken hover:text-ink transition-colors"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
                            >
                                {{ $page }}
                            </button>
                        @endif
                    </span>
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button
                type="button"
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="btn btn-ghost btn-sm"
                aria-label="{{ __('pagination.next') }}"
            >
                <x-lucide-chevron-right class="w-4 h-4" />
            </button>
        @else
            <span class="btn btn-ghost btn-sm opacity-40 cursor-not-allowed" aria-disabled="true">
                <x-lucide-chevron-right class="w-4 h-4" />
            </span>
        @endif

    </div>
</nav>
@endif
