<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MILBE BD | Admin Login </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/backend/images/favicon.png') }}">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .authincation {
            position: relative;
            z-index: 1;
        }
        .authincation::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.3;
            z-index: -1;
        }
        .authincation-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transform: translateY(0);
            transition: all 0.3s ease;
            margin: 15px;
        }
        .authincation-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .auth-form {
            padding: 50px 40px;
        }
        @media (max-width: 576px) {
            .auth-form {
                padding: 30px 20px;
            }
            .authincation-content {
                margin: 10px;
            }
            .auth-form h4 {
                margin-bottom: 25px;
            }
        }
        .auth-form h4 {
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control {
            background: #f7f9fc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 15px;
            color: #4a5568;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }
        label {
            font-size: 14px;
            color: #4a5568;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            box-shadow: 0 6px 20px rgba(118, 75, 162, 0.5);
            transform: translateY(-2px);
        }
        .form-check-label {
            color: #4a5568;
            font-weight: 500;
            cursor: pointer;
        }
        .invalid-feedback strong {
            color: #e53e3e;
        }
        .forgot-link {
            color: #667eea;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .forgot-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
    </style>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center">Sign In</h4>
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-4">
                                            <label class="mb-2">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@example.com">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="mb-2">Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mt-4 mb-4" style="gap: 10px;">
                                            <div class="form-group mb-0">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input mt-1" type="checkbox" id="basic_checkbox_1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                                </div>
                                            </div>
                                            @if (Route::has('password.request'))
                                            <div class="form-group mb-0">
                                                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="text-center mt-5">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In To Dashboard</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/backend/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom.min.js') }}"></script>

</body>

</html>