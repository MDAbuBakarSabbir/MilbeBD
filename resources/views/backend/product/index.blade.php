@extends('layouts.backend.masterLay')
@section('title', 'Products')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Products</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Color / Variant</th>
                                <th>Image</th>
                                <th>Regular Price</th>
                                <th>Sale Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td><span class="badge badge-info">{{ $product->color ?? 'স্ট্যান্ডার্ড' }}</span></td>
                                    <td>
                                        <img src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->title }}"
                                            class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>৳ {{ $product->regular_price }}</td>
                                    <td>৳ {{ $product->discounted_price }}</td>
                                    <td>
                                        <button type="button" title="Edit"
                                            class="btn btn-primary edit-product-btn"
                                            data-toggle="modal" 
                                            data-target="#editProductModal"
                                            data-id="{{ $product->id }}"
                                            data-title="{{ $product->title }}"
                                            data-color="{{ $product->color ?? 'স্ট্যান্ডার্ড' }}"
                                            data-regular-price="{{ $product->regular_price }}"
                                            data-discounted-price="{{ $product->discounted_price }}"
                                            data-image="{{ asset('image/product/' . $product->image) }}"
                                            data-action="{{ route('admin.product.update', $product->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
            <!-- Edit Product Modal -->
            <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST" id="editProductForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title / Name</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color / Variant Name</label>
                                    <input type="text" class="form-control" id="color" name="color" placeholder="e.g. স্ট্যান্ডার্ড বা ব্ল্যাক">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image (Leave blank to keep current)</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <div class="mt-3 text-center">
                                        <img id="image_preview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; display: none; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="regular_price" class="form-label">Regular Price</label>
                                    <input type="text" class="form-control" id="regular_price" name="regular_price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="discounted_price" class="form-label">Discounted / Sale Price</label>
                                    <input type="text" class="form-control" id="discounted_price" name="discounted_price">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.edit-product-btn').on('click', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let color = $(this).data('color');
            let regularPrice = $(this).data('regular-price');
            let discountedPrice = $(this).data('discounted-price');
            let actionUrl = $(this).data('action');
            let imageUrl = $(this).data('image');

            $('#editProductForm').attr('action', actionUrl);
            $('#editProductForm #title').val(title);
            $('#editProductForm #color').val(color);
            $('#editProductForm #regular_price').val(regularPrice);
            $('#editProductForm #discounted_price').val(discountedPrice);
            
            // Show current image in preview
            if(imageUrl && !imageUrl.endsWith('/image/product/')) {
                $('#image_preview').attr('src', imageUrl).show();
            } else {
                $('#image_preview').hide();
            }
        });

        // Image preview on file select
        $('#image').on('change', function() {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#image_preview').attr('src', event.target.result).show();
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush

@endsection