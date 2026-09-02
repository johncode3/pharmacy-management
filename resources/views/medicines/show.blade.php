@extends('layouts.pharmacy')

@section('title', $medicine->name)
@section('page-title', 'Medicine Detail Sheet')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/show.css') }}">
@endsection

@section('content')

<div class="detail-card">

    <div class="detail-header">
        @if($medicine->image)
            <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="detail-img">
        @else
            <div class="detail-img-placeholder">
                <i class="bi bi-capsule"></i>
            </div>
        @endif

        <div class="detail-info">
            <div class="detail-category">{{ $medicine->category->name }}</div>
            <h2 class="detail-title">{{ $medicine->name }}</h2>
            <p class="detail-subtitle">Generic: {{ $medicine->generic_name ?? 'N/A' }}</p>
            <div class="barcode-tag">
                <i class="bi bi-upc-scan"></i> {{ $medicine->barcode }}
            </div>
        </div>
    </div>

    <div class="spec-grid">
        <div class="spec-box">
            <div class="spec-label">Selling Price</div>
            <div class="spec-val success">${{ number_format($medicine->price, 2) }}</div>
        </div>

        <div class="spec-box">
            <div class="spec-label">Purchase Cost</div>
            <div class="spec-val cost">${{ number_format($medicine->cost, 2) }}</div>
        </div>

        <div class="spec-box">
            <div class="spec-label">Current Stock Level</div>
            <div class="spec-val {{ $medicine->stock_quantity <= 10 ? 'warning' : '' }}">
                {{ $medicine->stock_quantity }} Units
            </div>
        </div>

        <div class="spec-box">
            <div class="spec-label">Expiry Date</div>
            <div class="spec-val {{ $medicine->isExpired() ? 'danger' : '' }}">
                {{ $medicine->expiry_date->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="detail-actions">
        <a href="{{ route('medicines.index') }}" class="btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Inventory
        </a>
        <a href="{{ route('medicines.edit', $medicine) }}" class="btn-primary">
            <i class="bi bi-pencil-square"></i> Edit Medicine Details
        </a>
    </div>

</div>

@endsection