@props(['post'])

<div class="flex items-start gap-4 p-5 bg-surface-raised border border-border rounded-2xl">
    <div class="w-14 h-14 rounded-full bg-brand-100 flex items-center justify-center shrink-0">
        <span class="text-xl font-bold text-brand-600">
            {{ strtoupper(substr($post->author->name, 0, 1)) }}
        </span>
    </div>
    <div class="flex-1 min-w-0">
        <div class="text-xs font-semibold uppercase tracking-wider text-ink-muted mb-0.5">Ditulis oleh</div>
        <div class="font-display font-bold text-ink text-[1.0625rem]">{{ $post->author->name }}</div>
        <div class="text-sm text-ink-muted mt-0.5">
            Dipublikasikan {{ $post->published_at->translatedFormat('d F Y') }}
        </div>
    </div>
    <a href="{{ route('blog.index') }}" class="btn btn-ghost btn-sm shrink-0 hidden sm:inline-flex">
        Baca artikel lain
        <x-lucide-arrow-right class="w-3.5 h-3.5" />
    </a>
</div>
