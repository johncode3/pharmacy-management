@extends('layouts.pharmacy')
@section('title', 'Executive Dashboard')
@section('page-title', 'Executive Pharmacy Dashboard')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')
    <div class="kpi-grid">
        <div class="kpi-card">
            <div>
                <div class="kpi-label">Total Revenue</div>
                <div class="kpi-value">${{ number_format($totalRevenue, 2) }}</div>
            </div>
            <div class="kpi-icon revenue"><i class="bi bi-currency-dollar"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Today's Sales</div>
                <div class="kpi-value">${{ number_format($todaySales, 2) }}</div>
            </div>
            <div class="kpi-icon sales"><i class="bi bi-calendar-check"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label">Active Medicines</div>
                <div class="kpi-value">{{ $activeMedicinesCount }}</div>
            </div>
            <div class="kpi-icon active"><i class="bi bi-capsule"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label" style="color: var(--warning);">Low Stock (≤10)</div>
                <div class="kpi-value" style="color: var(--warning);">{{ $lowStockCount }}</div>
            </div>
            <div class="kpi-icon warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-label" style="color: var(--danger);">Expired Drugs</div>
                <div class="kpi-value" style="color: var(--danger);">{{ $expiredMedicinesCount }}</div>
            </div>
            <div class="kpi-icon danger"><i class="bi bi-shield-fill-x"></i></div>
        </div>
    </div>

    <div class="card-section">
        <div class="card-header-bar">
            <span class="card-title">Recent Sales Activity</span>
            <span style="font-size: 0.8rem; color: var(--slate-400);">Latest transactions</span>
        </div>
        
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Cashier</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                    <tr>
                        <td class="invoice-badge">{{ $sale->invoice_number }}</td>
                        <td><strong>{{ $sale->customer_name }}</strong></td>
                        <td>{{ $sale->cashier->name ?? 'N/A' }}</td>
                        <td>{{ $sale->payment_method }}</td>
                        <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                        <td style="color: var(--slate-400); font-size: 0.8rem;">{{ $sale->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
                            No sales transactions recorded yet. Complete a checkout in POS to see data here.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection