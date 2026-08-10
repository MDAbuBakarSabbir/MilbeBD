<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page->title ?? $page->name ?? 'Page' }} | MilbeBD</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header {
            background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.04) 0%, rgba(236, 72, 153, 0.04) 90%);
            padding: 6rem 0 3rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            text-align: center;
        }

        .page-content-wrapper {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--card-shadow);
            margin: -3rem auto 5rem auto;
            border: 1px solid rgba(0, 0, 0, 0.02);
            position: relative;
            z-index: 10;
        }
        
        .page-content-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }

        /* Footer styling identical to welcome */
        .footer-custom {
            background: var(--dark);
            padding: 5rem 0 2rem 0;
            color: rgba(255, 255, 255, 0.7);
        }
        .footer-custom a {
            color: rgba(255, 255, 255, 0.7);
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
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Sticky Header/Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="bi bi-lightning-charge-fill me-2"></i>
                MilbeBD
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ url('/') }}#order-form-section" class="btn btn-primary btn-sm py-2 px-4 shadow-sm" style="background: var(--primary); border:none; border-radius:30px;">
                            <i class="bi bi-cart3"></i> Order Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="display-5 fw-extrabold mb-3">{{ $page->title ?? $page->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page->title ?? $page->name }}</li>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-content-wrapper">
                    {!! $page->content ?? $page->details !!}
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-custom" id="contact">
        <div class="container">
            <div class="row gy-4 mb-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <a class="footer-logo d-inline-flex align-items-center mb-3" href="{{ url('/') }}">
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
                        @foreach ($pages as $p)
                        <li><a href="{{ route('front.page', $p->slug) }}">{{ $p->title ?? $p->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 text-center text-lg-start">
                    <h5 class="text-white mb-3 fw-bold">Contact & Support</h5>
                    <p class="mb-2"><i class="bi bi-telephone text-primary me-2" style="color:var(--primary)!important;"></i> +880 1234-567890</p>
                    <p class="mb-2"><i class="bi bi-envelope text-primary me-2" style="color:var(--primary)!important;"></i> support@milbebd.com</p>
                    <p class="mb-3"><i class="bi bi-geo-alt text-primary me-2" style="color:var(--primary)!important;"></i> Gulshan, Dhaka, Bangladesh</p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start fs-5 mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary opacity-10">
            <div class="row align-items-center justify-content-between text-center text-md-start">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} MilbeBD. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">Designed for maximum quality and trust.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Shrink/Fade Navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
