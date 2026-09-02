@extends('layouts.pharmacy')

@section('title', 'Add Category')
@section('page-title', 'Register New Category')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endsection

@section('content')

<div class="form-card">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group full-width">
                <label class="form-label">Category Name <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="e.g. Antibiotics, Painkillers" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-textarea" placeholder="Optional notes about drug classification...">{{ old('description') }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('categories.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-check2-circle"></i> Save Category
            </button>
        </div>
    </form>
</div>

@endsection