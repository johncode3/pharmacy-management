@extends('layouts.pharmacy')

@section('title', 'Receipt #' . $sale->invoice_number)
@section('page-title', 'Invoice Details')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <style>
        @media print {
            .sidebar, .top-bar, .no-print { display: none !important; }
            body { background: #fff !important; }
            .main-wrapper { padding: 0 !important; }
            .receipt-card { box-shadow: none !important; border: none !important; width: 100% !important; margin: 0 !important; }
        }
    </style>
@endsection

@section('content')

<div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between; max-width: 650px; margin-left: auto; margin-right: auto;">
    <a href="{{ route('pos.index') }}" class="btn-secondary">
        <i class="bi bi-cart-plus"></i> New Sale / Back to POS
    </a>
    <button type="button" onclick="window.print()" class="btn-primary">
        <i class="bi bi-printer"></i> Print Invoice Receipt
    </button>
</div>

<div class="receipt-card" style="max-width: 650px; margin: 0 auto; background: #ffffff; border: 1px solid var(--slate-200); border-radius: 14px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">

    <div style="text-align: center; border-bottom: 1px dashed var(--slate-200); padding-bottom: 20px; margin-bottom: 20px;">
        <i class="bi bi-capsule-pill" style="font-size: 2.2rem; color: #059669;"></i>
        <h2 style="font-size: 1.3rem; font-weight: 800; color: var(--slate-900); margin: 6px 0 2px;">PharmaCare Pharmacy</h2>
        <p style="font-size: 0.8rem; color: var(--slate-500);">Phnom Penh, Cambodia | Tel: +855 12 345 678</p>
    </div>

    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 20px;">
        <div>
            <div><strong>Invoice:</strong> <span class="invoice-badge">{{ $sale->invoice_number }}</span></div>
            <div style="color: var(--slate-500); margin-top: 4px;"><strong>Customer:</strong> {{ $sale->customer_name }}</div>
        </div>
        <div style="text-align: right;">
            <div style="color: var(--slate-500);"><strong>Date:</strong> {{ $sale->created_at->format('d M Y, h:i A') }}</div>
            <div style="color: var(--slate-500); margin-top: 4px;"><strong>Cashier:</strong> {{ $sale->cashier->name ?? 'N/A' }}</div>
        </div>
    </div>

    <table class="custom-table" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Item Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Unit Price</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->medicine->name ?? 'Medicine Deleted' }}</strong>
                        <div style="font-size: 0.75rem; color: var(--slate-400);">{{ $item->medicine->barcode ?? '' }}</div>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right; font-weight: 700;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="border-top: 1px solid var(--slate-200); padding-top: 14px; font-size: 0.9rem; display: flex; flex-direction: column; gap: 6px;">
        <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.2rem; color: var(--slate-900);">
            <span>Grand Total:</span>
            <span>${{ number_format($sale->total_amount, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; color: var(--slate-600);">
            <span>Paid Amount ({{ $sale->payment_method }}):</span>
            <span>${{ number_format($sale->paid_amount, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; color: #059669; font-weight: 700;">
            <span>Change Return:</span>
            <span>${{ number_format($sale->paid_amount - $sale->total_amount, 2) }}</span>
        </div>
    </div>

    <div style="text-align: center; border-top: 1px dashed var(--slate-200); padding-top: 18px; margin-top: 24px; font-size: 0.75rem; color: var(--slate-400);">
        <p>Thank you for choosing PharmaCare! Please retain this receipt for any warranty or exchange inquiries within 7 days.</p>
    </div>

</div>

@endsection