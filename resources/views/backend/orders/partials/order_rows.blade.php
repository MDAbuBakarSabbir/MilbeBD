@forelse($orders as $order)
    <tr>
        <td class="align-middle" style="padding-left: 1.5rem;">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input order-checkbox" id="check{{ $order->id }}" name="selected_orders[]" value="{{ $order->id }}">
                <label class="custom-control-label" for="check{{ $order->id }}"></label>
            </div>
        </td>
        <td class="align-middle">
            <span class="badge badge-light text-primary border p-2" style="font-size: 0.9rem; letter-spacing: 0.5px;">{{ $order->order_id }}</span>
            <div class="text-muted mt-1 small"><i class="mdi mdi-calendar-clock mr-1"></i>{{ $order->created_at ? $order->created_at->format('d M, Y g:i A') : 'N/A' }}</div>
        </td>
        <td class="align-middle">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 text-white shadow-sm" style="width: 42px; height: 42px; font-size: 1.2rem; background: linear-gradient(135deg, #8e2de2, #4a00e0);">
                    {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                </div>
                <div>
                    <h6 class="mb-1 font-weight-bold text-dark">{{ $order->customer_name }}</h6>
                    <div class="text-muted" style="font-size: 0.8rem;">
                        <a href="tel:{{ $order->customer_phone }}" class="text-muted mr-3 text-decoration-none"><i class="mdi mdi-phone mr-1"></i>{{ $order->customer_phone }}</a><br>
                        <span><i class="mdi mdi-map-marker mr-1"></i>{{ $order->customer_district }}</span>
                    </div>
                </div>
            </div>
        </td>
        <td class="align-middle">
            <h6 class="mb-1 font-weight-bold text-dark text-truncate" style="max-width: 180px;" title="{{ $order->product_id }}">{{ $order->product_id }}</h6>
            <div class="text-muted small">
                <span class="mr-2 border-right pr-2"><i class="mdi mdi-palette mr-1"></i>{{ $order->product_color ?: 'N/A' }}</span>
                <span><i class="mdi mdi-format-list-numbered mr-1"></i>Qty: <b class="text-dark">{{ $order->product_quantity }}</b></span>
            </div>
        </td>
        <td class="align-middle">
            <h6 class="mb-1 font-weight-bold text-dark" style="font-size: 1.1rem;">৳ {{ number_format(floatval($order->grand_total), 2) }}</h6>
            <div class="text-muted small">
                <span class="badge badge-light border">COD</span> {{ $order->payment_method }}
            </div>
        </td>
        <td class="align-middle">
            @php
                $statusLower = strtolower($order->order_status);
                $badgeClass = 'badge-secondary';
                if(in_array($statusLower, ['pending', 'hold'])) $badgeClass = 'badge-warning text-dark';
                if(in_array($statusLower, ['processing', 'approved', 'shipped'])) $badgeClass = 'badge-primary';
                if($statusLower == 'delivered') $badgeClass = 'badge-success';
                if(in_array($statusLower, ['cancelled', 'returned'])) $badgeClass = 'badge-danger';
            @endphp
            <span id="order-status-badge-{{ $order->id }}" class="badge {{ $badgeClass }} p-2 rounded-pill px-3 shadow-sm">{{ $order->order_status }}</span>
        </td>
        <td class="align-middle">
            @php
                $historyData = json_decode($order->courier_history, true);
                $summary = $historyData['data']['summary'] ?? ['total_parcel' => 0, 'success_parcel' => 0, 'cancelled_parcel' => 0, 'success_ratio' => 0];
                
                $totalOrders = $summary['total_parcel'];
                $successOrders = $summary['success_parcel'];
                $failedOrders = $summary['cancelled_parcel'];
                $successRate = $summary['success_ratio'];
                
                $rateColor = 'secondary';
                if ($successRate > 80) $rateColor = 'success';
                elseif ($successRate > 50) $rateColor = 'warning text-dark';
                elseif ($successRate > 0 || $totalOrders > 0) $rateColor = 'danger';
            @endphp
            <div class="w-100" style="max-width: 180px;">
                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.75rem;">
                    <span class="text-muted font-weight-bold">To: {{ $totalOrders }} | Su: <span class="text-success">{{ $successOrders }}</span> | Fa: <span class="text-danger">{{ $failedOrders }}</span></span>
                    <span class="font-weight-bold text-{{ $rateColor }}">Rate: {{ $successRate }}%</span>
                </div>
                <div class="progress" style="height: 6px; border-radius: 3px; background-color: #e9ecef;">
                    <div class="progress-bar bg-{{ $rateColor }}" role="progressbar" style="width: {{ $successRate }}%" aria-valuenow="{{ $successRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </td>
        <td class="align-middle text-center">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{$order->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-boundary="window">
                    <i class="mdi mdi-dots-vertical"></i> Actions
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropdownMenuButton{{$order->id}}">
                    <a class="dropdown-item text-info" href="{{ route('admin.orders.show', $order->id) }}"><i class="mdi mdi-eye mr-2"></i> View Order</a>
                    <a class="dropdown-item text-primary" href="{{ route('admin.orders.edit', $order->id) }}"><i class="mdi mdi-pencil mr-2"></i> Edit Order</a>
                    
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Update Status</h6>
                    @foreach($orderStatuses as $status)
                        <button type="button" class="dropdown-item" onclick="updateOrderStatus(event, {{ $order->id }}, '{{ $status->name }}', '{{ route('admin.orders.update', $order->id) }}')">
                            <i class="mdi mdi-check-circle-outline mr-2 text-muted"></i> {{ $status->name }}
                        </button>
                    @endforeach

                    <div class="dropdown-divider"></div>
                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete order {{ $order->order_id }}?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"><i class="mdi mdi-delete mr-2"></i> Delete Order</button>
                    </form>
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-5">
            <div class="py-5">
                <div class="icon-wrapper bg-light text-muted mx-auto mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 3rem; border-radius: 50%;">
                    <i class="mdi mdi-shopping"></i>
                </div>
                <h5 class="font-weight-bold text-dark">No Orders Found</h5>
                <p class="text-muted">You don't have any orders matching this status.</p>
            </div>
        </td>
    </tr>
@endforelse
