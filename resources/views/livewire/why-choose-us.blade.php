<div>

    {{-- ── Page Title / Breadcrumb ──────────────────────────────────────────── --}}
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Why Choose Us</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Why Choose Us</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- ── Hero Highlight ──────────────────────────────────────────────────── --}}
    @if($highlight)
    <section class="wcu-hero py-5">
        <div class="container">
            <div class="row align-items-center gy-5">

                {{-- Image --}}
                <div class="col-lg-5 text-center order-lg-2" data-aos="fade-left" data-aos-duration="800">
                    <div class="wcu-hero-img-wrap">
                        @if($highlight->file_url)
                            <img src="{{ $highlight->file_url }}" alt="{{ $highlight->title }}" class="img-fluid rounded-4 shadow-lg">
                        @else
                            <img src="{{ asset('website/assets/img/all_doctors.jpeg') }}" alt="Why Choose Us" class="img-fluid rounded-4 shadow-lg">
                        @endif
                        <div class="wcu-hero-badge">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>Excellence<br>in Cancer Care</span>
                        </div>
                    </div>
                </div>

                {{-- Text --}}
                <div class="col-lg-7 order-lg-1" data-aos="fade-right" data-aos-duration="800">
                    <span class="wcu-label">Why Choose Us</span>
                    <h2 class="wcu-hero-title">{{ $highlight->title }}</h2>
                    <p class="wcu-hero-lead text-justify">{{ $highlight->short_description }}</p>
                    @if(!empty($highlight->description))
                        <div class="wcu-hero-body text-justify">{!! nl2br(e($highlight->description)) !!}</div>
                    @endif
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <a href="{{ route('home') }}#appointment" class="btn btn-accent-fill">Book Appointment</a>
                        <a href="{{ route('home') }}" class="btn btn-accent-outline">Back to Home</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- ── Stats strip ─────────────────────────────────────────────────────── --}}
    <section class="wcu-stats">
        <div class="container">
            <div class="row g-0 text-center">
                @foreach([
                    ['value'=>'5000+',  'label'=>'Surgeries Performed', 'icon'=>'bi-scissors'],
                    ['value'=>'98%',    'label'=>'Patient Satisfaction', 'icon'=>'bi-emoji-smile'],
                    ['value'=>'15+',    'label'=>'Expert Specialists',   'icon'=>'bi-people-fill'],
                    ['value'=>'24 / 7', 'label'=>'Emergency Support',    'icon'=>'bi-clock-history'],
                ] as $stat)
                <div class="col-6 col-md-3 wcu-stat-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <i class="bi {{ $stat['icon'] }} wcu-stat-icon"></i>
                    <div class="wcu-stat-value">{{ $stat['value'] }}</div>
                    <div class="wcu-stat-label">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Feature Cards ───────────────────────────────────────────────────── --}}
    @if($items->count())
    <section class="wcu-features py-5">
        <div class="container">

            <div class="text-center mb-5" data-aos="fade-up">
                <span class="wcu-label">Our Strengths</span>
                <h2 class="wcu-section-title">What Sets Us Apart</h2>
                <p class="wcu-section-sub">Hope Centre combines world-class expertise with compassionate, patient-centred care.</p>
            </div>

            <div class="row gy-4">
                @foreach($items as $item)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="wcu-card h-100">
                        <div class="wcu-card-icon-wrap">
                            @if(!empty($item->icon))
                                <i class="{{ $item->icon }}"></i>
                            @else
                                <i class="bi bi-award-fill"></i>
                            @endif
                        </div>
                        <div class="wcu-card-body">
                            <h5 class="wcu-card-title">{{ $item->title }}</h5>
                            <p class="wcu-card-desc text-justify">{{ $item->short_description }}</p>
                            @if(!empty($item->description))
                                <p class="wcu-card-detail text-justify">{!! nl2br(e($item->description)) !!}</p>
                            @endif
                        </div>
                        <div class="wcu-card-footer">
                            <span class="wcu-card-number">0{{ $loop->iteration }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Why Trust Strip ─────────────────────────────────────────────────── --}}
    <section class="wcu-trust py-5 light-background">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="wcu-label">Our Commitment</span>
                    <h3 class="wcu-section-title">Trusted by Thousands of Patients</h3>
                    <p class="text-justify mt-3" style="color:var(--default-color)">
                        At Hope Centre, every patient receives personalised attention from a multidisciplinary team of oncologists, surgeons, and support staff.
                        We use the latest evidence-based protocols and minimally invasive techniques to deliver the safest, most effective outcomes.
                    </p>
                    <ul class="wcu-trust-list mt-3">
                        @foreach(['Dedicated Surgical Oncology Team','State-of-the-art Operation Theatres','Affordable, Transparent Pricing','Compassionate Patient Support','Post-operative Rehabilitation Care'] as $point)
                        <li><i class="bi bi-check-circle-fill"></i> {{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row g-3">
                        @foreach([
                            ['icon'=>'bi-heart-pulse-fill','title'=>'Personalised Care','text'=>'Each treatment plan is tailored to the individual patient\'s medical history and needs.'],
                            ['icon'=>'bi-shield-check','title'=>'Safe & Accredited','text'=>'Our facility meets national and international standards for surgical safety and infection control.'],
                            ['icon'=>'bi-graph-up-arrow','title'=>'Proven Results','text'=>'Consistently high success rates backed by clinical data and patient follow-up records.'],
                            ['icon'=>'bi-chat-dots-fill','title'=>'Clear Communication','text'=>'We ensure patients and families fully understand every step of the care journey.'],
                        ] as $trust)
                        <div class="col-6">
                            <div class="wcu-trust-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                                <i class="bi {{ $trust['icon'] }}"></i>
                                <h6>{{ $trust['title'] }}</h6>
                                <p class="text-justify">{{ $trust['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA Banner ──────────────────────────────────────────────────────── --}}
    <section class="wcu-cta py-5">
        <div class="container text-center" data-aos="zoom-in">
            <h3 class="wcu-cta-title">Ready to Begin Your Healing Journey?</h3>
            <p class="wcu-cta-sub">
                Our specialists are available to answer your questions and guide you toward the best care options.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                <a href="{{ route('home') }}#appointment" class="btn btn-cta-white">
                    <i class="bi bi-calendar2-check me-1"></i> Book an Appointment
                </a>
                <a href="{{ route('home') }}" class="btn btn-cta-outline">
                    <i class="bi bi-house me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </section>

    {{-- ── Page-scoped styles ──────────────────────────────────────────────── --}}
    <style>
        /* ── Utility ─────────────────────────────────────────────── */
        .text-justify { text-align: justify; }

        /* ── Label pill ──────────────────────────────────────────── */
        .wcu-label {
            display: inline-block;
            background: color-mix(in srgb, var(--accent-color), transparent 85%);
            color: var(--accent-color);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .25rem .85rem;
            border-radius: 50px;
            margin-bottom: .75rem;
        }

        /* ── Hero ────────────────────────────────────────────────── */
        .wcu-hero { background: var(--background-color); }

        .wcu-hero-img-wrap { position: relative; display: inline-block; }
        .wcu-hero-img-wrap img { max-height: 420px; object-fit: cover; width: 100%; }

        .wcu-hero-badge {
            position: absolute;
            bottom: -18px;
            left: 30px;
            background: var(--accent-color);
            color: #fff;
            border-radius: 14px;
            padding: .65rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .82rem;
            font-weight: 600;
            box-shadow: 0 6px 20px color-mix(in srgb, var(--accent-color), transparent 50%);
        }
        .wcu-hero-badge i { font-size: 1.4rem; }

        .wcu-hero-title {
            font-family: var(--heading-font);
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 700;
            color: var(--heading-color);
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        .wcu-hero-lead {
            font-size: 1.05rem;
            color: var(--default-color);
            line-height: 1.8;
        }
        .wcu-hero-body {
            color: color-mix(in srgb, var(--default-color), transparent 15%);
            line-height: 1.85;
            margin-top: .5rem;
        }

        /* ── Buttons ─────────────────────────────────────────────── */
        .btn-accent-fill {
            background: var(--accent-color);
            color: #fff;
            border: 2px solid var(--accent-color);
            border-radius: 50px;
            padding: .55rem 1.6rem;
            font-weight: 600;
            transition: .3s;
        }
        .btn-accent-fill:hover { background: color-mix(in srgb, var(--accent-color), #000 15%); color: #fff; }

        .btn-accent-outline {
            background: transparent;
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
            border-radius: 50px;
            padding: .55rem 1.6rem;
            font-weight: 600;
            transition: .3s;
        }
        .btn-accent-outline:hover { background: var(--accent-color); color: #fff; }

        /* ── Stats strip ─────────────────────────────────────────── */
        .wcu-stats {
            background: var(--heading-color);
            padding: 2.5rem 0;
        }
        .wcu-stat-item { padding: 1.5rem 1rem; border-right: 1px solid rgba(255,255,255,.12); }
        .wcu-stat-item:last-child { border-right: none; }
        .wcu-stat-icon { font-size: 2rem; color: var(--accent-color); display: block; margin-bottom: .4rem; }
        .wcu-stat-value { font-size: 2rem; font-weight: 800; color: #fff; line-height: 1; }
        .wcu-stat-label { font-size: .8rem; color: rgba(255,255,255,.65); margin-top: .3rem; text-transform: uppercase; letter-spacing: .06em; }

        /* ── Feature cards ───────────────────────────────────────── */
        .wcu-features { background: #f8f9fc; }

        .wcu-section-title {
            font-family: var(--heading-font);
            font-size: clamp(1.4rem, 2.5vw, 2rem);
            font-weight: 700;
            color: var(--heading-color);
        }
        .wcu-section-sub { color: color-mix(in srgb, var(--default-color), transparent 25%); max-width: 600px; margin: .5rem auto 0; }

        .wcu-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            padding: 2rem 1.6rem 1.4rem;
            transition: transform .3s, box-shadow .3s;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .wcu-card:hover { transform: translateY(-6px); box-shadow: 0 12px 36px rgba(0,0,0,.12); }
        .wcu-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: var(--accent-color);
            border-radius: 18px 18px 0 0;
        }

        .wcu-card-icon-wrap {
            width: 64px; height: 64px;
            background: color-mix(in srgb, var(--accent-color), transparent 88%);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.2rem;
        }
        .wcu-card-icon-wrap i { font-size: 1.75rem; color: var(--accent-color); }

        .wcu-card-body { flex: 1; }
        .wcu-card-title { font-weight: 700; color: var(--heading-color); margin-bottom: .5rem; font-size: 1rem; }
        .wcu-card-desc { font-size: .9rem; color: var(--default-color); line-height: 1.75; margin-bottom: .4rem; }
        .wcu-card-detail { font-size: .82rem; color: color-mix(in srgb, var(--default-color), transparent 20%); line-height: 1.75; }

        .wcu-card-footer { margin-top: 1rem; }
        .wcu-card-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: color-mix(in srgb, var(--accent-color), transparent 80%);
            line-height: 1;
        }

        /* ── Trust section ───────────────────────────────────────── */
        .wcu-trust-list { list-style: none; padding: 0; }
        .wcu-trust-list li { display: flex; align-items: flex-start; gap: .55rem; margin-bottom: .55rem; color: var(--default-color); font-size: .95rem; }
        .wcu-trust-list li i { color: var(--accent-color); flex-shrink: 0; margin-top: .2rem; }

        .wcu-trust-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.3rem;
            box-shadow: 0 3px 16px rgba(0,0,0,.07);
            height: 100%;
            transition: transform .3s;
        }
        .wcu-trust-card:hover { transform: translateY(-4px); }
        .wcu-trust-card i { font-size: 1.6rem; color: var(--accent-color); display: block; margin-bottom: .6rem; }
        .wcu-trust-card h6 { font-weight: 700; color: var(--heading-color); margin-bottom: .4rem; font-size: .95rem; }
        .wcu-trust-card p { font-size: .82rem; color: var(--default-color); line-height: 1.7; margin: 0; }

        /* ── CTA banner ──────────────────────────────────────────── */
        .wcu-cta {
            background: linear-gradient(135deg, var(--heading-color) 0%, color-mix(in srgb, var(--heading-color), var(--accent-color) 40%) 100%);
        }
        .wcu-cta-title { font-family: var(--heading-font); font-size: clamp(1.4rem,2.5vw,2rem); font-weight: 800; color: #fff; margin-bottom: .5rem; }
        .wcu-cta-sub { color: rgba(255,255,255,.75); max-width: 560px; margin: 0 auto; font-size: .97rem; }

        .btn-cta-white {
            background: #fff;
            color: var(--heading-color);
            border: 2px solid #fff;
            border-radius: 50px;
            padding: .6rem 1.8rem;
            font-weight: 700;
            transition: .3s;
        }
        .btn-cta-white:hover { background: transparent; color: #fff; }

        .btn-cta-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,.6);
            border-radius: 50px;
            padding: .6rem 1.8rem;
            font-weight: 600;
            transition: .3s;
        }
        .btn-cta-outline:hover { background: rgba(255,255,255,.15); border-color: #fff; }
    </style>

</div>
