@extends('layouts.backend.masterLay')
@section('title', 'Fraud Checker API Settings')
@section('content')

    <!-- Custom styling for premium fraud checker cards and interactive switches -->
    <style>
        .fraud-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s ease;
            overflow: hidden;
            background: #ffffff;
            height: 100%;
        }
        .fraud-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06) !important;
        }
        .fraud-card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem 2rem !important;
        }
        .fraud-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .bdcourier-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }
        .zachai-badge {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        }
        .form-control-custom {
            height: 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            padding-left: 1.2rem;
            transition: all 0.2s ease;
        }
        .form-control-custom:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }
        .input-group-text-custom {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            color: #64748b;
        }
        .input-group .form-control-custom {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        /* Custom Modern Switch */
        .switch-custom {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 28px;
            margin-bottom: 0;
        }
        .switch-custom input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider-round {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 34px;
        }
        .slider-round:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        input:checked + .slider-round {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        input:checked + .slider-round:before {
            transform: translateX(24px);
        }
        .btn-save-api {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            border: none;
            color: white;
            padding: 0.7rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        }
        .btn-save-api:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: white;
        }
        .how-to-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            margin-top: 1.5rem;
        }
        .how-to-box ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }
        .how-to-box li {
            color: #475569;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
        }
        .how-to-box li:last-child {
            margin-bottom: 0;
        }
    </style>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1">
                        <i class="ti-shield text-primary mr-2"></i> Fraud Checker API Settings
                    </h3>
                    <p class="text-muted mb-0">Automate customer screening, check phone number success rates, and verify delivery risk scores.</p>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg py-3 px-4 mb-4 d-flex align-items-center">
            <i class="ti-check-box mr-3 fs-4 text-success" style="font-size: 1.5rem;"></i>
            <div class="font-weight-semibold text-dark">{{ session('success') }}</div>
        </div>
    @endif

    <div class="row">
        <!-- BD Courier API Card -->
        <div class="col-lg-6 mb-4">
            @php
                $bdCourier = $fraudApis['BD Courier API'] ?? null;
                $bdCourierStatus = $bdCourier ? $bdCourier->api_status : 'Active';
            @endphp
            <div class="card fraud-card shadow-sm">
                <form action="{{ route('fraud-checkers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="api_name" value="BD Courier API">
                    
                    <div class="card-header fraud-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="fraud-badge bdcourier-badge mr-3">
                                <i class="ti-shield"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-1">BD Courier API</h5>
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $bdCourierStatus == 'Active' ? 'badge-success' : 'badge-secondary' }} rounded-pill px-2 py-1 mr-2" id="bdcourier-status-badge">
                                        {{ $bdCourierStatus }}
                                    </span>
                                    <small class="text-muted">Multi-Courier Delivery Success Rate</small>
                                </div>
                            </div>
                        </div>
                        <div class="switch">
                            <label class="switch-custom" title="Toggle BD Courier Fraud Check">
                                <input type="checkbox" name="status" id="bdcourier-toggle" value="Active" {{ $bdCourierStatus == 'Active' ? 'checked' : '' }}>
                                <span class="slider-round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label for="bdcourier_key" class="font-weight-semibold text-dark mb-2">API Key</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-key"></i></span>
                                </div>
                                <input type="text" name="api_key" id="bdcourier_key" class="form-control form-control-custom" 
                                       value="{{ $bdCourier->api_key ?? '' }}" placeholder="Enter BD Courier API Key" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="bdcourier_url" class="font-weight-semibold text-dark mb-2">Base URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-link"></i></span>
                                </div>
                                <input type="url" name="api_url" id="bdcourier_url" class="form-control form-control-custom" 
                                       value="{{ $bdCourier->api_url ?? 'https://bdcourier.com/api/v1' }}" placeholder="https://bdcourier.com/api/v1">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mb-2">
                            <button type="submit" class="btn btn-save-api">
                                <i class="ti-save mr-2"></i> Save BD Courier Config
                            </button>
                        </div>

                        <!-- Helper Box -->
                        <div class="how-to-box">
                            <div class="d-flex align-items-center mb-2 font-weight-bold text-dark">
                                <i class="ti-help-alt text-primary mr-2"></i> How to Get API Key:
                            </div>
                            <ul>
                                <li>Log in to your <strong>BD Courier</strong> Merchant Portal.</li>
                                <li>Navigate to <strong>Settings &rarr; API & Webhooks</strong>.</li>
                                <li>Click <strong>Generate New API Key</strong> and copy the token.</li>
                                <li>Paste the key directly into the input field above and click Save.</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Zachaikori API Card -->
        <div class="col-lg-6 mb-4">
            @php
                $zachai = $fraudApis['Zachaikori API'] ?? null;
                $zachaiStatus = $zachai ? $zachai->api_status : 'Active';
            @endphp
            <div class="card fraud-card shadow-sm">
                <form action="{{ route('fraud-checkers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="api_name" value="Zachaikori API">
                    
                    <div class="card-header fraud-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="fraud-badge zachai-badge mr-3">
                                <i class="ti-lock"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-1">Zachaikori API</h5>
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $zachaiStatus == 'Active' ? 'badge-success' : 'badge-secondary' }} rounded-pill px-2 py-1 mr-2" id="zachai-status-badge">
                                        {{ $zachaiStatus }}
                                    </span>
                                    <small class="text-muted">Real-Time Customer Risk Scoring</small>
                                </div>
                            </div>
                        </div>
                        <div class="switch">
                            <label class="switch-custom" title="Toggle Zachaikori Fraud Check">
                                <input type="checkbox" name="status" id="zachai-toggle" value="Active" {{ $zachaiStatus == 'Active' ? 'checked' : '' }}>
                                <span class="slider-round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label for="zachai_key" class="font-weight-semibold text-dark mb-2">API Key</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-key"></i></span>
                                </div>
                                <input type="text" name="api_key" id="zachai_key" class="form-control form-control-custom" 
                                       value="{{ $zachai->api_key ?? '' }}" placeholder="Enter Zachaikori API Key" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="zachai_url" class="font-weight-semibold text-dark mb-2">Base URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-link"></i></span>
                                </div>
                                <input type="url" name="api_url" id="zachai_url" class="form-control form-control-custom" 
                                       value="{{ $zachai->api_url ?? 'https://zachaikori.com/api/v1' }}" placeholder="https://zachaikori.com/api/v1">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mb-2">
                            <button type="submit" class="btn btn-save-api">
                                <i class="ti-save mr-2"></i> Save Zachaikori Config
                            </button>
                        </div>

                        <!-- Helper Box -->
                        <div class="how-to-box">
                            <div class="d-flex align-items-center mb-2 font-weight-bold text-dark">
                                <i class="ti-help-alt text-primary mr-2"></i> How to Get API Key:
                            </div>
                            <ul>
                                <li>Log in to your <strong>Zachaikori</strong> Dashboard.</li>
                                <li>Go to <strong>Developer Settings &rarr; API Management</strong>.</li>
                                <li>Copy your secret merchant API authorization key.</li>
                                <li>Paste the key into the API Key input field above and click Save.</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for interactive toggle status badges -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bdCourierToggle = document.getElementById('bdcourier-toggle');
            const bdCourierBadge = document.getElementById('bdcourier-status-badge');
            if (bdCourierToggle && bdCourierBadge) {
                bdCourierToggle.addEventListener('change', function() {
                    if (this.checked) {
                        bdCourierBadge.textContent = 'Active';
                        bdCourierBadge.classList.remove('badge-secondary');
                        bdCourierBadge.classList.add('badge-success');
                    } else {
                        bdCourierBadge.textContent = 'Inactive';
                        bdCourierBadge.classList.remove('badge-success');
                        bdCourierBadge.classList.add('badge-secondary');
                    }
                });
            }

            const zachaiToggle = document.getElementById('zachai-toggle');
            const zachaiBadge = document.getElementById('zachai-status-badge');
            if (zachaiToggle && zachaiBadge) {
                zachaiToggle.addEventListener('change', function() {
                    if (this.checked) {
                        zachaiBadge.textContent = 'Active';
                        zachaiBadge.classList.remove('badge-secondary');
                        zachaiBadge.classList.add('badge-success');
                    } else {
                        zachaiBadge.textContent = 'Inactive';
                        zachaiBadge.classList.remove('badge-success');
                        zachaiBadge.classList.add('badge-secondary');
                    }
                });
            }
        });
    </script>
@endsection