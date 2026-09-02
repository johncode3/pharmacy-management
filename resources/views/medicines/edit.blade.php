@extends('layouts.pharmacy')

@section('title', 'Edit Medicine')
@section('page-title', 'Edit Medicine Details')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endsection

@section('content')

<div class="form-card">
    <form action="{{ route('medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Brand / Trade Name <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name', $medicine->name) }}" class="form-input" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Generic Chemical Name</label>
                <input type="text" name="generic_name" value="{{ old('generic_name', $medicine->generic_name) }}" class="form-input">
                @error('generic_name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Category <span style="color: var(--danger);">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $medicine->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Barcode / SKU <span style="color: var(--danger);">*</span></label>
                <input type="text" name="barcode" value="{{ old('barcode', $medicine->barcode) }}" class="form-input" required>
                @error('barcode') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Selling Price ($) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $medicine->price) }}" class="form-input" required>
                @error('price') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Purchase Cost ($) <span style="color: var(--danger);">*</span></label>
                <input type="number" step="0.01" name="cost" value="{{ old('cost', $medicine->cost) }}" class="form-input" required>
                @error('cost') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Stock Quantity <span style="color: var(--danger);">*</span></label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $medicine->stock_quantity) }}" class="form-input" min="0" required>
                @error('stock_quantity') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Expiry Date <span style="color: var(--danger);">*</span></label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date->format('Y-m-d')) }}" class="form-input" required>
                @error('expiry_date') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label class="form-label">Change Photo (Leave empty to keep existing)</label>
                <input type="file" name="image" class="form-input" accept="image/*">
                @if($medicine->image)
                    <div style="margin-top: 10px;">
                        <img src="{{ asset('storage/' . $medicine->image) }}" alt="Current Photo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                    </div>
                @endif
                @error('image') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('medicines.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-save"></i> Update Medicine
            </button>
        </div>
    </form>
</div>

@endsection