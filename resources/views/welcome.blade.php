@php
    $pages = App\Models\Pages::where('status', '1')->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MilbeBD | Premium Offers & Shop</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Styles -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #ec4899;
            --accent: #10b981;
            --dark: #0f172a;
            --light: #f8fafc;
            --card-shadow: 0 12px 30px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: #334155;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Glassmorphism Sticky Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }
        
        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #475569 !important;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Gradients & Themes */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-section {
            background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.04) 0%, rgba(236, 72, 153, 0.04) 90%);
            padding: 8rem 0 5rem 0;
        }

        .product-section {
            padding: 5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* Countdown circular timer cards */
        .countdown-container {
            display: flex;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .countdown-box {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 0.75rem 1rem;
            min-width: 75px;
            text-align: center;
            border: 1px solid rgba(79, 70, 229, 0.08);
            transition: var(--transition);
        }

        .countdown-box:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
        }

        .countdown-val {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .countdown-lbl {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-top: 0.25rem;
            font-weight: 600;
        }

        /* Hover image animations */
        .img-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            transition: var(--transition);
        }

        .img-container:hover {
            transform: scale(1.02);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }

        .img-container img {
            transition: var(--transition);
        }

        /* Primary Call-to-action buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: white !important;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
        }

        /* Testimonials Carousel */
        .reviews-section {
            background: linear-gradient(180deg, #ffffff 0%, var(--light) 100%);
            padding: 5rem 0;
        }

        .review-card {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: var(--card-shadow);
            padding: 2.5rem;
            max-width: 750px;
            margin: 0 auto;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .review-stars i {
            color: #f59e0b;
            font-size: 1.25rem;
            margin: 0 1px;
        }

        .avatar-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Order Form Styles */
        .order-section {
            padding: 6rem 0;
            background: radial-gradient(circle at 90% 10%, rgba(236, 72, 153, 0.04) 0%, rgba(79, 70, 229, 0.04) 100%);
        }

        .order-card {
            border: none;
            border-radius: 24px;
            background: white;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            padding: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .form-floating > .form-control {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            transition: var(--transition);
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
        }

        /* Floating Animation */
        @keyframes floatAnim {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating-element {
            animation: floatAnim 5s ease-in-out infinite;
        }

        /* Footer */
        .footer-custom {
            background-color: var(--dark);
            color: #94a3b8;
            padding: 4rem 0 2rem 0;
        }

        .footer-custom a {
            color: #94a3b8;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-custom a:hover {
            color: white;
        }

        .footer-logo {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.75rem;
            color: white !important;
        }

        /* How It Works custom styles */
        .how-it-works-section {
            padding: 6rem 0;
            background-color: var(--light);
        }
        .step-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2rem;
            border: 1px solid rgba(0, 0, 0, 0.02);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            height: 100%;
        }
        .step-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        .step-icon-wrap {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.25);
        }

        /* Product Selection Table Styles */
        .product-select-section {
            padding: 5rem 0;
            background: white;
        }
        .table-premium-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0, 0, 0, 0.04);
            background: white;
        }
        .table-premium {
            margin-bottom: 0;
        }
        .table-premium thead {
            color: white;
        }
        .table-premium thead th {
            background-color: var(--dark) !important;
            color: white !important;
            padding: 1.2rem 1rem;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.02em;
            border-bottom: none;
            vertical-align: middle;
        }
        /* Custom color dots selection */
        .color-dot {
            border-color: #e2e8f0 !important;
            transition: var(--transition);
            cursor: pointer;
            background-color: white !important;
        }
        .color-dot:hover {
            border-color: #cbd5e1 !important;
        }
        .btn-check:checked + .color-dot {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2) !important;
        }
        .table-premium tbody td, 
        .table-premium tbody th {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .table-premium tbody tr:last-child td,
        .table-premium tbody tr:last-child th {
            border-bottom: none;
        }
        .product-thumb {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }
        
        /* Billing & Delivery Section Styles */
        .billing-summary {
            background: var(--light);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1.5px dashed rgba(79, 70, 229, 0.2);
            margin-bottom: 1.5rem;
        }
        .delivery-option-box {
            background: var(--light);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            transition: var(--transition);
        }
        .delivery-option-box:hover {
            border-color: var(--primary);
        }

        /* Razor vs Mini Shaver Comparison Section */
        .comparison-section {
            background-color: #161619;
            padding: 5rem 0;
            color: #ffffff;
        }

        .comparison-title {
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 2.5rem;
        }

        .comparison-container {
            max-width: 760px;
            margin: 0 auto;
            background: #232327;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .comparison-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .comparison-table th,
        .comparison-table td {
            padding: 1.1rem 1rem;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .comparison-table tr:last-child th,
        .comparison-table tr:last-child td {
            border-bottom: none;
        }

        /* Column 1: Feature labels */
        .comparison-table th.feature-col,
        .comparison-table td.feature-col {
            width: 38%;
            background-color: #2b2b30;
            text-align: left;
            padding-left: 1.5rem;
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            font-family: 'Hind Siliguri', sans-serif;
        }

        /* Column 2: Normal Razor */
        .comparison-table th.razor-col,
        .comparison-table td.razor-col {
            width: 31%;
            background-color: #232327;
            color: #94a3b8;
        }

        /* Column 3: Mini Shaver (Highlighted) */
        .comparison-table th.shaver-col,
        .comparison-table td.shaver-col {
            width: 31%;
            background-color: #351c1c;
            color: #ff5252;
        }

        .comparison-header-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .razor-header-icon {
            background-color: #333338;
            color: #94a3b8;
        }

        .shaver-header-icon {
            background-color: #4a2222;
            border: 2px solid #ff5252;
            overflow: hidden;
        }

        .shaver-header-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comparison-header-title {
            font-family: 'Hind Siliguri', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .shaver-header-title {
            color: #ff5252;
        }

        .razor-header-title {
            color: #cbd5e1;
        }

        .cross-icon {
            color: #818cf8;
            color: #a1a1aa;
            font-weight: 900;
            font-size: 1.25rem;
            line-height: 1;
            display: block;
            margin-bottom: 0.25rem;
        }

        .check-icon {
            color: #ff5252;
            font-weight: 900;
            font-size: 1.25rem;
            line-height: 1;
            display: block;
            margin-bottom: 0.25rem;
        }

        .razor-text {
            color: #94a3b8;
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Hind Siliguri', sans-serif;
        }

        .shaver-text {
            color: #ff5252;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Hind Siliguri', sans-serif;
        }

        @media (max-width: 576px) {
            .comparison-title {
                font-size: 1.5rem;
            }
            .comparison-table th,
            .comparison-table td {
                padding: 0.85rem 0.4rem;
            }
            .comparison-table th.feature-col,
            .comparison-table td.feature-col {
                padding-left: 0.75rem;
                font-size: 0.85rem;
            }
            .razor-text, .shaver-text {
                font-size: 0.8rem;
            }
            .comparison-header-icon {
                width: 38px;
                height: 38px;
            }
            .comparison-header-title {
                font-size: 0.85rem;
            }
        }

        /* Image Comparison Slider */
        .compare-slider-section {
            background-color: #161619;
            padding: 2rem 0 6rem 0;
        }
        .compare-slider-title {
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 3rem;
        }
        .image-compare-wrapper {
            position: relative;
            max-width: 460px;
            height: 550px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .image-compare-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .compare-overlay {
            clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
            -webkit-clip-path: polygon(0 0, 50% 0, 50% 100%, 0 100%);
            z-index: 2;
        }
        .compare-slider-handle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 42px;
            height: 42px;
            background-color: #ff5252;
            border: 3px solid #fff;
            border-radius: 50%;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            font-weight: 900;
            pointer-events: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.4);
        }
        .compare-slider-handle::before {
            content: '';
            position: absolute;
            top: -550px;
            bottom: -550px;
            left: 50%;
            width: 2.5px;
            background-color: #ff5252;
            transform: translateX(-50%);
            z-index: -1;
        }
        .compare-slider-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            appearance: none;
            -webkit-appearance: none;
            opacity: 0;
            z-index: 10;
            cursor: ew-resize;
            margin: 0;
        }
        .compare-slider-input::-webkit-slider-thumb {
            appearance: none;
            width: 42px;
            height: 550px;
            cursor: ew-resize;
        }
        .compare-slider-input::-moz-range-thumb {
            width: 42px;
            height: 550px;
            cursor: ew-resize;
            border: none;
            background: transparent;
        }
    </style>

    {{-- google tag start --}}
        
    {{-- google tag end  --}}
    {{-- facebook pixel start --}}

    {{-- facebook pixel end  --}}

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 58px;
            padding: 0.75rem 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: var(--bs-border-radius);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
            color: #495057;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 56px;
        }
    </style>
</head>
<body>

    <!-- Sticky Header/Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-lightning-charge-fill me-2"></i>
                MilbeBD
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#terms">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#privacy">Privacy Policy</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="#order-form-section" class="btn btn-premium btn-sm py-2 px-4 shadow-sm">
                            <i class="bi bi-cart3"></i> Order Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero / Offer 1 Section -->
    <section class="hero-section" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-star-fill me-1"></i> Special Launch Offer
                    </span>
                    <h1 class="display-4 fw-extrabold mb-3">
                        Experience Premium Quality <br><span class="gradient-text">Milbe Sound Pro</span>
                    </h1>
                    <p class="lead text-muted mb-4">
                        Immerse yourself in unmatched acoustic clarity and design perfection. Our flagship product elevates every beat, note, and whisper to pure bliss.
                    </p>
                    
                    <!-- Countdown Area -->
                    <div class="d-flex flex-column align-items-center align-items-lg-start">
                        <small class="text-uppercase tracking-wider fw-bold text-secondary mb-2">Offer ending soon in:</small>
                        <div class="countdown-container mb-4">
                            <div class="countdown-box">
                                <div class="countdown-val text-days">00</div>
                                <div class="countdown-lbl">Days</div>
                            </div>
                            <div class="countdown-box">
                                <div class="countdown-val text-hours">00</div>
                                <div class="countdown-lbl">Hours</div>
                            </div>
                            <div class="countdown-box">
                                <div class="countdown-val text-minutes">00</div>
                                <div class="countdown-lbl">Min</div>
                            </div>
                            <div class="countdown-box">
                                <div class="countdown-val text-seconds">00</div>
                                <div class="countdown-lbl">Sec</div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#order-form-section" class="btn btn-premium btn-lg">
                        Claim 50% Off Now <i class="bi bi-arrow-right-short fs-5"></i>
                    </a>
                </div>
                
                <div class="col-lg-6 text-center">
                    <div class="img-container floating-element mx-auto" style="max-width: 480px;">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80" alt="Milbe Sound Pro Headphones" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 1/1; object-position: center;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Offer 2 Section -->
    <section class="product-section bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center">
                    <div class="img-container mx-auto" style="max-width: 450px;">
                        <img src="{{ asset('assets/frontend/img/waterproof.png') }}" alt="Milbe Smart Horizon Watch" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 1/1; object-position: center;">
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-fire me-1"></i> Best Seller
                    </span>
                    <h2 class="h1 mb-3">Milbe Smart Horizon Watch</h2>
                    <p class="text-muted mb-4">
                        Stay connected, monitor your workouts, and look sophisticated with our ultimate smart companion. Engineered for style, built for durability.
                    </p>

                    <a href="#order-form-section" class="btn btn-premium btn-lg">
                        Order Now <i class="bi bi-chevron-right fs-6"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Razor vs Mini Shaver Comparison Section -->
    <section class="comparison-section" id="comparison">
        <div class="container">
            <div class="text-center">
                <h2 class="comparison-title text-center">সাধারণ রেজার কেন সমাধান নয়?</h2>
            </div>
            
            <div class="comparison-container">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th class="feature-col"></th>
                            <th class="razor-col">
                                <div class="comparison-header-icon razor-header-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.5 3h-15C3.67 3 3 3.67 3 4.5v1c0 .83.67 1.5 1.5 1.5h15c.83 0 1.5-.67 1.5-1.5v-1c0-.83-.67-1.5-1.5-1.5zm-1 4H5.5v2h13V7zM11 10h2v11h-2V10z"/>
                                    </svg>
                                </div>
                                <h3 class="comparison-header-title razor-header-title">সাধারণ রেজার</h3>
                            </th>
                            <th class="shaver-col">
                                <div class="comparison-header-icon shaver-header-icon">
                                    <img src="{{ asset('assets/frontend/img/waterproof.png') }}" alt="মিনি শেভার">
                                </div>
                                <h3 class="comparison-header-title shaver-header-title">মিনি শেভার</h3>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="feature-col">কাটার ঝুঁকি</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">প্রতিবার ভয়</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">একদম নেই</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="feature-col">বল ও বগলে নিরাপদ</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">কাটার ঝুঁকি</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">শতভাগ নিরাপদ</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="feature-col">কালো দাগ / র‍্যাশ</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">দাগ পড়ে</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">পড়ে না</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="feature-col">ফোম / জেল লাগে</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">লাগে</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">লাগে না</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="feature-col">সময় লাগে</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">১০-১৫ মিনিট</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">৩০ সেকেন্ড</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="feature-col">খরচ</td>
                            <td class="razor-col">
                                <span class="cross-icon">✖</span>
                                <div class="razor-text">প্রতি মাসে খরচ</div>
                            </td>
                            <td class="shaver-col">
                                <span class="check-icon">✔</span>
                                <div class="shaver-text">একবারই খরচ</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Image Comparison Slider Section -->
    <section class="compare-slider-section">
        <div class="container text-center">
            <h2 class="compare-slider-title text-white text-center">
                স্লাইড করে <span style="color: #ff5252;">পার্থক্য</span> দেখুন
            </h2>
            
            <div class="image-compare-wrapper" id="image-compare-wrapper">
                <!-- BASE WRAPPER (After - Right Side) -->
                <div class="w-100 h-100 position-absolute top-0 start-0 z-1">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&auto=format&fit=crop&q=80" alt="After">
                    <!-- Badge -->
                    <div class="position-absolute p-3" style="top: 15px; right: 15px;">
                        <span class="badge rounded-pill px-4 py-2 fs-6" style="background-color: #ff5252; font-family: 'Hind Siliguri', sans-serif;">পরে</span>
                    </div>
                    <!-- Tags -->
                    <div class="position-absolute d-flex align-items-center gap-2" style="top: 40%; right: 15%;">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #ff5252; font-family: 'Hind Siliguri', sans-serif; font-size: 0.9rem;">স্মুথ স্কিন</span>
                        <span class="rounded-circle" style="width: 20px; height: 20px; background-color: rgba(255, 82, 82, 0.4); border: 4px solid #ff5252; box-shadow: 0 0 10px rgba(255,82,82,0.5);"></span>
                    </div>
                    <div class="position-absolute d-flex align-items-center gap-2" style="top: 60%; right: 25%;">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #ff5252; font-family: 'Hind Siliguri', sans-serif; font-size: 0.9rem;">জ্বালা নেই</span>
                        <span class="rounded-circle" style="width: 20px; height: 20px; background-color: rgba(255, 82, 82, 0.4); border: 4px solid #ff5252; box-shadow: 0 0 10px rgba(255,82,82,0.5);"></span>
                    </div>
                </div>

                <!-- OVERLAY WRAPPER (Before - Left Side) -->
                <div class="compare-overlay w-100 h-100 position-absolute top-0 start-0" id="compare-overlay">
                    <img src="https://images.unsplash.com/photo-1616260787161-558e65842cda?w=800&auto=format&fit=crop&q=80" alt="Before">
                    <!-- Badge -->
                    <div class="position-absolute p-3" style="top: 15px; left: 15px;">
                        <span class="badge rounded-pill px-4 py-2 fs-6" style="background-color: #3f3f46; border: 1px solid #52525b; font-family: 'Hind Siliguri', sans-serif;">আগে</span>
                    </div>
                    <!-- Tags -->
                    <div class="position-absolute d-flex align-items-center gap-2" style="top: 35%; left: 15%;">
                        <span class="rounded-circle" style="width: 20px; height: 20px; background-color: rgba(161, 161, 170, 0.4); border: 4px solid #a1a1aa; box-shadow: 0 0 10px rgba(161,161,170,0.5);"></span>
                        <span class="badge bg-dark rounded-pill px-3 py-2 border border-secondary" style="font-family: 'Hind Siliguri', sans-serif; font-size: 0.9rem;">লালচে র‍্যাশ</span>
                    </div>
                </div>
                
                <div class="compare-slider-handle" id="compare-slider-handle">
                    <i class="bi bi-chevron-left" style="font-size: 0.9rem; margin-right: -2px;"></i>
                    <i class="bi bi-chevron-right" style="font-size: 0.9rem; margin-left: -2px;"></i>
                </div>
                
                <input type="range" min="0" max="100" value="50" class="compare-slider-input" id="compare-slider-input">
            </div>

            <p class="text-secondary mt-4 mb-4" style="font-family: 'Hind Siliguri', sans-serif;">স্লাইডার ড্র্যাগ করে পার্থক্য দেখুন</p>

            <!-- Bottom badges -->
            <div class="d-flex justify-content-center gap-3 flex-wrap mt-2">
                <div class="px-4 py-2 rounded-pill" style="border: 1px solid rgba(255, 82, 82, 0.5); background-color: #232327; color: #fff; font-family: 'Hind Siliguri', sans-serif; font-weight: 500;">
                    <span style="color: #ff5252; font-weight: bold;" class="me-2">✔</span> কাটার ভয় নেই
                </div>
                <div class="px-4 py-2 rounded-pill" style="border: 1px solid rgba(255, 82, 82, 0.5); background-color: #232327; color: #fff; font-family: 'Hind Siliguri', sans-serif; font-weight: 500;">
                    <span style="color: #ff5252; font-weight: bold;" class="me-2">✔</span> জ্বালা-পোড়া নেই
                </div>
            </div>
        </div>
    </section>

    <!-- Offer 3 Section -->
    <section class="product-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start order-2 order-lg-1">
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-lightning-fill me-1"></i> Limited Edition
                    </span>
                    <h2 class="h1 mb-3">Milbe Velocity Running Kicks</h2>
                    <p class="text-muted mb-4">
                        Experience ultimate cushioning and style on your daily runs. Designed with high-performance breathable mesh and responsive grip outsoles.
                    </p>
                    
                    <a href="#order-form-section" class="btn btn-premium btn-lg">
                        Order Now <i class="bi bi-chevron-right fs-6"></i>
                    </a>
                </div>
                <div class="col-lg-6 text-center order-1 order-lg-2">
                    <div class="img-container mx-auto" style="max-width: 450px;">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80" alt="Milbe Velocity Running Kicks" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 1/1; object-position: center;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Offer 4 Section -->
    <section class="product-section bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center">
                    <div class="img-container mx-auto" style="max-width: 450px;">
                        <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&auto=format&fit=crop&q=80" alt="Milbe Nomad Leather Pack" class="img-fluid w-100 object-fit-cover" style="aspect-ratio: 1/1; object-position: center;">
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-award-fill me-1"></i> Highly Rated
                    </span>
                    <h2 class="h1 mb-3">Milbe Nomad Leather Pack</h2>
                    <p class="text-muted mb-4">
                        Handcrafted top-grain leather backpack built to accompany your everyday adventures. Waterproof zippers, ergonomic straps, and plenty of organized compartments.
                    </p>
                    
                    <a href="#order-form-section" class="btn btn-premium btn-lg">
                        Order Now <i class="bi bi-chevron-right fs-6"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel Section -->
    <section class="reviews-section bg-light" id="testimonials">
        <div class="container text-center">
            <span class="text-uppercase text-primary tracking-widest fw-extrabold mb-2 d-block">Testimonials</span>
            <h2 class="mb-5 h1">What Our Customers Say</h2>
            
            <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <!-- Review 1 -->
                    <div class="carousel-item active">
                        <div class="review-card">
                            <div class="review-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="fs-5 text-muted mb-4 italic">
                                "The Sound Pro headphones exceeded my expectations. The noise cancellation is spectacular, and they are incredibly comfortable during long flights. MilbeBD delivers absolute perfection!"
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="Samantha K." class="avatar-img">
                                <div class="text-start">
                                    <h5 class="mb-0 fs-6 fw-bold">Samantha K.</h5>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Review 2 -->
                    <div class="carousel-item">
                        <div class="review-card">
                            <div class="review-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="fs-5 text-muted mb-4 italic">
                                "Absolutely stunning design on the Horizon smartwatch. It tracks my steps perfectly, and I've received so many compliments. Ordering was fast and customer support was exceptional."
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80" alt="Marcus V." class="avatar-img">
                                <div class="text-start">
                                    <h5 class="mb-0 fs-6 fw-bold">Marcus V.</h5>
                                    <small class="text-muted">Tech Enthusiast</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Review 3 -->
                    <div class="carousel-item">
                        <div class="review-card">
                            <div class="review-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <p class="fs-5 text-muted mb-4 italic">
                                "The Nomad Backpack holds everything I need, and the leather feels top quality. Very happy with my purchase. Best premium store out there!"
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&auto=format&fit=crop&q=80" alt="Eliza D." class="avatar-img">
                                <div class="text-start">
                                    <h5 class="mb-0 fs-6 fw-bold">Eliza D.</h5>
                                    <small class="text-muted">Digital Nomad</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Controls -->
                <button class="carousel-control-prev d-none d-md-flex align-items-center justify-content-center" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev" style="width: 50px;">
                    <span class="bg-white text-dark rounded-circle d-inline-flex p-2 shadow-sm border border-light"><i class="bi bi-arrow-left"></i></span>
                </button>
                <button class="carousel-control-next d-none d-md-flex align-items-center justify-content-center" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next" style="width: 50px;">
                    <span class="bg-white text-dark rounded-circle d-inline-flex p-2 shadow-sm border border-light"><i class="bi bi-arrow-right"></i></span>
                </button>
            </div>
            
            <div class="mt-4">
                <a href="#order-form-section" class="btn btn-premium">
                    Get Yours Today <i class="bi bi-cart-plus me-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works-section" id="how-it-works">
        <div class="container text-center">
            <span class="text-uppercase text-primary tracking-widest fw-extrabold mb-2 d-block">Process</span>
            <h2 class="mb-5 h1">How It Works</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="step-card">
                        <div class="step-icon-wrap">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <h3 class="h4 mb-3">1. Order</h3>
                        <p class="text-muted mb-0">Select your favorite product package and enter your shipping details in the checkout form below.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="step-card">
                        <div class="step-icon-wrap">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h3 class="h4 mb-3">2. Delivery</h3>
                        <p class="text-muted mb-0">Your package is handled with care and delivered to your doorstep within 2-3 business days.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="step-card">
                        <div class="step-icon-wrap">
                            <i class="bi bi-emoji-laughing"></i>
                        </div>
                        <h3 class="h4 mb-3">3. Enjoy</h3>
                        <p class="text-muted mb-0">Unbox, start using your new premium quality product, and enjoy our lifetime warranty support.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Select Product Section -->
    <section class="product-select-section" id="product-selection">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-uppercase text-primary tracking-widest fw-extrabold mb-2 d-block">Selection</span>
                <h2 class="h1 mb-2">Select Your Product</h2>
                <p class="text-muted">Choose your preferred product package to continue</p>
            </div>
            
            <div class="table-premium-container">
                <div class="table-responsive">
                    <table class="table table-premium align-middle">
                        <thead>
                            <tr>
                                <th style="width: 80px;" class="text-center">Select</th>
                                <th>Product Details</th>
                                <th>Colour</th>
                                <th>Price</th>
                                <th style="width: 150px;" class="text-center">Quantity</th>
                                <th class="text-end" style="width: 120px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Product 1 -->
                            <tr class="product-row active-row">
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center m-0">
                                        <input class="form-check-input fs-5 product-select-radio" type="radio" name="selected_product_radio" id="prod1" value="199" checked data-name="Milbe Sound Pro Headphones">
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/frontend/img/waterproof.png') }}" alt="Sound Pro" class="product-thumb">
                                        <div>
                                            <h5 class="mb-0 fs-6 fw-bold">Premium Skin Friendly Mini Shaver</h5>
                                            {{-- <small class="text-muted">Premium Skin Friendly Mini Shaver</small> --}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="form-check p-0 m-0">
                                            <input type="radio" name="product_color" id="color_silver" checked value="Platinum Silver" class="btn-check">
                                            <label class="btn btn-outline-secondary p-0 rounded-circle d-flex align-items-center justify-content-center color-dot shadow-sm" for="color_silver" style="width: 28px; height: 28px; border-width: 2px;" title="Platinum Silver">
                                                <span class="rounded-circle" style="width: 14px; height: 14px; background-color: #94a3b8;"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold text-dark">৳ 199</td>
                                <td>
                                    <div class="input-group input-group-sm justify-content-center mx-auto" style="max-width: 110px;">
                                        <button class="btn btn-outline-secondary border-secondary-subtle px-2 py-1 qty-btn-minus" type="button">-</button>
                                        <input type="text" class="form-control text-center fw-bold product-qty-input" value="1" readonly name="quantity_1">
                                        <button class="btn btn-outline-secondary border-secondary-subtle px-2 py-1 qty-btn-plus" type="button">+</button>
                                    </div>
                                </td>
                                <td class="fw-bold text-primary text-end row-total-price">৳ 199</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Form Section -->
    <section class="order-section" id="order-form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-card">
                        <div class="text-center mb-5">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-3 fw-semibold">
                                Checkout
                            </span>
                            <h2 class="h1 mb-2">Fast Order Checkout</h2>
                            <p class="text-muted">Fill in your shipping details below to place your order. Delivery inside and outside Dhaka is active.</p>
                        </div>
                        
                        <form action="{{ route('orders.store') }}" method="post" id="checkout-form">
                            @csrf
                            
                            <!-- Hidden inputs to submit selected product, price and quantity to backend -->
                            <input type="hidden" name="product_name" id="hidden_product_name" value="Milbe Sound Pro Headphones">
                            <input type="hidden" name="product_price" id="hidden_product_price" value="199">
                            <input type="hidden" name="product_qty" id="hidden_product_qty" value="1">
                            <input type="hidden" name="delivery_cost" id="hidden_delivery_cost" value="0">
                            <input type="hidden" name="total_amount" id="hidden_total_amount" value="199">
                            <input type="hidden" name="product_color" id="hidden_product_color" value="Midnight Black">

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Full Name" required>
                                        <label for="nameInput"><i class="bi bi-person me-1"></i> Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phoneInput" name="phone" placeholder="Phone Number" required>
                                        <label for="phoneInput"><i class="bi bi-telephone me-1"></i> Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="addressInput" name="address" placeholder="Shipping Address" required>
                                        <label for="addressInput"><i class="bi bi-geo-alt me-1"></i> Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cityInput" class="mb-1 text-muted" style="font-size: 0.9rem;"><i class="bi bi-building me-1"></i> City</label>
                                        <select class="form-select select2" id="cityInput" name="city" required>
                                            <option value="">Select City</option>
                                            @foreach(\App\Models\District::where('status', 1)->get() as $district)
                                                <option value="{{ $district->name }}" data-charge="{{ $district->delivery_charge }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Billing Summary -->
                            <div class="billing-summary p-4 mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Selected Product:</span>
                                    <span class="fw-semibold text-dark text-wrap text-end" id="summary-product-name" style="max-width: 250px;">Skin Friendly Mini Shaver</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal Price:</span>
                                    <strong class="text-dark" id="summary-product-price">৳ 199</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Delivery Charge:</span>
                                    <strong class="text-dark" id="summary-delivery-charge">৳ 0</strong>
                                </div>
                                <hr class="my-3 border-secondary opacity-15">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-5 text-dark">Total Amount:</span>
                                    <strong class="fs-5 text-primary" id="summary-total-price">৳ 199</strong>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-premium btn-lg w-100 py-3 rounded-3 shadow-lg fs-5">
                                    <i class="bi bi-bag-check me-2"></i> Confirm Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom" id="contact">
        <div class="container">
            <div class="row gy-4 mb-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <a class="footer-logo d-inline-flex align-items-center mb-3" href="#">
                        <i class="bi bi-lightning-charge-fill me-2 text-warning"></i>
                        MilbeBD
                    </a>
                    <p class="pe-lg-5" style="color: rgba(255, 255, 255, 0.7);">
                        Your trusted portal for premium lifestyle and technical products. Experience stellar customer service, rapid delivery, and genuine quality guarantees.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 text-center text-lg-start" id="terms">
                    <h5 class="text-white mb-3 fw-bold">Company & Policy</h5>
                    <ul class="list-unstyled d-flex flex-column align-items-center align-items-lg-start gap-2">
                        @foreach ($pages as $page)
                        <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->title ?? $page->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 text-center text-lg-start">
                    <h5 class="text-white mb-3 fw-bold">Contact & Support</h5>
                    <p class="mb-2"><i class="bi bi-telephone text-primary me-2"></i> +880 1234-567890</p>
                    <p class="mb-2"><i class="bi bi-envelope text-primary me-2"></i> support@milbebd.com</p>
                    <p class="mb-3"><i class="bi bi-geo-alt text-primary me-2"></i> Gulshan, Dhaka, Bangladesh</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start fs-5 mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary opacity-10">
            <div class="row align-items-center justify-content-between text-center text-md-start">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0 text-muted">&copy; 2026 MilbeBD. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">Designed for maximum quality and trust.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery (CDN) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 Bundle JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Interactive Scripts -->
    <script>
        $(document).ready(function() {
            $('#cityInput').select2({
                placeholder: 'Select City',
                width: '100%'
            }).on('change', function() {
                recalculateInvoice();
            });
        });
        // Shrink/Fade Navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Dynamic Countdown Logic
        // Set the deal target to 24 hours from the current time for demo/active urgency
        const countdownDuration = 24 * 60 * 60 * 1000; // 24 hours in ms
        let targetTime = localStorage.getItem('milbe_countdown_target');
        
        if (!targetTime || (new Date().getTime() > targetTime)) {
            targetTime = new Date().getTime() + countdownDuration;
            localStorage.setItem('milbe_countdown_target', targetTime);
        } else {
            targetTime = parseInt(targetTime, 10);
        }

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance < 0) {
                // reset to another 24 hours to keep the UI active
                localStorage.removeItem('milbe_countdown_target');
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update all countdown elements on the page
            const dayEls = document.querySelectorAll('.text-days');
            const hourEls = document.querySelectorAll('.text-hours');
            const minuteEls = document.querySelectorAll('.text-minutes');
            const secondEls = document.querySelectorAll('.text-seconds');

            const format = num => String(num).padStart(2, '0');

            dayEls.forEach(el => el.textContent = format(days));
            hourEls.forEach(el => el.textContent = format(hours));
            minuteEls.forEach(el => el.textContent = format(minutes));
            secondEls.forEach(el => el.textContent = format(seconds));
        }

        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Smooth Scroll handling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Soft order button action scroll
        const orderBtns = document.querySelectorAll('.btn-premium, .nav-link[href="#order-form-section"]');
        orderBtns.forEach(btn => {
            if (btn.getAttribute('href') === '#order-form-section') {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('#order-form-section').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }
        });

        // Product Selection Interactivity
        const selectRadios = document.querySelectorAll('.product-select-radio');
        const deliveryToggle = document.getElementById('delivery-option');

        // Form hidden values
        const hiddenProdName = document.getElementById('hidden_product_name');
        const hiddenProdPrice = document.getElementById('hidden_product_price');
        const hiddenProdQty = document.getElementById('hidden_product_qty');
        const hiddenDeliveryCost = document.getElementById('hidden_delivery_cost');
        const hiddenTotalAmount = document.getElementById('hidden_total_amount');

        // Form summary labels
        const summaryProdName = document.getElementById('summary-product-name');
        const summaryProdPrice = document.getElementById('summary-product-price');
        const summaryDeliveryCharge = document.getElementById('summary-delivery-charge');
        const summaryTotalPrice = document.getElementById('summary-total-price');

        function recalculateInvoice() {
            let activeRadio = document.querySelector('.product-select-radio:checked');
            if (!activeRadio) return;

            let price = parseFloat(activeRadio.value);
            let name = activeRadio.getAttribute('data-name');
            
            // Find active row
            let activeRow = activeRadio.closest('tr');
            let qtyInput = activeRow.querySelector('.product-qty-input');
            let qty = parseInt(qtyInput.value, 10) || 1;

            let subtotal = price * qty;
            
            // Update row total display
            activeRow.querySelector('.row-total-price').textContent = `৳ ${subtotal.toFixed(2)}`;

            // Check delivery
            let citySelect = document.getElementById('cityInput');
            let selectedOption = citySelect.options[citySelect.selectedIndex];
            let deliveryCharge = 0;
            if (selectedOption && selectedOption.dataset.charge) {
                deliveryCharge = parseFloat(selectedOption.dataset.charge);
            }
            let finalTotal = subtotal + deliveryCharge;

            // Update Summary
            summaryProdName.textContent = name;
            summaryProdPrice.textContent = `৳ ${subtotal.toFixed(2)}`;
            summaryDeliveryCharge.textContent = `৳ ${deliveryCharge.toFixed(2)}`;
            summaryTotalPrice.textContent = `৳ ${finalTotal.toFixed(2)}`;

            // Update hidden inputs for backend submissions
            hiddenProdName.value = name;
            hiddenProdPrice.value = price;
            hiddenProdQty.value = qty;
            hiddenDeliveryCost.value = deliveryCharge;
            hiddenTotalAmount.value = finalTotal;
        }

        // Handle radio selection changes
        selectRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active styling from all rows
                document.querySelectorAll('.product-row').forEach(row => {
                    row.classList.remove('active-row');
                    
                    // Disable quantity controls and reset to 1
                    let rowQtyInput = row.querySelector('.product-qty-input');
                    rowQtyInput.disabled = true;
                    rowQtyInput.value = 1;
                    
                    // Reset quantity buttons
                    row.querySelectorAll('.qty-btn-minus, .qty-btn-plus').forEach(btn => btn.disabled = true);
                    
                    // Style inactive total price
                    let rowPrice = parseFloat(row.querySelector('.product-select-radio').value);
                    row.querySelector('.row-total-price').textContent = `$${rowPrice.toFixed(2)}`;
                    row.querySelector('.row-total-price').classList.add('text-muted');
                    row.querySelector('.row-total-price').classList.remove('text-primary');
                });

                // Add active-row styling to selected row
                let activeRow = this.closest('tr');
                activeRow.classList.add('active-row');
                
                // Enable quantity inputs for selected row
                let activeQtyInput = activeRow.querySelector('.product-qty-input');
                activeQtyInput.disabled = false;
                
                // Enable quantity buttons
                activeRow.querySelectorAll('.qty-btn-minus, .qty-btn-plus').forEach(btn => btn.disabled = false);

                // Style active total price
                let activeTotal = activeRow.querySelector('.row-total-price');
                activeTotal.classList.remove('text-muted');
                activeTotal.classList.add('text-primary');

                recalculateInvoice();
            });
        });

        // Handle minus/plus buttons click events
        document.querySelectorAll('.product-row').forEach(row => {
            const minusBtn = row.querySelector('.qty-btn-minus');
            const plusBtn = row.querySelector('.qty-btn-plus');
            const qtyInput = row.querySelector('.product-qty-input');

            minusBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value, 10) || 1;
                if (currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                    recalculateInvoice();
                }
            });

            plusBtn.addEventListener('click', function() {
                let currentVal = parseInt(qtyInput.value, 10) || 1;
                if (currentVal < 20) {
                    qtyInput.value = currentVal + 1;
                    recalculateInvoice();
                }
            });
        });

        // Handle delivery switch toggle event
        deliveryToggle.addEventListener('change', recalculateInvoice);

        // Handle color radio selection changes
        const colorRadioInputs = document.querySelectorAll('input[name="product_color"]');
        const hiddenProductColor = document.getElementById('hidden_product_color');
        if (hiddenProductColor && colorRadioInputs) {
            colorRadioInputs.forEach(input => {
                input.addEventListener('change', function() {
                    hiddenProductColor.value = this.value;
                });
            });
        }

        // Initial trigger to configure correct initial states
        recalculateInvoice();

        // Image Comparison Slider Logic
        const compareSlider = document.getElementById('compare-slider-input');
        const compareOverlay = document.getElementById('compare-overlay');
        const compareHandle = document.getElementById('compare-slider-handle');

        if (compareSlider && compareOverlay && compareHandle) {
            compareSlider.addEventListener('input', function(e) {
                const val = e.target.value;
                compareOverlay.style.clipPath = `polygon(0 0, ${val}% 0, ${val}% 100%, 0 100%)`;
                compareOverlay.style.webkitClipPath = `polygon(0 0, ${val}% 0, ${val}% 100%, 0 100%)`;
                compareHandle.style.left = `${val}%`;
            });
        }
    </script>
</body>
</html>