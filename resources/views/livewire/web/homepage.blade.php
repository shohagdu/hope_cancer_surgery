<div>
   <!-- Hero Section -->
   <section id="hero" class="hero section light-background">
      <img src="{{ asset('website/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
      <div class="container position-relative">
         <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
             <h2 style="font-size: 30px;">WELCOME TO  </h2>
            <p style="font-size: 35px;" class="mt-2">{{ $organizationInfo->name??'HOPE' }} ({{ $organizationInfo->slug??'HOPE' }})</p>
         </div><!-- End Welcome -->

         <div class="content row gy-4">
            <div class="col-lg-4 d-flex align-items-stretch">
               <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                  <h3>{{ $whyChooseHighlightItem->title??'Why Choose Us' }}</span></h3>
                  <p>
                     {{ $whyChooseHighlightItem->short_description??'' }}
                  </p>
                  <div class="text-center">
                     <a href="{{ route('why-choose-us') }}" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                  </div>
               </div>
            </div><!-- End Why Box -->

            <div class="col-lg-8 d-flex align-items-stretch">
               <div class="d-flex flex-column justify-content-center">
                  <div class="row gy-4">
                     @if(!empty($whyChooseItem))
                        @foreach($whyChooseItem as $whyChooseRow)
                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                    <i class="{{ $whyChooseRow->icon }}"></i>
                                    <h4>{{ $whyChooseRow->title }}</h4>
                                    <p>{{ $whyChooseRow->short_description }}</p>
                                </div>
                            </div><!-- End Icon Box -->
                        @endforeach
                     @endif

                  </div>
               </div>
            </div>
         </div><!-- End  Content-->

      </div>

   </section><!-- /Hero Section -->

   <!-- About Section -->
   <section id="about" class="about section">

      <div class="container">

         <div class="row gy-4 gx-5">

            <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
               <img src="{{ asset('website/assets/img/all_doctors.jpeg')}}" class="img-fluid" alt="">
            </div>

            <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
               <h3>{{ $aboutUsHighlightItem->title??'About Us' }}</h3>
               <p>
                  {{ $aboutUsHighlightItem->short_description??'' }}

               </p>
               <ul>
                  @if($aboutUsItem)
                     @foreach($aboutUsItem as $aboutUsRow)

                        <li>
                           <i class=" {{  !empty($aboutUsRow->icon) ?$aboutUsRow->icon: 'fa-solid fa-vial-circle-check' }}"></i>
                           <div>
                              <h5>{{ $aboutUsRow->title }}</h5>
                              <p>{{ $aboutUsRow->short_description }}</p>
                           </div>
                        </li>
                     @endforeach
                  @endif

               </ul>
            </div>

         </div>

      </div>

   </section><!-- /About Section -->

   <section id="doctors" class="doctors section light-background">
      <div class="container section-title" data-aos="fade-up">
         <h2>Our Doctors</h2>
         <p>Meet our team of highly qualified and experienced cancer surgeons dedicated to providing compassionate, advanced, and personalised care for every patient.</p>
      </div>

      <div class="container">
         <div class="row gy-4 justify-content-center">
            @foreach($doctors as $index => $doctor)
            @php
               $imgPath = $doctor->picture && file_exists(storage_path('app/public/'.$doctor->picture))
                  ? asset('storage/'.$doctor->picture)
                  : asset('website/assets/img/doctors/doctors-1.jpg');
               $positions = array_filter(array_map('trim', explode("\n", $doctor->positions ?? '')));
               $detailUrl = url('/doctor/'.$doctor->id.'/'.Str::slug($doctor->name));
            @endphp
            <div class="col-xl-4 col-lg-5 col-md-8" data-aos="fade-up" data-aos-delay="{{ $loop->index * 120 }}">
               <div class="hp-doctor-card">
                  {{-- Photo strip --}}
                  <div class="hp-doctor-photo-wrap">
                     <img src="{{ $imgPath }}" alt="{{ $doctor->name }}">
                     <div class="hp-doctor-overlay">
                        <a href="{{ $detailUrl }}" class="hp-doctor-view-btn">View Full Profile</a>
                     </div>
                  </div>
                  {{-- Info --}}
                  <div class="hp-doctor-body">
                     <h4 class="hp-doctor-name">{{ $doctor->name }}</h4>
                     <p class="hp-doctor-qual">{{ $doctor->qualifications }}</p>
                     @if(!empty($positions))
                        <div class="hp-doctor-pos">
                           @foreach(array_slice($positions, 0, 2) as $pos)
                              <span><i class="bi bi-dot"></i>{{ $pos }}</span>
                           @endforeach
                        </div>
                     @endif
                     @if(!empty($doctor->special_training))
                        <p class="hp-doctor-training">
                           <i class="bi bi-mortarboard-fill me-1"></i>{{ Str::limit($doctor->special_training, 80) }}
                        </p>
                     @endif
                     {{-- Socials --}}
                     <div class="hp-doctor-socials">
                        @foreach(['facebook'=>'bi-facebook','youtube'=>'bi-youtube','linkedin'=>'bi-linkedin','instagram'=>'bi-instagram','tiktok'=>'bi-tiktok'] as $field => $icon)
                           @if(!empty($doctor->$field))
                              <a href="{{ $doctor->$field }}" target="_blank" rel="noopener"><i class="bi {{ $icon }}"></i></a>
                           @endif
                        @endforeach
                     </div>
                  </div>
                  {{-- Footer --}}
                  <div class="hp-doctor-footer">
                     @if(!empty($doctor->mobile))
                        <span><i class="bi bi-telephone-fill me-1"></i>{{ $doctor->mobile }}</span>
                     @endif
                     <a href="{{ $detailUrl }}" class="hp-doctor-readmore">Read More <i class="bi bi-arrow-right-short"></i></a>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>

      <style>
         .hp-doctor-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.09);transition:transform .35s,box-shadow .35s;display:flex;flex-direction:column;height:100%}
         .hp-doctor-card:hover{transform:translateY(-8px);box-shadow:0 18px 48px rgba(0,0,0,.14)}
         .hp-doctor-photo-wrap{position:relative;overflow:hidden;height:340px;background:#f0f4f8}
         .hp-doctor-photo-wrap img{width:100%;height:100%;object-fit:cover;object-position:center 10%;transition:transform .5s}
         .hp-doctor-card:hover .hp-doctor-photo-wrap img{transform:scale(1.06)}
         .hp-doctor-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.65) 0%,transparent 55%);display:flex;align-items:flex-end;justify-content:center;padding-bottom:1.2rem;opacity:0;transition:opacity .35s}
         .hp-doctor-card:hover .hp-doctor-overlay{opacity:1}
         .hp-doctor-view-btn{background:var(--accent-color);color:#fff;border-radius:50px;padding:.4rem 1.3rem;font-size:.82rem;font-weight:600;text-decoration:none;transition:.25s}
         .hp-doctor-view-btn:hover{background:#fff;color:var(--accent-color)}
         .hp-doctor-body{padding:1.3rem 1.4rem .8rem;flex:1}
         .hp-doctor-name{font-family:var(--heading-font);font-size:1.15rem;font-weight:700;color:var(--heading-color);margin-bottom:.25rem}
         .hp-doctor-qual{font-size:.82rem;color:var(--accent-color);font-weight:600;margin-bottom:.5rem}
         .hp-doctor-pos{display:flex;flex-direction:column;gap:.1rem;margin-bottom:.55rem}
         .hp-doctor-pos span{font-size:.82rem;color:var(--default-color);display:flex;align-items:flex-start}
         .hp-doctor-pos .bi-dot{font-size:1.1rem;color:var(--accent-color);flex-shrink:0;margin-top:-.05rem}
         .hp-doctor-training{font-size:.78rem;color:color-mix(in srgb,var(--default-color),transparent 20%);margin-bottom:.6rem;line-height:1.5}
         .hp-doctor-training .bi{color:var(--accent-color)}
         .hp-doctor-socials{display:flex;gap:.5rem;margin-top:.5rem}
         .hp-doctor-socials a{width:32px;height:32px;border-radius:50%;background:color-mix(in srgb,var(--accent-color),transparent 88%);display:flex;align-items:center;justify-content:center;color:var(--accent-color);font-size:.85rem;transition:.25s;text-decoration:none}
         .hp-doctor-socials a:hover{background:var(--accent-color);color:#fff}
         .hp-doctor-footer{display:flex;align-items:center;justify-content:space-between;padding:.8rem 1.4rem;border-top:1px solid #f0f0f0;background:#fafafa}
         .hp-doctor-footer span{font-size:.78rem;color:var(--default-color)}
         .hp-doctor-footer .bi-telephone-fill{color:var(--accent-color)}
         .hp-doctor-readmore{font-size:.85rem;font-weight:700;color:var(--accent-color);text-decoration:none;display:flex;align-items:center;gap:.1rem;transition:.2s}
         .hp-doctor-readmore:hover{color:var(--heading-color)}
         .hp-doctor-readmore .bi{font-size:1.1rem}
      </style>
   </section>


   <!-- Services Section -->
   <section id="services" class="services section">
      <?php
      $ctg = [
              ['title' => 'Stomach Cancer', 'description' => 'Treatment and consultation for stomach (gastric) cancer.'],
              ['title' => 'Esophageal Cancer', 'description' => 'Comprehensive care for cancer of the esophagus.'],
              ['title' => 'Breast Cancer', 'description' => 'Diagnosis, surgery, and chemotherapy support for breast cancer.'],
              ['title' => 'Colon Cancer', 'description' => 'Medical and surgical services for colon cancer.'],
              ['title' => 'Rectal Cancer', 'description' => 'Specialized treatment for cancer in the rectum.'],
              ['title' => 'Anal Cancer', 'description' => 'Consultation and management for anal cancer.'],
              ['title' => 'Sarcoma', 'description' => 'Care and treatment for soft tissue and bone sarcomas.'],
              ['title' => 'Skin Cancer', 'description' => 'Screening and surgical removal of skin cancers.'],
              ['title' => 'Pancreatic and Peripancreatic Cancer', 'description' => 'Advanced support for pancreatic and surrounding area cancers.'],
              ['title' => 'Pancreas Cancer', 'description' => 'Diagnosis and surgery for primary pancreatic cancer.'],
              ['title' => 'Prostate Cancer', 'description' => 'Consultation, biopsy, and treatment options for prostate cancer.'],
              ['title' => 'Ovarian Cancer', 'description' => 'Medical and surgical management for ovarian cancer.'],
              ['title' => 'Kidney Cancer', 'description' => 'Treatment for cancer in one or both kidneys.'],
              ['title' => 'Thyroid Cancer', 'description' => 'Consultation and surgical services for thyroid cancer.']
      ];
      $emergencyServices = [
              [
                      'title' => 'Feeding Jejunostomy',
                      'description' => 'A surgical procedure to insert a feeding tube into the jejunum for patients unable to eat by mouth.'
              ],
              [
                      'title' => 'Esophageal Stenting',
                      'description' => 'Placement of a stent in the esophagus to relieve obstruction and help with swallowing in esophageal cancer patients.'
              ],
              [
                      'title' => 'DJ Stenting',
                      'description' => 'Insertion of a double J (DJ) stent to relieve blockage in the urinary tract, often used in kidney or ureteral obstructions.'
              ],
              [
                      'title' => 'Endoscopy',
                      'description' => 'A minimally invasive procedure used to examine internal organs, typically the digestive tract, using an endoscope.'
              ],
              [
                      'title' => 'Colonoscopy',
                      'description' => 'A diagnostic procedure that uses a colonoscope to view the inside of the colon and detect cancer or polyps.'
              ],
              [
                      'title' => 'Cystoscopy',
                      'description' => 'A procedure that allows doctors to examine the inside of the bladder and urethra using a cystoscope.'
              ],
              [
                      'title' => 'Core-Cut Biopsy',
                      'description' => 'A biopsy method where a core of tissue is extracted from a tumor using a special needle for accurate cancer diagnosis.'
              ],
              [
                      'title' => 'Chemoport Insertion',
                      'description' => 'Implantation of a chemoport under the skin to make it easier to deliver chemotherapy safely and efficiently.'
              ]
      ];
      ?>
      {{-- ── Section Header ──────────────────────────────────────────── --}}
      <div class="container ta-header text-center" data-aos="fade-up">
         <span class="ta-label">Specialised Care</span>
         <h2 class="ta-title">Our Treatment Area</h2>
         <p class="ta-sub">Advanced oncology care delivered with compassion — from diagnosis through surgery and beyond.</p>
      </div>

      {{-- ── Cancer Treatment ─────────────────────────────────────────── --}}
      <div class="container" data-aos="fade-up" data-aos-delay="50">
         <div class="ta-category-header">
            <div class="ta-cat-icon"><i class="fa-solid fa-ribbon"></i></div>
            <div>
               <h4 class="ta-cat-title">Cancer Treatment &amp; Consultation</h4>
               <p class="ta-cat-sub">Comprehensive surgical and medical oncology services for all major cancer types</p>
            </div>
         </div>
         <div class="row gy-3">
            @if($service_treatment)
               @foreach($service_treatment as $key => $row)
               <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                  <a href="{{ route('service.details', ['id'=>$row->id,'slug'=>\Illuminate\Support\Str::slug($row->title)]) }}" class="ta-card ta-card--cancer">
                     <div class="ta-card-icon">
                        <i class="{{ !empty($row->icon) ? $row->icon : 'fa-solid fa-microscope' }}"></i>
                     </div>
                     <div class="ta-card-body">
                        <h5 class="ta-card-title">{{ $row['title'] }}</h5>
                        <p class="ta-card-desc">{{ Str::limit($row['short_description'] ?? '', 70) }}</p>
                     </div>
                     <div class="ta-card-arrow"><i class="bi bi-arrow-right-short"></i></div>
                  </a>
               </div>
               @endforeach
            @else
               @foreach($ctg as $key => $row)
               <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                  <a href="#" class="ta-card ta-card--cancer">
                     <div class="ta-card-icon"><i class="fa-solid fa-microscope"></i></div>
                     <div class="ta-card-body">
                        <h5 class="ta-card-title">{{ $row['title'] }}</h5>
                        <p class="ta-card-desc">{{ Str::limit($row['description'], 70) }}</p>
                     </div>
                     <div class="ta-card-arrow"><i class="bi bi-arrow-right-short"></i></div>
                  </a>
               </div>
               @endforeach
            @endif
         </div>
      </div>

      {{-- ── Emergency Services ───────────────────────────────────────── --}}
      <div class="container mt-5" data-aos="fade-up" data-aos-delay="50">
         <div class="ta-category-header ta-category-header--emergency">
            <div class="ta-cat-icon ta-cat-icon--emergency"><i class="fa-solid fa-kit-medical"></i></div>
            <div>
               <h4 class="ta-cat-title">Emergency &amp; Diagnostic Services</h4>
               <p class="ta-cat-sub">Urgent procedures and minimally invasive diagnostics available when you need them most</p>
            </div>
         </div>
         <div class="row gy-3">
            @if($service_emergency)
               @foreach($service_emergency as $key => $row)
               <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                  <a href="{{ route('service.details', ['id'=>$row->id,'slug'=>\Illuminate\Support\Str::slug($row->title)]) }}" class="ta-card ta-card--emergency">
                     <div class="ta-card-icon ta-card-icon--emergency">
                        <i class="{{ !empty($row->icon) ? $row->icon : 'fa-solid fa-stethoscope' }}"></i>
                     </div>
                     <div class="ta-card-body">
                        <h5 class="ta-card-title">{{ $row['title'] }}</h5>
                        <p class="ta-card-desc">{{ Str::limit($row['short_description'] ?? '', 70) }}</p>
                     </div>
                     <div class="ta-card-arrow ta-card-arrow--emergency"><i class="bi bi-arrow-right-short"></i></div>
                  </a>
               </div>
               @endforeach
            @else
               @foreach($emergencyServices as $key => $row)
               <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                  <a href="#" class="ta-card ta-card--emergency">
                     <div class="ta-card-icon ta-card-icon--emergency"><i class="fa-solid fa-stethoscope"></i></div>
                     <div class="ta-card-body">
                        <h5 class="ta-card-title">{{ $row['title'] }}</h5>
                        <p class="ta-card-desc">{{ Str::limit($row['description'], 70) }}</p>
                     </div>
                     <div class="ta-card-arrow ta-card-arrow--emergency"><i class="bi bi-arrow-right-short"></i></div>
                  </a>
               </div>
               @endforeach
            @endif
         </div>
      </div>

      {{-- ── Styles ───────────────────────────────────────────────────── --}}
      <style>
         /* Header */
         .ta-label{display:inline-block;background:color-mix(in srgb,var(--accent-color),transparent 85%);color:var(--accent-color);font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:.22rem .9rem;border-radius:50px;margin-bottom:.6rem}
         .ta-title{font-family:var(--heading-font);font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;color:var(--heading-color);margin-bottom:.5rem}
         .ta-sub{color:color-mix(in srgb,var(--default-color),transparent 25%);max-width:580px;margin:0 auto 2.5rem;font-size:.97rem}
         .ta-header{margin-bottom:1rem}

         /* Category header */
         .ta-category-header{display:flex;align-items:center;gap:1rem;margin-bottom:1.4rem;padding:1rem 1.4rem;background:#fff;border-radius:16px;box-shadow:0 3px 16px rgba(0,0,0,.07);border-left:5px solid var(--accent-color)}
         .ta-category-header--emergency{border-left-color:#e05c2a}
         .ta-cat-icon{width:52px;height:52px;flex-shrink:0;border-radius:14px;background:color-mix(in srgb,var(--accent-color),transparent 88%);display:flex;align-items:center;justify-content:center}
         .ta-cat-icon i{font-size:1.4rem;color:var(--accent-color)}
         .ta-cat-icon--emergency{background:color-mix(in srgb,#e05c2a,transparent 88%)}
         .ta-cat-icon--emergency i{color:#e05c2a}
         .ta-cat-title{font-family:var(--heading-font);font-size:1.1rem;font-weight:700;color:var(--heading-color);margin:0 0 .2rem}
         .ta-cat-sub{font-size:.82rem;color:color-mix(in srgb,var(--default-color),transparent 25%);margin:0}

         /* Cards */
         .ta-card{display:flex;align-items:center;gap:.9rem;background:#fff;border-radius:14px;padding:.95rem 1rem;box-shadow:0 3px 14px rgba(0,0,0,.07);text-decoration:none;transition:transform .3s,box-shadow .3s,border-color .3s;border:1.5px solid transparent;position:relative;overflow:hidden}
         .ta-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,color-mix(in srgb,var(--accent-color),transparent 95%) 0%,transparent 60%);opacity:0;transition:opacity .3s}
         .ta-card:hover{transform:translateY(-4px);box-shadow:0 12px 32px rgba(0,0,0,.13);border-color:color-mix(in srgb,var(--accent-color),transparent 60%)}
         .ta-card:hover::before{opacity:1}
         .ta-card--emergency::before{background:linear-gradient(135deg,color-mix(in srgb,#e05c2a,transparent 92%) 0%,transparent 60%)}
         .ta-card--emergency:hover{border-color:color-mix(in srgb,#e05c2a,transparent 55%)}

         /* Card icon */
         .ta-card-icon{width:44px;height:44px;flex-shrink:0;border-radius:12px;background:color-mix(in srgb,var(--accent-color),transparent 88%);display:flex;align-items:center;justify-content:center;transition:.3s}
         .ta-card-icon i{font-size:1.15rem;color:var(--accent-color)}
         .ta-card:hover .ta-card-icon{background:var(--accent-color)}
         .ta-card:hover .ta-card-icon i{color:#fff}
         .ta-card-icon--emergency{background:color-mix(in srgb,#e05c2a,transparent 88%)}
         .ta-card-icon--emergency i{color:#e05c2a}
         .ta-card--emergency:hover .ta-card-icon{background:#e05c2a}
         .ta-card--emergency:hover .ta-card-icon i{color:#fff}

         /* Card body */
         .ta-card-body{flex:1;min-width:0}
         .ta-card-title{font-size:.88rem;font-weight:700;color:var(--heading-color);margin:0 0 .18rem;line-height:1.3;transition:color .3s}
         .ta-card:hover .ta-card-title{color:var(--accent-color)}
         .ta-card--emergency:hover .ta-card-title{color:#e05c2a}
         .ta-card-desc{font-size:.75rem;color:color-mix(in srgb,var(--default-color),transparent 30%);margin:0;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

         /* Arrow */
         .ta-card-arrow{flex-shrink:0;width:28px;height:28px;border-radius:50%;background:color-mix(in srgb,var(--accent-color),transparent 90%);display:flex;align-items:center;justify-content:center;transition:.3s}
         .ta-card-arrow i{font-size:1.1rem;color:var(--accent-color);transition:.3s}
         .ta-card:hover .ta-card-arrow{background:var(--accent-color)}
         .ta-card:hover .ta-card-arrow i{color:#fff;transform:translateX(2px)}
         .ta-card-arrow--emergency{background:color-mix(in srgb,#e05c2a,transparent 90%)}
         .ta-card-arrow--emergency i{color:#e05c2a}
         .ta-card--emergency:hover .ta-card-arrow{background:#e05c2a}
         .ta-card--emergency:hover .ta-card-arrow i{color:#fff}
      </style>

   </section>

   <!-- Appointment Section -->
   <section id="appointment" class="appt-section">

      <div class="container">
         <div class="row g-0 appt-wrapper" data-aos="fade-up">

            {{-- Left info panel --}}
            <div class="col-lg-5 appt-info-panel d-flex flex-column justify-content-between">
               <div>
                  <div class="appt-info-badge"><i class="bi bi-calendar2-heart-fill me-2"></i>Book an Appointment</div>
                  <h2 class="appt-info-title">Get Expert Cancer Care <span>Today</span></h2>
                  <p class="appt-info-desc">Our team of specialist surgeons is dedicated to providing timely, compassionate, and advanced care. Fill in the form and we will confirm your slot.</p>
               </div>

               <ul class="appt-info-list">
                  <li>
                     <span class="appt-info-icon"><i class="bi bi-clock-fill"></i></span>
                     <div>
                        <strong>Consultation Hours</strong>
                        <span>Sat – Thu &nbsp;|&nbsp; 9:00 AM – 6:00 PM</span>
                     </div>
                  </li>
                  <li>
                     <span class="appt-info-icon"><i class="bi bi-telephone-fill"></i></span>
                     <div>
                        <strong>Call for Emergency</strong>
                        <span>{{ $organizationInfo->phone ?? '+880 xxxxxxxx' }}</span>
                     </div>
                  </li>
                  <li>
                     <span class="appt-info-icon"><i class="bi bi-geo-alt-fill"></i></span>
                     <div>
                        <strong>Location</strong>
                        <span>{{ $organizationInfo->address ?? '152/2/G Panthapath, Dhaka-1205' }}</span>
                     </div>
                  </li>
               </ul>

               <div class="appt-info-note">
                  <i class="bi bi-shield-check me-2"></i>Your information is safe and never shared.
               </div>
            </div>

            {{-- Right form panel --}}
            <div class="col-lg-7 appt-form-panel">
               <form wire:submit.prevent="submitDoctorAppointment">

                  <div class="row g-3">

                     {{-- Doctor --}}
                     <div class="col-12">
                        <label class="appt-label"><i class="bi bi-person-badge me-1"></i>Select Doctor <span class="text-danger">*</span></label>
                        <select wire:model="appt_doctor" class="appt-input">
                           <option value="">-- Choose a Doctor --</option>
                           @foreach($doctors as $d)
                              <option value="{{ $d->id }}">{{ $d->name }}{{ $d->qualifications ? ' — '.$d->qualifications : '' }}</option>
                           @endforeach
                        </select>
                        @error('appt_doctor') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Appointment Date --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-calendar-event me-1"></i>Preferred Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" wire:model="appt_date" class="appt-input" min="{{ now()->addHours(1)->format('Y-m-d\TH:i') }}">
                        @error('appt_date') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Patient Type --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-person-lines-fill me-1"></i>Patient Type <span class="text-danger">*</span></label>
                        <select wire:model="appt_patient_type" class="appt-input">
                           <option value="1">New Patient</option>
                           <option value="2">Existing Patient</option>
                        </select>
                        @error('appt_patient_type') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Name --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-person me-1"></i>Patient Name <span class="text-danger">*</span></label>
                        <input type="text" wire:model="appt_name" class="appt-input" placeholder="Full name">
                        @error('appt_name') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Age --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-123 me-1"></i>Age</label>
                        <input type="text" wire:model="appt_age" class="appt-input" placeholder="e.g. 45">
                        @error('appt_age') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Phone --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-telephone me-1"></i>Mobile Number <span class="text-danger">*</span></label>
                        <input type="tel" wire:model="appt_phone" class="appt-input" placeholder="+880 01xxxxxxxxx">
                        @error('appt_phone') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Gender --}}
                     <div class="col-md-6">
                        <label class="appt-label"><i class="bi bi-gender-ambiguous me-1"></i>Gender <span class="text-danger">*</span></label>
                        <select wire:model="appt_gender" class="appt-input">
                           <option value="">-- Select --</option>
                           <option value="male">Male</option>
                           <option value="female">Female</option>
                           <option value="other">Other</option>
                        </select>
                        @error('appt_gender') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Message --}}
                     <div class="col-12">
                        <label class="appt-label"><i class="bi bi-chat-left-text me-1"></i>Additional Notes</label>
                        <textarea wire:model="appt_message" class="appt-input" rows="3" placeholder="Describe your condition or any special requests (optional)"></textarea>
                        @error('appt_message') <span class="appt-error">{{ $message }}</span> @enderror
                     </div>

                     {{-- Math Captcha --}}
                     <div class="col-12">
                        <div class="appt-captcha">
                           <i class="bi bi-shield-lock-fill appt-captcha-icon"></i>
                           <label class="appt-label mb-0">Security check: What is <strong>{{ $captchaNum1 }}</strong> + <strong>{{ $captchaNum2 }}</strong> ?</label>
                           <input type="number" wire:model="captchaInput" class="appt-input appt-captcha-input" placeholder="Your answer">
                           @error('captchaInput') <span class="appt-error">{{ $message }}</span> @enderror
                        </div>
                     </div>

                     {{-- Submit --}}
                     <div class="col-12">
                        <button type="submit" class="appt-submit-btn" wire:loading.attr="disabled">
                           <span wire:loading.remove><i class="bi bi-send-fill me-2"></i>Book Appointment</span>
                           <span wire:loading><i class="bi bi-hourglass-split me-2"></i>Submitting…</span>
                        </button>
                     </div>

                  </div>
               </form>
            </div>

         </div>
      </div>

      <style>
         .appt-section{padding:80px 0;background:linear-gradient(135deg,#f0f6ff 0%,#faf0ff 100%)}
         .appt-wrapper{border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.10)}

         /* Left panel */
         .appt-info-panel{background:linear-gradient(160deg,var(--heading-color) 0%,color-mix(in srgb,var(--accent-color),var(--heading-color) 40%) 100%);padding:48px 40px;color:#fff}
         .appt-info-badge{display:inline-flex;align-items:center;background:rgba(255,255,255,.15);border-radius:50px;padding:.35rem 1rem;font-size:.82rem;font-weight:600;letter-spacing:.5px;margin-bottom:1.2rem;color:#fff}
         .appt-info-title{font-size:1.9rem;font-weight:800;line-height:1.25;color:#fff;margin-bottom:1rem}
         .appt-info-title span{color:color-mix(in srgb,var(--accent-color),#fff 40%)}
         .appt-info-desc{font-size:.92rem;opacity:.88;line-height:1.7;margin-bottom:2rem;color:#fff}
         .appt-info-list{list-style:none;padding:0;margin:0 0 2rem;display:flex;flex-direction:column;gap:1.1rem}
         .appt-info-list li{display:flex;align-items:flex-start;gap:.9rem}
         .appt-info-icon{flex-shrink:0;width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:1rem;color:#fff;margin-top:.1rem}
         .appt-info-list strong{display:block;font-size:.88rem;font-weight:700;color:#fff;margin-bottom:.1rem}
         .appt-info-list span{font-size:.82rem;opacity:.82;color:#fff}
         .appt-info-note{font-size:.78rem;opacity:.75;color:#fff;border-top:1px solid rgba(255,255,255,.2);padding-top:1rem}

         /* Right panel */
         .appt-form-panel{background:#fff;padding:48px 44px}
         .appt-label{display:block;font-size:.82rem;font-weight:600;color:var(--heading-color);margin-bottom:.35rem}
         .appt-input{display:block;width:100%;padding:.6rem .9rem;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.9rem;color:var(--default-color);background:#fafbff;transition:border-color .2s,box-shadow .2s;outline:none}
         .appt-input:focus{border-color:var(--accent-color);box-shadow:0 0 0 3px color-mix(in srgb,var(--accent-color),transparent 82%);background:#fff}
         .appt-error{display:block;font-size:.78rem;color:#e53e3e;margin-top:.25rem}

         /* Captcha */
         .appt-captcha{background:#f8f4ff;border:1.5px dashed color-mix(in srgb,var(--accent-color),transparent 60%);border-radius:12px;padding:.9rem 1.1rem;display:flex;flex-direction:column;gap:.5rem}
         .appt-captcha-icon{font-size:1.2rem;color:var(--accent-color)}
         .appt-captcha-input{max-width:140px;margin-top:.3rem}

         /* Submit button */
         .appt-submit-btn{width:100%;padding:.85rem;background:var(--accent-color);color:#fff;font-size:1rem;font-weight:700;border:none;border-radius:12px;cursor:pointer;transition:background .25s,transform .2s,box-shadow .2s;display:flex;align-items:center;justify-content:center;gap:.4rem}
         .appt-submit-btn:hover{background:color-mix(in srgb,var(--accent-color),#000 15%);transform:translateY(-2px);box-shadow:0 8px 20px color-mix(in srgb,var(--accent-color),transparent 55%)}
         .appt-submit-btn:disabled{opacity:.65;cursor:not-allowed;transform:none}

         @media(max-width:991px){
            .appt-info-panel{padding:36px 28px}
            .appt-form-panel{padding:36px 28px}
         }
         @media(max-width:575px){
            .appt-info-panel{padding:28px 20px}
            .appt-form-panel{padding:28px 20px}
         }
      </style>

   </section><!-- /Appointment Section -->



   <!-- Faq Section -->
   <!-- FAQ Section -->
   <section id="faq" class="hfaq-section">

      <div class="container">

         {{-- Section Header --}}
         <div class="hfaq-header" data-aos="fade-up">
            <span class="hfaq-badge">Got Questions?</span>
            <h2 class="hfaq-title">Frequently Asked Questions</h2>
            <p class="hfaq-subtitle">Everything you need to know about our services and care.</p>
         </div>

         @php
            $faqItems = $faqInfo && count($faqInfo) ? $faqInfo : collect([]);
         @endphp

         @if($faqItems->isNotEmpty())
         <div class="row g-4" data-aos="fade-up" data-aos-delay="100">

            {{-- Split into two columns --}}
            @php
               $col1 = $faqItems->filter(fn($v,$k) => $k % 2 === 0)->values();
               $col2 = $faqItems->filter(fn($v,$k) => $k % 2 !== 0)->values();
            @endphp

            <div class="col-lg-6">
               @foreach($col1 as $idx => $faqRow)
               <div class="hfaq-item" data-aos="fade-up" data-aos-delay="{{ $idx * 60 }}">
                  <button class="hfaq-question {{ $idx === 0 ? 'hfaq-open' : '' }}"
                          onclick="hfaqToggle(this)" type="button">
                     <span class="hfaq-q-icon">
                        <i class="bi bi-question-lg"></i>
                     </span>
                     <span class="hfaq-q-text">{{ $faqRow->title ?? '' }}</span>
                     <span class="hfaq-chevron">
                        <i class="bi bi-chevron-down"></i>
                     </span>
                  </button>
                  <div class="hfaq-answer {{ $idx === 0 ? 'hfaq-answer-open' : '' }}">
                     <p>{{ $faqRow->description ?? '' }}</p>
                  </div>
               </div>
               @endforeach
            </div>

            <div class="col-lg-6">
               @foreach($col2 as $idx => $faqRow)
               <div class="hfaq-item" data-aos="fade-up" data-aos-delay="{{ ($idx * 60) + 30 }}">
                  <button class="hfaq-question"
                          onclick="hfaqToggle(this)" type="button">
                     <span class="hfaq-q-icon">
                        <i class="bi bi-question-lg"></i>
                     </span>
                     <span class="hfaq-q-text">{{ $faqRow->title ?? '' }}</span>
                     <span class="hfaq-chevron">
                        <i class="bi bi-chevron-down"></i>
                     </span>
                  </button>
                  <div class="hfaq-answer">
                     <p>{{ $faqRow->description ?? '' }}</p>
                  </div>
               </div>
               @endforeach
            </div>

         </div>
         @else
            <p class="text-center text-muted py-4">No FAQs available at the moment.</p>
         @endif

      </div>

      {{-- Styles --}}
      <style>
         .hfaq-section {
            padding: 80px 0;
            background: linear-gradient(160deg,
               color-mix(in srgb, var(--accent-color), transparent 95%) 0%,
               #f8f9fc 40%,
               #fff 100%);
         }
         .hfaq-header {
            text-align: center;
            margin-bottom: 3rem;
         }
         .hfaq-badge {
            display: inline-block;
            background: color-mix(in srgb, var(--accent-color), transparent 85%);
            color: var(--accent-color);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: .28rem .9rem;
            border-radius: 50px;
            margin-bottom: .7rem;
         }
         .hfaq-title {
            font-family: var(--heading-font, inherit);
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 800;
            color: var(--heading-color);
            margin-bottom: .5rem;
         }
         .hfaq-subtitle {
            color: color-mix(in srgb, var(--default-color), transparent 30%);
            font-size: .97rem;
            max-width: 480px;
            margin: 0 auto;
         }

         /* Card */
         .hfaq-item {
            background: #fff;
            border-radius: 14px;
            margin-bottom: 12px;
            box-shadow: 0 2px 12px rgba(44,73,100,.07);
            border: 1.5px solid color-mix(in srgb, var(--heading-color), transparent 90%);
            overflow: hidden;
            transition: box-shadow .25s, border-color .25s;
         }
         .hfaq-item:hover {
            box-shadow: 0 6px 24px color-mix(in srgb, var(--accent-color), transparent 82%);
            border-color: color-mix(in srgb, var(--accent-color), transparent 70%);
         }

         /* Question button */
         .hfaq-question {
            width: 100%;
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1.1rem 1.3rem;
            cursor: pointer;
            text-align: left;
         }
         .hfaq-q-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: color-mix(in srgb, var(--accent-color), transparent 88%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: .85rem;
            font-weight: 800;
            color: var(--accent-color);
            transition: background .25s;
         }
         .hfaq-open .hfaq-q-icon,
         .hfaq-question.hfaq-open .hfaq-q-icon {
            background: var(--accent-color);
            color: #fff;
         }
         .hfaq-q-text {
            flex: 1;
            font-size: .93rem;
            font-weight: 600;
            color: var(--heading-color);
            line-height: 1.4;
         }
         .hfaq-chevron {
            flex-shrink: 0;
            width: 26px; height: 26px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--heading-color), transparent 92%);
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem;
            color: var(--heading-color);
            transition: transform .3s, background .25s;
         }
         .hfaq-question.hfaq-open .hfaq-chevron {
            transform: rotate(180deg);
            background: color-mix(in srgb, var(--accent-color), transparent 85%);
            color: var(--accent-color);
         }

         /* Answer */
         .hfaq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease, padding .3s ease;
            padding: 0 1.3rem 0 calc(1.3rem + 32px + .85rem);
         }
         .hfaq-answer.hfaq-answer-open {
            max-height: 400px;
            padding-bottom: 1.1rem;
         }
         .hfaq-answer p {
            font-size: .88rem;
            color: color-mix(in srgb, var(--default-color), transparent 15%);
            line-height: 1.75;
            margin: 0;
         }

         /* Open state border accent */
         .hfaq-item:has(.hfaq-open) {
            border-color: color-mix(in srgb, var(--accent-color), transparent 65%);
            border-left: 3px solid var(--accent-color);
         }

         @media (max-width: 576px) {
            .hfaq-section { padding: 50px 0; }
            .hfaq-answer { padding-left: 1.3rem; }
         }
      </style>

      {{-- Toggle script --}}
      <script>
         function hfaqToggle(btn) {
            const item   = btn.closest('.hfaq-item');
            const answer = item.querySelector('.hfaq-answer');
            const isOpen = btn.classList.contains('hfaq-open');

            // Close all in the same column
            const col = item.closest('.col-lg-6');
            col.querySelectorAll('.hfaq-question.hfaq-open').forEach(b => {
               b.classList.remove('hfaq-open');
               b.closest('.hfaq-item').querySelector('.hfaq-answer').classList.remove('hfaq-answer-open');
            });

            if (!isOpen) {
               btn.classList.add('hfaq-open');
               answer.classList.add('hfaq-answer-open');
            }
         }
      </script>

   </section><!-- /FAQ Section -->

   <!-- Testimonials Section -->
   @if(!empty($testimonials))
   <section id="testimonials" class="testimonials section">

      <div class="container">

         <div class="row align-items-center">

            <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
               <h3>{{ $testimonialsHeading ?: 'Testimonials' }}</h3>
               @if($testimonialsSubtext)
                  <p>{{ $testimonialsSubtext }}</p>
               @endif
            </div>

            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">

               <div class="swiper init-swiper">
                  <script type="application/json" class="swiper-config">
                     {
                       "loop": true,
                       "speed": 600,
                       "autoplay": { "delay": 5000 },
                       "slidesPerView": "auto",
                       "pagination": {
                         "el": ".swiper-pagination",
                         "type": "bullets",
                         "clickable": true
                       }
                     }
                  </script>
                  <div class="swiper-wrapper">
                     @foreach($testimonials as $t)
                        @php
                           $tName    = $t['name']        ?? '';
                           $tRole    = $t['role']        ?? '';
                           $tPhotoRaw = $t['picture_url'] ?? '';
                           $tPhoto    = $tPhotoRaw
                               ? (str_starts_with($tPhotoRaw, 'http') ? $tPhotoRaw : asset('storage/' . $tPhotoRaw))
                               : '';
                           $tRating  = (int)($t['rating'] ?? 5);
                           $tMsg     = $t['message']     ?? '';
                        @endphp
                        <div class="swiper-slide">
                           <div class="testimonial-item">
                              <div class="d-flex">
                                 @if($tPhoto)
                                    <img src="{{ $tPhoto }}" class="testimonial-img flex-shrink-0" alt="{{ $tName }}">
                                 @else
                                    <div class="testimonial-img flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white fs-4 fw-bold"
                                         style="width:60px;height:60px;">
                                       {{ strtoupper(substr($tName, 0, 1)) }}
                                    </div>
                                 @endif
                                 <div>
                                    <h3>{{ $tName }}</h3>
                                    @if($tRole)<h4>{{ $tRole }}</h4>@endif
                                    <div class="stars">
                                       @for($s = 1; $s <= 5; $s++)
                                          @if($s <= $tRating)
                                             <i class="bi bi-star-fill"></i>
                                          @else
                                             <i class="bi bi-star"></i>
                                          @endif
                                       @endfor
                                    </div>
                                 </div>
                              </div>
                              @if($tMsg)
                              <p>
                                 <i class="bi bi-quote quote-icon-left"></i>
                                 <span>{{ $tMsg }}</span>
                                 <i class="bi bi-quote quote-icon-right"></i>
                              </p>
                              @endif
                           </div>
                        </div><!-- End testimonial item -->
                     @endforeach
                  </div>
                  <div class="swiper-pagination"></div>
               </div>

            </div>

         </div>

      </div>

   </section><!-- /Testimonials Section -->
   @endif

   <!-- Gallery Section -->
   <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Gallery</h2>
         <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

         <div class="row g-0">

            @forelse($pictureItems as $picture)
               @php
                  $imgSrc = $picture->storage_type == 1
                     ? asset('storage/' . $picture->file_path)
                     : $picture->file_path;
               @endphp
               <div class="col-lg-3 col-md-4">
                  <div class="gallery-item">
                     <a href="{{ $imgSrc }}" class="glightbox" data-gallery="images-gallery" data-title="{{ $picture->title }}">
                        <img src="{{ $imgSrc }}" alt="{{ $picture->title }}" class="img-fluid">
                     </a>
                  </div>
               </div><!-- End Gallery Item -->
            @empty
               <div class="col-12 text-center py-4 text-muted">No images available.</div>
            @endforelse

         </div>

      </div>

   </section><!-- /Gallery Section -->

   <!-- Video Gallery Section -->
   @if(!empty($videoItems) && $videoItems->count())
   <section id="video-gallery" class="gallery section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Video Gallery</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
         <div class="row g-3">
            @foreach($videoItems as $video)
               @php
                  $src = $video->storage_type == 1
                     ? asset('storage/' . $video->file_path)
                     : $video->file_path;
               @endphp
               <div class="col-lg-4 col-md-6">
                  <div class="card border-0 shadow-sm h-100">
                     <div class="ratio ratio-16x9">
                        <iframe
                           src="{{ $src }}"
                           title="{{ $video->title }}"
                           allowfullscreen
                           frameborder="0"
                           loading="lazy"
                        ></iframe>
                     </div>
                     @if($video->title)
                     <div class="card-body py-2 px-3">
                        <p class="mb-0 fw-semibold small">{{ $video->title }}</p>
                        @if($video->short_description)
                           <p class="mb-0 text-muted small">{{ $video->short_description }}</p>
                        @endif
                     </div>
                     @endif
                  </div>
               </div>
            @endforeach
         </div>
      </div>

   </section><!-- /Video Gallery Section -->
   @endif

   <!-- Contact Section -->
   <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Contact Us</h2>
         <p>Find us on the map or reach out directly — we're here to help.</p>
      </div>

      @php
         $mapEmbed = $organizationInfo->google_map_embed ?? null;
         $mapLink  = $organizationInfo->google_map_link  ?? null;
         // fallback hardcoded embed if admin hasn't set one yet
         $fallbackEmbed = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.9002970426773!2d90.38418017431287!3d23.750934578669966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b99d90587569%3A0x9f276ae22c464021!2sHealth%20and%20Hope%20Doctor%27s%20Chamber!5e0!3m2!1sen!2sbd!4v1775530141075!5m2!1sen!2sbd';
         $embedSrc = $mapEmbed ?: $fallbackEmbed;
      @endphp

      {{-- ── Map + Location Card ── --}}
      <div class="container mb-4" data-aos="fade-up" data-aos-delay="100">
         <div class="loc-map-wrap">

            {{-- Google Map iframe --}}
            <div class="loc-map-frame">
               <iframe
                  src="{{ $embedSrc }}"
                  style="border:0; width:100%; height:100%;"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade">
               </iframe>
            </div>

            {{-- Location Details Card --}}
            <div class="loc-info-card">

               {{-- Header --}}
               <div class="loc-card-header">
                  <span class="loc-pin-icon">
                     <i class="bi bi-geo-alt-fill"></i>
                  </span>
                  <div>
                     <p class="loc-card-label">Find Us Here</p>
                     <h5 class="loc-card-title">Our Location</h5>
                  </div>
               </div>

               {{-- Org name --}}
               @if(!empty($organizationInfo->name))
                  <p class="loc-org-name">{{ $organizationInfo->name }}</p>
               @endif

               {{-- Address --}}
               @php $displayAddress = $organizationInfo->address ?? '152/2/G Panthapath, Dhaka-1205'; @endphp
               <div class="loc-detail-row">
                  <span class="loc-detail-icon"><i class="bi bi-map"></i></span>
                  <span class="loc-detail-text">{{ $displayAddress }}</span>
               </div>

               {{-- Divider --}}
               <div class="loc-divider"></div>

               {{-- Phone --}}
               @if(!empty($organizationInfo->mobile))
               <div class="loc-detail-row">
                  <span class="loc-detail-icon"><i class="bi bi-telephone-fill"></i></span>
                  <a href="tel:{{ $organizationInfo->mobile }}" class="loc-detail-link">{{ $organizationInfo->mobile }}</a>
               </div>
               @endif

               {{-- Email --}}
               @if(!empty($organizationInfo->email))
               <div class="loc-detail-row mt-1">
                  <span class="loc-detail-icon"><i class="bi bi-envelope-fill"></i></span>
                  <a href="mailto:{{ $organizationInfo->email }}" class="loc-detail-link">{{ $organizationInfo->email }}</a>
               </div>
               @endif

               {{-- Open in Maps button --}}
               @php
                  $mapsHref = $mapLink ?: 'https://maps.google.com/?q=' . urlencode($displayAddress);
               @endphp
               <a href="{{ $mapsHref }}" target="_blank" rel="noopener" class="loc-open-btn">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                     <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                  Open in Google Maps
                  <i class="bi bi-arrow-up-right-square ms-1" style="font-size:.75rem;"></i>
               </a>

            </div>
         </div>
      </div>

      <style>
         .loc-map-wrap {
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(44,73,100,.13);
            min-height: 380px;
         }
         .loc-map-frame {
            flex: 1 1 0;
            min-height: 380px;
         }
         .loc-info-card {
            width: 300px;
            flex-shrink: 0;
            background: #fff;
            border-left: 4px solid var(--accent-color);
            padding: 2rem 1.6rem;
            display: flex;
            flex-direction: column;
         }
         .loc-card-header {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: 1.2rem;
         }
         .loc-pin-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: color-mix(in srgb, var(--accent-color), transparent 88%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.25rem;
            color: var(--accent-color);
         }
         .loc-card-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--accent-color);
            margin: 0 0 .1rem;
         }
         .loc-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--heading-color);
            margin: 0;
         }
         .loc-org-name {
            font-size: .82rem;
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: .5rem;
            padding: .4rem .75rem;
            background: color-mix(in srgb, var(--heading-color), transparent 93%);
            border-radius: 6px;
         }
         .loc-detail-row {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            margin-bottom: .6rem;
         }
         .loc-detail-icon {
            width: 26px; height: 26px;
            border-radius: 6px;
            background: color-mix(in srgb, var(--accent-color), transparent 90%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: .78rem;
            color: var(--accent-color);
            margin-top: .1rem;
         }
         .loc-detail-text {
            font-size: .83rem;
            color: var(--default-color);
            line-height: 1.55;
         }
         .loc-detail-link {
            font-size: .83rem;
            color: var(--default-color);
            text-decoration: none;
            transition: color .2s;
         }
         .loc-detail-link:hover { color: var(--accent-color); }
         .loc-divider {
            height: 1px;
            background: color-mix(in srgb, var(--heading-color), transparent 88%);
            margin: .9rem 0;
         }
         .loc-open-btn {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .6rem 1rem;
            border-radius: 8px;
            background: var(--accent-color);
            color: #fff !important;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none !important;
            transition: background .25s, transform .2s, box-shadow .25s;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--accent-color), transparent 55%);
         }
         .loc-open-btn:hover {
            background: color-mix(in srgb, var(--accent-color), #000 15%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px color-mix(in srgb, var(--accent-color), transparent 40%);
         }
         @media (max-width: 768px) {
            .loc-map-wrap { flex-direction: column; }
            .loc-map-frame { min-height: 260px; }
            .loc-info-card { width: 100%; border-left: none; border-top: 4px solid var(--accent-color); }
         }
      </style>

      {{-- ── Info Items Row ── --}}
      <div class="container" data-aos="fade-up" data-aos-delay="200">
         <div class="row gy-4 justify-content-center">

            @if(!empty($organizationInfo->address))
            <div class="col-lg-4 col-md-6">
               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>
                     <h3>Address</h3>
                     <p>{{ $organizationInfo->address }}</p>
                  </div>
               </div>
            </div>
            @endif

            @if(!empty($organizationInfo->mobile))
            <div class="col-lg-4 col-md-6">
               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-telephone flex-shrink-0"></i>
                  <div>
                     <h3>Call Us</h3>
                     <p><a href="tel:{{ $organizationInfo->mobile }}" style="color:inherit;">{{ $organizationInfo->mobile }}</a></p>
                  </div>
               </div>
            </div>
            @endif

            @if(!empty($organizationInfo->email))
            <div class="col-lg-4 col-md-6">
               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                     <h3>Email Us</h3>
                     <p><a href="mailto:{{ $organizationInfo->email }}" style="color:inherit;">{{ $organizationInfo->email }}</a></p>
                  </div>
               </div>
            </div>
            @endif

         </div>
      </div>

   </section><!-- /Contact Section -->

</div>
<script>
   document.addEventListener('DOMContentLoaded', () => {
      window.addEventListener('swal:success', e => {
         Swal.fire({
            icon: 'success',
            title: e.detail[0].title,
            text: e.detail[0].text,
            timer: 2000,          // optional: SweetAlert closes automatically after 5s
            timerProgressBar: true
         }).then(() => {
            // Refresh the page after the alert closes
               location.reload();
         });

         // Or, alternatively, refresh after 5 seconds regardless of whether user closes it

      });

      window.addEventListener('swal:confirm', e => {
         Swal.fire({
            icon: 'warning',
            title: e.detail.title,
            text: e.detail.text,
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
         }).then(result => {
            if (result.isConfirmed) {
               // Call the Livewire PHP method directly
            @this.delete(e.detail.id);
            }
         });
      });
   });
</script>