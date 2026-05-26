<footer class="bg-brand-950 text-white">

    {{-- Main content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-10 pb-8 lg:pt-16 lg:pb-12">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr] lg:gap-12">

            {{-- Brand column --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 no-underline mb-5">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-teal-500 rounded-md flex items-center justify-center">
                        <x-lucide-plane class="w-4 h-4 text-white" />
                    </div>
                    <span class="font-display font-extrabold text-xl text-white">TripKuy</span>
                </a>
                <p class="text-[0.9375rem] text-brand-300 leading-7 max-w-[280px] mb-7">
                    Platform open trip terpercaya untuk petualang Indonesia. Temukan dan pesan trip impianmu bersama kami.
                </p>

                {{-- Social links --}}
                <div class="flex items-center gap-2.5">
                    <a href="#" aria-label="Instagram" class="social-link">
                        <x-lucide-instagram class="w-4 h-4" />
                    </a>
                    <a href="#" aria-label="TikTok" class="social-link">
                        <x-lucide-music-2 class="w-4 h-4" />
                    </a>
                    <a href="#" aria-label="YouTube" class="social-link">
                        <x-lucide-youtube class="w-4 h-4" />
                    </a>
                    <a href="#" aria-label="Twitter / X" class="social-link">
                        <x-lucide-twitter class="w-4 h-4" />
                    </a>
                </div>
            </div>

            {{-- Jelajahi --}}
            <div>
                <h6 class="font-display text-[0.8rem] font-bold tracking-[0.07em] uppercase text-brand-600 mb-5">
                    Jelajahi
                </h6>
                <ul class="list-none p-0 m-0 flex flex-col gap-3">
                    <li>
                        <a href="{{ route('trips.index') }}" class="footer-link">Semua Trips</a>
                    </li>
                    @if(Route::has('trips.index'))
                        <li>
                            <a href="{{ route('trips.index') }}?sort=popular" class="footer-link">Trip Populer</a>
                        </li>
                        <li>
                            <a href="{{ route('trips.index') }}?sort=upcoming" class="footer-link">Trip Terbaru</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('blog.index') }}" class="footer-link">Blog & Inspirasi</a>
                    </li>
                </ul>
            </div>

            {{-- Perusahaan --}}
            <div>
                <h6 class="font-display text-[0.8rem] font-bold tracking-[0.07em] uppercase text-brand-600 mb-5">
                    Perusahaan
                </h6>
                <ul class="list-none p-0 m-0 flex flex-col gap-3">
                    <li><a href="{{ route('about.index') }}" class="footer-link">Tentang Kami</a></li>
                    <li><a href="{{ route('about.index') }}" class="footer-link">Cara Kerja</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Bergabung Jadi Guide</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Karir</a></li>
                </ul>
            </div>

            {{-- Dukungan --}}
            <div>
                <h6 class="font-display text-[0.8rem] font-bold tracking-[0.07em] uppercase text-brand-600 mb-5">
                    Dukungan
                </h6>
                <ul class="list-none p-0 m-0 flex flex-col gap-3">
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Pusat Bantuan</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Kebijakan Pembatalan</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('contact.index') }}" class="footer-link">Kebijakan Privasi</a></li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-brand-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex items-center justify-center gap-4 flex-wrap">
            <p class="text-sm text-brand-500 m-0">
                © {{ date('Y') }} TripKuy. Hak cipta dilindungi.
            </p>
        </div>
    </div>

</footer>
