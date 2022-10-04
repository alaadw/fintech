<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="ar" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="ar" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="ar" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10" lang="ar" prefix="og: https://ogp.me/ns#"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="ar" prefix="og: https://ogp.me/ns#">
<!--<![endif]-->
<title>
    Fin tech
</title>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta name="og:type" content="website" />

<meta name="robots" content="follow, index" />
<link rel="shortcut icon" href="/images/favicon.png" />

<meta name='author_id' content='alaa' />
<meta name='author' content='' />
<meta name='category' content='' />
<meta name='keywords' content='' />
<meta name='date' content='' />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="/images/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
<link href="/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<link href="/vendor/aos/aos.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" rel="stylesheet">
<noscript>
    <meta http-equiv="refresh" content="0; url=/" />
</noscript>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                Fin Tech

            </a>

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
            <nav id="navbar " class="nav   navbar" aria-label="Secondary navigation">
                <ul class="main-menu">



                    @if (isset(auth()->user()->id) and auth()->user()->id > 0)
                        <li class="nav-item dropdown currency-drop">
                            <a class="nav-link dropdown-toggle green" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                My Profile

                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="nav-link green" href="{{ env('APP_URL') }}/">
                                        <i class=""></i> All Transactions
                                    </a>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="nav-link green" href="{{ env('APP_URL') }}/add">
                                        <i class=""></i> Add or Withdraw
                                    </a>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="nav-link green" href="{{ env('APP_URL') }}/logout"
                                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                                        role="button">
                                        <i class="fas fa-logout"></i> Logout
                                    </a>
                                </li>
                            </ul>


                            <form id="logout-form" action="{{ env('APP_URL') }}/logout" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="get-a-quote register nav-link" href="/login">
                                Login
                            </a>
                        </li>
                    @endif
                    </li>


                </ul>
            </nav>


        </div>
    </header><!-- End Header -->
    <!-- End Header -->


    <main id="main">
        @if ($errors->any())
            <div class="container alert alert-danger toremove-beforeajax mt-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} </li>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="container alert alert-success toremove-beforeajax mt-4">
                <i class="fa fa-check-circle fa-lg"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="container alert alert-danger toremove-beforeajax mt-4">
                <i class="fa fa-exclamation-triangle fa-lg"></i> {{ session('error') }}
            </div>
        @endif



        @yield('content')
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-info">
                    <a href="index.html" class="logo d-flex align-items-center">
                        Fin Tech
                    </a>


                </div>







            </div>
        </div>

        <div class="container mt-4">
            <div class="copyright">
                &copy; Copyright <strong><span> </span></strong> All Right Reserved
            </div>
            <div class="credits mt-3">

            </div>
        </div>

    </footer><!-- End Footer -->
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="/vendor/aos/aos.js"></script>
    <script src="/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/js/main.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 5,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        });
        var topcourses = new Swiper(".topcourses", {
            slidesPerView: 1,
            spaceBetween: 5,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            },
        });
    </script>

</body>

</html>
