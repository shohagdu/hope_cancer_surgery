<div>

    {{-- ── Breadcrumb ───────────────────────────────────────────────────────── --}}
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $service->title }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#services">{{ $typeLabel }}</a></li>
                    <li class="current">{{ $service->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- ── Hero ─────────────────────────────────────────────────────────────── --}}
    <section class="sd-hero py-5">
        <div class="container">
            <div class="row align-items-center gy-5">

                <div class="col-lg-5 text-center order-lg-2" data-aos="fade-left">
                    <div class="sd-img-wrap">
                        @if($service->file_url)
                            <img src="{{ $service->file_url }}" alt="{{ $service->title }}" class="img-fluid rounded-4 shadow-lg">
                        @else
                            <div class="sd-icon-placeholder rounded-4 shadow-lg d-flex flex-column align-items-center justify-content-center">
                                <i class="{{ !empty($service->icon) ? $service->icon : 'fa-solid fa-user-doctor' }}"></i>
                                <span>{{ $service->title }}</span>
                            </div>
                        @endif
                        <div class="sd-hero-badge">
                            <i class="bi bi-patch-check-fill"></i>
                            <span>{{ $typeLabel }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 order-lg-1" data-aos="fade-right">
                    <span class="sd-label">{{ $typeLabel }}</span>
                    <h2 class="sd-hero-title">{{ $service->title }}</h2>
                    @if(!empty($service->short_description))
                        <p class="sd-hero-lead text-justify">{{ $service->short_description }}</p>
                    @endif
                    @if(!empty($service->description))
                        <div class="sd-hero-body text-justify mt-3">{!! nl2br(e($service->description)) !!}</div>
                    @endif
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <a href="{{ route('home') }}#appointment" class="btn sd-btn-fill">
                            <i class="bi bi-calendar2-check me-1"></i> Book Appointment
                        </a>
                        <a href="{{ route('home') }}#services" class="btn sd-btn-outline">
                            <i class="bi bi-arrow-left me-1"></i> All Services
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Approach cards ───────────────────────────────────────────────────── --}}
    @php
        $infoCards = match((int)$service->type) {
            3 => [
                ['icon'=>'bi-search-heart',    'title'=>'Diagnosis',           'text'=>'Early and accurate diagnosis using advanced imaging, biopsy, and pathology services.'],
                ['icon'=>'bi-scissors',         'title'=>'Surgical Treatment',  'text'=>'Minimally invasive and open surgical options performed by our expert oncology team.'],
                ['icon'=>'bi-capsule',          'title'=>'Medical Oncology',    'text'=>'Chemotherapy, targeted therapy, and hormone therapy tailored to each patient.'],
                ['icon'=>'bi-activity',         'title'=>'Monitoring',          'text'=>'Regular follow-up, surveillance, and survivorship care after treatment.'],
                ['icon'=>'bi-people-fill',      'title'=>'Multidisciplinary',   'text'=>'Tumour board review involving surgeons, oncologists, radiologists, and pathologists.'],
                ['icon'=>'bi-heart-pulse-fill', 'title'=>'Supportive Care',     'text'=>'Nutritional support, pain management, and psychological counselling throughout.'],
            ],
            4 => [
                ['icon'=>'bi-lightning-charge-fill','title'=>'Rapid Response',    'text'=>'Immediate assessment and intervention available around the clock.'],
                ['icon'=>'bi-tools',                'title'=>'Minimally Invasive','text'=>'Advanced endoscopic and laparoscopic techniques to reduce recovery time.'],
                ['icon'=>'bi-shield-plus',          'title'=>'Safe Procedures',   'text'=>'Performed under strict sterile conditions with experienced specialists.'],
                ['icon'=>'bi-clipboard2-pulse',     'title'=>'Post-procedure Care','text'=>'Dedicated nursing and follow-up to ensure smooth recovery.'],
            ],
            default => [],
        };
    @endphp

    @if(count($infoCards))
    <section class="py-5 light-background">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="sd-label">Our Approach</span>
                <h3 class="sd-section-title">How We Treat {{ Str::limit($service->title, 40) }}</h3>
            </div>
            <div class="row gy-4">
                @foreach($infoCards as $card)
                <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                    <div class="sd-info-card h-100">
                        <div class="sd-info-icon"><i class="bi {{ $card['icon'] }}"></i></div>
                        <h6 class="sd-info-title">{{ $card['title'] }}</h6>
                        <p class="sd-info-text text-justify">{{ $card['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Why Hope Centre ──────────────────────────────────────────────────── --}}
    <section class="sd-why py-5">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="sd-label">Why Hope Centre</span>
                    <h3 class="sd-section-title">Expert Care You Can Trust</h3>
                    <p class="text-justify mt-3" style="color:var(--default-color);line-height:1.85">
                        Our team of specialist surgeons and oncologists brings together decades of experience
                        in managing complex cancer and emergency cases. Every patient receives a personalised
                        care plan designed for the best possible outcome.
                    </p>
                    <ul class="sd-check-list mt-3">
                        @foreach(['Dedicated Surgical Oncology Team','State-of-the-art Facilities','Affordable & Transparent Pricing','Compassionate Patient Support','24/7 Emergency Availability'] as $pt)
                        <li><i class="bi bi-check-circle-fill"></i> {{ $pt }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row g-3">
                        @foreach([['num'=>'5000+','label'=>'Procedures Done'],['num'=>'98%','label'=>'Success Rate'],['num'=>'15+','label'=>'Specialists'],['num'=>'24/7','label'=>'Emergency Support']] as $st)
                        <div class="col-6">
                            <div class="sd-stat-box text-center" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 80 }}">
                                <div class="sd-stat-num">{{ $st['num'] }}</div>
                                <div class="sd-stat-lbl">{{ $st['label'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Related Services ─────────────────────────────────────────────────── --}}
    @if($relatedItems->count())
    <section class="py-5 light-background">
        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <span class="sd-label">Related</span>
                <h3 class="sd-section-title">Other {{ $typeLabel }} Services</h3>
            </div>
            <div class="row gy-3">
                @foreach($relatedItems as $rel)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                    <a href="{{ route('service.details', ['id'=>$rel->id,'slug'=>\Illuminate\Support\Str::slug($rel->title)]) }}"
                       class="sd-related-card text-decoration-none d-flex align-items-center gap-3">
                        <div class="sd-related-icon">
                            <i class="{{ !empty($rel->icon) ? $rel->icon : 'fa-solid fa-user-doctor' }}"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="sd-related-title">{{ $rel->title }}</div>
                            @if(!empty($rel->short_description))
                                <div class="sd-related-sub">{{ Str::limit($rel->short_description, 60) }}</div>
                            @endif
                        </div>
                        <i class="bi bi-chevron-right sd-related-arrow flex-shrink-0"></i>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── CTA ─────────────────────────────────────────────────────────────── --}}
    <section class="sd-cta py-5">
        <div class="container text-center" data-aos="zoom-in">
            <h3 class="sd-cta-title">Need Help with {{ $service->title }}?</h3>
            <p class="sd-cta-sub">Speak with one of our specialists today and take the first step toward recovery.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                <a href="{{ route('home') }}#appointment" class="btn sd-cta-btn-white">
                    <i class="bi bi-calendar2-check me-1"></i> Book Appointment
                </a>
                <a href="{{ route('home') }}" class="btn sd-cta-btn-outline">
                    <i class="bi bi-house me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </section>

    <style>
        .text-justify{text-align:justify}
        .sd-label{display:inline-block;background:color-mix(in srgb,var(--accent-color),transparent 85%);color:var(--accent-color);font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.25rem .85rem;border-radius:50px;margin-bottom:.75rem}
        .sd-hero{background:var(--background-color)}
        .sd-img-wrap{position:relative;display:inline-block;width:100%}
        .sd-img-wrap img{max-height:420px;object-fit:cover;width:100%}
        .sd-icon-placeholder{background:color-mix(in srgb,var(--accent-color),transparent 88%);min-height:340px;width:100%;gap:1rem}
        .sd-icon-placeholder i{font-size:5rem;color:var(--accent-color)}
        .sd-icon-placeholder span{font-size:1.1rem;font-weight:600;color:var(--heading-color);text-align:center;padding:0 1rem}
        .sd-hero-badge{position:absolute;bottom:-18px;left:30px;background:var(--accent-color);color:#fff;border-radius:14px;padding:.6rem 1.1rem;display:flex;align-items:center;gap:.5rem;font-size:.82rem;font-weight:600;box-shadow:0 6px 20px color-mix(in srgb,var(--accent-color),transparent 50%)}
        .sd-hero-badge i{font-size:1.3rem}
        .sd-hero-title{font-family:var(--heading-font);font-size:clamp(1.6rem,3vw,2.4rem);font-weight:700;color:var(--heading-color);line-height:1.3;margin-bottom:1rem}
        .sd-hero-lead{font-size:1.05rem;color:var(--default-color);line-height:1.85}
        .sd-hero-body{color:color-mix(in srgb,var(--default-color),transparent 10%);line-height:1.9}
        .sd-btn-fill{background:var(--accent-color);color:#fff;border:2px solid var(--accent-color);border-radius:50px;padding:.55rem 1.6rem;font-weight:600;transition:.3s}
        .sd-btn-fill:hover{background:color-mix(in srgb,var(--accent-color),#000 15%);color:#fff}
        .sd-btn-outline{background:transparent;color:var(--accent-color);border:2px solid var(--accent-color);border-radius:50px;padding:.55rem 1.6rem;font-weight:600;transition:.3s}
        .sd-btn-outline:hover{background:var(--accent-color);color:#fff}
        .sd-section-title{font-family:var(--heading-font);font-size:clamp(1.3rem,2.5vw,1.9rem);font-weight:700;color:var(--heading-color);margin-top:.3rem}
        .sd-info-card{background:#fff;border-radius:18px;box-shadow:0 4px 20px rgba(0,0,0,.07);padding:1.8rem 1.5rem;transition:transform .3s,box-shadow .3s;position:relative;overflow:hidden}
        .sd-info-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:var(--accent-color);border-radius:18px 18px 0 0}
        .sd-info-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(0,0,0,.11)}
        .sd-info-icon{width:56px;height:56px;background:color-mix(in srgb,var(--accent-color),transparent 88%);border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem}
        .sd-info-icon i{font-size:1.6rem;color:var(--accent-color)}
        .sd-info-title{font-weight:700;color:var(--heading-color);margin-bottom:.4rem}
        .sd-info-text{font-size:.9rem;color:var(--default-color);line-height:1.78;margin:0}
        .sd-check-list{list-style:none;padding:0}
        .sd-check-list li{display:flex;align-items:flex-start;gap:.5rem;margin-bottom:.5rem;color:var(--default-color);font-size:.95rem}
        .sd-check-list li i{color:var(--accent-color);flex-shrink:0;margin-top:.2rem}
        .sd-stat-box{background:#fff;border-radius:16px;box-shadow:0 3px 16px rgba(0,0,0,.07);padding:1.4rem 1rem;transition:transform .3s}
        .sd-stat-box:hover{transform:translateY(-4px)}
        .sd-stat-num{font-size:2rem;font-weight:800;color:var(--accent-color);line-height:1}
        .sd-stat-lbl{font-size:.78rem;color:var(--default-color);text-transform:uppercase;letter-spacing:.06em;margin-top:.3rem}
        .sd-related-card{background:#fff;border-radius:14px;padding:1rem 1.2rem;box-shadow:0 3px 14px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s;color:var(--default-color)}
        .sd-related-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.1)}
        .sd-related-icon{width:46px;height:46px;flex-shrink:0;background:color-mix(in srgb,var(--accent-color),transparent 88%);border-radius:12px;display:flex;align-items:center;justify-content:center}
        .sd-related-icon i{color:var(--accent-color);font-size:1.2rem}
        .sd-related-title{font-weight:600;color:var(--heading-color);font-size:.95rem}
        .sd-related-sub{font-size:.78rem;color:color-mix(in srgb,var(--default-color),transparent 20%);margin-top:.15rem}
        .sd-related-arrow{color:var(--accent-color);font-size:.9rem}
        .sd-cta{background:linear-gradient(135deg,var(--heading-color) 0%,color-mix(in srgb,var(--heading-color),var(--accent-color) 40%) 100%)}
        .sd-cta-title{font-family:var(--heading-font);font-size:clamp(1.4rem,2.5vw,2rem);font-weight:800;color:#fff;margin-bottom:.5rem}
        .sd-cta-sub{color:rgba(255,255,255,.75);max-width:540px;margin:0 auto;font-size:.97rem}
        .sd-cta-btn-white{background:#fff;color:var(--heading-color);border:2px solid #fff;border-radius:50px;padding:.6rem 1.8rem;font-weight:700;transition:.3s}
        .sd-cta-btn-white:hover{background:transparent;color:#fff}
        .sd-cta-btn-outline{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.6);border-radius:50px;padding:.6rem 1.8rem;font-weight:600;transition:.3s}
        .sd-cta-btn-outline:hover{background:rgba(255,255,255,.15);border-color:#fff}
    </style>

</div>
