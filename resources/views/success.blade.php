<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed | MilbeBD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --secondary: #ec4899;
            --accent: #10b981;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.08) 0%, rgba(236, 72, 153, 0.08) 90%), #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
            color: #334155;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        .receipt-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.6);
            overflow: hidden;
            max-width: 780px;
            width: 100%;
            margin: auto;
            position: relative;
        }

        .receipt-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 3.5rem 2.5rem 2.5rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .check-circle {
            width: 84px;
            height: 84px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.8rem;
            color: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: pulse-scale 2s infinite ease-in-out;
        }

        @keyframes pulse-scale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        .badge-status {
            background: rgba(255, 255, 255, 0.25);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            height: 100%;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .info-value {
            font-weight: 600;
            color: #0f172a;
            font-size: 0.95rem;
        }

        .table-custom th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-weight: 500;
            color: #1e293b;
        }

        .total-box {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05), rgba(236, 72, 153, 0.05));
            border-radius: 18px;
            padding: 1.5rem 2rem;
            border: 1px solid rgba(79, 70, 229, 0.15);
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 14px;
            padding: 0.9rem 2rem;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.25);
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.35);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 0.9rem 2rem;
            font-weight: 600;
            color: #475569;
            transition: all 0.3s;
            background: white;
        }

        .btn-outline-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #f8fafc;
        }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .receipt-card {
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .receipt-header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-card">
        <!-- Header -->
        <div class="receipt-header">
            <div class="check-circle">
                <i class="bi bi-check-lg"></i>
            </div>
            <span class="badge-status mb-2 d-inline-block">Order Confirmed</span>
            <h1 class="fw-bold mb-2">Thank You For Your Order!</h1>
            <p class="mb-0 opacity-75">Your order details have been securely recorded. We will dispatch your shipment soon.</p>
        </div>

        <!-- Body Content -->
        <div class="p-4 p-md-5">
            <!-- Order Meta Grid -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-label">Order ID</div>
                        <div class="info-value text-primary fw-bold">{{ $order->order_id }}</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-label">Order Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-label">Payment Method</div>
                        <div class="info-value">{{ $order->payment_method }}</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="info-box">
                        <div class="info-label">Order Status</div>
                        <div class="info-value"><span class="badge bg-warning text-dark px-2 py-1">{{ $order->order_status }}</span></div>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery Info -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="info-box">
                        <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                            <i class="bi bi-person-badge text-primary me-2 fs-5"></i> Customer Details
                        </h6>
                        <div class="mb-2">
                            <span class="text-muted d-block" style="font-size: 0.8rem;">Full Name:</span>
                            <span class="fw-semibold text-dark">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-muted d-block" style="font-size: 0.8rem;">Phone Number:</span>
                            <span class="fw-semibold text-dark">{{ $order->customer_phone }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-box">
                        <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                            <i class="bi bi-geo-alt text-primary me-2 fs-5"></i> Shipping Address
                        </h6>
                        <div class="mb-2">
                            <span class="text-muted d-block" style="font-size: 0.8rem;">Street Address:</span>
                            <span class="fw-semibold text-dark">{{ $order->customer_address }}</span>
                        </div>
                        <div>
                            <span class="text-muted d-block" style="font-size: 0.8rem;">District / City:</span>
                            <span class="fw-semibold text-dark">{{ $order->customer_district }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itemized Table -->
            <div class="table-responsive mb-4 rounded-3 border">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th class="text-center">Color / Variant</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->product_id }}</div>
                                <small class="text-muted">High-grade technical guarantee</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $order->product_color }}</span>
                            </td>
                            <td class="text-center fw-semibold">{{ $order->product_quantity }}</td>
                            <td class="text-end fw-bold text-dark">৳ {{ number_format(floatval($order->order_sub_total), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Totals Section -->
            <div class="total-box mb-5">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Subtotal Amount:</span>
                    <span class="fw-bold text-dark">৳ {{ number_format(floatval($order->order_sub_total), 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted fw-semibold">Delivery Charge ({{ $order->customer_district }}):</span>
                    <span class="fw-bold text-dark">৳ {{ number_format(floatval($order->delivery_cost), 2) }}</span>
                </div>
                @if(floatval($order->coupon_discount) > 0 || floatval($order->admin_discount) > 0)
                <div class="d-flex justify-content-between mb-2 text-success">
                    <span class="fw-semibold">Total Discount:</span>
                    <span class="fw-bold">- ৳ {{ number_format(floatval($order->coupon_discount) + floatval($order->admin_discount), 2) }}</span>
                </div>
                @endif
                <hr class="border-secondary opacity-15 my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0 fw-bold text-dark">Grand Total:</span>
                    <span class="h3 mb-0 fw-extrabold text-primary" style="font-family: 'Outfit', sans-serif; font-weight: 800;">
                        ৳ {{ number_format(floatval($order->grand_total), 2) }}
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-3 justify-content-center no-print">
                <button onclick="window.print()" class="btn btn-outline-custom d-flex align-items-center gap-2">
                    <i class="bi bi-printer fs-5"></i> Print Invoice
                </button>
                <a href="{{ url('/') }}" class="btn btn-gradient d-flex align-items-center gap-2">
                    <i class="bi bi-shop fs-5"></i> Return to Store
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
