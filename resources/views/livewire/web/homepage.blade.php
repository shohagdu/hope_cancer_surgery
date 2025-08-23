<div>
   <!-- Hero Section -->
   <section id="hero" class="hero section light-background">
      <img src="{{ asset('website/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">
      <div class="container position-relative">
         <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
            <h2>WELCOME TO  </h2>
            <p>{{ $organizationInfo->name??'HOPE' }}</p>
         </div><!-- End Welcome -->

         <div class="content row gy-4">
            <div class="col-lg-4 d-flex align-items-stretch">
               <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                  <h3>{{ $whyChooseHighlightItem->title??'Why Choose' }} <br/> <span style="font-size:25px"> {{ $organizationInfo->name??'HOPE' }}?</span></h3>
                  <p>
                     {{ $whyChooseHighlightItem->short_description??'' }}
                  </p>
                  <div class="text-center">
                     <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
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
{{--               <img src="{{ asset('website/assets/img/about.jpg')}}" class="img-fluid" alt="">--}}
               <img src="{{ asset('website/assets/img/all_doctors.jpeg')}}" class="img-fluid" alt="">

{{--               <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>--}}
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

   <section id="doctors" class="doctors section light-background"">
   <?php
//   $doctors = [
//           [
//                   'title' => 'Dr. Md. Ashiqur Rahman',
//                   'qualifications' => 'MBBS (CMC),FCPS(Surgery)  MS (Surgical Oncology), FACS (America)',
//                   'special_training' => 'Tata Memorial Hospital, Mumbai, India & UKM Hospital, Malaysia',
//                   'positions' => [
//                           'Associate Professor, Institute of Cancer Research & Hospital, Dhaka'
//                   ]
//           ],
//           [
//                   'title' => 'Dr. Mitun Kumar Mallick',
//                   'qualifications' => 'MBBS, BCS(Health), MS (Surgical Oncology)',
//                   'special_training' => 'Genito Unrinary Surgical Oncology Institute of Cancer Research & Hospital, Dhaka',
//                   'positions' => [
//                           'Surgical Oncology, Institute of Cancer Research & Hospital, Dhaka'
//                   ]
//           ],
//           [
//                   'title' => 'Dr. Muhammad Syeef Khalid',
//                   'qualifications' => 'MBBS, MS (Surgical Oncology), MRCS (England)',
//                   'special_training' => 'Endoscopy and Colonscopy Basic Laparospic Surgery',
//                   'positions' => [
//                           'Ex-Registrar, Surgical Oncology, Institute of Cancer Research & Hospital, Dhaka',
//                           'Life Member, Society of Endro-laparoscopic Surgeons of Bangladesh',
//                   ]
//           ],
//   ];

   ?>
   <div class="container section-title" data-aos="fade-up">
      <h2>Doctors</h2>
      <p>Meet our team of highly qualified and experienced cancer surgeons dedicated to providing compassionate, advanced, and personalized care for every patient.</p>
   </div><!-- End Section Title -->
   <div class="container">
      <div class="row gy-4">
         @foreach($doctors as $index => $doctor)
            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
               <div class="team-member d-flex align-items-start">
                  <div class="pic">
{{--                     <img src="{{ asset('storage/assets/img/doctors/doctors-3.jpg') }}" class="img-fluid" alt="{{ $doctor['name'] }}">--}}
                     <img src="{{ $doctor->picture_url }}" class="img-fluid" alt="{{ $doctor->name }}">

                  </div>
                  <div class="member-info">
                     <h4>{{ $doctor['name'] }}</h4>
                     <div>{{ $doctor['qualifications'] }}</div>
                     <p>Special Training: {{ $doctor['special_training'] }}</p>

                     @if(!empty($doctor['positions']))
                        <ul class="mt-2 ml-4 list-disc list-inside">
                           @foreach(explode("\n", $doctor['positions']) as $position)
                              @if(!empty(trim($position)))
                                 <li>{{ $position }}</li>
                              @endif
                           @endforeach
                        </ul>
                     @endif

{{--                     <div class="social">--}}
{{--                        <a href="#"><i class="bi bi-twitter-x"></i></a>--}}
{{--                        <a href="#"><i class="bi bi-facebook"></i></a>--}}
{{--                        <a href="#"><i class="bi bi-instagram"></i></a>--}}
{{--                        <a href="#"><i class="bi bi-linkedin"></i></a>--}}
{{--                     </div>--}}
                  </div>
               </div>
            </div><!-- End Team Member -->
         @endforeach

      </div>

   </div>

   </section><!-- /Doctors Section -->


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
              <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Our Treatment Area</h2>
      </div>
      <div class="container">
         <h4 class="pb-2">Cancer Treatment & Consultation Services Provided For:</h4>
         <div class="row gy-4">
            @if($service_treatment)
               @foreach($service_treatment as $key=> $row)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                         <div class="service-item  position-relative">
                            <div class="icon">
                             <i class="{{ !empty($row->icon)?$row->icon:'fa-solid fa-user-doctor' }}"></i>
                            </div>
                            <a href="#" class="stretched-link">
                             <h3>{{ $row['title'] }}</h3>
                            </a>
                            <p>{{ $row['description'] }}</p>
                         </div>
                    </div>
               @endforeach
            @else
               @foreach($ctg as $key=> $row)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-item  position-relative">
                        <div class="icon">
                           <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <a href="#" class="stretched-link">
                           <h3>{{ $row['title'] }}</h3>
                        </a>
                        <p>{{ $row['description'] }}</p>
                     </div>
                  </div>
               @endforeach
            @endif
         </div>
         <h4 class="pt-4 pb-2">Emergency Services Provided:</h4>
         <div class="row gy-4">
            @if($service_emergency)
               @foreach($service_emergency as $key=> $row)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-item  position-relative">
                        <div class="icon">
                           <i class="{{ !empty($row->icon)?$row->icon:'fa-solid fa-user-doctor' }}"></i>
                        </div>
                        <a href="#" class="stretched-link">
                           <h3>{{ $row['title'] }}</h3>
                        </a>
                        <p>{{ $row['description'] }}</p>
                     </div>
                  </div>
               @endforeach
            @else
               @foreach($emergencyServices as $key=> $row)
                  <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-item  position-relative">
                        <div class="icon">
                           <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <a href="#" class="stretched-link">
                           <h3>{{ $row['title'] }}</h3>
                        </a>
                        <p>{{ $row['description'] }}</p>
                     </div>
                  </div>
               @endforeach
            @endif
         </div>
      </div>

   </section>

   <!-- Appointment Section -->
   <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Appointment</h2>
         <p>Book an appointment with our expert cancer specialists for consultation, diagnosis, or treatment. We are committed to providing timely and compassionate care to every patient.</p>

      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

         <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
            <div class="form-group mt-3">
               <select name="doctor" id="doctor" class="form-select" required="">
                  <option value="">Select Doctor</option>
                  <option value="Doctor 1">Doctor 1</option>
               </select>
            </div>
            <div class="form-group mt-3">
               <input type="datetime-local" name="date" class="form-control datepicker" id="date" placeholder="Appointment Date" required="">
            </div>
            <div class="form-group mt-3">
               <input type="text" name="name" class="form-control" id="name" placeholder="Patient Name" required="">
            </div>
            <div class="form-group mt-3">
               <input type="tel" class="form-control" name="phone" id="phone" placeholder="Mobile" required="">
            </div>
            <div class="form-group mt-3">
               <select name="doctor" id="doctor" class="form-select" required="">
                  <option value="">Select Gender</option>
                  <option value="1">Male</option>
                  <option value="2">Female</option>
                  <option value="3">Others</option>
               </select>
            </div>
            <div class="form-group mt-3">
               <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
            </div>
            <div class="mt-3">
               <div class="loading">Loading</div>
               <div class="error-message"></div>
               <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
               <div ><button type="submit">Submit</button></div>
            </div>
         </form>
      </div>
   </section><!-- /Appointment Section -->



   <!-- Faq Section -->
   <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Frequently Asked Questions</h2>
         <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

         <div class="row justify-content-center">

            <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

               <div class="faq-container">
                  @if($faqInfo)
                     @foreach($faqInfo as $key=> $faqRow)
                        <div class="faq-item {{ $key==0?"faq-active":'' }} ">
                           <h3>{{ $faqRow->title??'' }}</h3>
                           <div class="faq-content">
                              <p>{{ $faqRow->description??'' }}</p>
                           </div>
                           <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                     @endforeach
                  @else
                     <div class="faq-item faq-active">
                        <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                        <div class="faq-content">
                           <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                     </div><!-- End Faq item-->
                  @endif
               </div>

            </div><!-- End Faq Column-->

         </div>

      </div>

   </section><!-- /Faq Section -->

   <!-- Testimonials Section -->
   <section id="testimonials" class="testimonials section">

      <div class="container">

         <div class="row align-items-center">

            <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
               <h3>Testimonials</h3>
               <p>
                  Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
               </p>
            </div>

            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">

               <div class="swiper init-swiper">
                  <script type="application/json" class="swiper-config">
                            {
                              "loop": true,
                              "speed": 600,
                              "autoplay": {
                                "delay": 5000
                              },
                              "slidesPerView": "auto",
                              "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                              }
                            }
                        </script>
                  <div class="swiper-wrapper">
                     @if(!empty($testimonial))
                        @foreach($testimonial as $testimonialRow)
                           <div class="swiper-slide">
                              <div class="testimonial-item">
                                 <div class="d-flex">
                                    @if(!empty($testimonialRow->picture_url))
                                       <img src="{{ $testimonialRow->picture_url }}" class="testimonial-img flex-shrink-0" alt="">
                                    @else
                                     <img src="{{ asset('website/assets/img/testimonials/testimonials-1.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                    @endif
                                    <div>
                                       <h3>{{ $testimonialRow->title??'-' }}</h3>
                                       <h4>{{ $testimonialRow->short_description??'-' }}</h4>
                                       <div class="stars">
                                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                       </div>
                                    </div>
                                 </div>
                                 <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>{{ $testimonialRow->description??'-' }}</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                 </p>
                              </div>
                           </div>
                        @endforeach
                     @endif
                     <!-- End testimonial item -->

{{--                     <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                           <div class="d-flex">--}}
{{--                              <img src="{{ asset('website/assets/img/testimonials/testimonials-2.jpg')}}" class="testimonial-img flex-shrink-0" alt="">--}}
{{--                              <div>--}}
{{--                                 <h3>Sara Wilsson</h3>--}}
{{--                                 <h4>Designer</h4>--}}
{{--                                 <div class="stars">--}}
{{--                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                 </div>--}}
{{--                              </div>--}}
{{--                           </div>--}}
{{--                           <p>--}}
{{--                              <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                              <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>--}}
{{--                              <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                           </p>--}}
{{--                        </div>--}}
{{--                     </div><!-- End testimonial item -->--}}

{{--                     <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                           <div class="d-flex">--}}
{{--                              <img src="{{ asset('website/assets/img/testimonials/testimonials-3.jpg')}}" class="testimonial-img flex-shrink-0" alt="">--}}
{{--                              <div>--}}
{{--                                 <h3>Jena Karlis</h3>--}}
{{--                                 <h4>Store Owner</h4>--}}
{{--                                 <div class="stars">--}}
{{--                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                 </div>--}}
{{--                              </div>--}}
{{--                           </div>--}}
{{--                           <p>--}}
{{--                              <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                              <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>--}}
{{--                              <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                           </p>--}}
{{--                        </div>--}}
{{--                     </div><!-- End testimonial item -->--}}

{{--                     <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                           <div class="d-flex">--}}
{{--                              <img src="{{ asset('website/assets/img/testimonials/testimonials-4.jpg')}}" class="testimonial-img flex-shrink-0" alt="">--}}
{{--                              <div>--}}
{{--                                 <h3>Matt Brandon</h3>--}}
{{--                                 <h4>Freelancer</h4>--}}
{{--                                 <div class="stars">--}}
{{--                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                 </div>--}}
{{--                              </div>--}}
{{--                           </div>--}}
{{--                           <p>--}}
{{--                              <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                              <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>--}}
{{--                              <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                           </p>--}}
{{--                        </div>--}}
{{--                     </div><!-- End testimonial item -->--}}

{{--                     <div class="swiper-slide">--}}
{{--                        <div class="testimonial-item">--}}
{{--                           <div class="d-flex">--}}
{{--                              <img src="{{ asset('website/assets/img/testimonials/testimonials-5.jpg')}}" class="testimonial-img flex-shrink-0" alt="">--}}
{{--                              <div>--}}
{{--                                 <h3>John Larson</h3>--}}
{{--                                 <h4>Entrepreneur</h4>--}}
{{--                                 <div class="stars">--}}
{{--                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>--}}
{{--                                 </div>--}}
{{--                              </div>--}}
{{--                           </div>--}}
{{--                           <p>--}}
{{--                              <i class="bi bi-quote quote-icon-left"></i>--}}
{{--                              <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>--}}
{{--                              <i class="bi bi-quote quote-icon-right"></i>--}}
{{--                           </p>--}}
{{--                        </div>--}}
{{--                     </div><!-- End testimonial item -->--}}

                  </div>
                  <div class="swiper-pagination"></div>
               </div>

            </div>

         </div>

      </div>

   </section><!-- /Testimonials Section -->

   <!-- Gallery Section -->
   <section id="gallery" class="gallery section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Gallery</h2>
         <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

         <div class="row g-0">

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-1.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-1.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-2.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-2.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-3.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-3.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-4.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-4.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-5.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-5.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-6.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-6.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-7.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-7.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

            <div class="col-lg-3 col-md-4">
               <div class="gallery-item">
                  <a href="{{ asset('website/assets/img/gallery/gallery-8.jpg')}}" class="glightbox" data-gallery="images-gallery">
                     <img src="{{ asset('website/assets/img/gallery/gallery-8.jpg')}}" alt="" class="img-fluid">
                  </a>
               </div>
            </div><!-- End Gallery Item -->

         </div>

      </div>

   </section><!-- /Gallery Section -->

   <!-- Contact Section -->
   <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
         <h2>Contact</h2>
         <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
         <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

         <div class="row gy-4">

            <div class="col-lg-4">
               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>

                     <h3>Location</h3>

                     <p>Health & Hope Hospital <br/> 152/2/G Panthapath, Dhaka-1205</p>

                  </div>
               </div><!-- End Info Item -->

               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-telephone flex-shrink-0"></i>
                  <div>
                     <h3>Call Us</h3>
                     <p>+1 5589 55488 55</p>
                  </div>
               </div><!-- End Info Item -->

               <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                     <h3>Email Us</h3>
                     <p>info@example.com</p>
                  </div>
               </div><!-- End Info Item -->

            </div>

            <div class="col-lg-8">
               <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                  <div class="row gy-4">

                     <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                     </div>

                     <div class="col-md-6 ">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                     </div>

                     <div class="col-md-12">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                     </div>

                     <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                     </div>

                     <div class="col-md-12 text-center">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>

                        <button type="submit">Send Message</button>
                     </div>

                  </div>
               </form>
            </div><!-- End Contact Form -->

         </div>

      </div>

   </section><!-- /Contact Section -->

</div>
