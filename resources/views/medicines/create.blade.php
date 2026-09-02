@extends('layouts.pharmacy')

@section('title', 'Add Medicine')
@section('page-title', 'Register New Medicine')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endsection

@section('content')

<div class="form-card">
    <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Brand / Trade Name <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="e.g. Panadol Extra 500mg" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Generic Chemical Name</label>
                <input type="text" name="generic_name" value="{{ old('generic_name') }}" class="form-input" placeholder="e.g. Paracetamol + Caffeine">
                @error('generic_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Category <span style="color: var(--danger);">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Barcode / SKU <span style="color: var(--danger);">*</span></label>
                <input type="text" name="barcode" value="{{ old('barcode') }}" class="form-input" placeholder="Auto generated" readonly>
                @error('barcode') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Selling Price ($) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-input" placeholder="0.00" required>
                @error('price') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Purchase Cost ($) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" name="cost" value="{{ old('cost') }}" class="form-input" placeholder="0.00" required>
                @error('cost') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Initial Stock Quantity <span style="color: var(--danger);">*</span></label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" class="form-input" min="0" required>
                @error('stock_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Expiry Date <span style="color: var(--danger);">*</span></label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="form-input" required>
                @error('expiry_date') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label class="form-label">Medicine Photo (Optional)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
                @error('image') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('medicines.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-check2-circle"></i> Save Medicine
            </button>
        </div>
    </form>
</div>

@endsection