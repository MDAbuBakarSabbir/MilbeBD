@extends('layouts.backend.masterLay')
@section('title','Incomplete Orders')
@section('content')

@php
    $totalLeads = $orders->count();
    $potentialRevenue = $orders->sum(function($order) {
        return floatval($order->grand_total ?: 0);
    });
    $todayLeads = $orders->filter(function($order) {
        if ($order->created_at) {
            return $order->created_at->isToday();
        }
        if ($order->order_date) {
            return date('Y-m-d', strtotime($order->order_date)) === date('Y-m-d');
        }
        return false;
    })->count();
@endphp

<style>
    /* Premium Dashboard Aesthetic Upgrades */
    .dashboard-stat-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        background: #ffffff;
    }
    .dashboard-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }
    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.12) !important;
        color: #ffc107 !important;
    }
    .bg-light-success {
        background-color: rgba(40, 167, 69, 0.12) !important;
        color: #28a745 !important;
    }
    .bg-light-info {
        background-color: rgba(23, 162, 184, 0.12) !important;
        color: #17a2b8 !important;
    }
    .bg-light-danger {
        background-color: rgba(220, 53, 69, 0.12) !important;
        color: #dc3545 !important;
    }
    .card-premium {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.03);
        background: #ffffff;
        margin-bottom: 2rem;
    }
    .card-premium .card-header {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
        padding: 1.25rem 1.5rem;
    }
    .table-premium {
        width: 100%;
        margin-bottom: 0;
    }
    .table-premium thead th {
        background-color: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1.1rem 1.25rem;
        border-bottom: 2px solid #e2e8f0;
    }
    .table-premium tbody td {
        padding: 1.2rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .table-premium tbody tr:hover {
        background-color: #fafbfc;
    }
    .avatar-product {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .badge-premium-warning {
        background-color: rgba(255, 193, 7, 0.12) !important;
        color: #ffc107 !important;
        border: 1px solid rgba(255, 193, 7, 0.2);
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.02em;
    }
    .badge-phone {
        background-color: rgba(102, 126, 234, 0.1) !important;
        color: #667eea !important;
        border: 1px solid rgba(102, 126, 234, 0.2);
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    .badge-phone:hover {
        background-color: rgba(102, 126, 234, 0.2) !important;
        text-decoration: none;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
    }
    .action-btn:hover {
        transform: translateY(-2px);
    }
    .form-control-premium {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .form-control-premium:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }
    .gap-2 {
        gap: 0.5rem !important;
    }
</style>

<!-- Stats Cards Row -->
<div class="row mb-2">
    <!-- Total Incomplete Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Incomplete</h6>
                    <h3 class="mb-0 font-weight-bold text-dark">{{ $totalLeads }}</h3>
                    <small class="text-warning mt-1 d-block"><i class="fa-solid fa-circle-exclamation mr-1"></i> Awaiting follow up</small>
                </div>
                <div class="stat-icon-wrapper bg-light-warning">
                    <i class="fa-solid fa-clipboard-question"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Potential Revenue Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Potential Value</h6>
                    <h3 class="mb-0 font-weight-bold text-dark">৳ {{ number_format($potentialRevenue, 2) }}</h3>
                    <small class="text-success mt-1 d-block"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Lead value in cart</small>
                </div>
                <div class="stat-icon-wrapper bg-light-success">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Today's Leads Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-stat-card h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <div>
                    <h6 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Today's Leads</h6>
                    <h3 class="mb-0 font-weight-bold text-dark">{{ $todayLeads }}</h3>
                    <small class="text-info mt-1 d-block"><i class="fa-solid fa-bolt mr-1"></i> Captured today</small>
                </div>
                <div class="stat-icon-wrapper bg-light-info">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-filter text-primary mr-2"></i>Filter Leads</span>
                <span class="badge bg-light text-dark font-weight-medium px-3 py-2 rounded-pill" style="font-size: 0.8rem;">Real-time Search Active</span>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-end g-3">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label font-weight-bold text-dark" style="font-size: 0.8rem;">Search Customer/ID</label>
                        <input type="text" id="searchInput" class="form-control form-control-premium" placeholder="Name, Phone, Order ID..." title="Search by details">
                    </div>
                    <div class="col-lg-2.5 col-md-3 col-6">
                        <label class="form-label font-weight-bold text-dark" style="font-size: 0.8rem;">From Date</label>
                        <input type="date" id="fromDateInput" class="form-control form-control-premium" title="From Date">
                    </div>
                    <div class="col-lg-2.5 col-md-3 col-6">
                        <label class="form-label font-weight-bold text-dark" style="font-size: 0.8rem;">To Date</label>
                        <input type="date" id="toDateInput" class="form-control form-control-premium" title="To Date">
                    </div>
                    <div class="col-lg-3 col-md-12 d-flex gap-2 justify-content-md-end mt-4 mt-lg-0">
                        <button type="button" id="resetBtn" class="btn btn-light font-weight-bold px-4 py-2 w-100 w-md-auto" style="border-radius: 10px; border: 1.5px solid #e2e8f0;">
                            <i class="fa-solid fa-rotate-right mr-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="row">
    <div class="col-lg-12">
        <div class="card card-premium">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fa-solid fa-list text-primary mr-2"></i>Lead Records</span>
                <span class="badge bg-primary text-white font-weight-bold px-3 py-1 rounded-pill" style="font-size: 0.8rem; background-color: #667eea !important;">{{ $totalLeads }} Leads</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-premium align-middle" id="leadsTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;">SL</th>
                                <th>Order ID</th>
                                <th>Customer Details</th>
                                <th>Contact & Courier</th>
                                <th>Product Details</th>
                                <th>Cart Amount</th>
                                <th>Date & Status</th>
                                <th class="text-right" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr class="lead-row" data-name="{{ strtolower($order->customer_name) }}" data-phone="{{ $order->customer_phone }}" data-id="{{ strtolower($order->order_id) }}" data-date="{{ $order->created_at ? $order->created_at->format('Y-m-d') : date('Y-m-d', strtotime($order->order_date)) }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-weight-bold text-primary">{{ $order->order_id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $order->customer_name }}</div>
                                        <span class="text-muted" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $order->customer_address }}{{ $order->customer_district && $order->customer_district !== 'N/A' ? ', '.$order->customer_district : '' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->customer_phone && $order->customer_phone !== 'N/A')
                                            <a href="tel:{{ $order->customer_phone }}" class="badge-phone mb-1" title="Call Customer">
                                                <i class="fa-solid fa-phone mr-1"></i> {{ $order->customer_phone }}
                                            </a>
                                        @else
                                            <span class="badge bg-light text-muted">No Phone</span>
                                        @endif
                                        <div style="font-size: 0.8rem;" class="mt-1">
                                            <span class="text-muted">History:</span> 
                                            <span class="font-weight-medium text-dark">{{ $order->courier_history ?: 'No Courier Log' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#667eea" stroke-width="1.5" class="avatar-product" style="background-color: rgba(102, 126, 234, 0.08); padding: 8px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 text-dark font-weight-bold" style="font-size: 0.9rem;">{{ $order->product_id }}</h6>
                                                <p class="text-muted mb-0" style="font-size: 0.75rem;">Color: {{ $order->product_color ?: 'N/A' }} | Qty: {{ $order->product_quantity ?: '1' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold text-dark">৳ {{ number_format(floatval($order->grand_total ?: 0), 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-premium-warning d-inline-block mb-1">{{ $order->order_status }}</span>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                                            <i class="fa-regular fa-calendar mr-1"></i> {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : date('d M Y, h:i A', strtotime($order->order_date)) }}
                                        </small>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="action-btn bg-light-warning" title="Edit Order Details">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete lead #{{ $order->order_id }}?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn bg-light-danger text-danger" title="Delete Lead">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 50px; height: 50px; color: #cbd5e1; margin-bottom: 12px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="font-weight-bold mb-1 text-dark">No Incomplete Orders Found</p>
                                        <p class="text-muted small">All checkout leads are currently converted or none exist yet.</p>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const fromDateInput = document.getElementById("fromDateInput");
        const toDateInput = document.getElementById("toDateInput");
        const resetBtn = document.getElementById("resetBtn");
        const rows = document.querySelectorAll(".lead-row");

        function filterLeads() {
            const query = searchInput.value.toLowerCase().trim();
            const fromDateStr = fromDateInput.value;
            const toDateStr = toDateInput.value;

            rows.forEach(row => {
                const name = row.getAttribute("data-name") || "";
                const phone = row.getAttribute("data-phone") || "";
                const orderId = row.getAttribute("data-id") || "";
                const rowDate = row.getAttribute("data-date") || "";

                // 1. Search Query Filter
                const matchesQuery = query === "" || 
                    name.includes(query) || 
                    phone.includes(query) || 
                    orderId.includes(query);

                // 2. Custom Date Range Filter
                let matchesRange = true;
                if (fromDateStr && rowDate < fromDateStr) {
                    matchesRange = false;
                }
                if (toDateStr && rowDate > toDateStr) {
                    matchesRange = false;
                }

                if (matchesQuery && matchesRange) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Add event listeners for dynamic real-time filtering
        searchInput.addEventListener("input", filterLeads);
        fromDateInput.addEventListener("change", filterLeads);
        toDateInput.addEventListener("change", filterLeads);

        // Reset fields action
        resetBtn.addEventListener("click", function () {
            searchInput.value = "";
            fromDateInput.value = "";
            toDateInput.value = "";
            rows.forEach(row => row.style.display = "");
        });
    });
</script>

@endsection