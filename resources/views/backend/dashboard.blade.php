@extends('layouts.backend.masterLay')
@section('title', 'Dashboard')

@section('content')
<style>
    .stat-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        background: #fff;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }
    .stat-icon-wrapper {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: white; }
    .bg-gradient-info { background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); color: white; }
    .bg-gradient-success { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: white; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }
    .modern-table thead th {
        border-top: none;
        border-bottom: 2px solid #f4f5f9;
        color: #8f9fc2;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
    }
    .modern-table tbody td {
        vertical-align: middle;
        border-bottom: 1px solid #f4f5f9;
        color: #2d3748;
        font-weight: 500;
        padding: 18px 10px;
    }
    .badge-soft-warning { background-color: #fff4e5; color: #ff9800; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; }
    .badge-soft-success { background-color: #e6f8f0; color: #10c469; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; }
    .badge-soft-danger { background-color: #ffe8e8; color: #ff5b5b; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; }
    
    .stat-list-item {
        padding: 15px 20px;
        border-radius: 15px;
        background: #f8f9fa;
        margin-bottom: 15px;
        transition: 0.3s;
    }
    .stat-list-item:hover { background: #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.06); transform: scale(1.02); }
</style>

<div class="row mb-4">
    <!-- Stat 1 -->
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0">
        <a href="{{ route('admin.orders.index', ['status' => 'Pending']) }}" class="text-decoration-none">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-wrapper bg-gradient-warning shadow-sm mr-4">
                        <i class="mdi mdi-clock-outline"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 font-weight-bold text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Pending Order</p>
                        <h3 class="font-weight-bolder text-dark m-0">{{ number_format($stats['pending']) }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 2 -->
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0">
        <a href="{{ route('admin.orders.index', ['from_date' => date('Y-m-d'), 'to_date' => date('Y-m-d')]) }}" class="text-decoration-none">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-wrapper bg-gradient-info shadow-sm mr-4">
                        <i class="mdi mdi-calendar-today"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 font-weight-bold text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Today's Order</p>
                        <h3 class="font-weight-bolder text-dark m-0">{{ number_format($stats['today']) }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 3 -->
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-sm-0">
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-wrapper bg-gradient-success shadow-sm mr-4">
                        <i class="mdi mdi-shopping"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 font-weight-bold text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Total Order</p>
                        <h3 class="font-weight-bolder text-dark m-0">{{ number_format($stats['total']) }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- Stat 4 -->
    <div class="col-xl-3 col-lg-6 col-sm-6">
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stat-icon-wrapper bg-gradient-primary shadow-sm mr-4">
                        <i class="mdi mdi-cash-multiple"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 font-weight-bold text-uppercase" style="font-size: 12px; letter-spacing: 1px;">Total Sale</p>
                        <h3 class="font-weight-bolder text-dark m-0">৳ {{ number_format($stats['total_sale']) }}</h3>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mb-4">
    <!-- Recent Orders Table -->
    <div class="col-xl-8 col-lg-12 mb-4 mb-xl-0">
        <div class="card glass-card h-100">
            <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold text-dark m-0" style="font-size: 18px;">Recent Orders</h4>
                <a href="{{ route('admin.orders.index') ?? '#' }}" class="btn btn-sm btn-outline-primary" style="border-radius: 20px; padding: 5px 15px; font-weight: 600;">View All</a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table modern-table table-borderless m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Order Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><span class="font-weight-bold text-primary">#{{ $order->order_id }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 50%; background: #f0f4ff; color: #667eea; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px;">{{ strtoupper(substr($order->customer_name, 0, 1)) }}</div>
                                        <span class="font-weight-bold">{{ $order->customer_name }}</span>
                                    </div>
                                </td>
                                <td><i class="mdi mdi-calendar-blank mr-1 text-muted"></i> {{ \Carbon\Carbon::parse($order->order_date ?? $order->created_at)->format('Y-m-d') }}</td>
                                <td class="font-weight-bold">৳ {{ number_format($order->grand_total) }}</td>
                                <td>
                                    @if(in_array($order->order_status, ['Pending', 'Incomplete']))
                                        <span class="badge-soft-warning"><i class="mdi mdi-clock-outline mr-1" style="font-size: 14px;"></i>{{ $order->order_status }}</span>
                                    @elseif(in_array($order->order_status, ['Delivered', 'Completed']))
                                        <span class="badge-soft-success"><i class="mdi mdi-check-circle-outline mr-1" style="font-size: 14px;"></i>{{ $order->order_status }}</span>
                                    @elseif(in_array($order->order_status, ['Cancelled', 'Canceled', 'Returned']))
                                        <span class="badge-soft-danger"><i class="mdi mdi-close-circle-outline mr-1" style="font-size: 14px;"></i>{{ $order->order_status }}</span>
                                    @else
                                        <span class="badge-soft-warning"><i class="mdi mdi-information-outline mr-1" style="font-size: 14px;"></i>{{ $order->order_status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="col-xl-4 col-lg-12">
        <div class="card glass-card h-100">
            <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent">
                <h4 class="card-title font-weight-bold text-dark m-0" style="font-size: 18px;">Order Statistics</h4>
            </div>
            <div class="card-body p-4">
                <div class="stat-list-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; background: #e3f2fd; color: #2196f3; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="mdi mdi-cart"></i>
                        </div>
                        <span class="font-weight-bold text-dark" style="font-size: 15px;">Total Order</span>
                    </div>
                    <span class="font-weight-bolder" style="font-size: 18px;">{{ number_format($stats['total']) }}</span>
                </div>
                
                <div class="stat-list-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; background: #e6f8f0; color: #10c469; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="mdi mdi-truck-delivery"></i>
                        </div>
                        <span class="font-weight-bold text-dark" style="font-size: 15px;">Total Delivered</span>
                    </div>
                    <span class="font-weight-bolder text-success" style="font-size: 18px;">{{ number_format($stats['delivered']) }}</span>
                </div>
                
                <div class="stat-list-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; background: #ffe8e8; color: #ff5b5b; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="mdi mdi-close-box"></i>
                        </div>
                        <span class="font-weight-bold text-dark" style="font-size: 15px;">Total Cancel</span>
                    </div>
                    <span class="font-weight-bolder text-danger" style="font-size: 18px;">{{ number_format($stats['cancelled']) }}</span>
                </div>
                
                <div class="stat-list-item d-flex justify-content-between align-items-center mb-0">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 shadow-sm" style="width: 45px; height: 45px; border-radius: 12px; background: #fff4e5; color: #ff9800; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            <i class="mdi mdi-keyboard-return"></i>
                        </div>
                        <span class="font-weight-bold text-dark" style="font-size: 15px;">Total Return</span>
                    </div>
                    <span class="font-weight-bolder text-warning" style="font-size: 18px;">{{ number_format($stats['returned']) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Ordered Districts Table -->
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold text-dark m-0" style="font-size: 18px;">Top Ordered Districts</h4>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light text-dark shadow-sm dropdown-toggle font-weight-bold" type="button" data-toggle="dropdown" style="border-radius: 20px; padding: 6px 16px;">
                        All Time
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table modern-table table-borderless m-0">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>District Name</th>
                                <th>Order Count</th>
                                <th style="width: 35%;">Performance Growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $colors = ['primary', 'info', 'success', 'warning', 'danger'];
                                $bgs = ['#f0f4ff', '#e3f2fd', '#e6f8f0', '#fff4e5', '#ffe8e8'];
                            @endphp
                            @forelse($topDistricts as $index => $district)
                                @php
                                    $percentage = $maxDistrictCount > 0 ? round(($district->order_count / $maxDistrictCount) * 100) : 0;
                                    $color = $colors[$index % count($colors)];
                                    $bg = $bgs[$index % count($bgs)];
                                @endphp
                                <tr>
                                    <td><span class="font-weight-bold text-muted" style="font-size: 18px;">#{{ $index + 1 }}</span></td>
                                    <td><span class="font-weight-bold text-dark" style="font-size: 15px;">{{ $district->customer_district ?: 'Unknown' }}</span></td>
                                    <td class="font-weight-bold" style="font-size: 15px;">{{ number_format($district->order_count) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress w-100 mr-3 shadow-sm" style="height: 10px; border-radius: 10px; background-color: {{ $bg }};">
                                                <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%; border-radius: 10px;"></div>
                                            </div>
                                            <span class="font-weight-bold text-{{ $color }}" style="font-size: 13px;">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No district data available.</td>
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
