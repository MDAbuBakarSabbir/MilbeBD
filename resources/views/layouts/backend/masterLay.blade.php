@php
    $orderStatus = App\Models\OrderStatus::where('status', '1')->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Milbe BD | @yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/img/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css" integrity="sha512-ApSLB1Pd3/bZN8fWB/RG9YhN/7bd9Hkf3AGaE2mPfebjrxagjuBtx2GcgdqIlJkUzwylBo61r9Xa9NmgBI0swA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/owl-carousel/css/owl.theme.default.min.css') }}">
    <link href="{{ asset('assets/backend/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
    @stack('styles')</head>

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
        <div class="header shadow-sm bg-white" style="transition: all 0.3s ease;">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <!-- Search Bar -->
                        <div class="header-left">
                            <div class="search_bar d-none d-md-block">
                                <form class="position-relative" style="width: 260px;">
                                    <input class="form-control rounded-pill pl-4 pr-5 border-light bg-light" type="search" placeholder="Search orders..." aria-label="Search" style="height: 40px; font-size: 0.85rem; transition: all 0.3s ease;">
                                    <button class="btn btn-link position-absolute right-0 top-0 text-muted mt-2 mr-3 p-0" type="submit" style="z-index: 4; border: none; background: transparent;">
                                        <i class="mdi mdi-magnify" style="font-size: 1.2rem;"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="search_bar dropdown d-block d-md-none">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-2 m-0 shadow border-0" style="min-width: 250px;">
                                    <form class="p-1">
                                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Courier Balance Widget -->
                        <div class="courier-balance mx-3">
                            <div class="d-flex align-items-center bg-light text-primary px-3 py-2 rounded-pill shadow-xs" style="border: 1px solid rgba(102, 126, 234, 0.15);">
                                <i class="ti-wallet mr-2" style="font-size: 1.15rem; color: #667eea; line-height: 1;"></i>
                                <span class="text-dark font-weight-medium mr-2 d-none d-sm-inline" style="font-size: 0.825rem; letter-spacing: 0.02em;">Courier Balance:</span>
                                <span class="badge bg-primary text-white font-weight-bold px-2 py-1 rounded-pill" style="font-size: 0.8rem; background-color: #667eea !important;">0 ৳</span>
                            </div>
                        </div>

                        <!-- Header Right Controls -->
                        <ul class="navbar-nav header-right">
                            <!-- Notification Dropdown -->
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link position-relative" href="#" role="button" data-toggle="dropdown" style="padding: 0.5rem 1rem;">
                                    <i class="mdi mdi-bell text-secondary" style="font-size: 1.4rem;"></i>
                                    <span class="position-absolute badge rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; font-size: 0.65rem; top: 12px; right: 8px;">1</span>
                                    <div class="pulse-css" style="top: 12px; right: 8px;"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow border-0 rounded-lg p-0" style="width: 300px; overflow: hidden;">
                                    <div class="dropdown-header bg-primary text-white py-3 px-4 d-flex align-items-center justify-content-between">
                                        <h6 class="text-white mb-0 font-weight-bold" style="font-size: 0.9rem;">Notifications</h6>
                                        <span class="badge bg-white text-primary rounded-pill font-weight-bold" style="font-size: 0.75rem;">1 New</span>
                                    </div>
                                    <ul class="list-unstyled mb-0" style="max-height: 350px; overflow-y: auto;">
                                        <li class="media dropdown-item d-flex align-items-center py-3 border-bottom border-light" style="cursor: pointer; white-space: normal;">
                                            <span class="mr-3 bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; min-width: 38px; background-color: rgba(40, 167, 69, 0.1);">
                                                <i class="ti-user" style="font-size: 1rem;"></i>
                                            </span>
                                            <div class="media-body">
                                                <p class="mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.4;">
                                                    <strong>Martin</strong> added a new <strong>customer</strong> successfully
                                                </p>
                                                <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">3:20 am</small>
                                            </div>
                                        </li>
                                    </ul>
                                    <a class="all-notification text-center py-2 d-block bg-light font-weight-semibold text-primary" href="#" style="font-size: 0.8rem; text-decoration: none; border-top: 1px solid #f1f5f9;">
                                        See all notifications <i class="ti-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </li>

                            <!-- User Profile Dropdown -->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link d-flex align-items-center py-2 px-3 ml-2 rounded-pill hover-bg-light" href="#" role="button" data-toggle="dropdown" style="transition: all 0.2s;">
                                    <div class="user-avatar bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center font-weight-bold shadow-sm" style="width: 35px; height: 35px; background-color: rgba(102, 126, 234, 0.1); color: #667eea;">
                                        A
                                    </div>
                                    <span class="ml-2 d-none d-lg-inline-block text-dark font-weight-semibold" style="font-size: 0.85rem;">Admin</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow border-0 rounded-lg p-2 mt-2" style="min-width: 180px;">
                                    <a href="./app-profile.html" class="dropdown-item py-2 px-3 rounded d-flex align-items-center">
                                        <i class="icon-user text-primary mr-2" style="font-size: 0.95rem;"></i>
                                        <span style="font-size: 0.825rem;">My Profile</span>
                                    </a>
                                    <a href="./email-inbox.html" class="dropdown-item py-2 px-3 rounded d-flex align-items-center">
                                        <i class="icon-envelope-open text-success mr-2" style="font-size: 0.95rem;"></i>
                                        <span style="font-size: 0.825rem;">Inbox</span>
                                    </a>
                                    <hr class="my-2 border-light">
                                    <a href="{{ route('logout') }}" class="dropdown-item py-2 px-3 rounded text-danger d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-key mr-2" style="font-size: 0.95rem;"></i>
                                        <span style="font-size: 0.825rem; font-weight: 500;">Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
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
                    <li><a href="{{ route('dashboard') }}" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                    </li>
                    <li class="nav-label">Operations</li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Orders</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.orders.create') }}">Create Orders</a></li>
                            <li><a href="{{ route('admin.orders.index') }}">All Orders</a></li>
                            @foreach ($orderStatus as $orderS)
                                <li><a href="{{ route('admin.orders.status', $orderS->id) }}">{{ $orderS->name }}</a></li>
                            @endforeach
                            <li><a href="{{ route('admin.incomplete.view') }}">Incomplete Orders</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.product.index') }}" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Product</span></a>
                    </li>
                    <li><a href="{{ route('admin.pages.index') }}" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Pages</span></a>
                    </li>
                    <li><a href="{{ route('admin.reviews.index') }}" aria-expanded="false"><i
                                class="icon icon-single-04"></i><span class="nav-text">Customer Reviews</span></a>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                                class="icon icon-app-store"></i><span class="nav-text">Website Settings</span></a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin.siteSettings') }}">General Web Settings</a></li>
                            <li><a href="{{ route('admin.orderStatus.index') }}">Order Status Settings</a></li>
                            <li><a href="{{ route('courier-apis.index') }}">Courier API Settings</a></li>
                            <li><a href="{{ route('fraud-checkers.index') }}">Fraud API Settings</a></li>
                            <li><a href="{{ route('admin.districts.index') }}">District Settings</a></li>
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
                <p>Copyright © Designed &amp; Developed by <a href="https://www.facebook.com/sabalontech" target="_blank">SABALON TECH</a> 2026</p>
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global Session Alerts
        @if(session('success'))
            Swal.fire({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                icon: 'success', title: "{{ session('success') }}"
            });
        @endif
        @if(session('error'))
            Swal.fire({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                icon: 'error', title: "{{ session('error') }}"
            });
        @endif
        
        // Global Delete Confirmation
        function confirmDelete(e, form, message = 'Are you sure you want to delete this?') {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>

</html>
