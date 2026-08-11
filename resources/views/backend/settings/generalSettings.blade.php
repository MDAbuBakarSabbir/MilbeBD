@extends('layouts.backend.masterLay')
@section('title','General Settings')
@section('content')
<style>
    /* Premium Dashboard Styles */
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --info: #4895ef;
        --warning: #f72585;
        --danger: #e63946;
        --dark: #2b2d42;
        --light: #f8f9fa;
    }
    body { background-color: #f4f7fe; font-family: 'Inter', sans-serif; }
    
    .glass-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .glass-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .card-header-custom {
        padding: 1.5rem 1.5rem 0 1.5rem;
        background: transparent;
        border-bottom: none;
    }

    .card-title-custom {
        font-weight: 700;
        color: var(--dark);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
    }
    
    .card-title-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .form-group label {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        background-color: #f8fafc;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        background-color: #ffffff;
    }
    
    .btn-update {
        background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        transition: all 0.2s;
        width: 100%;
        color: white;
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(67, 97, 238, 0.3);
        color: white;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-upload-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    
    .file-upload-btn {
        border: 2px dashed #cbd5e0;
        border-radius: 10px;
        background-color: #f8fafc;
        padding: 1.5rem;
        text-align: center;
        color: #718096;
        transition: all 0.2s;
        cursor: pointer;
        position: relative;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .file-upload-btn::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(248, 250, 252, 0.9);
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 1;
    }
    
    .file-upload-btn.has-image .upload-content {
        opacity: 0;
        transition: opacity 0.2s;
        position: relative;
        z-index: 2;
    }
    
    .file-upload-btn.has-image:hover::before,
    .file-upload-btn.has-image:hover .upload-content {
        opacity: 1;
    }

    .upload-content {
        position: relative;
        z-index: 2;
    }
    
    .file-upload-wrapper:hover .file-upload-btn:not(.has-image) {
        border-color: var(--primary);
        background-color: rgba(67, 97, 238, 0.05);
        color: var(--primary);
    }
    
    /* Input Groups */
    .input-group-text {
        border-radius: 10px 0 0 10px;
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }
    
    .input-group .form-control {
        border-radius: 0 10px 10px 0;
    }
</style>

<div class="container-fluid px-0">
    <div class="mb-4">
        <h3 class="mb-0 font-weight-bold text-dark" style="letter-spacing: -0.5px;">General Settings</h3>
        <p class="text-muted mb-0">Configure your website's core information and assets.</p>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-xl-6 col-lg-6">
            <!-- Website Information -->
            <div class="glass-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <div class="card-title-icon bg-light text-primary">
                            <i class="mdi mdi-web"></i>
                        </div>
                        Website Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.siteInfoUpdate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="site_name">Site Name</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? '' }}" placeholder="e.g. Milbe BD">
                        </div>
                        <div class="form-group">
                            <label for="site_description">Site Description</label>
                            <textarea class="form-control" id="site_description" name="site_description" rows="3" placeholder="Briefly describe your website...">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="sitetag">Site Tags (SEO)</label>
                            <input type="text" class="form-control" id="sitetag" name="sitetag" value="{{ $settings['sitetag'] ?? '' }}" placeholder="e.g. ecommerce, gadgets, tech">
                            <small class="text-muted mt-1 d-block"><i class="mdi mdi-information-outline"></i> Separate tags with commas.</small>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save mr-2"></i>Save Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Contact Details</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.siteContactUpdate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{ $settings['phone'] ?? '' }}" placeholder="Enter Your Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $settings['email'] ?? '' }}" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $settings['address'] ?? '' }}" placeholder="Enter Your Address">
                        </div>
                        <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save mr-2"></i>Save Contact Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <!-- Right Column -->
        <div class="col-xl col-lg">
            <!-- Brand Assets -->
            <div class="glass-card h-100">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <div class="card-title-icon bg-light text-warning">
                            <i class="mdi mdi-palette"></i>
                        </div>
                        Brand Assets
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <!-- Header Logo -->
                            <div class="form-group mb-4">
                                <label>Site Header Logo</label>
                                <div class="file-upload-wrapper">
                                    <div class="file-upload-btn {{ isset($settings['site_logo']) && $settings['site_logo'] ? 'has-image' : '' }}" id="btn_site_logo_header" style="{{ isset($settings['site_logo']) && $settings['site_logo'] ? 'background-image: url(' . asset('storage/' . $settings['site_logo']) . ');' : '' }}">
                                        <div class="upload-content">
                                            <i class="mdi mdi-cloud-upload text-primary" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 font-weight-bold text-dark">Drag & Drop or Click</h6>
                                            <p class="small mb-0">Recommended size: 200x60px (PNG, SVG)</p>
                                        </div>
                                    </div>
                                    <input type="file" id="site_logo_header" name="site_logo" accept="image/*" onchange="previewImageInBox(this, 'btn_site_logo_header')">
                                </div>
                            </div>
    
                            <!-- Footer Logo -->
                            <div class="form-group mb-4">
                                <label>Site Footer Logo</label>
                                <div class="file-upload-wrapper">
                                    <div class="file-upload-btn {{ isset($settings['site_logo_footer']) && $settings['site_logo_footer'] ? 'has-image' : '' }}" id="btn_site_logo_footer" style="{{ isset($settings['site_logo_footer']) && $settings['site_logo_footer'] ? 'background-image: url(' . asset('storage/' . $settings['site_logo_footer']) . '); background-color: #2b2d42;' : '' }}">
                                        <div class="upload-content">
                                            <i class="mdi mdi-cloud-upload text-info" style="font-size: 2rem;"></i>
                                            <h6 class="mt-2 font-weight-bold text-dark" style="{{ isset($settings['site_logo_footer']) && $settings['site_logo_footer'] ? 'color: #fff !important;' : '' }}">Drag & Drop or Click</h6>
                                            <p class="small mb-0" style="{{ isset($settings['site_logo_footer']) && $settings['site_logo_footer'] ? 'color: #fff !important;' : '' }}">For dark backgrounds (PNG, SVG)</p>
                                        </div>
                                    </div>
                                    <input type="file" id="site_logo_footer" name="site_logo_footer" accept="image/*" onchange="previewImageInBox(this, 'btn_site_logo_footer')">
                                </div>
                            </div>
    
                            <!-- Favicon -->
                            <div class="form-group mb-4">
                                <label>Site Favicon</label>
                                <div class="file-upload-wrapper">
                                    <div class="file-upload-btn {{ isset($settings['site_favicon']) && $settings['site_favicon'] ? 'has-image' : '' }}" id="btn_site_favicon" style="padding: 1rem; {{ isset($settings['site_favicon']) && $settings['site_favicon'] ? 'background-image: url(' . asset('storage/' . $settings['site_favicon']) . ');' : '' }}">
                                        <div class="upload-content">
                                            <i class="mdi mdi-image-size-select-actual text-success" style="font-size: 1.5rem;"></i>
                                            <h6 class="mt-1 font-weight-bold text-dark" style="font-size: 0.9rem;">Upload Favicon (32x32)</h6>
                                        </div>
                                    </div>
                                    <input type="file" id="site_favicon" name="site_favicon" accept="image/*" onchange="previewImageInBox(this, 'btn_site_favicon')">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2 border-top">
                            <button type="submit" disabled class="btn btn-update"><i class="mdi mdi-content-save mr-2"></i>Save Brand Assets</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- Meta Pixel & GTag -->
            <div class="glass-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <div class="card-title-icon bg-light text-info">
                            <i class="mdi mdi-google-analytics"></i>
                        </div>
                        Analytics & Tracking
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="meta_pixel_id">Meta Pixel ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-facebook text-primary"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0" id="meta_pixel_id" name="meta_pixel_id" value="{{ $settings['meta_pixel_id'] ?? '' }}" placeholder="e.g. 1234567890">
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="gtag_id">Google Tag ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-google text-danger"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0" id="gtag_id" name="gtag_id" value="{{ $settings['gtag_id'] ?? '' }}" placeholder="e.g. G-XXXXXXX">
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save mr-2"></i>Save Tracking IDs</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </div>  
</div>

<script>
    function previewImageInBox(input, btnId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var btn = document.getElementById(btnId);
                btn.style.backgroundImage = 'url(' + e.target.result + ')';
                
                // For footer logo, set a dark background color as well so white text/logos are visible
                if (btnId === 'btn_site_logo_footer') {
                    btn.style.backgroundColor = '#2b2d42';
                    var h6 = btn.querySelector('h6');
                    var p = btn.querySelector('p');
                    if (h6) h6.style.setProperty('color', '#fff', 'important');
                    if (p) p.style.setProperty('color', '#fff', 'important');
                }
                
                btn.classList.add('has-image');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection