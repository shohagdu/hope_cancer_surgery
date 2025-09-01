<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title ?? 'Hope - Hope centre for cancer surgery and research' }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Favicons -->
    <link href="{{ asset('website/assets/img/favicon.ico')  }}" rel="icon">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="index-page">

<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <a href="mailto:{{ $organizationInfo->email??'' }}"> <i class="bi bi-envelope d-flex align-items-center"> &nbsp; {{ $organizationInfo->email??'' }}</i></a>
                <a href="tel:{{ $organizationInfo->mobile??'' }}"> <i class="bi bi-phone d-flex align-items-center ms-4"><span>{{ $organizationInfo->mobile??'' }}</span></i></a>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                @isset($organizationInfo->fb)
                    <a href="{{ $organizationInfo->fb }}" class="facebook"><i class="bi bi-facebook"></i></a>
                @endisset
                @isset($organizationInfo->twitter)
                    <a href="{{ $organizationInfo->twitter }}" class="twitter"><i class="bi bi-twitter-x"></i></a>
                @endisset
                @isset($organizationInfo->tiktok)
                    <a href="{{ $organizationInfo->tiktok }}" class="instagram"><i class="bi bi-instagram"></i></a>
                @endisset
                @isset($organizationInfo->linkedin)
                    <a href="{{ $organizationInfo->linkedin }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                @endisset
            </div>
        </div>
    </div><!-- End Top Bar -->
    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ asset('website/assets/img/logo.png') }}" alt="">
                {{--                <h1 class="sitename">Medilab</h1>--}}
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active">Home<br></a></li>
                    <li><a href="{{ url('/#about') }}">About Us</a></li>
                    <li><a href="{{ url('/#services') }}">Treatment Area</a></li>
                    <li><a href="{{ url('/#doctors') }}">Doctors</a></li>
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
                            <li><a href="{{ url('/#gallery') }}">Image</a></li>
{{--                            <li><a href="#gallery">Viewo</a></li>--}}
                        </ul>
                    </li>
{{--                    <li><a href="#contact">Article</a></li>--}}
                    <li><a href="{{ url('/#contact') }}">Contact Us</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="cta-btn d-none d-sm-block" href="{{ url('/#appointment') }}">Make an Appointment</a>
        </div>
    </div>
</header>

<!-- Page Content -->
<main class="main">
    {{ $slot }}
</main>

<!-- Footer -->
<footer id="footer" class="footer light-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">


                <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                    <span class="sitename">{{ $organizationInfo->name??'' }}</span>
                </a>
                <div class="footer-contact pt-3">
                    @if(!empty($organizationInfo->address))
                        @foreach(explode("\n", $organizationInfo->address) as $address)
                            @if(!empty(trim($address)))
                                <p>{{ $address }}</p>
                            @endif
                        @endforeach
                    @endif
                    <p class="mt-3"><strong>Phone:</strong> <span>{{ $organizationInfo->mobile??'' }}</span></p>
                    <p><strong>Email:</strong> <span>{{ $organizationInfo->email??'' }}</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    @isset($organizationInfo->fb)
                        <a href="{{ $organizationInfo->fb }}" ><i class="bi bi-facebook"></i></a>
                    @endisset
                    @isset($organizationInfo->twitter)
                        <a href="{{ $organizationInfo->twitter }}" ><i class="bi bi-twitter-x"></i></a>
                    @endisset
                    @isset($organizationInfo->tiktok)
                        <a href="{{ $organizationInfo->tiktok }}" ><i class="bi bi-instagram"></i></a>
                    @endisset
                    @isset($organizationInfo->linkedin)
                        <a href="{{ $organizationInfo->linkedin }}" ><i class="bi bi-linkedin"></i></a>
                    @endisset

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
{{--<div id="preloader"></div>--}}

<!-- Vendor JS Files -->
<script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/php-email-form/validate.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/aos/aos.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/glightbox/js/glightbox.min.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/purecounter/purecounter_vanilla.js')  }}"></script>
<script src="{{ asset('website/assets/vendor/swiper/swiper-bundle.min.js')  }}"></script>

<!-- Main JS File -->
<script src="{{ asset('website/assets/js/main.js')  }}"></script>
@livewireScripts
</body>
</html>
