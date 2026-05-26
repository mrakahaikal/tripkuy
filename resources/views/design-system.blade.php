<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TripKuy — Design System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300..700;1,9..40,300..700&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .ds-section { margin-bottom: 4rem; }
        .ds-row     { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; }
        .ds-label   { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--color-ink-muted); margin-bottom: 0.5rem; }
        .ds-swatch  { width: 3.5rem; height: 3.5rem; border-radius: var(--radius-md); border: 1px solid oklch(0 0 0 / 0.08); }
        .ds-swatch-wrap { display: flex; flex-direction: column; align-items: center; gap: 0.375rem; }
        .ds-swatch-name { font-size: 0.7rem; color: var(--color-ink-muted); text-align: center; }
        .ds-page-title { font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; color: var(--color-ink); }
        .ds-section-header { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; color: var(--color-ink); padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-border); margin-bottom: 1.75rem; display: flex; align-items: center; gap: 0.5rem; }
        .ds-section-header span.tag { font-size: 0.7rem; font-weight: 600; padding: 0.15rem 0.5rem; background: var(--color-brand-100); color: var(--color-brand-700); border-radius: var(--radius-pill); letter-spacing: 0.04em; text-transform: uppercase; }
        .ds-container { max-width: 1080px; margin: 0 auto; padding: 3rem 2rem 6rem; }
        .ds-sidebar { position: sticky; top: 2rem; }
        .ds-nav-item { display: block; padding: 0.375rem 0.75rem; font-size: 0.875rem; color: var(--color-ink-secondary); border-radius: var(--radius-sm); text-decoration: none; transition: all 0.15s; border-left: 2px solid transparent; }
        .ds-nav-item:hover { color: var(--color-brand-600); border-left-color: var(--color-brand-300); background: var(--color-brand-50); }
        .ds-nav-item.active { color: var(--color-brand-700); border-left-color: var(--color-brand-600); font-weight: 600; }

        /* Image Link Cards */
        .img-link-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-3px); }
        .img-link-card:hover .img-link-card__img { transform: scale(1.06); }

        /* Fake hero preview */
        .hero-preview {
            background: linear-gradient(135deg, oklch(24% 0.095 238) 0%, oklch(40% 0.165 234) 50%, oklch(61% 0.185 190) 100%);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            position: relative;
        }
        .hero-preview::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body style="background-color: var(--color-surface);">

{{-- TOP NAV --}}
<nav style="background: var(--color-surface-raised); border-bottom: 1.5px solid var(--color-border); position: sticky; top: 0; z-index: 50;">
    <div style="max-width: 1080px; margin: 0 auto; padding: 0 2rem; height: 3.5rem; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 2rem; height: 2rem; background: var(--color-brand-600); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                <x-lucide-plane class="w-3.5 h-3.5 text-white" />
            </div>
            <span style="font-family: var(--font-display); font-weight: 800; font-size: 1.125rem; color: var(--color-ink);">TripKuy</span>
            <span style="font-size: 0.7rem; font-weight: 600; padding: 0.15rem 0.5rem; background: var(--color-coral-100); color: var(--color-coral-700); border-radius: var(--radius-pill);">Design System</span>
        </div>
        <span style="font-size: 0.8rem; color: var(--color-ink-muted);">v1.0.0</span>
    </div>
</nav>

<div style="max-width: 1080px; margin: 0 auto; padding: 3rem 2rem 6rem; display: grid; grid-template-columns: 200px 1fr; gap: 3rem; align-items: start;">

    {{-- SIDEBAR --}}
    <aside class="ds-sidebar">
        <div style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-ink-muted); padding: 0 0.75rem; margin-bottom: 0.75rem;">Navigation</div>
        <a href="#foundations"  class="ds-nav-item active">Foundations</a>
        <a href="#typography"   class="ds-nav-item">Typography</a>
        <a href="#colors"       class="ds-nav-item">Colors</a>
        <a href="#buttons"      class="ds-nav-item">Buttons</a>
        <a href="#badges"       class="ds-nav-item">Badges & Chips</a>
        <a href="#inputs"       class="ds-nav-item">Inputs</a>
        <a href="#cards"        class="ds-nav-item">Cards</a>
        <a href="#image-cards"  class="ds-nav-item">Image Link Cards</a>
        <a href="#tabs"         class="ds-nav-item">Tabs</a>
        <a href="#navigation"   class="ds-nav-item">Navigation</a>
        <a href="#data-display" class="ds-nav-item">Data Display</a>
        <a href="#hero-preview" class="ds-nav-item">Hero Preview</a>
    </aside>

    {{-- MAIN --}}
    <main>

        {{-- PAGE HEADER --}}
        <div style="margin-bottom: 3.5rem;">
            <p class="section-eyebrow" style="margin-bottom: 0.5rem;">TripKuy Design System</p>
            <h1 class="ds-page-title" style="margin-bottom: 1rem;">Component Library</h1>
            <p style="font-size: 1rem; color: var(--color-ink-secondary); max-width: 560px; line-height: 1.7;">
                Inspired by Trip.com's clean, trust-building aesthetic — refined for the Indonesian travel market.
                Built on Tailwind CSS v4 with <strong>DM Sans</strong> for body text and <strong>Sora</strong> as the display typeface.
            </p>
        </div>

        {{-- ========== FOUNDATIONS ========== --}}
        <section id="foundations" class="ds-section">
            <div class="ds-section-header">Foundations <span class="tag">Core</span></div>

            <div class="ds-label">Spacing Scale</div>
            <div class="ds-row" style="align-items: flex-end; margin-bottom: 2rem;">
                @foreach([1=>4, 2=>8, 3=>12, 4=>16, 5=>20, 6=>24, 8=>32, 10=>40, 12=>48, 16=>64] as $key => $px)
                <div class="ds-swatch-wrap">
                    <div style="width: {{ $px }}px; height: {{ $px }}px; background: var(--color-brand-400); border-radius: 2px;"></div>
                    <span class="ds-swatch-name">{{ $key }}</span>
                </div>
                @endforeach
            </div>

            <div class="ds-label">Border Radius</div>
            <div class="ds-row" style="margin-bottom: 2rem;">
                @foreach(['xs'=>'4px','sm'=>'6px','md'=>'8px','lg'=>'12px','xl'=>'16px','2xl'=>'20px','3xl'=>'24px','pill'=>'∞'] as $name => $val)
                <div class="ds-swatch-wrap">
                    <div style="width: 3rem; height: 3rem; background: var(--color-brand-100); border: 2px solid var(--color-brand-400); border-radius: var(--radius-{{ $name }});"></div>
                    <span class="ds-swatch-name">{{ $name }}<br><span style="color: var(--color-ink-subtle);">{{ $val }}</span></span>
                </div>
                @endforeach
            </div>

            <div class="ds-label">Shadows</div>
            <div class="ds-row">
                @foreach(['xs','sm','md','lg','xl','card'] as $s)
                <div class="ds-swatch-wrap">
                    <div style="width: 4rem; height: 4rem; background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-{{ $s }});"></div>
                    <span class="ds-swatch-name">{{ $s }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ========== TYPOGRAPHY ========== --}}
        <section id="typography" class="ds-section">
            <div class="ds-section-header">Typography <span class="tag">DM Sans + Sora</span></div>

            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <div class="ds-label">Display — Sora</div>
                    <h1 style="font-family: var(--font-display); font-size: 3rem; font-weight: 800; line-height: 1.15; color: var(--color-ink);">Explore Indonesia</h1>
                    <h2 style="font-family: var(--font-display); font-size: 2.25rem; font-weight: 700; line-height: 1.2; color: var(--color-ink);">Find Your Next Trip</h2>
                    <h3 style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 700; line-height: 1.25; color: var(--color-ink);">Popular Destinations</h3>
                    <h4 style="font-family: var(--font-display); font-size: 1.375rem; font-weight: 600; line-height: 1.3; color: var(--color-ink);">Hotel & Resort Packages</h4>
                    <h5 style="font-family: var(--font-display); font-size: 1.125rem; font-weight: 600; line-height: 1.4; color: var(--color-ink);">Best deals this week</h5>
                    <h6 style="font-family: var(--font-display); font-size: 1rem; font-weight: 600; line-height: 1.5; color: var(--color-ink);">Section heading</h6>
                </div>
                <div>
                    <div class="ds-label">Body — DM Sans</div>
                    <p style="font-size: 1rem; line-height: 1.75; color: var(--color-ink);">Regular body text — Temukan pengalaman perjalanan terbaik bersama TripKuy. Dari destinasi eksotis hingga kota metropolitan yang modern.</p>
                    <p style="font-size: 0.9375rem; line-height: 1.7; color: var(--color-ink-secondary);">Secondary body — Harga terjangkau dengan layanan premium. Booking sekarang dan nikmati promo eksklusif untuk member baru.</p>
                    <p style="font-size: 0.875rem; line-height: 1.6; color: var(--color-ink-muted);">Small / caption — *Syarat dan ketentuan berlaku. Harga dapat berubah sewaktu-waktu.</p>
                    <p style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--color-brand-600); margin-top: 0.5rem;">Eyebrow / Label Uppercase</p>
                </div>
            </div>
        </section>

        {{-- ========== COLORS ========== --}}
        <section id="colors" class="ds-section">
            <div class="ds-section-header">Colors <span class="tag">Palette</span></div>

            @php
            $palettes = [
                'brand'   => ['50','100','200','300','400','500','600','700','800','900','950'],
                'coral'   => ['50','100','200','300','400','500','600','700','800','900','950'],
                'teal'    => ['50','100','200','300','400','500','600','700','800','900','950'],
            ];
            $semantics = [
                'Surface'         => 'var(--color-surface)',
                'Surface Raised'  => 'var(--color-surface-raised)',
                'Surface Sunken'  => 'var(--color-surface-sunken)',
                'Border'          => 'var(--color-border)',
                'Border Strong'   => 'var(--color-border-strong)',
                'Ink'             => 'var(--color-ink)',
                'Ink Secondary'   => 'var(--color-ink-secondary)',
                'Ink Muted'       => 'var(--color-ink-muted)',
                'Ink Subtle'      => 'var(--color-ink-subtle)',
                'Success'         => 'var(--color-success)',
                'Warning'         => 'var(--color-warning)',
                'Danger'          => 'var(--color-danger)',
            ];
            @endphp

            @foreach($palettes as $name => $steps)
            <div style="margin-bottom: 1.5rem;">
                <div class="ds-label">{{ ucfirst($name) }}</div>
                <div style="display: flex; gap: 0.375rem; flex-wrap: wrap;">
                    @foreach($steps as $step)
                    <div class="ds-swatch-wrap">
                        <div class="ds-swatch" style="background: var(--color-{{ $name }}-{{ $step }});"></div>
                        <span class="ds-swatch-name">{{ $step }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div style="margin-top: 2rem;">
                <div class="ds-label">Semantic Tokens</div>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @foreach($semantics as $label => $val)
                    <div class="ds-swatch-wrap">
                        <div class="ds-swatch" style="background: {{ $val }};"></div>
                        <span class="ds-swatch-name" style="max-width: 5rem; text-align: center;">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ========== BUTTONS ========== --}}
        <section id="buttons" class="ds-section">
            <div class="ds-section-header">Buttons <span class="tag">Interactive</span></div>

            <div class="ds-label">Variants</div>
            <div class="ds-row" style="margin-bottom: 2rem;">
                <button class="btn btn-primary btn-md">Book Now</button>
                <button class="btn btn-secondary btn-md">Learn More</button>
                <button class="btn btn-ghost btn-md">Cancel</button>
                <button class="btn btn-coral btn-md">🔥 Hot Deal</button>
                <button class="btn btn-ghost btn-md" style="opacity: 0.45; cursor: not-allowed;" disabled>Disabled</button>
            </div>

            <div class="ds-label">Sizes</div>
            <div class="ds-row" style="align-items: center; margin-bottom: 2rem;">
                <button class="btn btn-primary btn-sm">Small</button>
                <button class="btn btn-primary btn-md">Medium</button>
                <button class="btn btn-primary btn-lg">Large</button>
                <button class="btn btn-primary btn-xl">XL — Search</button>
            </div>

            <div class="ds-label">With Icons</div>
            <div class="ds-row">
                <button class="btn btn-primary btn-md">
                    <x-lucide-search class="w-4 h-4" />
                    Search Flights
                </button>
                <button class="btn btn-secondary btn-md">
                    <x-lucide-heart class="w-4 h-4" />
                    Save
                </button>
                <button class="btn btn-ghost btn-md btn-icon" title="Share">
                    <x-lucide-share-2 class="w-4 h-4" />
                </button>
                <button class="btn btn-primary btn-md" style="width: 100%; max-width: 240px; justify-content: center;">
                    Full Width Button
                    <x-lucide-arrow-right class="w-4 h-4" />
                </button>
            </div>
        </section>

        {{-- ========== BADGES & CHIPS ========== --}}
        <section id="badges" class="ds-section">
            <div class="ds-section-header">Badges & Chips <span class="tag">Labels</span></div>

            <div class="ds-label">Badge Variants</div>
            <div class="ds-row" style="margin-bottom: 1.5rem;">
                <span class="badge badge-brand">Recommended</span>
                <span class="badge badge-coral">Flash Sale</span>
                <span class="badge badge-teal">Free Wifi</span>
                <span class="badge badge-success">Available</span>
                <span class="badge badge-warning">Limited</span>
                <span class="badge badge-danger">Sold Out</span>
                <span class="badge badge-neutral">Standard</span>
            </div>

            <div class="ds-label">Solid Badges</div>
            <div class="ds-row" style="margin-bottom: 1.5rem;">
                <span class="badge badge-solid-brand">⭐ Top Pick</span>
                <span class="badge badge-solid-coral">🔥 Best Value</span>
                <span class="badge" style="background: var(--color-success); color: white;">✓ Verified</span>
                <span class="badge" style="background: var(--color-ink); color: white;">NEW</span>
            </div>

            <div class="ds-label">Filter Chips</div>
            <div class="ds-row">
                <button class="chip selected">✈ All</button>
                <button class="chip">Hotels</button>
                <button class="chip">Flights</button>
                <button class="chip">Tours</button>
                <button class="chip">Car Rental</button>
                <button class="chip">Activities</button>
                <button class="chip">Visa</button>
            </div>
        </section>

        {{-- ========== INPUTS ========== --}}
        <section id="inputs" class="ds-section">
            <div class="ds-section-header">Form Inputs <span class="tag">Forms</span></div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; max-width: 640px; margin-bottom: 2rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink-secondary); margin-bottom: 0.375rem;">From</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--color-ink-muted); display: flex;">
                            <x-lucide-search class="w-4 h-4" />
                        </span>
                        <input class="input" style="padding-left: 2.5rem;" placeholder="Jakarta (CGK)" value="Jakarta (CGK)">
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink-secondary); margin-bottom: 0.375rem;">To</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); color: var(--color-ink-muted); display: flex;">
                            <x-lucide-map-pin class="w-4 h-4" />
                        </span>
                        <input class="input" style="padding-left: 2.5rem;" placeholder="Bali (DPS)">
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink-secondary); margin-bottom: 0.375rem;">Departure Date</label>
                    <input class="input" type="date" value="2025-06-15">
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink-secondary); margin-bottom: 0.375rem;">Passengers</label>
                    <select class="input">
                        <option>1 Adult</option>
                        <option>2 Adults</option>
                        <option>2 Adults, 1 Child</option>
                    </select>
                </div>
                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-ink-secondary); margin-bottom: 0.375rem;">Special Requests</label>
                    <textarea class="input" rows="3" placeholder="Any special requirements..."></textarea>
                </div>
            </div>

            <div class="ds-label">Input Sizes</div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem; max-width: 320px;">
                <input class="input input-sm" placeholder="Small input">
                <input class="input" placeholder="Default input">
                <input class="input input-lg" placeholder="Large input">
            </div>

            <div style="margin-top: 1.5rem;">
                <div class="ds-label">States</div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; max-width: 320px;">
                    <input class="input" placeholder="Default" value="Normal state">
                    <input class="input" style="border-color: var(--color-border-focus); box-shadow: 0 0 0 3px oklch(56% 0.19 230 / 0.15);" placeholder="Focused state" value="Focused state">
                    <input class="input" style="border-color: var(--color-danger); box-shadow: 0 0 0 3px oklch(57% 0.22 25 / 0.15);" value="Error state">
                    <div style="font-size: 0.8125rem; color: var(--color-danger); margin-top: -0.375rem;">This field is required.</div>
                    <input class="input" style="border-color: var(--color-success); box-shadow: 0 0 0 3px oklch(55% 0.17 155 / 0.15);" value="Valid state ✓">
                    <input class="input" disabled style="opacity: 0.5; cursor: not-allowed;" value="Disabled state">
                </div>
            </div>
        </section>

        {{-- ========== CARDS ========== --}}
        <section id="cards" class="ds-section">
            <div class="ds-section-header">Cards <span class="tag">Content</span></div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 2rem;">

                {{-- Destination Card --}}
                <div class="card">
                    <div style="height: 160px; position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&h=320&fit=crop&q=80" alt="Bali" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, oklch(0% 0 0 / 0.45) 0%, transparent 55%);"></div>
                        <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                            <span class="badge badge-solid-coral">Popular</span>
                        </div>
                        <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: white; border-radius: var(--radius-pill); width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-sm);">
                            <x-lucide-heart class="w-3.5 h-3.5" style="stroke: var(--color-ink-secondary)" />
                        </div>
                    </div>
                    <div style="padding: 1rem;">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.5rem; margin-bottom: 0.375rem;">
                            <h4 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--color-ink);">Bali, Indonesia</h4>
                            <div class="stars" style="font-size: 0.75rem; flex-shrink: 0;">★★★★★</div>
                        </div>
                        <p style="font-size: 0.8125rem; color: var(--color-ink-secondary); line-height: 1.6; margin-bottom: 0.875rem;">Tropical paradise with rich culture, beaches & temples</p>
                        <hr class="divider" style="margin-bottom: 0.875rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div class="price-strike">Rp 2.500.000</div>
                                <div class="price-tag">
                                    <span style="font-size: 0.75rem; color: var(--color-coral-600); font-weight: 600;">Rp</span>
                                    <span class="price-main" style="font-size: 1.25rem;">1.850.000</span>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm">Book</button>
                        </div>
                    </div>
                </div>

                {{-- Hotel Card --}}
                <div class="card">
                    <div style="height: 160px; position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=320&fit=crop&q=80" alt="Hotel Pool" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, oklch(0% 0 0 / 0.4) 0%, transparent 55%);"></div>
                        <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                            <span class="badge badge-solid-brand">⭐ 4.8</span>
                        </div>
                    </div>
                    <div style="padding: 1rem;">
                        <h4 style="font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--color-ink); margin-bottom: 0.25rem;">The Grand Hyatt</h4>
                        <p style="font-size: 0.8rem; color: var(--color-ink-muted); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.25rem;"><x-lucide-map-pin class="w-3 h-3" /> Nusa Dua, Bali</p>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.375rem; margin-bottom: 0.875rem;">
                            <span class="badge badge-teal">Free Wifi</span>
                            <span class="badge badge-neutral">Pool</span>
                            <span class="badge badge-neutral">Breakfast</span>
                        </div>
                        <hr class="divider" style="margin-bottom: 0.875rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--color-ink-muted);">per night from</span>
                                <div class="price-tag">
                                    <span style="font-size: 0.75rem; color: var(--color-coral-600); font-weight: 600;">Rp</span>
                                    <span class="price-main" style="font-size: 1.25rem;">1.200.000</span>
                                </div>
                            </div>
                            <button class="btn btn-secondary btn-sm">View</button>
                        </div>
                    </div>
                </div>

                {{-- Tour Package Card --}}
                <div class="card-flat" style="overflow: hidden; display: flex; flex-direction: column;">
                    <div style="height: 120px; position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=600&h=240&fit=crop&q=80" alt="Bromo" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, oklch(0% 0 0 / 0.5) 0%, transparent 60%);"></div>
                        <div style="position: absolute; bottom: 0.625rem; left: 0.875rem;">
                            <span style="font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: white;">Bromo Sunrise Tour</span>
                        </div>
                    </div>
                    <div style="padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem; flex: 1;">
                    <div style="display: flex; align-items: center; gap: 0.875rem;">
                        <div style="width: 2.25rem; height: 2.25rem; background: var(--color-teal-100); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--color-teal-700);">
                            <x-lucide-map class="w-4 h-4" />
                        </div>
                        <div>
                            <h4 style="font-family: var(--font-display); font-size: 0.9375rem; font-weight: 700; color: var(--color-ink); margin-bottom: 0.125rem;">Bromo Sunrise Tour</h4>
                            <p style="font-size: 0.8rem; color: var(--color-ink-muted);">3 days · 2 nights</p>
                        </div>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.375rem;">
                        @foreach(['Hotel Bintang 4','Transportasi AC','Guide Lokal','Sarapan Termasuk'] as $item)
                        <li style="font-size: 0.8125rem; color: var(--color-ink-secondary); display: flex; align-items: center; gap: 0.5rem;">
                            <x-lucide-check class="w-3 h-3 shrink-0" style="color: var(--color-success)" /> {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    <hr class="divider">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="price-tag">
                            <span style="font-size: 0.75rem; color: var(--color-coral-600); font-weight: 600;">Rp</span>
                            <span class="price-main" style="font-size: 1.125rem;">850.000</span>
                            <span style="font-size: 0.75rem; color: var(--color-ink-muted);">/orang</span>
                        </div>
                        <button class="btn btn-coral btn-sm">Pesan</button>
                    </div>
                </div>
            </div>
            </div>

            {{-- Horizontal Card --}}
            <div class="ds-label">Horizontal Card</div>
            <div class="card-flat" style="overflow: hidden; max-width: 640px; display: flex;">
                <div style="width: 140px; flex-shrink: 0; position: relative; overflow: hidden;">
                    <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=280&h=300&fit=crop&q=80" alt="Airplane" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to right, transparent 60%, oklch(0% 0 0 / 0.15));"></div>
                </div>
                <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; gap: 0.5rem;">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                        <div>
                            <h4 style="font-family: var(--font-display); font-weight: 700; font-size: 1rem; color: var(--color-ink);">CGK → DPS</h4>
                            <p style="font-size: 0.8rem; color: var(--color-ink-muted);">Garuda Indonesia · GA-400 · Economy</p>
                        </div>
                        <span class="badge badge-success">On Time</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.8125rem; color: var(--color-ink-secondary);">
                        <span><strong style="font-size: 1rem; color: var(--color-ink);">07:30</strong> CGK</span>
                        <span style="flex: 1; text-align: center; position: relative;">
                            <span style="display: block; height: 1px; background: var(--color-border-strong);"></span>
                            <span style="position: absolute; top: -8px; left: 50%; transform: translateX(-50%); font-size: 0.7rem; background: white; padding: 0 0.25rem; color: var(--color-ink-muted);">1h 45m</span>
                        </span>
                        <span><strong style="font-size: 1rem; color: var(--color-ink);">09:15</strong> DPS</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="price-tag">
                            <span class="price-main" style="font-size: 1.125rem;">Rp 780.000</span>
                        </div>
                        <button class="btn btn-primary btn-sm">Select</button>
                    </div>
                </div>
            </div>

            {{-- ========== IMAGE LINK CARDS ========== --}}
            <div id="image-cards" style="margin-top: 2.5rem;">
                <div class="ds-label" style="margin-bottom: 1.25rem;">Image Link Cards — Destination / Hotel</div>

                {{-- Portrait grid (destination style) --}}
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    @php
                    $destinations = [
                        [
                            'img'      => 'photo-1537996194471-e657df975ab4',
                            'city'     => 'Bali',
                            'country'  => 'Indonesia',
                            'count'    => '1,240 hotels',
                            'badge'    => 'Popular',
                            'badgeClass' => 'badge-solid-coral',
                        ],
                        [
                            'img'      => 'photo-1555400038-63f5ba517a47',
                            'city'     => 'Jakarta',
                            'country'  => 'Indonesia',
                            'count'    => '860 hotels',
                            'badge'    => null,
                            'badgeClass' => '',
                        ],
                        [
                            'img'      => 'photo-1601301405892-3873b4346c53',
                            'city'     => 'Yogyakarta',
                            'country'  => 'Indonesia',
                            'count'    => '430 hotels',
                            'badge'    => 'Trending',
                            'badgeClass' => 'badge-solid-brand',
                        ],
                        [
                            'img'      => 'photo-1525625293386-3f8f99389edd',
                            'city'     => 'Singapore',
                            'country'  => 'Singapore',
                            'count'    => '2,100 hotels',
                            'badge'    => null,
                            'badgeClass' => '',
                        ],
                    ];
                    @endphp

                    @foreach($destinations as $dest)
                    <a href="#" style="display: block; border-radius: var(--radius-xl); overflow: hidden; position: relative; text-decoration: none; aspect-ratio: 3/4; box-shadow: var(--shadow-card);" class="img-link-card">
                        <img
                            src="https://images.unsplash.com/{{ $dest['img'] }}?w=400&h=533&fit=crop&q=80"
                            alt="{{ $dest['city'] }}"
                            style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease;"
                            class="img-link-card__img"
                        >
                        {{-- gradient overlay --}}
                        <div style="position: absolute; inset: 0; background: linear-gradient(to top, oklch(5% 0.01 240 / 0.85) 0%, oklch(5% 0.01 240 / 0.3) 45%, transparent 75%);"></div>
                        {{-- badge --}}
                        @if($dest['badge'])
                        <div style="position: absolute; top: 0.75rem; left: 0.75rem;">
                            <span class="badge {{ $dest['badgeClass'] }}">{{ $dest['badge'] }}</span>
                        </div>
                        @endif
                        {{-- save button --}}
                        <div style="position: absolute; top: 0.75rem; right: 0.75rem; width: 2rem; height: 2rem; background: oklch(100% 0 0 / 0.15); backdrop-filter: blur(8px); border-radius: var(--radius-pill); display: flex; align-items: center; justify-content: center; color: white; transition: background 0.2s ease;">
                            <x-lucide-heart class="w-3.5 h-3.5" />
                        </div>
                        {{-- content --}}
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 1rem 1rem 1.125rem;">
                            <div style="font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; color: white; line-height: 1.2; margin-bottom: 0.25rem;">{{ $dest['city'] }}</div>
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.8rem; color: oklch(88% 0.04 230);">
                                    <x-lucide-map-pin class="w-3 h-3" style="display:inline-block; vertical-align: middle; margin-bottom:1px;" /> {{ $dest['country'] }}
                                </span>
                                <span style="font-size: 0.75rem; color: oklch(80% 0.06 230); font-weight: 500;">{{ $dest['count'] }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Wide landscape variant (hotel card as link) --}}
                <div class="ds-label" style="margin-bottom: 1rem;">Wide Variant</div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    @php
                    $hotels = [
                        [
                            'img'     => 'photo-1566073771259-6a8506099945',
                            'name'    => 'The Ritz-Carlton Bali',
                            'city'    => 'Nusa Dua, Bali',
                            'rating'  => '4.9',
                            'reviews' => '2,841',
                            'price'   => '2.400.000',
                            'badge'   => 'Free Breakfast',
                        ],
                        [
                            'img'     => 'photo-1520250497591-112f2f40a3f4',
                            'name'    => 'Alila Villas Uluwatu',
                            'city'    => 'Uluwatu, Bali',
                            'rating'  => '4.8',
                            'reviews' => '1,204',
                            'price'   => '3.100.000',
                            'badge'   => 'Best Value',
                        ],
                    ];
                    @endphp

                    @foreach($hotels as $hotel)
                    <a href="#" style="display: flex; border-radius: var(--radius-xl); overflow: hidden; text-decoration: none; box-shadow: var(--shadow-card); background: white; transition: box-shadow 0.2s ease, transform 0.2s ease;" class="img-link-card">
                        {{-- image --}}
                        <div style="width: 160px; flex-shrink: 0; position: relative; overflow: hidden;">
                            <img
                                src="https://images.unsplash.com/{{ $hotel['img'] }}?w=320&h=220&fit=crop&q=80"
                                alt="{{ $hotel['name'] }}"
                                style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease;"
                                class="img-link-card__img"
                            >
                            <div style="position: absolute; top: 0.625rem; left: 0.625rem;">
                                <span class="badge badge-solid-coral" style="font-size: 0.65rem;">{{ $hotel['badge'] }}</span>
                            </div>
                        </div>
                        {{-- content --}}
                        <div style="padding: 1rem 1.125rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-width: 0;">
                            <div>
                                <div style="font-family: var(--font-display); font-size: 0.9375rem; font-weight: 700; color: var(--color-ink); margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $hotel['name'] }}</div>
                                <div style="font-size: 0.8rem; color: var(--color-ink-muted); display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0.625rem;">
                                    <x-lucide-map-pin class="w-3 h-3 shrink-0" /> {{ $hotel['city'] }}
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.375rem;">
                                    <span style="background: var(--color-brand-600); color: white; font-size: 0.75rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: var(--radius-sm);">{{ $hotel['rating'] }}</span>
                                    <div class="stars" style="font-size: 0.7rem;">★★★★★</div>
                                    <span style="font-size: 0.75rem; color: var(--color-ink-muted);">({{ $hotel['reviews'] }})</span>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-end; justify-content: space-between;">
                                <div>
                                    <div style="font-size: 0.72rem; color: var(--color-ink-muted);">mulai dari</div>
                                    <div class="price-tag">
                                        <span style="font-size: 0.72rem; color: var(--color-coral-600); font-weight: 600;">Rp</span>
                                        <span class="price-main" style="font-size: 1.125rem;">{{ $hotel['price'] }}</span>
                                        <span style="font-size: 0.72rem; color: var(--color-ink-muted);">/malam</span>
                                    </div>
                                </div>
                                <span style="color: var(--color-brand-600); display: flex; align-items: center; gap: 0.2rem; font-size: 0.8rem; font-weight: 600;">
                                    Lihat <x-lucide-arrow-right class="w-3.5 h-3.5" />
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ========== TABS ========== --}}
        <section id="tabs" class="ds-section">
            <div class="ds-section-header">Tabs <span class="tag">Navigation</span></div>

            <div class="ds-label">Primary Tabs (Booking Type)</div>
            <div class="tabs" style="width: fit-content; margin-bottom: 2rem;">
                <button class="tab active">
                    <x-lucide-plane class="w-3.5 h-3.5" />
                    Flights
                </button>
                <button class="tab">
                    <x-lucide-hotel class="w-3.5 h-3.5" />
                    Hotels
                </button>
                <button class="tab">
                    <x-lucide-map-pin class="w-3.5 h-3.5" />
                    Tours
                </button>
                <button class="tab">
                    <x-lucide-car class="w-3.5 h-3.5" />
                    Car Rental
                </button>
            </div>

            <div class="ds-label">Underline Tabs</div>
            <div style="display: flex; border-bottom: 2px solid var(--color-border); width: fit-content; gap: 0;">
                @foreach(['Overview','Amenities','Location','Reviews (248)'] as $i => $t)
                <button style="padding: 0.625rem 1.25rem; font-size: 0.9rem; font-weight: {{ $i === 0 ? '700' : '500' }}; color: {{ $i === 0 ? 'var(--color-brand-600)' : 'var(--color-ink-secondary)' }}; border: none; background: none; cursor: pointer; margin-bottom: -2px; border-bottom: 2px solid {{ $i === 0 ? 'var(--color-brand-600)' : 'transparent' }}; transition: all 0.15s;">{{ $t }}</button>
                @endforeach
            </div>
        </section>

        {{-- ========== NAVIGATION ========== --}}
        <section id="navigation" class="ds-section">
            <div class="ds-section-header">Navigation <span class="tag">Layout</span></div>

            <div class="ds-label">Top Navigation Bar</div>
            <div style="background: var(--color-surface-raised); border: 1.5px solid var(--color-border); border-radius: var(--radius-xl); overflow: hidden; margin-bottom: 2rem;">
                <div style="padding: 0 1.5rem; height: 4rem; display: flex; align-items: center; justify-content: space-between;">
                    {{-- Logo --}}
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 2.25rem; height: 2.25rem; background: linear-gradient(135deg, var(--color-brand-600), var(--color-teal-500)); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                            <x-lucide-plane class="w-4 h-4 text-white" />
                        </div>
                        <span style="font-family: var(--font-display); font-weight: 800; font-size: 1.25rem; color: var(--color-ink);">TripKuy</span>
                    </div>
                    {{-- Links --}}
                    <nav style="display: flex; align-items: center; gap: 0.25rem;">
                        <a href="#" class="nav-link active">Flights</a>
                        <a href="#" class="nav-link">Hotels</a>
                        <a href="#" class="nav-link">Tours</a>
                        <a href="#" class="nav-link">Deals</a>
                        <a href="#" class="nav-link">More</a>
                    </nav>
                    {{-- Actions --}}
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <button class="btn btn-ghost btn-sm">Login</button>
                        <button class="btn btn-primary btn-sm">Register</button>
                    </div>
                </div>
            </div>

            <div class="ds-label">Breadcrumb</div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--color-ink-muted); margin-bottom: 2rem;">
                <a href="#" style="color: var(--color-brand-600); text-decoration: none;">Home</a>
                <x-lucide-chevron-right class="w-3.5 h-3.5" />
                <a href="#" style="color: var(--color-brand-600); text-decoration: none;">Hotels</a>
                <x-lucide-chevron-right class="w-3.5 h-3.5" />
                <a href="#" style="color: var(--color-brand-600); text-decoration: none;">Bali</a>
                <x-lucide-chevron-right class="w-3.5 h-3.5" />
                <span style="color: var(--color-ink);">The Grand Hyatt</span>
            </div>

            <div class="ds-label">Pagination</div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <button class="btn btn-ghost btn-sm btn-icon"><x-lucide-chevron-left class="w-4 h-4" /></button>
                @foreach([1,2,3,'...',8,9] as $p)
                    @if($p === 3)
                    <button class="btn btn-primary btn-sm" style="min-width: 2.25rem;">{{ $p }}</button>
                    @elseif($p === '...')
                    <span style="padding: 0 0.25rem; color: var(--color-ink-muted);">…</span>
                    @else
                    <button class="btn btn-ghost btn-sm" style="min-width: 2.25rem;">{{ $p }}</button>
                    @endif
                @endforeach
                <button class="btn btn-ghost btn-sm btn-icon"><x-lucide-chevron-right class="w-4 h-4" /></button>
            </div>
        </section>

        {{-- ========== DATA DISPLAY ========== --}}
        <section id="data-display" class="ds-section">
            <div class="ds-section-header">Data Display <span class="tag">Information</span></div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

                {{-- Stat card --}}
                @php
                $statCards = [
                    ['building-2', 'var(--color-brand-100)', 'var(--color-brand-600)', '1,200+', 'Partner Hotels'],
                    ['plane',      'var(--color-coral-100)', 'var(--color-coral-600)', '150+',   'Airlines'],
                    ['globe',      'var(--color-teal-100)',  'var(--color-teal-600)',  '50+',    'Destinations'],
                    ['star',       'oklch(97% 0.05 75)',     'var(--color-warning)',   '4.9',    'Avg Rating'],
                ];
                @endphp
                @foreach($statCards as [$iconName, $bg, $color, $val, $label])
                <div class="card-flat" style="padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 3.5rem; height: 3.5rem; background: {{ $bg }}; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: {{ $color }};">
                        @if($iconName === 'building-2')  <x-lucide-building-2 class="w-6 h-6" />
                        @elseif($iconName === 'plane')    <x-lucide-plane class="w-6 h-6" />
                        @elseif($iconName === 'globe')    <x-lucide-globe class="w-6 h-6" />
                        @elseif($iconName === 'star')     <x-lucide-star class="w-6 h-6" />
                        @endif
                    </div>
                    <div>
                        <div style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 800; color: var(--color-ink); line-height: 1.1;">{{ $val }}</div>
                        <div style="font-size: 0.8rem; color: var(--color-ink-muted);">{{ $label }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="ds-label">Alert / Notification</div>
            @php
            $alerts = [
                ['success', 'circle-check', 'Booking berhasil!',  'Tiket kamu akan dikirim ke email dalam 5 menit.'],
                ['warning', 'triangle-alert', 'Kursi hampir habis', 'Hanya tersisa 3 kursi lagi dengan harga ini.'],
                ['danger',  'circle-x',     'Pembayaran gagal',   'Kartu kredit kamu ditolak. Coba metode lain.'],
                ['info',    'info',          'Promo aktif',         'Gunakan kode TRIPKUY untuk diskon 20%.'],
            ];
            @endphp
            <div style="display: flex; flex-direction: column; gap: 0.75rem; max-width: 560px;">
                @foreach($alerts as [$type, $alertIcon, $title, $msg])
                <div style="background: var(--color-{{ $type }}-surface, var(--color-info-surface)); border: 1.5px solid var(--color-{{ $type }}, var(--color-info)); border-radius: var(--radius-lg); padding: 0.875rem 1.125rem; display: flex; gap: 0.75rem; align-items: flex-start;">
                    <span style="color: var(--color-{{ $type }}, var(--color-info)); flex-shrink: 0; margin-top: 0.0625rem;">
                        @if($alertIcon === 'circle-check')    <x-lucide-circle-check class="w-4 h-4" />
                        @elseif($alertIcon === 'triangle-alert') <x-lucide-triangle-alert class="w-4 h-4" />
                        @elseif($alertIcon === 'circle-x')    <x-lucide-circle-x class="w-4 h-4" />
                        @elseif($alertIcon === 'info')         <x-lucide-info class="w-4 h-4" />
                        @endif
                    </span>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--color-{{ $type }}, var(--color-info)); margin-bottom: 0.125rem;">{{ $title }}</div>
                        <div style="font-size: 0.8125rem; color: var(--color-ink-secondary);">{{ $msg }}</div>
                    </div>
                    <button style="background: none; border: none; cursor: pointer; color: var(--color-ink-muted); display: flex;">
                        <x-lucide-x class="w-4 h-4" />
                    </button>
                </div>
                @endforeach
            </div>
        </section>

        {{-- ========== HERO PREVIEW ========== --}}
        <section id="hero-preview" class="ds-section">
            <div class="ds-section-header">Hero Preview <span class="tag">Composition</span></div>

            <div class="hero-preview" style="padding: 3rem 2.5rem 2.5rem;">
                <div style="position: relative; z-index: 1;">
                    <p style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: oklch(80% 0.14 190); margin-bottom: 0.75rem;">Indonesia's #1 Travel Platform</p>
                    <h1 style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; color: white; line-height: 1.15; margin-bottom: 1rem; max-width: 480px;">
                        Jelajahi Dunia<br>Bersama TripKuy
                    </h1>
                    <p style="font-size: 1rem; color: oklch(88% 0.04 230); max-width: 440px; line-height: 1.7; margin-bottom: 2rem;">
                        Temukan ribuan destinasi wisata, hotel terbaik, dan paket tour eksklusif dengan harga terjangkau.
                    </p>

                    {{-- Search Widget --}}
                    <div style="background: white; border-radius: var(--radius-2xl); padding: 1.25rem; box-shadow: var(--shadow-xl); max-width: 660px;">
                        <div class="tabs" style="width: fit-content; margin-bottom: 1.25rem;">
                            <button class="tab active"><x-lucide-plane class="w-3.5 h-3.5" /> Flights</button>
                            <button class="tab"><x-lucide-hotel class="w-3.5 h-3.5" /> Hotels</button>
                            <button class="tab"><x-lucide-map-pin class="w-3.5 h-3.5" /> Tours</button>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 0.75rem; align-items: end;">
                            <div>
                                <div class="ds-label" style="margin-bottom: 0.375rem;">Dari</div>
                                <input class="input input-sm" value="Jakarta (CGK)" style="font-weight: 500;">
                            </div>
                            <div>
                                <div class="ds-label" style="margin-bottom: 0.375rem;">Ke</div>
                                <input class="input input-sm" placeholder="Kota tujuan...">
                            </div>
                            <div>
                                <div class="ds-label" style="margin-bottom: 0.375rem;">Tanggal</div>
                                <input class="input input-sm" type="date">
                            </div>
                            <button class="btn btn-coral btn-md" style="white-space: nowrap;">
                                <x-lucide-search class="w-4 h-4" />
                                Cari
                            </button>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div style="display: flex; gap: 2.5rem; margin-top: 2rem;">
                        @foreach([['1.2Jt+','Traveler Puas'],['50K+','Destinasi'],['4.9★','Rating']] as [$v, $l])
                        <div>
                            <div style="font-family: var(--font-display); font-weight: 800; font-size: 1.25rem; color: white;">{{ $v }}</div>
                            <div style="font-size: 0.8rem; color: oklch(75% 0.06 230);">{{ $l }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

</body>
</html>
