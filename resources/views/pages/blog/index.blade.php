<x-layouts.app title="Blog & Inspirasi — TripKuy">

    {{-- Page header --}}
    <div class="bg-brand-900 border-b border-brand-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
            <p class="text-xs font-bold tracking-widest uppercase text-teal-400 mb-2">Dari Blog Kami</p>
            <h1 class="font-display text-2xl md:text-[2rem] font-extrabold text-white mb-2">Blog & Inspirasi</h1>
            <p class="text-[0.9375rem] text-brand-300 leading-relaxed max-w-lg">
                Tips perjalanan, panduan destinasi, dan cerita petualangan dari seluruh Indonesia.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <livewire:blog-list />
    </div>

</x-layouts.app>
