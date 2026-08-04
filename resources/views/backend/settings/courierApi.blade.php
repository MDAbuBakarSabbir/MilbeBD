@extends('layouts.backend.masterLay')
@section('title', 'Courier API Settings')
@section('content')

    <!-- Custom styling for premium API cards and modern switches -->
    <style>
        .courier-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            transition: all 0.3s ease;
            overflow: hidden;
            background: #ffffff;
            height: 100%;
        }
        .courier-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06) !important;
        }
        .courier-card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem 2rem !important;
        }
        .courier-badge {
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
        .steadfast-badge {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
        }
        .pathao-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
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
        .toggle-secret-btn {
            border: 1.5px solid #e2e8f0;
            border-left: none;
            background: #f8fafc;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            color: #64748b;
            transition: all 0.2s;
        }
        .toggle-secret-btn:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1">
                        <i class="ti-truck text-primary mr-2"></i> Courier API Integrations
                    </h3>
                    <p class="text-muted mb-0">Manage automated logistics, parcel booking credentials, and delivery webhooks.</p>
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
        <!-- SteadFast Courier Card -->
        <div class="col-lg-6 mb-4">
            @php
                $steadfast = $courierApis['SteadFast Courier'] ?? null;
                $steadfastStatus = $steadfast ? $steadfast->api_status : 'Active';
            @endphp
            <div class="card courier-card shadow-sm">
                <form action="{{ route('courier-apis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="api_name" value="SteadFast Courier">
                    
                    <div class="card-header courier-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="courier-badge steadfast-badge mr-3">
                                <i class="ti-package"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-1">SteadFast Courier</h5>
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $steadfastStatus == 'Active' ? 'badge-success' : 'badge-secondary' }} rounded-pill px-2 py-1 mr-2" id="steadfast-status-badge">
                                        {{ $steadfastStatus }}
                                    </span>
                                    <small class="text-muted">Automated Parcel Creation & Tracking</small>
                                </div>
                            </div>
                        </div>
                        <div class="switch">
                            <label class="switch-custom" title="Toggle SteadFast Courier Integration">
                                <input type="checkbox" name="status" id="steadfast-toggle" value="Active" {{ $steadfastStatus == 'Active' ? 'checked' : '' }}>
                                <span class="slider-round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label for="steadfast_key" class="font-weight-semibold text-dark mb-2">API Key</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-key"></i></span>
                                </div>
                                <input type="text" name="api_key" id="steadfast_key" class="form-control form-control-custom" 
                                       value="{{ $steadfast->api_key ?? '' }}" placeholder="Enter SteadFast API Key">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="steadfast_secret" class="font-weight-semibold text-dark mb-2">API Secret</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-lock"></i></span>
                                </div>
                                <input type="password" name="api_secret" id="steadfast_secret" class="form-control form-control-custom" 
                                       value="{{ $steadfast->api_secret ?? '' }}" placeholder="Enter SteadFast API Secret">
                                <div class="input-group-append">
                                    <button type="button" class="btn toggle-secret-btn px-3" data-target="#steadfast_secret" title="Show/Hide Secret">
                                        <i class="ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="steadfast_url" class="font-weight-semibold text-dark mb-2">API Base URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-link"></i></span>
                                </div>
                                <input type="url" name="api_url" id="steadfast_url" class="form-control form-control-custom" 
                                       value="{{ $steadfast->api_url ?? 'https://portal.steadfast.com.bd/api/v1' }}" placeholder="https://portal.steadfast.com.bd/api/v1">
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-save-api">
                                <i class="ti-save mr-2"></i> Save SteadFast Config
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Pathao Courier Card -->
        <div class="col-lg-6 mb-4">
            @php
                $pathao = $courierApis['Pathao Courier'] ?? null;
                $pathaoStatus = $pathao ? $pathao->api_status : 'Active';
            @endphp
            <div class="card courier-card shadow-sm">
                <form action="{{ route('courier-apis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="api_name" value="Pathao Courier">
                    
                    <div class="card-header courier-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="courier-badge pathao-badge mr-3">
                                <i class="ti-direction-alt"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold text-dark mb-1">Pathao Courier</h5>
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $pathaoStatus == 'Active' ? 'badge-success' : 'badge-secondary' }} rounded-pill px-2 py-1 mr-2" id="pathao-status-badge">
                                        {{ $pathaoStatus }}
                                    </span>
                                    <small class="text-muted">Nationwide Express Delivery Network</small>
                                </div>
                            </div>
                        </div>
                        <div class="switch">
                            <label class="switch-custom" title="Toggle Pathao Courier Integration">
                                <input type="checkbox" name="status" id="pathao-toggle" value="Active" {{ $pathaoStatus == 'Active' ? 'checked' : '' }}>
                                <span class="slider-round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="form-group mb-4">
                            <label for="pathao_key" class="font-weight-semibold text-dark mb-2">API Key (Client ID)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-key"></i></span>
                                </div>
                                <input type="text" name="api_key" id="pathao_key" class="form-control form-control-custom" 
                                       value="{{ $pathao->api_key ?? '' }}" placeholder="Enter Pathao Client ID / API Key">
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="pathao_secret" class="font-weight-semibold text-dark mb-2">API Secret (Client Secret)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-lock"></i></span>
                                </div>
                                <input type="password" name="api_secret" id="pathao_secret" class="form-control form-control-custom" 
                                       value="{{ $pathao->api_secret ?? '' }}" placeholder="Enter Pathao Client Secret">
                                <div class="input-group-append">
                                    <button type="button" class="btn toggle-secret-btn px-3" data-target="#pathao_secret" title="Show/Hide Secret">
                                        <i class="ti-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="pathao_url" class="font-weight-semibold text-dark mb-2">API Base URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-group-text-custom"><i class="ti-link"></i></span>
                                </div>
                                <input type="url" name="api_url" id="pathao_url" class="form-control form-control-custom" 
                                       value="{{ $pathao->api_url ?? 'https://api-hermes.pathao.com/aladdin/api/v1' }}" placeholder="https://api-hermes.pathao.com/aladdin/api/v1">
                            </div>
                        </div>

                        <hr class="border-light my-4">

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-save-api">
                                <i class="ti-save mr-2"></i> Save Pathao Config
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script for interactive toggle status badges and secret reveal -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle secret visibility
            document.querySelectorAll('.toggle-secret-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const targetInput = document.querySelector(this.getAttribute('data-target'));
                    if (targetInput) {
                        const icon = this.querySelector('i');
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text';
                            icon.classList.remove('ti-eye');
                            icon.classList.add('ti-lock');
                        } else {
                            targetInput.type = 'password';
                            icon.classList.remove('ti-lock');
                            icon.classList.add('ti-eye');
                        }
                    }
                });
            });

            // Interactive status badge updates on switch toggle
            const steadfastToggle = document.getElementById('steadfast-toggle');
            const steadfastBadge = document.getElementById('steadfast-status-badge');
            if (steadfastToggle && steadfastBadge) {
                steadfastToggle.addEventListener('change', function() {
                    if (this.checked) {
                        steadfastBadge.textContent = 'Active';
                        steadfastBadge.classList.remove('badge-secondary');
                        steadfastBadge.classList.add('badge-success');
                    } else {
                        steadfastBadge.textContent = 'Inactive';
                        steadfastBadge.classList.remove('badge-success');
                        steadfastBadge.classList.add('badge-secondary');
                    }
                });
            }

            const pathaoToggle = document.getElementById('pathao-toggle');
            const pathaoBadge = document.getElementById('pathao-status-badge');
            if (pathaoToggle && pathaoBadge) {
                pathaoToggle.addEventListener('change', function() {
                    if (this.checked) {
                        pathaoBadge.textContent = 'Active';
                        pathaoBadge.classList.remove('badge-secondary');
                        pathaoBadge.classList.add('badge-success');
                    } else {
                        pathaoBadge.textContent = 'Inactive';
                        pathaoBadge.classList.remove('badge-success');
                        pathaoBadge.classList.add('badge-secondary');
                    }
                });
            }
        });
    </script>
@endsection