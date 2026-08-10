@extends('layouts.backend.masterLay')
@section('title','Orders Overview')
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
    
    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .icon-wrapper {
        width: 54px; height: 54px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
    }
    
    .bg-gradient-primary { background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #4cc9f0 0%, #00b4d8 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f72585 0%, #b5179e 100%); color: white; }
    .bg-gradient-danger { background: linear-gradient(135deg, #e63946 0%, #d62828 100%); color: white; }
    
    .table-container { border-radius: 16px; overflow: visible !important; }
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
    .table-responsive { overflow: visible !important; }
    
    .filter-section {
        background: white; border-radius: 16px; padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 2rem;
    }
    .form-control, .custom-select {
        border-radius: 10px; border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem; transition: all 0.2s;
    }
    .form-control:focus, .custom-select:focus {
        border-color: #4361ee; box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    }
    .btn-action { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;}
    .btn-action:hover { transform: translateY(-2px); }
</style>

@php
    $icons = [
        'pending' => ['icon' => 'mdi-clock-outline', 'bg' => 'bg-gradient-warning'],
        'hold' => ['icon' => 'mdi-pause-circle-outline', 'bg' => 'bg-gradient-danger'],
        'processing' => ['icon' => 'mdi-cogs', 'bg' => 'bg-gradient-info'],
        'approved' => ['icon' => 'mdi-check-decagram', 'bg' => 'bg-gradient-primary'],
        'shipped' => ['icon' => 'mdi-truck-fast', 'bg' => 'bg-gradient-primary'],
        'delivered' => ['icon' => 'mdi-check-circle-outline', 'bg' => 'bg-gradient-success'],
        'cancelled' => ['icon' => 'mdi-close-circle-outline', 'bg' => 'bg-gradient-danger'],
        'returned' => ['icon' => 'mdi-keyboard-return', 'bg' => 'bg-gradient-danger'],
    ];
@endphp

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 font-weight-bold text-dark" style="letter-spacing: -0.5px;">Orders Overview</h3>
            <p class="text-muted mb-0">Manage and track all your incoming orders.</p>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row mb-2">
        @forelse($statusCounts ?? [] as $status => $count)
            @php $statusConfig = $icons[strtolower($status)] ?? ['icon' => 'mdi-label', 'bg' => 'bg-gradient-primary']; @endphp
            
            <div class="col-xl-3 col-lg-4 col-sm-6 mb-4">
                <div class="glass-card status-card h-100 p-4" style="cursor: pointer; transition: transform 0.2s ease;" onclick="filterOrdersByStatus('{{ $status }}')" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted font-weight-bold text-uppercase mb-1" style="font-size: 0.8rem; letter-spacing: 1px;">{{ $status }}</p>
                            <h2 class="font-weight-bold text-dark mb-0">{{ $count }}</h2>
                        </div>
                        <div class="icon-wrapper {{ $statusConfig['bg'] }} shadow">
                            <i class="mdi {{ $statusConfig['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info border-0 rounded-lg"><i class="mdi mdi-information mr-2"></i> No order data available.</div></div>
        @endforelse
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold text-dark mb-3"><i class="mdi mdi-filter-variant mr-2 text-primary"></i>Advanced Filter</h6>

            <div>
                <a href="{{ route('admin.orders.create') ?? '#' }}" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%); border: none;">
                    <i class="mdi mdi-plus mr-1"></i> Create Order
                </a>
            </div>
        </div>
        <div class="row align-items-end">
            <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                <label class="text-muted small font-weight-bold">Search Order</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text bg-light border-0"><i class="mdi mdi-magnify text-muted"></i></span></div>
                    <input type="text" id="search-input" class="form-control bg-light border-0" placeholder="Order ID, Name, or Phone">
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-3 mb-lg-0">
                <label class="text-muted small font-weight-bold">Status</label>
                <select id="status-filter" class="form-control bg-light border-0 custom-select">
                    <option value="">All Statuses</option>
                    @foreach($orderStatuses as $statusRow)
                        <option value="{{ $statusRow->name }}">{{ $statusRow->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-4 mb-3 mb-lg-0">
                <label class="text-muted small font-weight-bold">From Date</label>
                <input type="date" id="from-date" class="form-control bg-light border-0">
            </div>
            <div class="col-lg-2 col-md-4 mb-3 mb-lg-0">
                <label class="text-muted small font-weight-bold">To Date</label>
                <input type="date" id="to-date" class="form-control bg-light border-0">
            </div>
            <div class="col-lg-3 col-md-4 text-right">
                <button id="reset-filter" class="btn btn-light rounded-pill px-4 mr-2">Reset</button>
                <button id="apply-filter" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: #4361ee; border: none;">Apply Filter</button>
            </div>
        </div>
    </div>

    <!-- Bulk Action & Table -->
    <div class="glass-card table-container">
        <div class="courier-entry px-4 pt-3 pb-2 d-flex justify-content-between align-items-center">
            <h5 class="font-weight-bold text-dark mb-0">Courier Integration</h5>
            <button type="button" id="send-steadfast-btn" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none;">
                <i class="mdi mdi-truck-fast mr-1"></i> Send to SteadFast
            </button>
        </div>
        <div class="p-4 d-flex justify-content-between align-items-center border-bottom bg-white">
            <h5 class="font-weight-bold text-dark mb-0">Order List</h5>
            <div class="d-flex align-items-center">
                <select class="form-control form-control-sm mr-2 rounded-pill bg-light border-0 px-3" style="width: 150px;">
                    <option value="">Bulk Action</option>
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
                        <th>Order ID</th>
                        <th>Customer Details</th>
                        <th>Product Info</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>History</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="orders-table-body">
                    @include('backend.orders.partials.order_rows')
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
function updateOrderStatus(e, orderId, statusName, url) {
    e.preventDefault();
    
    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    formData.append('order_status', statusName);

    fetch(url, {
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
                icon: 'success', title: 'Order status updated to ' + data.status_text
            });
            
            // Update the badge
            let badge = document.getElementById('order-status-badge-' + orderId);
            if(badge) {
                badge.className = 'badge p-2 rounded-pill px-3 shadow-sm ' + data.badge_class;
                badge.innerText = data.status_text;
                badge.style.transition = 'transform 0.3s ease';
                badge.style.transform = 'scale(1.1)';
                setTimeout(() => { badge.style.transform = 'scale(1)'; }, 300);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error', title: 'Oops...', text: 'Failed to update order status!'
        });
    });
}

function filterOrdersByStatus(status) {
    document.getElementById('status-filter').value = status;
    document.getElementById('apply-filter').click();
}

document.getElementById('apply-filter').addEventListener('click', function() {
    let search = document.getElementById('search-input').value;
    let status = document.getElementById('status-filter').value;
    let from_date = document.getElementById('from-date').value;
    let to_date = document.getElementById('to-date').value;
    
    let url = new URL('{{ route('admin.orders.index') }}');
    if (search) url.searchParams.append('search', search);
    if (status) url.searchParams.append('status', status);
    if (from_date) url.searchParams.append('from_date', from_date);
    if (to_date) url.searchParams.append('to_date', to_date);
    
    let tbody = document.getElementById('orders-table-body');
    tbody.style.opacity = '0.5';
    tbody.style.transition = 'opacity 0.3s';
    
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(response => response.json())
    .then(data => {
        if(data.html !== undefined) {
            tbody.innerHTML = data.html;
            tbody.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error fetching filtered orders:', error);
        tbody.style.opacity = '1';
        Swal.fire({icon: 'error', title: 'Oops...', text: 'Failed to filter orders.'});
    });
});

document.getElementById('reset-filter').addEventListener('click', function() {
    document.getElementById('search-input').value = '';
    document.getElementById('status-filter').value = '';
    document.getElementById('from-date').value = '';
    document.getElementById('to-date').value = '';
    document.getElementById('apply-filter').click();
});

// Select All functionality
document.querySelector('.select-all').addEventListener('change', function(e) {
    document.querySelectorAll('.order-checkbox').forEach(function(checkbox) {
        checkbox.checked = e.target.checked;
    });
});

// SteadFast Bulk Entry
document.getElementById('send-steadfast-btn').addEventListener('click', function() {
    let selectedOrders = [];
    document.querySelectorAll('.order-checkbox:checked').forEach(function(checkbox) {
        selectedOrders.push(checkbox.value);
    });

    if (selectedOrders.length === 0) {
        Swal.fire({icon: 'warning', title: 'Oops...', text: 'Please select at least one order to send.'});
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: `You are about to send ${selectedOrders.length} orders to SteadFast Courier.`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#38ef7d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send them!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sending Orders...',
                html: 'Please wait while we connect to SteadFast.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route('admin.orders.steadfast.bulk') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ order_ids: selectedOrders })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({icon: 'success', title: 'Success!', text: data.message}).then(() => {
                        document.getElementById('apply-filter').click(); // Reload table seamlessly
                    });
                } else {
                    Swal.fire({icon: 'error', title: 'Error!', text: data.message});
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({icon: 'error', title: 'Oops...', text: 'An unexpected error occurred.'});
            });
        }
    });
});
</script>
@endpush
@endsection