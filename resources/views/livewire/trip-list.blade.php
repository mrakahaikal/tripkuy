<div x-data="{ sidebarOpen: false }">

    {{-- Mobile filter toggle --}}
    <div class="lg:hidden flex items-center justify-between mb-4 px-4 pt-4">
        <button
            @click="sidebarOpen = true"
            class="btn btn-secondary btn-sm"
        >
            <x-lucide-sliders-horizontal class="w-4 h-4" />
            Filter
            @if($this->hasActiveFilters())
                <span class="ml-1 w-5 h-5 rounded-full bg-brand-600 text-white text-[0.65rem] font-bold flex items-center justify-center">!</span>
            @endif
        </button>
        <div class="flex items-center gap-2">
            <span class="text-sm text-ink-muted">Urutkan:</span>
            <select wire:model.live="sortBy" class="input input-sm text-sm py-1">
                <option value="popular">Terpopuler</option>
                <option value="newest">Terbaru</option>
                <option value="price_asc">Harga Terendah</option>
                <option value="price_desc">Harga Tertinggi</option>
            </select>
        </div>
    </div>

    {{-- Mobile sidebar drawer --}}
    <div
        x-show="sidebarOpen"
        x-cloak
        class="fixed inset-0 z-50 lg:hidden"
    >
        {{-- Backdrop --}}
        <div
            class="absolute inset-0 bg-black/50"
            @click="sidebarOpen = false"
        ></div>

        {{-- Drawer --}}
        <div
            class="absolute left-0 top-0 bottom-0 w-80 bg-surface-raised overflow-y-auto shadow-2xl"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
        >
            <div class="flex items-center justify-between p-4 border-b border-border">
                <span class="font-display font-semibold text-ink">Filter Trip</span>
                <button @click="sidebarOpen = false" class="btn btn-ghost btn-sm p-1.5">
                    <x-lucide-x class="w-4 h-4" />
                </button>
            </div>
            <div class="p-4">
                @include('livewire.partials.trip-filter-body')
            </div>
        </div>
    </div>

    {{-- Main layout --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="flex gap-7">

            {{-- Sidebar (desktop) --}}
            <aside class="hidden lg:block w-60 shrink-0">
                <div class="sticky top-24 bg-surface-raised rounded-2xl border border-border p-5 flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <span class="font-display font-semibold text-sm text-ink">Filter</span>
                        @if($this->hasActiveFilters())
                            <button wire:click="resetFilters" class="text-[0.75rem] text-brand-600 hover:text-brand-700 font-medium">
                                Reset semua
                            </button>
                        @endif
                    </div>
                    @include('livewire.partials.trip-filter-body')
                </div>
            </aside>

            {{-- Content --}}
            <div class="flex-1 min-w-0">

                {{-- Sort bar --}}
                <div class="hidden lg:flex items-center justify-between mb-6">
                    <p class="text-sm text-ink-muted">
                        <span class="font-semibold text-ink">{{ $trips->total() }}</span> trip ditemukan
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-ink-muted">Urutkan:</span>
                        <select wire:model.live="sortBy" class="input input-sm text-sm py-1.5">
                            <option value="popular">Terpopuler</option>
                            <option value="newest">Terbaru</option>
                            <option value="price_asc">Harga Terendah</option>
                            <option value="price_desc">Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                {{-- Active filter tags --}}
                @if($this->hasActiveFilters())
                    <div class="flex flex-wrap gap-2 mb-5">
                        @if($search)
                            <button wire:click="$set('search', '')" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                "{{ $search }}" <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endif
                        @if($category)
                            @php $cat = $categories->firstWhere('slug', $category) @endphp
                            <button wire:click="$set('category', '')" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                {{ $cat?->name ?? $category }} <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endif
                        @if($destination)
                            <button wire:click="$set('destination', '')" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                Destinasi: {{ $destination }} <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endif
                        @if($dateFrom || $dateTo)
                            <button wire:click="$set('dateFrom', ''); $set('dateTo', '')" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                Tanggal: {{ $dateFrom ?: '...' }} – {{ $dateTo ?: '...' }} <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endif
                        @if($minPrice !== '' || $maxPrice !== '')
                            <button wire:click="$set('minPrice', ''); $set('maxPrice', '')" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                Harga: {{ $minPrice !== '' ? 'Rp'.number_format((int)$minPrice,0,',','.') : '0' }} – {{ $maxPrice !== '' ? 'Rp'.number_format((int)$maxPrice,0,',','.') : '∞' }} <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endif
                        @foreach($difficulty as $d)
                            <button wire:click="$set('difficulty', array_values(array_filter($difficulty, fn($v) => $v !== '{{ $d }}')))" class="badge badge-brand flex items-center gap-1 cursor-pointer hover:bg-brand-200">
                                {{ match($d) { 'easy' => 'Mudah', 'moderate' => 'Sedang', 'hard' => 'Sulit', default => $d } }} <x-lucide-x class="w-3 h-3" />
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Trip grid --}}
                @if($trips->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($trips as $trip)
                            <x-ui.trip-card :trip="$trip" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($trips->hasPages())
                        <div class="mt-10">
                            {{ $trips->links() }}
                        </div>
                    @endif

                @else
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center text-center py-24 px-8">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center mb-5">
                            <x-lucide-search-x class="w-8 h-8 text-brand-400" />
                        </div>
                        <h3 class="font-display font-bold text-lg text-ink mb-2">Trip tidak ditemukan</h3>
                        <p class="text-sm text-ink-muted max-w-xs leading-relaxed">
                            Tidak ada trip yang cocok dengan filter kamu. Coba ubah atau reset filter.
                        </p>
                        <button wire:click="resetFilters" class="btn btn-secondary btn-sm mt-5">
                            Reset Filter
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>
