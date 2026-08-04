@extends('layouts.backend.masterLay')
@section('title','ORDER STATUS')
@section('content')

    <!-- Style additions for hover-up buttons and custom cards -->
    <style>
        .premium-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden;
        }
        .premium-card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem 2rem !important;
        }
        .premium-table {
            margin-bottom: 0;
        }
        .premium-table thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-top: none !important;
        }
        .premium-table tbody td {
            padding: 1.2rem 1.5rem !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-top: none !important;
        }
        .premium-table tbody tr:last-child td {
            border-bottom: none !important;
        }
        .btn-add-status {
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            border: none;
            color: white !important;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        }
        .btn-add-status:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }
        .badge-success-light {
            background-color: rgba(40, 167, 69, 0.1) !important;
            color: #28a745 !important;
        }
        .badge-secondary-light {
            background-color: rgba(108, 117, 125, 0.1) !important;
            color: #6c757d !important;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card premium-card">
                <div class="card-header premium-card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-dark font-weight-bold mb-0">
                        <i class="ti-layout-list-thumb text-primary mr-2" style="font-size: 1.2rem;"></i>
                        Order Status List
                    </h4>
                    <button class="btn btn-add-status add-status-btn">
                        <i class="ti-plus mr-1"></i> Add New Status
                    </button>
                </div>
                <div class="card-body p-0">
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-xs mx-4 my-3 rounded-lg py-3 px-4 d-flex align-items-center">
                            <i class="ti-check-box mr-3 fs-4 text-success"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table premium-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th style="width: 80px;">SL</th>
                                    <th>Status Name</th>
                                    <th>Status</th>
                                    <th class="text-right" style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orderStatuses as $orderStatus)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_status[]" value="{{ $orderStatus->id }}" class="status-checkbox">
                                        </td>
                                        <td class="text-dark font-weight-medium">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="font-weight-semibold text-dark" style="font-size: 0.925rem;">{{ $orderStatus->name }}</span>
                                        </td>
                                        <td>
                                            @if($orderStatus->status == 1)
                                                <span class="badge badge-success-light px-3 py-2 rounded-pill font-weight-bold">Active</span>
                                            @else
                                                <span class="badge badge-secondary-light px-3 py-2 rounded-pill font-weight-bold">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill px-3 mr-1 edit-btn" 
                                                    data-id="{{ $orderStatus->id }}" 
                                                    data-name="{{ $orderStatus->name }}" 
                                                    data-status="{{ $orderStatus->status }}">
                                                <i class="ti-pencil text-primary mr-1"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.orderStatus.destroy', $orderStatus->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm rounded-pill px-3 delete-btn">
                                                    <i class="ti-trash text-danger mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="ti-face-sad mb-2 d-block text-muted" style="font-size: 2.5rem;"></i>
                                            <p class="mb-0">No order statuses found. Click "Add New Status" to create one.</p>
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

    <!-- Bootstrap 4 Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow border-0" style="border-radius: 16px;">
                <div class="modal-header bg-primary py-3 px-4" style="border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: none;">
                    <h5 class="modal-title text-white font-weight-bold" id="modalTitle">Add Order Status</h5>
                    <button type="button" class="close text-white opacity-8" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.orderStatus.store') }}" method="POST" id="statusForm">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label for="status_name" class="font-weight-semibold text-dark mb-1">Status Name</label>
                            <input type="text" name="status_name" id="status_name" class="form-control rounded-lg" placeholder="e.g. Processing, Shipped" style="height: 45px; border: 1.5px solid #e2e8f0;" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="status_active" class="font-weight-semibold text-dark mb-1">Status</label>
                            <select name="status" id="status_active" class="form-control rounded-lg" style="height: 45px; border: 1.5px solid #e2e8f0;">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 p-3 bg-light" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <button type="button" class="btn btn-link text-secondary rounded-pill px-4 font-weight-semibold" data-dismiss="modal" style="text-decoration: none;">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-semibold shadow-sm">Save Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 & JS scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select All Checkboxes
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.status-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                });
            }

            // Trigger Add Modal
            document.querySelectorAll('.add-status-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('modalTitle').textContent = 'Add Order Status';
                    document.getElementById('statusForm').setAttribute('action', "{{ route('admin.orderStatus.store') }}");
                    document.getElementById('formMethod').value = 'POST';
                    document.getElementById('status_name').value = '';
                    document.getElementById('status_active').value = '1';
                    
                    // Show modal via Bootstrap jQuery API
                    $('#statusModal').modal('show');
                });
            });

            // Trigger Edit Modal (Populate values)
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const status = this.getAttribute('data-status');
                    const url = "{{ url('admin/order-status') }}/" + id;

                    document.getElementById('modalTitle').textContent = 'Edit Order Status';
                    document.getElementById('statusForm').setAttribute('action', url);
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('status_name').value = name;
                    document.getElementById('status_active').value = status;
                    
                    $('#statusModal').modal('show');
                });
            });

            // Confirmation on delete action
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to delete this status?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection