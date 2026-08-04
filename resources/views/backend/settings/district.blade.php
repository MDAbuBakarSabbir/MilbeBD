@extends('layouts.backend.masterLay')
@section('title', 'District Settings')
@section('content')

    <!-- Custom styling for premium district table, cards, and switches -->
    <style>
        .district-card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            background: #ffffff;
            overflow: hidden;
        }
        .district-card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 1.5rem 2rem !important;
        }
        .btn-add-district {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            border: none;
            color: white;
            padding: 0.65rem 1.6rem;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
            transition: all 0.3s ease;
        }
        .btn-add-district:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: white;
        }
        .table-custom {
            margin-bottom: 0;
        }
        .table-custom thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.6px;
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 1.5rem;
        }
        .table-custom tbody td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 0.95rem;
        }
        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }
        .badge-status {
            font-weight: 600;
            padding: 0.45rem 1rem;
            border-radius: 30px;
            font-size: 0.82rem;
        }
        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-inactive {
            background-color: #f1f5f9;
            color: #64748b;
        }
        .charge-badge {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            color: #334155;
            font-weight: 700;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            display: inline-block;
        }
        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            border: none;
            margin-right: 0.3rem;
        }
        .btn-action-edit {
            background-color: #e0e7ff;
            color: #4f46e5;
        }
        .btn-action-edit:hover {
            background-color: #4f46e5;
            color: white;
        }
        .btn-action-delete {
            background-color: #fee2e2;
            color: #ef4444;
        }
        .btn-action-delete:hover {
            background-color: #ef4444;
            color: white;
        }
        /* Custom Switch inside Modal */
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
    </style>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1">
                        <i class="ti-map-alt text-primary mr-2"></i> District & Delivery Charges
                    </h3>
                    <p class="text-muted mb-0">Configure regional delivery zones, shipping fees, and active coverage areas.</p>
                </div>
                <div>
                    <button type="button" class="btn btn-add-district" id="btnOpenAddModal">
                        <i class="ti-plus mr-2"></i> Add New District
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg py-3 px-4 mb-4 d-flex align-items-center">
            <i class="ti-check-box mr-3 fs-4 text-success" style="font-size: 1.5rem;"></i>
            <div class="font-weight-semibold text-dark">{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-lg py-3 px-4 mb-4">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- District Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card district-card shadow-sm">
                <div class="district-card-header d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-dark mb-0">District List</h5>
                    <span class="badge badge-primary badge-pill px-3 py-2 font-weight-bold">
                        Total: {{ isset($districts) ? count($districts) : 0 }} Zones
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th width="8%" class="text-center">#</th>
                                    <th width="35%">District Name</th>
                                    <th width="25%">Delivery Charge</th>
                                    <th width="17%" class="text-center">Status</th>
                                    <th width="15%" class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($districts as $key => $district)
                                    <tr>
                                        <td class="text-center font-weight-bold text-muted">{{ $key + 1 }}</td>
                                        <td class="font-weight-semibold text-dark">
                                            <i class="ti-location-pin text-primary mr-2"></i> {{ $district->name }}
                                        </td>
                                        <td>
                                            <span class="charge-badge">
                                                ৳ {{ number_format($district->delivery_charge, 2) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($district->status == '1')
                                                <span class="badge badge-status badge-active">Active</span>
                                            @else
                                                <span class="badge badge-status badge-inactive">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-action btn-action-edit btn-edit-district"
                                                    data-id="{{ $district->id }}"
                                                    data-name="{{ $district->name }}"
                                                    data-charge="{{ $district->delivery_charge }}"
                                                    data-status="{{ $district->status }}"
                                                    title="Edit District">
                                                <i class="ti-pencil"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.districts.destroy', $district->id) }}" method="POST" class="d-inline form-delete-district">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-action btn-action-delete btn-delete-district" title="Delete District">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="ti-map-alt d-block mb-3" style="font-size: 2.5rem; opacity: 0.5;"></i>
                                            <h5>No Districts Configured Yet</h5>
                                            <p class="mb-0">Click the "+ Add New District" button above to add your first delivery zone.</p>
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

    <!-- Bootstrap Modal for Add/Edit District -->
    <div class="modal fade" id="districtModal" tabindex="-1" role="dialog" aria-labelledby="districtModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 rounded-lg shadow-lg overflow-hidden" style="border-radius: 16px !important;">
                <div class="modal-header bg-light py-3 px-4 border-bottom">
                    <h5 class="modal-title font-weight-bold text-dark" id="districtModalLabel">
                        <i class="ti-plus text-primary mr-2"></i> Add New District
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form id="districtForm" action="{{ route('admin.districts.store') }}" method="POST">
                    @csrf
                    <div id="methodContainer"></div>

                    <div class="modal-body p-4">
                        <div class="form-group mb-4">
                            <label for="district_name" class="font-weight-semibold text-dark mb-2">District Name</label>
                            <input type="text" name="name" id="district_name" class="form-control form-control-custom" 
                                   placeholder="e.g. Dhaka City, Chittagong, Sylhet" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="district_charge" class="font-weight-semibold text-dark mb-2">Delivery Charge (৳ BDT)</label>
                            <input type="number" step="0.01" name="delivery_charge" id="district_charge" class="form-control form-control-custom" 
                                   placeholder="e.g. 60 or 120" required>
                        </div>

                        <div class="form-group mb-2 d-flex justify-content-between align-items-center p-3 rounded" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0;">
                            <div>
                                <span class="font-weight-semibold text-dark d-block">District Status</span>
                                <small class="text-muted">Enable to make this district selectable for orders</small>
                            </div>
                            <label class="switch-custom mb-0">
                                <input type="checkbox" name="status" id="district_status" value="1" checked>
                                <span class="slider-round"></span>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer bg-light py-3 px-4 border-top">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-add-district px-4" id="btnSubmitDistrict">Save District</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 for polished delete confirmation -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Open Modal for Add
            const btnOpenAddModal = document.getElementById('btnOpenAddModal');
            if (btnOpenAddModal) {
                btnOpenAddModal.addEventListener('click', function() {
                    document.getElementById('districtModalLabel').innerHTML = '<i class="ti-plus text-primary mr-2"></i> Add New District';
                    document.getElementById('districtForm').action = "{{ route('admin.districts.store') }}";
                    document.getElementById('methodContainer').innerHTML = '';
                    document.getElementById('district_name').value = '';
                    document.getElementById('district_charge').value = '';
                    document.getElementById('district_status').checked = true;
                    document.getElementById('btnSubmitDistrict').textContent = 'Save District';
                    $('#districtModal').modal('show');
                });
            }

            // Open Modal for Edit
            document.querySelectorAll('.btn-edit-district').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const charge = this.getAttribute('data-charge');
                    const status = this.getAttribute('data-status');

                    document.getElementById('districtModalLabel').innerHTML = '<i class="ti-pencil text-primary mr-2"></i> Edit District';
                    document.getElementById('districtForm').action = "{{ url('admin/districts') }}/" + id;
                    document.getElementById('methodContainer').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                    
                    document.getElementById('district_name').value = name;
                    document.getElementById('district_charge').value = charge;
                    document.getElementById('district_status').checked = (status === '1');
                    document.getElementById('btnSubmitDistrict').textContent = 'Update District';

                    $('#districtModal').modal('show');
                });
            });

            @if(isset($editDistrict))
                // If controller redirected directly to edit view
                document.getElementById('districtModalLabel').innerHTML = '<i class="ti-pencil text-primary mr-2"></i> Edit District';
                document.getElementById('districtForm').action = "{{ route('admin.districts.update', $editDistrict->id) }}";
                document.getElementById('methodContainer').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                document.getElementById('district_name').value = "{{ $editDistrict->name }}";
                document.getElementById('district_charge').value = "{{ $editDistrict->delivery_charge }}";
                document.getElementById('district_status').checked = {{ $editDistrict->status == '1' ? 'true' : 'false' }};
                document.getElementById('btnSubmitDistrict').textContent = 'Update District';
                $('#districtModal').modal('show');
            @endif

            // Delete confirmation with SweetAlert2
            document.querySelectorAll('.btn-delete-district').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This district will be permanently deleted from delivery zones!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
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