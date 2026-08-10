@extends('layouts.backend.masterLay')
@section('title', 'Reviews')
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
    }
    
    .table-container { border-radius: 16px; overflow: hidden; }
    .table thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem;
    }
    .table tbody tr { transition: background-color 0.2s; border-bottom: 1px solid #f1f5f9; }
    .table tbody tr:hover { background-color: #f8faff; }
    .table td { padding: 1rem; vertical-align: middle; }
    
    .btn-action { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;}
    .btn-action:hover { transform: translateY(-2px); }

    .review-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        color: #64748b;
        font-size: 0.85rem;
        max-width: 300px;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 0.9rem;
    }
    
    /* Toggle Switch */
    .switch { position: relative; display: inline-block; width: 44px; height: 24px; margin-bottom: 0; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    input:checked + .slider { background-color: #4cc9f0; }
    input:checked + .slider:before { transform: translateX(20px); }

    @keyframes highlight {
        0% { background-color: #d1fae5; }
        100% { background-color: #ffffff; }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 font-weight-bold text-dark" style="letter-spacing: -0.5px;">Customer Reviews</h3>
            <p class="text-muted mb-0">Manage product ratings and feedback</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); border: none;" data-toggle="modal" data-target="#addReviewModal">
            <i class="fa-solid fa-plus mr-2"></i> Add Review
        </button>
    </div>

    <!-- Filters & Stats (Placeholder) -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="glass-card p-4 h-100 d-flex align-items-center">
                <div class="mr-3" style="font-size: 2rem; color: #4cc9f0;"><i class="fa-regular fa-comments"></i></div>
                <div>
                    <h4 class="mb-0 font-weight-bold text-dark">{{ $reviews->count() }}</h4>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Total Reviews</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="glass-card table-container">
        <div class="p-4 d-flex justify-content-between align-items-center border-bottom bg-white">
            <h5 class="font-weight-bold text-dark mb-0">All Reviews</h5>
            <div class="d-flex align-items-center">
                <select class="form-control form-control-sm mr-2 rounded-pill bg-light border-0 px-3" style="width: 150px;">
                    <option value="" disabled selected>Bulk Action</option>
                    <option value="active">Active Selected</option>
                    <option value="inactive">Inactive Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                <button class="btn btn-sm btn-dark rounded-pill px-3">Apply</button>
            </div>
        </div>
        <div class="table-responsive bg-white">
            <table class="table table-borderless table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px; padding-left: 1.5rem;"><input type="checkbox" class="select-all"></th>
                        <th>Product Info</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th class="text-right" style="padding-right: 1.5rem;">Actions</th>
                    </tr>
                </thead>
                <tbody id="reviewsTableBody">
                    @forelse($reviews as $review)
                        @php
                            $productObj = \App\Models\Product::find($review->product);
                            $productName = $productObj ? $productObj->name : 'Unknown Product';
                            $firstLetter = $productName ? strtoupper(substr($productName, 0, 1)) : 'U';
                        @endphp
                        <tr id="review-row-{{ $review->id }}">
                            <td style="padding-left: 1.5rem;"><input type="checkbox" value="{{ $review->id }}"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary font-weight-bold mr-3" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                        {{ $firstLetter }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ $productName }}</h6>
                                        <p class="text-muted mb-0" style="font-size: 0.75rem;">ID: {{ $review->product }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex" style="gap: 5px;">
                                    <img src="{{ asset('uploads/' . $review->image) }}" class="rounded border" alt="review_img" style="object-fit: cover; width: 50px; height: 50px;">
                                </div>
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" onchange="updateStatus({{ $review->id }}, this.checked ? '1' : '0')" {{ $review->status == '1' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right" style="padding-right: 1.5rem;">
                                <div class="btn-group shadow-sm rounded-pill p-1" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="confirmDelete(event, this);" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-action text-danger border-0 bg-transparent" title="Delete"><i class="mdi mdi-delete"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No reviews found. Click "Add Review" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header bg-light border-0 px-4 py-3">
                <h5 class="modal-title font-weight-bold text-dark"><i class="fa-solid fa-plus text-primary mr-2"></i> Add New Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4 py-4">
                <form id="addReviewForm" action="{{ route('admin.reviews.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark" style="font-size: 0.9rem;">Select Product [Optional]</label>
                        <select name="product_id" id="product_id" class="form-control rounded-lg" style="height: 48px; border-color: #e2e8f0;">
                            <option value="">-- Choose Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark" style="font-size: 0.9rem;">Review Image <span class="text-danger">*</span></label>
                        <div class="custom-file mb-3">
                            <input type="file" name="image" id="imageInput" class="custom-file-input" accept="image/*" required onchange="previewImage(this)">
                            <label class="custom-file-label" for="imageInput" style="border-radius: 8px; border-color: #e2e8f0; height: 48px; line-height: 2;">Choose image...</label>
                        </div>
                        <div class="text-center bg-light rounded-lg border d-none p-2 mt-2" id="imagePreviewContainer" style="border-color: #e2e8f0 !important;">
                            <img src="" alt="Preview" id="imagePreview" style="max-height: 150px; border-radius: 8px; object-fit: contain;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block rounded-pill font-weight-bold py-2" id="submitReviewBtn" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); border: none;">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreviewContainer').classList.remove('d-none');
                input.nextElementSibling.innerText = input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('addReviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let form = this;
        let formData = new FormData(form);
        let btn = document.getElementById('submitReviewBtn');
        let originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Submitting...';
        btn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Close modal
                $('#addReviewModal').modal('hide');
                form.reset();
                document.getElementById('imagePreviewContainer').classList.add('d-none');
                document.querySelector('.custom-file-label').innerText = 'Choose image...';
                
                // Show success toast
                Swal.fire({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                    icon: 'success', title: data.message
                });

                // Append new row to table
                let tableBody = document.getElementById('reviewsTableBody');
                
                // Remove 'No reviews found' row if it exists
                if(tableBody.querySelector('td[colspan="5"]')) {
                    tableBody.innerHTML = '';
                }

                let firstLetter = data.product_name ? data.product_name.charAt(0).toUpperCase() : 'U';
                let csrfToken = form.querySelector('input[name="_token"]').value;
                let deleteUrl = "{{ url('admin/reviews') }}/" + data.review.id;
                let statusUrl = "{{ route('admin.reviews.status') }}";

                let newRow = `
                    <tr id="review-row-${data.review.id}" class="bg-light" style="animation: highlight 2s;">
                        <td style="padding-left: 1.5rem;"><input type="checkbox" value="${data.review.id}"></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center text-primary font-weight-bold mr-3 shadow-sm border" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    ${firstLetter}
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold text-dark">${data.product_name}</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.75rem;">ID: ${data.review.product}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex" style="gap: 5px;">
                                <img src="${data.image_url}" class="rounded border" alt="review_img" style="object-fit: cover; width: 50px; height: 50px;">
                            </div>
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" onchange="updateStatus(${data.review.id}, this.checked ? '1' : '0')" ${data.review.status == '1' ? 'checked' : ''}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-right" style="padding-right: 1.5rem;">
                            <div class="btn-group shadow-sm rounded-pill p-1" style="background: #ffffff; border: 1px solid #e9ecef;">
                                <form action="${deleteUrl}" method="POST" onsubmit="confirmDelete(event, this);" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-action text-danger border-0 bg-transparent" title="Delete"><i class="mdi mdi-delete"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('afterbegin', newRow);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.'
            });
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    });

    function updateStatus(id, status) {
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('id', id);
        formData.append('status', status);

        fetch("{{ route('admin.reviews.status') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                    icon: 'success', title: data.message
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to update status!'
            });
        });
    }
</script>

@endsection