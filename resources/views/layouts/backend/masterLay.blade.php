<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Milbe BD | @yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/backend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ asset('assets/backend/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">



</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <style>
        #preloader {
            position: fixed;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-color: #ffffff;
            z-index: 9999999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .preloader-content {
            text-align: center;
            animation: pulse 2s infinite ease-in-out;
        }
        .preloader-icon {
            margin-bottom: 15px;
        }
        .preloader-text {
            font-size: 26px;
            font-weight: 800;
            color: #2d3748;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Inter', sans-serif;
        }
        .preloader-text span {
            color: #667eea;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .loader-dots {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .loader-dots div {
            width: 12px;
            height: 12px;
            background-color: #667eea;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .loader-dots div:nth-child(1) { animation-delay: -0.32s; }
        .loader-dots div:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
    <div id="preloader">
        <div class="preloader-content">
            <div class="preloader-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
            <div class="preloader-text">MILBE <span>BD</span></div>
            <div class="loader-dots">
                <div></div><div></div><div></div>
            </div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="./images/logo.png" alt="">
                <img class="logo-compact" src="./images/logo-text.png" alt="">
                <img class="brand-title" src="./images/logo-text.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="courier-balance">
                            <span class=""><i class="ti-wallet"></i> Courier Balance: </span>
                            <span class="">0</span>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="ti-user"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> has added a <strong>customer</strong> Successfully
                                                    </p>
                                                </a>
                                            </div>
                                            <span class="notify-time">3:20 am</span>
                                        </li>
                                    </ul>
                                    <a class="all-notification" href="#">See all notifications <i
                                            class="ti-arrow-right"></i></a>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="mdi mdi-account"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./app-profile.html" class="dropdown-item">
                                        <i class="icon-user"></i>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item">
                                        <i class="icon-envelope-open"></i>
                                        <span class="ml-2">Inbox </span>
                                    </a>
                                    <a href="{{ route('logout') }}" class="dropdown-item">
                                        <i class="icon-key"></i>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="quixnav">
            <div class="quixnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
                    <li><a href="" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                    </li>
                    <li class="nav-label">Operations</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Orders</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.orders.create') }}">Create Orders</a></li>
                            <li><a href="{{ route('admin.incomplete.view') }}">Incomplete Orders</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Website Settings</span></a>
                        <ul aria-expanded="false">
                            <li><a href="">Courier API Settings</a></li>
                            <li><a href="">SMS API Settings</a></li>
                            <li><a href="">Payment API Settings</a></li>
                            <li><a href="">Fraud API Settings</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">

                @yield('content')

            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">MilbeBD.com</a> 2026</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/backend/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom.min.js') }}"></script>


    <!-- Vectormap -->
    <script src="{{ asset('assets/backend/vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/morris/morris.min.js') }}"></script>


    <script src="{{ asset('assets/backend/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/chart.js/Chart.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/backend/vendor/gaugeJS/dist/gauge.min.js') }}"></script>

    <!--  flot-chart js -->
    <script src="{{ asset('assets/backend/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/flot/jquery.flot.resize.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="{{ asset('assets/backend/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

    <!-- Counter Up -->
    <script src="{{ asset('assets/backend/vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>


    <script src="{{ asset('assets/backend/js/dashboard/dashboard-1.js') }}"></script>

</body>

</html>
