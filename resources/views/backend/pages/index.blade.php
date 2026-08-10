@extends('layouts.backend.masterLay')
@section('title', 'Pages')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pt-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold mb-0">Pages List</h4>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm rounded px-3 shadow-sm">
                    <i class="fa fa-plus mr-1"></i> Add New Page
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm text-center align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th class="text-left">Title</th>
                                <th class="text-left">Content</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td><strong>{{ $loop->iteration }}</strong></td>
                                    <td class="text-left">{{ $page->title }}</td>
                                    <td>{{ Str::limit($page->content, 30, '...') }}</td>
                                    <td><span class="badge badge-light text-muted">{{ $page->slug ?? Str::slug($page->title) }}</span></td>
                                    <td>
                                        <div class="custom-control custom-switch d-flex justify-content-center">
                                            <input type="checkbox" class="custom-control-input status-toggle" id="statusSwitch{{ $page->id }}" data-id="{{ $page->id }}" {{ $page->status == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="statusSwitch{{ $page->id }}" style="cursor: pointer;"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary shadow btn-sm sharp mr-2" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline-block delete-page-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger shadow btn-sm sharp" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted mb-2"><i class="fa fa-folder-open fa-2x"></i></div>
                                        No pages found. <a href="{{ route('admin.pages.create') }}" class="text-primary">Create one now</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.status-toggle').on('change', function() {
            let status = $(this).prop('checked') ? 1 : 0;
            let pageId = $(this).data('id');
            
            $.ajax({
                url: "{{ route('admin.pages.status') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: pageId,
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong.'
                        });
                        $(`#statusSwitch${pageId}`).prop('checked', !status);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while updating status.'
                    });
                    $(`#statusSwitch${pageId}`).prop('checked', !status);
                }
            });
        });
        $('.delete-page-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
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
        });
    });
</script>
@endpush