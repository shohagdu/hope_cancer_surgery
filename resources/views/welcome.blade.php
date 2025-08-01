<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Hope - Hope centre for cancer surgery and research</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('website/assets/img/favicon.png')  }}" rel="icon">
    <link href="{{ asset('website/assets/img/apple-touch-icon.png')  }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css')  }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/bootstrap-icons/bootstrap-icons.css')  }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/aos/aos.css')  }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/fontawesome-free/css/all.min.css')  }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/glightbox/css/glightbox.min.css')  }}" rel="stylesheet">
    <link href="{{ asset('website/assets/vendor/swiper/swiper-bundle.min.css')  }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('website/assets/css/main.css')  }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Medilab
    * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
    * Updated: Aug 07 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="index-page">

<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:info@hopecancersurgery.com">info@hopecancersurgery.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+880 155 6313 500</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('website/assets/img/logo.png') }}" alt="">
{{--                <h1 class="sitename">Medilab</h1>--}}
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home<br></a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Treatment Area</a></li>
                    <li><a href="#doctors">Doctors</a></li>
{{--                    <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>--}}
{{--                        <ul>--}}
{{--                            <li><a href="#">Dropdown 1</a></li>--}}
{{--                            <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>--}}
{{--                                <ul>--}}
{{--                                    <li><a href="#">Deep Dropdown 1</a></li>--}}
{{--                                    <li><a href="#">Deep Dropdown 2</a></li>--}}
{{--                                    <li><a href="#">Deep Dropdown 3</a></li>--}}
{{--                                    <li><a href="#">Deep Dropdown 4</a></li>--}}
{{--                                    <li><a href="#">Deep Dropdown 5</a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li><a href="#">Dropdown 2</a></li>--}}
{{--                            <li><a href="#">Dropdown 3</a></li>--}}
{{--                            <li><a href="#">Dropdown 4</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <li class="dropdown"><a href="#"><span>Gallery</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#gallery">Image</a></li>
                            <li><a href="#">Viewo</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact">Article</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="cta-btn d-none d-sm-block" href="#appointment">Make an Appointment</a>

        </div>

    </div>

</header>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

        <img src="{{ asset('website/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">

        <div class="container position-relative">

            <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
                <h2>WELCOME TO  </h2>
                <p>Hope centre for cancer surgery and research</p>
            </div><!-- End Welcome -->

            <div class="content row gy-4">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                        <h3>Why Choose <br/> <span style="font-size:25px"> Hope centre for cancer surgery and research?</span></h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                            Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad corporis.
                        </p>
                        <div class="text-center">
                            <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Why Box -->

                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="row gy-4">

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                    <i class="bi bi-clipboard-data"></i>
                                    <h4>Corporis voluptates officia eiusmod</h4>
                                    <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                                    <i class="bi bi-gem"></i>
                                    <h4>Ullamco laboris ladore pan</h4>
                                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                                    <i class="bi bi-inboxes"></i>
                                    <h4>Labore consequatur incidid dolore</h4>
                                    <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                                </div>
                            </div><!-- End Icon Box -->

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
                    <img src="{{ asset('website/assets/img/about.jpg')}}" class="img-fluid" alt="">
                    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
                </div>

                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <h3>About Us</h3>
                    <p>
                        Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti. Sit quia molestiae quia quas qui magnam itaque veritatis dolores. Corrupti totam ut eius incidunt reiciendis veritatis asperiores placeat.
                    </p>
                    <ul>
                        <li>
                            <i class="fa-solid fa-vial-circle-check"></i>
                            <div>
                                <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                                <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-pump-medical"></i>
                            <div>
                                <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                                <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
                            </div>
                        </li>
                        <li>
                            <i class="fa-solid fa-heart-circle-xmark"></i>
                            <div>
                                <h5>Voluptatem et qui exercitationem</h5>
                                <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime veniam</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </section><!-- /About Section -->

    <section id="doctors" class="doctors section light-background"">
        <?php
        $doctors = [
            [
                'title' => 'Dr. Md. Ashiqur Rahman',
                'qualifications' => 'MBBS (CMC),FCPS(Surgery)  MS (Surgical Oncology), FACS (America)',
                'special_training' => 'Tata Memorial Hospital, Mumbai, India & UKM Hospital, Malaysia',
                'positions' => [
                    'Associate Professor, Institute of Cancer Research & Hospital, Dhaka'
                ]
            ],
            [
                'title' => 'Dr. Mitun Kumar Mallick',
                'qualifications' => 'MBBS, BCS(Health), MS (Surgical Oncology)',
                'special_training' => 'Genito Unrinary Surgical Oncology Institute of Cancer Research & Hospital, Dhaka',
                'positions' => [
                    'Surgical Oncology, Institute of Cancer Research & Hospital, Dhaka'
                ]
            ],
            [
                'title' => 'Dr. Muhammad Syeef Khalid',
                'qualifications' => 'MBBS, MS (Surgical Oncology), MRCS (England)',
                'special_training' => 'Endoscopy and Colonscopy Basic Laparospic Surgery',
                'positions' => [
                    'Ex-Registrar, Surgical Oncology, Institute of Cancer Research & Hospital, Dhaka',
                    'Life Member, Society of Endro-laparoscopic Surgeons of Bangladesh',
                ]
            ],
        ];

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
                                <img src="{{ asset('website/assets/img/doctors/doctors-3.jpg') }}" class="img-fluid" alt="{{ $doctor['title'] }}">
                            </div>
                            <div class="member-info">
                                <h4>{{ $doctor['title'] }}</h4>
                                <span>{{ $doctor['qualifications'] }}</span>
                                <p>Special Training: {{ $doctor['special_training'] }}</p>
                                <ul>
                                    @foreach($doctor['positions'] as $position)
                                        <li>{{ $position }}</li>
                                    @endforeach
                                </ul>
                                <div class="social">
                                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                    <a href="#"><i class="bi bi-instagram"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                @endforeach

            </div>

        </div>

    </section><!-- /Doctors Section -->

    <!-- Stats Section -->
{{--    <section id="stats" class="stats section light-background">--}}

{{--        <div class="container" data-aos="fade-up" data-aos-delay="100">--}}

{{--            <div class="row gy-4">--}}

{{--                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">--}}
{{--                    <i class="fa-solid fa-user-doctor"></i>--}}
{{--                    <div class="stats-item">--}}
{{--                        <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>--}}
{{--                        <p>Doctors</p>--}}
{{--                    </div>--}}
{{--                </div><!-- End Stats Item -->--}}

{{--                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">--}}
{{--                    <i class="fa-regular fa-hospital"></i>--}}
{{--                    <div class="stats-item">--}}
{{--                        <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1" class="purecounter"></span>--}}
{{--                        <p>Departments</p>--}}
{{--                    </div>--}}
{{--                </div><!-- End Stats Item -->--}}

{{--                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">--}}
{{--                    <i class="fas fa-flask"></i>--}}
{{--                    <div class="stats-item">--}}
{{--                        <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>--}}
{{--                        <p>Research Labs</p>--}}
{{--                    </div>--}}
{{--                </div><!-- End Stats Item -->--}}

{{--                <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">--}}
{{--                    <i class="fas fa-award"></i>--}}
{{--                    <div class="stats-item">--}}
{{--                        <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>--}}
{{--                        <p>Awards</p>--}}
{{--                    </div>--}}
{{--                </div><!-- End Stats Item -->--}}

{{--            </div>--}}

{{--        </div>--}}

{{--    </section><!-- /Stats Section -->--}}

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
            </div>
            <h4 class="pt-4 pb-2">Emergency Services Provided:</h4>
            <div class="row gy-4">
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

                        <div class="faq-item faq-active">
                            <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                            <div class="faq-content">
                                <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Feugiat scelerisque varius morbi enim nunc faucibus?</h3>
                            <div class="faq-content">
                                <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                            <div class="faq-content">
                                <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                            <div class="faq-content">
                                <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Tempus quam pellentesque nec nam aliquam sem et tortor?</h3>
                            <div class="faq-content">
                                <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                            <div class="faq-content">
                                <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non sed in suscipit sequi. Distinctio ipsam dolore et.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

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

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="d-flex">
                                        <img src="{{ asset('website/assets/img/testimonials/testimonials-1.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                        <div>
                                            <h3>Saul Goodman</h3>
                                            <h4>Ceo &amp; Founder</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="d-flex">
                                        <img src="{{ asset('website/assets/img/testimonials/testimonials-2.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                        <div>
                                            <h3>Sara Wilsson</h3>
                                            <h4>Designer</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="d-flex">
                                        <img src="{{ asset('website/assets/img/testimonials/testimonials-3.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                        <div>
                                            <h3>Jena Karlis</h3>
                                            <h4>Store Owner</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="d-flex">
                                        <img src="{{ asset('website/assets/img/testimonials/testimonials-4.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                        <div>
                                            <h3>Matt Brandon</h3>
                                            <h4>Freelancer</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->

                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="d-flex">
                                        <img src="{{ asset('website/assets/img/testimonials/testimonials-5.jpg')}}" class="testimonial-img flex-shrink-0" alt="">
                                        <div>
                                            <h3>John Larson</h3>
                                            <h4>Entrepreneur</h4>
                                            <div class="stars">
                                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        <i class="bi bi-quote quote-icon-left"></i>
                                        <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                                        <i class="bi bi-quote quote-icon-right"></i>
                                    </p>
                                </div>
                            </div><!-- End testimonial item -->

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

</main>

<footer id="footer" class="footer light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="#" class="logo d-flex align-items-center">
                    <span class="sitename">HOPE</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>Health & Hope Hospital</p>
                    <p>152/2/G Panthapath</p>
                    <p> Dhaka-1205</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>info@example.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Cancer Treatment</a></li>
                    <li><a href="#">Surgical Oncology</a></li>
                    <li><a href="#">Radiation Therapy</a></li>
                    <li><a href="#">Chemotherapy</a></li>
                    <li><a href="#">Patient Support</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Cancer Treatment</a></li>
                    <li><a href="#">Surgical Oncology</a></li>
                    <li><a href="#">Radiation Therapy</a></li>
                    <li><a href="#">Chemotherapy</a></li>
                    <li><a href="#">Patient Support</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Cancer Treatment</a></li>
                    <li><a href="#">Surgical Oncology</a></li>
                    <li><a href="#">Radiation Therapy</a></li>
                    <li><a href="#">Chemotherapy</a></li>
                    <li><a href="#">Patient Support</a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Hope</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            Designed & Developed by  <a href="https://shohozit.com" target="_blank">Shohozit</a>
        </div>
    </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/php-email-form/validate.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/aos/aos.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/glightbox/js/glightbox.min.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/purecounter/purecounter_vanilla.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/swiper/swiper-bundle.min.js')  }}"></script>

<!-- Main JS File -->
<script src="{{ asset('website/assets/js/main.js')  }}"></script>

</body>

</html>