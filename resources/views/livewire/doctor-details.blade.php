<div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         HERO — full-width banner with doctor photo
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section class="dd-hero">
        <div class="dd-hero-bg"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-end gy-4">

                {{-- Photo --}}
                <div class="col-lg-3 col-md-4 text-center" data-aos="fade-right">
                    @php
                        $imgPath = $doctor->picture && file_exists(storage_path('app/public/'.$doctor->picture))
                            ? asset('storage/'.$doctor->picture)
                            : asset('website/assets/img/doctors/doctors-1.jpg');
                    @endphp
                    <div class="dd-hero-photo-wrap">
                        <img src="{{ $imgPath }}" alt="{{ $doctor->name }}">
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-lg-9 col-md-8 pb-4" data-aos="fade-left">
                    <span class="dd-hero-tag">Surgical Oncologist</span>
                    <h1 class="dd-hero-name">{{ $doctor->name }}</h1>
                    <p class="dd-hero-qual">{{ $doctor->qualifications }}</p>

                    @if(!empty($doctor->special_training))
                        <p class="dd-hero-training">
                            <i class="bi bi-mortarboard-fill me-1"></i>{{ $doctor->special_training }}
                        </p>
                    @endif

                    @php $positions = array_filter(array_map('trim', explode("\n", $doctor->positions ?? ''))); @endphp
                    @if(!empty($positions))
                        <div class="dd-hero-positions">
                            @foreach($positions as $pos)
                                <span class="dd-position-badge"><i class="bi bi-briefcase-fill me-1"></i>{{ $pos }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="dd-hero-actions mt-3">
                        <a href="{{ route('home') }}#appointment" class="dd-btn-primary">
                            <i class="bi bi-calendar2-check me-1"></i> Book Appointment
                        </a>
                        @if(!empty($doctor->mobile))
                            <a href="tel:{{ $doctor->mobile }}" class="dd-btn-ghost">
                                <i class="bi bi-telephone-fill me-1"></i> {{ $doctor->mobile }}
                            </a>
                        @endif
                    </div>

                    {{-- Social Media Links --}}
                    @php
                        $socials = [
                            'facebook'  => ['icon' => 'bi-facebook',  'label' => 'Facebook',  'color' => '#1877F2'],
                            'youtube'   => ['icon' => 'bi-youtube',   'label' => 'YouTube',   'color' => '#FF0000'],
                            'linkedin'  => ['icon' => 'bi-linkedin',  'label' => 'LinkedIn',  'color' => '#0A66C2'],
                            'instagram' => ['icon' => 'bi-instagram', 'label' => 'Instagram', 'color' => '#E4405F'],
                            'tiktok'    => ['icon' => 'bi-tiktok',    'label' => 'TikTok',    'color' => '#010101'],
                        ];
                        $hasSocials = collect($socials)->keys()->filter(fn($f) => !empty($doctor->$f))->isNotEmpty();
                    @endphp
                    @if($hasSocials)
                        <div class="dd-hero-socials mt-3">
                            <span class="dd-social-label">Follow</span>
                            @foreach($socials as $field => $info)
                                @if(!empty($doctor->$field))
                                    <a href="{{ $doctor->$field }}" target="_blank" rel="noopener"
                                       class="dd-social-pill"
                                       style="--sc:#{{ ltrim(substr($info['color'],1), '#') }}{{ strlen($info['color']) === 7 ? '' : '' }}; --sc:{{ $info['color'] }}">
                                        <i class="bi {{ $info['icon'] }}"></i>
                                        <span>{{ $info['label'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         STICKY NAV
         ═══════════════════════════════════════════════════════════════════════ --}}
    <nav class="dd-sticky-nav">
        <div class="container">
            <ul>
                <li><a href="#dd-about">About</a></li>
                <li><a href="#dd-expertise">Expertise</a></li>
                <li><a href="#dd-chambers">Chambers</a></li>
                <li><a href="#dd-contact">Contact</a></li>
            </ul>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════════════════════════════
         STATS STRIP
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section class="dd-stats">
        <div class="container">
            <div class="row g-0 text-center">
                @foreach([
                    ['icon'=>'bi-award-fill',      'val'=>'15+',   'lbl'=>'Years Experience'],
                    ['icon'=>'bi-file-earmark-text','val'=>'15+',   'lbl'=>'Publications'],
                    ['icon'=>'bi-people-fill',      'val'=>'5000+', 'lbl'=>'Patients Treated'],
                    ['icon'=>'bi-heart-pulse-fill', 'val'=>'98%',   'lbl'=>'Success Rate'],
                ] as $s)
                <div class="col-6 col-md-3 dd-stat-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                    <i class="bi {{ $s['icon'] }} dd-stat-icon"></i>
                    <div class="dd-stat-val">{{ $s['val'] }}</div>
                    <div class="dd-stat-lbl">{{ $s['lbl'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         ABOUT / PROFILE
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section id="dd-about" class="dd-about py-5">
        <div class="container">
            <div class="row align-items-start gy-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <span class="dd-label">Biography</span>
                    <h2 class="dd-section-title">About Dr. {{ explode(' ', $doctor->name, 2)[1] ?? $doctor->name }}</h2>
                    @if(!empty($doctor->doctor_profile))
                        <div class="dd-profile-text">
                            {!! $doctor->doctor_profile !!}
                        </div>
                    @endif
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="dd-credentials-box">
                        <h5 class="dd-cred-title"><i class="bi bi-patch-check-fill me-2"></i>Credentials</h5>
                        <ul class="dd-cred-list">
                            @if(!empty($doctor->qualifications))
                                @foreach(explode(',', $doctor->qualifications) as $q)
                                    <li><i class="bi bi-check-circle-fill"></i>{{ trim($q) }}</li>
                                @endforeach
                            @endif
                            @if(!empty($doctor->special_training))
                                <li><i class="bi bi-mortarboard-fill"></i>{{ $doctor->special_training }}</li>
                            @endif
                        </ul>
                        @if(!empty($positions))
                            <h5 class="dd-cred-title mt-4"><i class="bi bi-briefcase-fill me-2"></i>Current Positions</h5>
                            <ul class="dd-cred-list">
                                @foreach($positions as $pos)
                                    <li><i class="bi bi-building-fill"></i>{{ $pos }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         AREAS OF EXPERTISE
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section id="dd-expertise" class="dd-expertise py-5 light-background">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="dd-label">Specialisation</span>
                <h2 class="dd-section-title">Areas of Expertise</h2>
                <p class="dd-section-sub">Comprehensive surgical oncology care across a wide range of cancer types.</p>
            </div>
            <div class="row gy-3 justify-content-center">
                @php
                    $expertiseItems = [
                        ['icon'=>'fa-solid fa-ribbon',         'name'=>'Breast Cancer'],
                        ['icon'=>'fa-solid fa-stomach',        'name'=>'Stomach Cancer'],
                        ['icon'=>'fa-solid fa-colon',          'name'=>'Colo-rectal Cancer'],
                        ['icon'=>'fa-solid fa-bone',           'name'=>'Sarcoma'],
                        ['icon'=>'fa-solid fa-liver',          'name'=>'Hepatobiliary Cancer'],
                        ['icon'=>'fa-solid fa-user-injured',   'name'=>'Skin Cancer'],
                        ['icon'=>'fa-solid fa-circle-nodes',   'name'=>'Testicular Cancer'],
                        ['icon'=>'fa-solid fa-lungs',          'name'=>'Esophageal Cancer'],
                        ['icon'=>'fa-solid fa-flask-vial',     'name'=>'Pancreas Cancer'],
                        ['icon'=>'fa-solid fa-microscope',     'name'=>'Thyroid Cancer'],
                        ['icon'=>'fa-solid fa-venus',          'name'=>'Ovarian Cancer'],
                        ['icon'=>'fa-solid fa-mars',           'name'=>'Prostate Cancer'],
                    ];
                @endphp
                @foreach($expertiseItems as $exp)
                <div class="col-lg-2 col-md-3 col-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="dd-exp-card text-center">
                        <div class="dd-exp-icon">
                            <i class="{{ $exp['icon'] }}"></i>
                        </div>
                        <div class="dd-exp-name">{{ $exp['name'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         CHAMBERS
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section id="dd-chambers" class="dd-chambers py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="dd-label">Visit Us</span>
                <h2 class="dd-section-title">Chambers & Consultation</h2>
            </div>
            @php
                $chambers = [
                    [
                        'icon'  => 'bi-hospital-fill',
                        'title' => 'Main Chamber',
                        'place' => 'Health and Hospital, Green Road, Panthapath, Dhaka',
                        'days'  => 'Saturday – Thursday',
                        'hours' => '6:00 PM – 9:00 PM',
                        'badge' => 'Primary',
                    ],
                ];
                if ($doctor->id === 1) {
                    $chambers[] = [
                        'icon'  => 'bi-building-fill',
                        'title' => 'Weekly Chamber',
                        'place' => 'Nova Hospital, Jashore',
                        'days'  => 'Every Friday',
                        'hours' => 'Morning Session',
                        'badge' => 'Friday Only',
                    ];
                }
            @endphp
            <div class="row gy-4 justify-content-center">
                @foreach($chambers as $idx => $ch)
                <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-delay="{{ $idx * 120 }}">
                    <div class="dd-chamber-card">
                        <div class="dd-chamber-icon">
                            <i class="bi {{ $ch['icon'] }}"></i>
                        </div>
                        <div class="dd-chamber-body">
                            <span class="dd-chamber-badge">{{ $ch['badge'] }}</span>
                            <h5 class="dd-chamber-title">{{ $ch['title'] }}</h5>
                            <p class="dd-chamber-place"><i class="bi bi-geo-alt-fill me-1"></i>{{ $ch['place'] }}</p>
                            <div class="dd-chamber-meta">
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $ch['days'] }}</span>
                                <span><i class="bi bi-clock me-1"></i>{{ $ch['hours'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         CONTACT / CTA
         ═══════════════════════════════════════════════════════════════════════ --}}
    <section id="dd-contact" class="dd-cta py-5">
        <div class="container">
            <div class="dd-cta-inner" data-aos="zoom-in">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-7">
                        <span class="dd-label" style="background:rgba(255,255,255,.15);color:#fff">Get in Touch</span>
                        <h2 class="dd-cta-title">Ready for a Consultation?</h2>
                        <p class="dd-cta-sub">
                            Take the first step toward expert cancer care. Book an appointment with
                            {{ $doctor->name }} today.
                        </p>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-lg-end">
                            <a href="{{ route('home') }}#appointment" class="dd-cta-btn-white">
                                <i class="bi bi-calendar2-check me-1"></i> Book Appointment
                            </a>
                            @if(!empty($doctor->mobile))
                                <a href="tel:{{ $doctor->mobile }}" class="dd-cta-btn-outline">
                                    <i class="bi bi-telephone-fill me-1"></i> Call Now
                                </a>
                            @endif
                        </div>
                        {{-- Social --}}
                        <div class="dd-cta-socials mt-3">
                            @foreach(['facebook'=>'bi-facebook','youtube'=>'bi-youtube','linkedin'=>'bi-linkedin','instagram'=>'bi-instagram','tiktok'=>'bi-tiktok'] as $field => $icon)
                                @if(!empty($doctor->$field))
                                    <a href="{{ $doctor->$field }}" target="_blank" rel="noopener"><i class="bi {{ $icon }}"></i></a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════
         BACK TO HOME
         ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="py-3 light-background text-center">
        <a href="{{ route('home') }}#doctors" class="dd-back-link">
            <i class="bi bi-arrow-left me-1"></i> Back to All Doctors
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         STYLES
         ═══════════════════════════════════════════════════════════════════════ --}}
    <style>
        /* ── Hero ──────────────────────────────────────────────────── */
        .dd-hero {
            position: relative;
            background: linear-gradient(135deg, var(--heading-color) 0%, color-mix(in srgb,var(--heading-color),var(--accent-color) 45%) 100%);
            padding: 5rem 0 0;
            overflow: hidden;
        }
        .dd-hero-bg {
            position: absolute; inset: 0;
            background-image: radial-gradient(circle at 70% 50%, color-mix(in srgb,var(--accent-color),transparent 70%) 0%, transparent 55%);
        }
        .dd-hero-photo-wrap {
            display: inline-block;
            border-radius: 20px 20px 0 0;
            overflow: hidden;
            width: 220px;
            box-shadow: 0 -6px 40px rgba(0,0,0,.35);
            border: 4px solid rgba(255,255,255,.2);
        }
        .dd-hero-photo-wrap img { width: 100%; height: 280px; object-fit: cover; object-position: top; display: block; }

        .dd-hero-tag {
            display: inline-block;
            background: var(--accent-color);
            color: #fff; font-size: .72rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            padding: .22rem .8rem; border-radius: 50px; margin-bottom: .7rem;
        }
        .dd-hero-name { font-family: var(--heading-font); font-size: clamp(1.8rem,4vw,3rem); font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: .4rem; }
        .dd-hero-qual { font-size: .95rem; color: rgba(255,255,255,.8); margin-bottom: .5rem; }
        .dd-hero-training { font-size: .85rem; color: rgba(255,255,255,.7); margin-bottom: .8rem; }
        .dd-hero-positions { display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: .8rem; }
        .dd-position-badge {
            background: rgba(255,255,255,.12); color: rgba(255,255,255,.9);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 50px; padding: .22rem .9rem; font-size: .78rem;
        }
        .dd-hero-actions { display: flex; flex-wrap: wrap; gap: .75rem; }
        .dd-btn-primary { background: var(--accent-color); color: #fff; border-radius: 50px; padding: .55rem 1.6rem; font-weight: 700; font-size: .9rem; text-decoration: none; transition: .3s; display: inline-flex; align-items: center; }
        .dd-btn-primary:hover { background: color-mix(in srgb,var(--accent-color),#fff 15%); color: #fff; }
        .dd-btn-ghost { background: rgba(255,255,255,.12); color: #fff; border: 1.5px solid rgba(255,255,255,.4); border-radius: 50px; padding: .55rem 1.4rem; font-weight: 600; font-size: .9rem; text-decoration: none; transition: .3s; display: inline-flex; align-items: center; }
        .dd-btn-ghost:hover { background: rgba(255,255,255,.22); color: #fff; }

        /* ── Hero Social Pills ──────────────────────────────────────── */
        .dd-hero-socials { display: flex; align-items: center; flex-wrap: wrap; gap: .5rem; }
        .dd-social-label { font-size: .7rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.55); margin-right: .25rem; }
        .dd-social-pill {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(255,255,255,.12);
            border: 1.5px solid rgba(255,255,255,.22);
            color: #fff;
            border-radius: 50px;
            padding: .32rem .9rem .32rem .7rem;
            font-size: .8rem; font-weight: 600;
            text-decoration: none;
            transition: background .25s, border-color .25s, transform .2s, box-shadow .25s;
            backdrop-filter: blur(4px);
        }
        .dd-social-pill i { font-size: 1rem; color: var(--sc); transition: transform .25s; }
        .dd-social-pill:hover {
            background: var(--sc);
            border-color: var(--sc);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,.28);
        }
        .dd-social-pill:hover i { color: #fff; transform: scale(1.15); }

        /* ── Sticky nav ────────────────────────────────────────────── */
        .dd-sticky-nav {
            background: #fff;
            border-bottom: 1px solid #eee;
            position: sticky; top: 0; z-index: 99;
            box-shadow: 0 2px 12px rgba(0,0,0,.07);
        }
        .dd-sticky-nav ul { display: flex; list-style: none; margin: 0; padding: 0; gap: .25rem; overflow-x: auto; }
        .dd-sticky-nav ul li a {
            display: block; padding: .75rem 1.2rem; font-size: .88rem; font-weight: 600;
            color: var(--default-color); text-decoration: none; white-space: nowrap;
            border-bottom: 3px solid transparent; transition: .2s;
        }
        .dd-sticky-nav ul li a:hover { color: var(--accent-color); border-bottom-color: var(--accent-color); }

        /* ── Stats ─────────────────────────────────────────────────── */
        .dd-stats { background: var(--heading-color); padding: 2.2rem 0; }
        .dd-stat-item { padding: 1.3rem .5rem; border-right: 1px solid rgba(255,255,255,.1); }
        .dd-stat-item:last-child { border-right: none; }
        .dd-stat-icon { font-size: 1.8rem; color: var(--accent-color); display: block; margin-bottom: .3rem; }
        .dd-stat-val { font-size: 1.9rem; font-weight: 800; color: #fff; line-height: 1; }
        .dd-stat-lbl { font-size: .75rem; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: .06em; margin-top: .25rem; }

        /* ── Label / section titles ────────────────────────────────── */
        .dd-label {
            display: inline-block;
            background: color-mix(in srgb,var(--accent-color),transparent 85%);
            color: var(--accent-color); font-size: .72rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            padding: .22rem .8rem; border-radius: 50px; margin-bottom: .65rem;
        }
        .dd-section-title { font-family: var(--heading-font); font-size: clamp(1.4rem,2.5vw,2.1rem); font-weight: 700; color: var(--heading-color); margin-top: .2rem; }
        .dd-section-sub { color: color-mix(in srgb,var(--default-color),transparent 25%); max-width: 560px; margin: .4rem auto 0; }

        /* ── About ─────────────────────────────────────────────────── */
        .dd-about { background: var(--background-color); }
        .dd-profile-text { color: var(--default-color); line-height: 1.9; font-size: .96rem; text-align: justify; }
        .dd-profile-text p { margin-bottom: .75rem; }
        .dd-profile-text ul, .dd-profile-text ol { padding-left: 1.4rem; margin-bottom: .75rem; }
        .dd-profile-text li { margin-bottom: .3rem; }
        .dd-profile-text strong { color: var(--heading-color); }
        .dd-profile-text a { color: var(--accent-color); }

        .dd-credentials-box { background: color-mix(in srgb,var(--accent-color),transparent 93%); border-radius: 20px; padding: 1.8rem; border-left: 4px solid var(--accent-color); }
        .dd-cred-title { font-size: .92rem; font-weight: 700; color: var(--heading-color); margin-bottom: .8rem; }
        .dd-cred-list { list-style: none; padding: 0; margin: 0; }
        .dd-cred-list li { display: flex; align-items: flex-start; gap: .5rem; margin-bottom: .55rem; font-size: .88rem; color: var(--default-color); }
        .dd-cred-list li .bi { color: var(--accent-color); flex-shrink: 0; margin-top: .15rem; }

        /* ── Expertise ─────────────────────────────────────────────── */
        .dd-expertise { background: #f8f9fc; }
        .dd-exp-card { background: #fff; border-radius: 16px; padding: 1.3rem .8rem; box-shadow: 0 3px 16px rgba(0,0,0,.07); transition: transform .3s, box-shadow .3s; }
        .dd-exp-card:hover { transform: translateY(-5px); box-shadow: 0 10px 28px rgba(0,0,0,.11); }
        .dd-exp-icon { width: 52px; height: 52px; border-radius: 14px; background: color-mix(in srgb,var(--accent-color),transparent 88%); display: flex; align-items: center; justify-content: center; margin: 0 auto .7rem; }
        .dd-exp-icon i { font-size: 1.4rem; color: var(--accent-color); }
        .dd-exp-name { font-size: .78rem; font-weight: 600; color: var(--heading-color); line-height: 1.3; }

        /* ── Chambers ──────────────────────────────────────────────── */
        .dd-chambers { background: var(--background-color); }
        .dd-chamber-card { display: flex; gap: 1.2rem; background: #fff; border-radius: 18px; padding: 1.6rem; box-shadow: 0 4px 22px rgba(0,0,0,.08); transition: transform .3s; border-top: 4px solid var(--accent-color); }
        .dd-chamber-card:hover { transform: translateY(-4px); }
        .dd-chamber-icon { width: 52px; height: 52px; flex-shrink: 0; border-radius: 14px; background: color-mix(in srgb,var(--accent-color),transparent 88%); display: flex; align-items: center; justify-content: center; }
        .dd-chamber-icon i { font-size: 1.5rem; color: var(--accent-color); }
        .dd-chamber-badge { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--accent-color); background: color-mix(in srgb,var(--accent-color),transparent 88%); padding: .15rem .65rem; border-radius: 50px; }
        .dd-chamber-title { font-size: 1.05rem; font-weight: 700; color: var(--heading-color); margin: .35rem 0 .4rem; }
        .dd-chamber-place { font-size: .85rem; color: var(--default-color); margin-bottom: .5rem; }
        .dd-chamber-place .bi { color: var(--accent-color); }
        .dd-chamber-meta { display: flex; flex-direction: column; gap: .2rem; }
        .dd-chamber-meta span { font-size: .82rem; color: color-mix(in srgb,var(--default-color),transparent 20%); }
        .dd-chamber-meta .bi { color: var(--accent-color); }

        /* ── CTA ───────────────────────────────────────────────────── */
        .dd-cta { background: var(--background-color); }
        .dd-cta-inner {
            background: linear-gradient(135deg, var(--heading-color) 0%, color-mix(in srgb,var(--heading-color),var(--accent-color) 45%) 100%);
            border-radius: 24px; padding: 3rem 2.5rem;
            box-shadow: 0 12px 48px rgba(0,0,0,.18);
        }
        .dd-cta-title { font-family: var(--heading-font); font-size: clamp(1.5rem,3vw,2.2rem); font-weight: 800; color: #fff; margin-bottom: .5rem; }
        .dd-cta-sub { color: rgba(255,255,255,.75); font-size: .97rem; max-width: 480px; }
        .dd-cta-btn-white { background: #fff; color: var(--heading-color); border: 2px solid #fff; border-radius: 50px; padding: .6rem 1.6rem; font-weight: 700; text-decoration: none; transition: .3s; display: inline-flex; align-items: center; }
        .dd-cta-btn-white:hover { background: transparent; color: #fff; }
        .dd-cta-btn-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.55); border-radius: 50px; padding: .6rem 1.6rem; font-weight: 600; text-decoration: none; transition: .3s; display: inline-flex; align-items: center; }
        .dd-cta-btn-outline:hover { background: rgba(255,255,255,.15); border-color: #fff; }
        .dd-cta-socials { display: flex; gap: .5rem; justify-content: flex-end; }
        .dd-cta-socials a { width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,.12); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: .9rem; transition: .25s; }
        .dd-cta-socials a:hover { background: var(--accent-color); }

        /* ── Back link ─────────────────────────────────────────────── */
        .dd-back-link { color: var(--accent-color); font-weight: 600; font-size: .9rem; text-decoration: none; }
        .dd-back-link:hover { color: var(--heading-color); }
    </style>

</div>
