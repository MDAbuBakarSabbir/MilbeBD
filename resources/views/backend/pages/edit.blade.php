@extends('layouts.backend.masterLay')
@section('title', 'Edit Page')

@push('styles')
<link href="{{ asset('assets/backend/vendor/summernote/summernote.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pt-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold mb-0">Edit Page: {{ $page->title }}</h4>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-primary btn-sm rounded px-3">
                    <i class="fa fa-arrow-left mr-2"></i> Back to Pages
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label for="title" class="font-weight-bold">Page Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light" id="title" name="title" value="{{ $page->title }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select class="form-control form-control-lg bg-light" id="status" name="status">
                                    <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-4">
                                <label for="content" class="font-weight-bold">Page Content <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote" id="content" name="content" required>{{ $page->content }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-primary btn-lg rounded px-5">
                            <i class="fa fa-save mr-2"></i> Update Page
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/backend/vendor/summernote/js/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 350,
            placeholder: 'Write your page content here...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush