@extends('layouts.backend.masterLay')
@section('title', 'Point of Sale (POS)')

@section('content')
<style>
    .pos-glass-card {
        background: rgba(255, 255, 255, 0.98);
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        margin-bottom: 25px;
        overflow: hidden;
    }
    .pos-product-card {
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 16px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    .pos-product-card:hover {
        border-color: #667eea;
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(102,126,234,0.15);
        background: #ffffff;
    }
    .pos-product-img {
        width: 100%;
        height: 110px;
        border-radius: 12px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 12px;
    }
    .pos-product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pos-product-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
        line-height: 1.3;
        margin-bottom: 6px;
    }
    .pos-product-price {
        font-weight: 800;
        color: #667eea;
        font-size: 16px;
    }
    .modern-input {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 10px 14px;
        font-size: 14px;
        transition: 0.3s;
        background-color: #f8fafc;
    }
    .modern-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        background-color: #fff;
    }
    .modern-label {
        font-weight: 600;
        color: #4a5568;
        font-size: 13px;
        margin-bottom: 6px;
    }
    .pos-cart-table th {
        border-top: none;
        border-bottom: 2px solid #f1f5f9;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.8px;
        padding: 12px 8px;
    }
    .pos-cart-table td {
        vertical-align: middle;
        border-bottom: 1px solid #f8fafc;
        padding: 12px 8px;
        font-weight: 500;
        color: #1e293b;
    }
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }
    .summary-item.total {
        font-size: 18px;
        color: #0f172a;
        border-bottom: none;
        padding-top: 14px;
        font-weight: 800;
    }
    .btn-pos-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 14px 24px;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(102,126,234,0.3);
    }
    .btn-pos-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(102,126,234,0.45);
        color: #fff;
    }
</style>

<form action="{{ route('admin.orders.store') }}" method="POST" id="pos-form">
    @csrf
    <!-- Hidden inputs for calculated invoice data -->
    <input type="hidden" name="product_items" id="hidden_product_items" value="">
    <input type="hidden" name="order_sub_total" id="hidden_sub_total" value="0">
    <input type="hidden" name="delivery_cost" id="hidden_delivery_cost" value="0">
    <input type="hidden" name="discount" id="hidden_discount" value="0">
    <input type="hidden" name="grand_total" id="hidden_grand_total" value="0">
    <input type="hidden" name="product_quantity" id="hidden_total_qty" value="1">

    <div class="row">
        <!-- Left Side: Product Grid & Search -->
        <div class="col-xl-7 col-lg-6">
            <div class="card pos-glass-card p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <h4 class="font-weight-bold text-dark m-0 d-flex align-items-center">
                        <span class="mr-2 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background: #e3f2fd; color: #2196f3;">
                            <i class="mdi mdi-point-of-sale" style="font-size: 20px;"></i>
                        </span>
                        POS Terminal Catalog
                    </h4>
                    <div style="width: 260px;">
                        <input type="text" id="posProductSearch" class="form-control modern-input" placeholder="Search catalog items...">
                    </div>
                </div>

                <!-- Products Catalog -->
                <div class="row g-3" id="productGrid" style="max-height: 650px; overflow-y: auto; overflow-x: hidden; padding-right: 4px;">
                    @forelse($products as $product)
                        <div class="col-sm-6 col-md-4 mb-3 product-grid-item" data-name="{{ strtolower($product->name) }}">
                            <div class="pos-product-card" onclick="addToCart('{{ addslashes($product->name) }}', {{ floatval($product->price) }})">
                                <div>
                                    <div class="pos-product-img">
                                        @if($product->image && file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <i class="mdi mdi-image-outline text-muted" style="font-size: 36px;"></i>
                                        @endif
                                    </div>
                                    <div class="pos-product-title">{{ $product->name }}</div>
                                </div>
                                <div class="pos-product-price mt-2">৳ {{ number_format(floatval($product->price), 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback / Default Catalog Items if DB is empty -->
                        <div class="col-sm-6 col-md-4 mb-3 product-grid-item" data-name="milbe sound pro headphones">
                            <div class="pos-product-card" onclick="addToCart('Milbe Sound Pro Headphones', 199)">
                                <div>
                                    <div class="pos-product-img">
                                        <i class="mdi mdi-headphones text-primary" style="font-size: 36px;"></i>
                                    </div>
                                    <div class="pos-product-title">Milbe Sound Pro Headphones</div>
                                </div>
                                <div class="pos-product-price mt-2">৳ 199.00</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3 product-grid-item" data-name="premium skin friendly mini shaver">
                            <div class="pos-product-card" onclick="addToCart('Premium Skin Friendly Mini Shaver', 499)">
                                <div>
                                    <div class="pos-product-img">
                                        <i class="mdi mdi-laser-pointer text-success" style="font-size: 36px;"></i>
                                    </div>
                                    <div class="pos-product-title">Premium Skin Friendly Mini Shaver</div>
                                </div>
                                <div class="pos-product-price mt-2">৳ 499.00</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-3 product-grid-item" data-name="smart fitness power watch">
                            <div class="pos-product-card" onclick="addToCart('Smart Fitness Power Watch', 1299)">
                                <div>
                                    <div class="pos-product-img">
                                        <i class="mdi mdi-watch text-warning" style="font-size: 36px;"></i>
                                    </div>
                                    <div class="pos-product-title">Smart Fitness Power Watch</div>
                                </div>
                                <div class="pos-product-price mt-2">৳ 1,299.00</div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Custom POS Item Adder -->
                <div class="mt-4 pt-3 border-top d-flex flex-wrap gap-2 align-items-center justify-content-between">
                    <span class="text-muted font-weight-bold" style="font-size: 13px;">Selling a custom unlisted item?</span>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-2 font-weight-bold" onclick="addCustomItem()">
                        <i class="mdi mdi-plus-circle mr-1"></i> Add Custom Item
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Side: Cart, Customer & Checkout -->
        <div class="col-xl-5 col-lg-6">
            <!-- Customer Information Card -->
            <div class="card pos-glass-card p-4">
                <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center">
                    <i class="mdi mdi-account-circle mr-2 text-primary" style="font-size: 22px;"></i> Customer Shipping Info
                </h5>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="modern-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control modern-input" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label class="modern-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="customer_phone" class="form-control modern-input" placeholder="e.g. 01XXXXXXXXX" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="modern-label">Delivery Address <span class="text-danger">*</span></label>
                    <input type="text" name="customer_address" class="form-control modern-input" placeholder="Street number, house, area details" required>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-0">
                        <label class="modern-label">District / City <span class="text-danger">*</span></label>
                        <select name="customer_city" id="districtSelect" class="form-control modern-input" onchange="updateDeliveryCharge()">
                            <option value="Dhaka" data-charge="60">Dhaka (Inside City - ৳ 60)</option>
                            <option value="Outside Dhaka" data-charge="120">Outside Dhaka (৳ 120)</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->name }}" data-charge="{{ $district->delivery_charge }}">
                                    {{ $district->name }} (৳ {{ $district->delivery_charge }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 mb-0">
                        <label class="modern-label">Delivery Fee (৳)</label>
                        <input type="number" id="customDeliveryInput" class="form-control modern-input text-right font-weight-bold" value="60" oninput="manualDeliveryChange()">
                    </div>
                </div>
            </div>

            <!-- POS Cart & Billing Summary -->
            <div class="card pos-glass-card p-4">
                <h5 class="font-weight-bold text-dark mb-3 d-flex justify-content-between align-items-center">
                    <span><i class="mdi mdi-cart mr-2 text-success" style="font-size: 22px;"></i> Current Cart</span>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 font-weight-bold" onclick="clearCart()">Clear All</button>
                </h5>

                <div class="table-responsive mb-3" style="max-height: 220px; overflow-y: auto;">
                    <table class="table pos-cart-table m-0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center" style="width: 80px;">Price</th>
                                <th class="text-center" style="width: 90px;">Qty</th>
                                <th class="text-right" style="width: 85px;">Total</th>
                                <th style="width: 35px;"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Summary Box -->
                <div class="p-3 bg-light rounded-lg mb-4" style="border-radius: 14px;">
                    <div class="summary-item">
                        <span>Cart Subtotal</span>
                        <span id="displaySubTotal">৳ 0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Delivery Fee</span>
                        <span id="displayDeliveryCost">৳ 60.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Discount / Rebate (৳)</span>
                        <div style="width: 100px;">
                            <input type="number" id="discountInput" class="form-control form-control-sm text-right modern-input py-1 px-2 font-weight-bold" value="0" min="0" oninput="calculateInvoice()">
                        </div>
                    </div>
                    <div class="summary-item total">
                        <span>Grand Total Payable</span>
                        <span class="text-primary" id="displayGrandTotal">৳ 60.00</span>
                    </div>
                </div>

                <!-- Payment & Order Status -->
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label class="modern-label">Payment Method</label>
                        <select name="payment_method" class="form-control modern-input font-weight-semibold">
                            <option value="POS Cash">POS Cash Paid</option>
                            <option value="Cash on Delivery">Cash on Delivery (COD)</option>
                            <option value="bKash / Mobile Banking">bKash / Mobile Banking</option>
                            <option value="Card Payment">Card Payment</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="modern-label">Order Status</label>
                        <select name="order_status" class="form-control modern-input font-weight-semibold">
                            <option value="Approved">Approved</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                            @foreach($orderStatuses as $os)
                                <option value="{{ $os->name }}">{{ $os->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Complete Button -->
                <button type="submit" class="btn btn-pos-gradient btn-block shadow-lg d-flex align-items-center justify-content-center gap-2">
                    <i class="mdi mdi-check-circle fs-5 mr-2"></i> Complete POS Order
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    let posCart = [];

    // Filter product grid
    document.getElementById('posProductSearch').addEventListener('input', function() {
        let query = this.value.toLowerCase().trim();
        document.querySelectorAll('.product-grid-item').forEach(item => {
            let name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? '' : 'none';
        });
    });

    // Add item to cart
    function addToCart(name, price) {
        let existing = posCart.find(item => item.name === name);
        if (existing) {
            existing.qty += 1;
        } else {
            posCart.push({ name: name, price: price, qty: 1 });
        }
        renderCart();
    }

    // Add custom item dialog/prompt
    function addCustomItem() {
        let name = prompt("Enter Custom Item Name:", "POS Custom Product");
        if (!name) return;
        let priceStr = prompt("Enter Unit Price (৳):", "250");
        let price = parseFloat(priceStr) || 0;
        addToCart(name, price);
    }

    // Update quantity
    function updateCartQty(index, change) {
        posCart[index].qty += change;
        if (posCart[index].qty <= 0) {
            posCart.splice(index, 1);
        }
        renderCart();
    }

    // Remove item
    function removeCartItem(index) {
        posCart.splice(index, 1);
        renderCart();
    }

    // Clear cart
    function clearCart() {
        if (confirm("Are you sure you want to clear the current POS cart?")) {
            posCart = [];
            renderCart();
        }
    }

    // Render cart items inside table & trigger calculation
    function renderCart() {
        let tbody = document.getElementById('cartTableBody');
        tbody.innerHTML = '';

        if (posCart.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="mdi mdi-cart-off" style="font-size: 28px;"></i>
                        <p class="m-0 mt-1 font-weight-semibold" style="font-size: 12px;">Cart is empty. Click items on the left to add.</p>
                    </td>
                </tr>
            `;
        } else {
            posCart.forEach((item, idx) => {
                let itemTotal = item.price * item.qty;
                tbody.innerHTML += `
                    <tr>
                        <td><div class="font-weight-bold text-dark text-truncate" style="max-width: 130px;" title="${item.name}">${item.name}</div></td>
                        <td class="text-center">৳${item.price.toFixed(0)}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-xs btn-outline-secondary px-1 py-0" onclick="updateCartQty(${idx}, -1)">-</button>
                                <span class="mx-2 font-weight-bold">${item.qty}</span>
                                <button type="button" class="btn btn-xs btn-outline-secondary px-1 py-0" onclick="updateCartQty(${idx}, 1)">+</button>
                            </div>
                        </td>
                        <td class="text-right font-weight-bold text-primary">৳${itemTotal.toFixed(0)}</td>
                        <td class="text-right">
                            <button type="button" class="btn btn-xs text-danger p-0" onclick="removeCartItem(${idx})"><i class="mdi mdi-close-circle fs-5"></i></button>
                        </td>
                    </tr>
                `;
            });
        }

        calculateInvoice();
    }

    // Handle Delivery charge dropdown choice
    function updateDeliveryCharge() {
        let select = document.getElementById('districtSelect');
        let charge = parseFloat(select.options[select.selectedIndex].getAttribute('data-charge')) || 0;
        document.getElementById('customDeliveryInput').value = charge;
        calculateInvoice();
    }

    function manualDeliveryChange() {
        calculateInvoice();
    }

    // Calculate subtotal, grand total, and set hidden fields
    function calculateInvoice() {
        let subTotal = 0;
        let totalQty = 0;
        let itemSummaryList = [];

        posCart.forEach(item => {
            subTotal += (item.price * item.qty);
            totalQty += item.qty;
            itemSummaryList.push(`${item.name} (x${item.qty})`);
        });

        let deliveryCost = parseFloat(document.getElementById('customDeliveryInput').value) || 0;
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let grandTotal = subTotal + deliveryCost - discount;
        if (grandTotal < 0) grandTotal = 0;

        // Update displays
        document.getElementById('displaySubTotal').textContent = `৳ ${subTotal.toFixed(2)}`;
        document.getElementById('displayDeliveryCost').textContent = `৳ ${deliveryCost.toFixed(2)}`;
        document.getElementById('displayGrandTotal').textContent = `৳ ${grandTotal.toFixed(2)}`;

        // Set hidden inputs for controller
        document.getElementById('hidden_product_items').value = itemSummaryList.join(', ') || 'POS Order Item';
        document.getElementById('hidden_sub_total').value = subTotal.toFixed(2);
        document.getElementById('hidden_delivery_cost').value = deliveryCost.toFixed(2);
        document.getElementById('hidden_discount').value = discount.toFixed(2);
        document.getElementById('hidden_grand_total').value = grandTotal.toFixed(2);
        document.getElementById('hidden_total_qty').value = totalQty > 0 ? totalQty : 1;
    }

    // Initial render
    renderCart();
</script>
@endsection
