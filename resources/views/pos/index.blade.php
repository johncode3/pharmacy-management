@extends('layouts.pharmacy')

@section('title', 'POS Checkout')
@section('page-title', 'Point of Sale (Cashier)')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <style>
        .pos-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 24px;
            align-items: flex-start;
        }
        .medicine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 16px;
        }
        .med-card {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .med-card:hover {
            border-color: #38bdf8;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }
        .med-card-img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid var(--slate-200);
        }
        .med-card-placeholder {
            width: 100%;
            height: 110px;
            border-radius: 8px;
            background: var(--slate-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--slate-400);
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .cart-box {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 14px;
            padding: 20px;
            position: sticky;
            top: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            margin-top: 10px;
        }
        .cart-table th {
            padding: 8px 4px;
            border-bottom: 1px solid var(--slate-200);
            text-align: left;
            color: var(--slate-500);
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .cart-table td {
            padding: 10px 4px;
            border-bottom: 1px solid var(--slate-100);
        }
        .qty-btn {
            background: var(--slate-100);
            border: 1px solid var(--slate-200);
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .qty-btn:hover {
            background: var(--slate-200);
        }
    </style>
@endsection

@section('content')

<div class="pos-layout">

    <!-- LEFT: Medicine Catalog -->
    <div>
        <!-- Search & Filter Bar -->
        <div class="page-action-bar">
            <form method="GET" action="{{ route('pos.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <div class="search-box" style="flex: 1;">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ $search }}" class="search-input" style="width: 100%;" placeholder="Search medicine name, generic, or barcode..." autofocus>
                </div>
                <select name="category_id" class="search-input" style="width: 180px;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Medicine Cards Grid -->
        <div class="medicine-grid">
            @forelse($medicines as $med)
                <div class="med-card" onclick="addToCart({{ $med->id }}, '{{ addslashes($med->name) }}', {{ $med->price }}, {{ $med->stock_quantity }})">
                    <div>
                        @if($med->image)
                            <img src="{{ asset('storage/' . $med->image) }}" alt="{{ $med->name }}" class="med-card-img">
                        @else
                            <div class="med-card-placeholder">
                                <i class="bi bi-capsule"></i>
                            </div>
                        @endif

                        <div style="font-size: 0.72rem; color: var(--slate-400); font-weight: 700; text-transform: uppercase;">{{ $med->category->name }}</div>
                        <div style="font-weight: 700; font-size: 0.92rem; color: var(--slate-900); margin: 3px 0;">{{ $med->name }}</div>
                        <div class="barcode-tag" style="font-size: 0.7rem; padding: 2px 5px;">{{ $med->barcode }}</div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 12px; padding-top: 8px; border-top: 1px dashed var(--slate-200);">
                        <div>
                            <div style="font-size: 1.15rem; font-weight: 800; color: #059669;">${{ number_format($med->price, 2) }}</div>
                            <div style="font-size: 0.72rem; color: {{ $med->stock_quantity <= 10 ? 'var(--warning)' : 'var(--slate-400)' }};">
                                Stock: {{ $med->stock_quantity }}
                            </div>
                        </div>
                        <span class="btn-icon edit" style="pointer-events: none; width: 28px; height: 28px;"><i class="bi bi-plus-lg"></i></span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1;" class="empty-state">
                    <i class="bi bi-capsule" style="font-size: 2.5rem; display: block; margin-bottom: 8px;"></i>
                    No available medicines found.
                </div>
            @endforelse
        </div>

        <div style="margin-top: 20px;">
            {{ $medicines->links() }}
        </div>
    </div>

    <!-- RIGHT: Cashier Cart -->
    <div class="cart-box">
        <form action="{{ route('pos.checkout') }}" method="POST" id="checkout-form" onsubmit="return clearCartOnSubmit()">
            @csrf

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--slate-200); padding-bottom: 12px;">
                <h3 style="font-size: 1rem; font-weight: 700; color: var(--slate-900);">
                    <i class="bi bi-cart3"></i> Order Summary
                </h3>
                <button type="button" onclick="clearCart()" style="background: none; border: none; color: var(--danger); font-size: 0.8rem; cursor: pointer; font-weight: 600;">
                    <i class="bi bi-trash"></i> Clear
                </button>
            </div>

            <div style="max-height: 230px; overflow-y: auto; margin-bottom: 12px;">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: right;">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cart-items-body">
                        <!-- Loaded dynamically via JavaScript / LocalStorage -->
                    </tbody>
                </table>
            </div>

            <div style="border-top: 1px solid var(--slate-200); padding-top: 14px; display: flex; flex-direction: column; gap: 10px;">
                
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.78rem;">Customer ID / Code</label>
                    <input id="pos_cust_code" type="text" name="customer_code" class="form-input" style="padding: 7px 10px; font-size: 0.85rem; background-color: var(--slate-100); font-family: monospace; font-weight: 700;" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-size: 0.78rem;">Customer Name</label>
                    <input type="text" name="customer_name" class="form-input" style="padding: 7px 10px; font-size: 0.85rem;" placeholder="Walk-in Customer">
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-size: 0.78rem;">Payment Method</label>
                    <select name="payment_method" class="form-select" style="padding: 7px 10px; font-size: 0.85rem;" required>
                        <option value="Cash">Cash</option>
                        <option value="ABA / KHQR">ABA / KHQR</option>
                        <option value="Card">Debit / Credit Card</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-size: 0.78rem;">Paid Amount ($) <span style="color: var(--danger);">*</span></label>
                    <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-input" style="padding: 7px 10px; font-size: 0.85rem;" placeholder="0.00" oninput="calculateChange()" required>
                </div>

                <div style="background: var(--slate-50); padding: 12px 14px; border-radius: 8px; border: 1px solid var(--slate-200); margin-top: 4px;">
                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.15rem; color: var(--slate-900);">
                        <span>Total Due:</span>
                        <span id="grand-total">$0.00</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--slate-500); margin-top: 6px;">
                        <span>Change Return:</span>
                        <span id="change-due" style="font-weight: 700; color: #059669;">$0.00</span>
                    </div>
                </div>

                <button type="submit" id="btn-submit-order" class="btn-primary" style="width: 100%; justify-content: center; padding: 12px; margin-top: 6px;" disabled>
                    <i class="bi bi-printer"></i> Process & Pay
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    const CART_STORAGE_KEY = 'pharmacy_pos_cart';

    let cart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY) || '{}');

    let custCode = sessionStorage.getItem('pos_cust_code');
    if (!custCode) {
        const now = new Date();
        const YmdHis = now.getFullYear() +
            String(now.getMonth() + 1).padStart(2, '0') +
            String(now.getDate()).padStart(2, '0') +
            String(now.getHours()).padStart(2, '0') +
            String(now.getMinutes()).padStart(2, '0') +
            String(now.getSeconds()).padStart(2, '0');

        custCode = 'CUST-' + YmdHis;
        sessionStorage.setItem('pos_cust_code', custCode);
    }

    if (document.getElementById('pos_cust_code')) {
        document.getElementById('pos_cust_code').value = custCode;
    }

    document.getElementById('pos_cust_code').value = custCode;

    function saveCart() {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
    }

    function addToCart(id, name, price, maxStock) {
        if (cart[id]) {
            if (cart[id].qty < maxStock) {
                cart[id].qty++;
            } else {
                alert('Maximum available stock reached (' + maxStock + ' units).');
            }
        } else {
            cart[id] = { id, name, price, qty: 1, maxStock };
        }
        saveCart();
        renderCart();
    }

    function updateQty(id, delta) {
        if (cart[id]) {
            cart[id].qty += delta;
            if (cart[id].qty <= 0) {
                delete cart[id];
            } else if (cart[id].qty > cart[id].maxStock) {
                cart[id].qty = cart[id].maxStock;
                alert('Cannot exceed available stock of ' + cart[id].maxStock);
            }
        }
        saveCart();
        renderCart();
    }

    function removeItem(id) {
        delete cart[id];
        saveCart();
        renderCart();
    }

    function clearCart() {
        cart = {};
        localStorage.removeItem(CART_STORAGE_KEY);
        renderCart();
        sessionStorage.removeItem('pos_cust_code');
    }

    function clearCartOnSubmit() {
        localStorage.removeItem(CART_STORAGE_KEY);
        sessionStorage.removeItem('pos_cust_code');
        return true;
    }

    function renderCart() {
        const tbody = document.getElementById('cart-items-body');
        tbody.innerHTML = '';
        let total = 0;
        let count = 0;

        for (let id in cart) {
            count++;
            const item = cart[id];
            const subtotal = item.price * item.qty;
            total += subtotal;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <div style="font-weight: 600; font-size: 0.85rem; color: var(--slate-900);">${item.name}</div>
                    <div style="color: var(--slate-400); font-size: 0.72rem;">$${item.price.toFixed(2)} each</div>
                    <input type="hidden" name="items[${count}][id]" value="${item.id}">
                    <input type="hidden" name="items[${count}][qty]" value="${item.qty}">
                </td>
                <td style="text-align: center;">
                    <div style="display: inline-flex; align-items: center; gap: 4px;">
                        <button type="button" class="qty-btn" onclick="updateQty(${item.id}, -1)">-</button>
                        <span style="font-weight: 700; min-width: 16px; text-align: center;">${item.qty}</span>
                        <button type="button" class="qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                    </div>
                </td>
                <td style="text-align: right; font-weight: 700; color: var(--slate-900);">$${subtotal.toFixed(2)}</td>
                <td style="text-align: right;">
                    <button type="button" onclick="removeItem(${item.id})" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 0.9rem;">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        if (count === 0) {
            tbody.innerHTML = `
                <tr id="empty-cart-msg">
                    <td colspan="4" style="text-align: center; color: var(--slate-400); padding: 30px 0;">
                        <i class="bi bi-bag-plus" style="font-size: 1.8rem; display: block; margin-bottom: 6px;"></i>
                        Click medicines on the left to add
                    </td>
                </tr>
            `;
            document.getElementById('btn-submit-order').disabled = true;
        } else {
            document.getElementById('btn-submit-order').disabled = false;
        }

        document.getElementById('grand-total').innerText = '$' + total.toFixed(2);
        calculateChange();
    }

    function calculateChange() {
        const total = parseFloat(document.getElementById('grand-total').innerText.replace('$', '')) || 0;
        const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
        const change = paid - total;
        const changeEl = document.getElementById('change-due');

        if (paid === 0 && total === 0) {
            changeEl.innerText = '$0.00';
            changeEl.style.color = '#059669';
            return;
        }

        if (change >= 0) {
            changeEl.innerText = '$' + change.toFixed(2);
            changeEl.style.color = '#059669';
        } else {
            changeEl.innerText = '-$' + Math.abs(change).toFixed(2);
            changeEl.style.color = 'var(--danger)';
        }
    }

    // Automatically render the cart when page finishes loading
    document.addEventListener('DOMContentLoaded', renderCart);
</script>

@endsection