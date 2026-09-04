@extends('layouts.pharmacy')

@section('title', 'Sales History')
@section('page-title', 'Sales History & Past Receipts')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
@endsection

@section('content')
    <div class="page-action-bar">
        <form method="GET" action="{{ route('sales.index') }}" class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Search invoice or customer name...">
        </form>

        <a href="{{ route('pos.index') }}" class="btn-primary">
            <i class="bi bi-calculator"></i>
            <span>New POS Sale</span>
        </a>
    </div>

    <div class="card-section">
        <div class="card-header-bar">
            <span class="card-title">Completed Sales Invoices</span>
            <span style="font-size: 0.8rem; color: var(--slate-400);">{{ $sales->total() }} Total Invoices Recorded</span>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Customer Name</th>
                    <th>Cashier</th>
                    <th>Items Sold</th>
                    <th>Payment Method</th>
                    <th>Total Amount</th>
                    <th>Date & Time</th>
                    <th style="text-align: right;">Receipt</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>
                            <span class="invoice-badge">{{ $sale->invoice_number }}</span>
                        </td>

                        <td>
                            <strong style="color: var(--slate-900);">{{ $sale->customer_name }}</strong>
                        </td>

                        <td>
                            <span style="color: var(--slate-600); font-weight: 500;">{{ $sale->cashier->name ?? 'System' }}</span>
                        </td>

                        <td>
                            <span class="status-pill warning">
                                <i class="bi bi-bag-check"></i>
                                {{ $sale->items->count() }} items
                            </span>
                        </td>

                        <td>
                            <span style="font-size: 0.85rem; font-weight: 600; color: var(--slate-700);">
                                {{ $sale->payment_method }}
                            </span>
                        </td>

                        <td>
                            <strong style="color: #059669; font-size: 0.95rem;">${{ number_format($sale->total_amount, 2) }}</strong>
                        </td>

                        <td style="font-size: 0.8rem; color: var(--slate-500);">
                            {{ $sale->created_at->format('d M Y, h:i A') }}
                        </td>

                        <td style="text-align: right;">
                            <a href="{{ route('sales.show', $sale) }}" class="btn-icon view" title="View & Print Receipt">
                                <i class="bi bi-receipt"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="bi bi-receipt" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
                            No sales records found. Complete a checkout in POS to see invoices here.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $sales->links() }}
    </div>

@endsection