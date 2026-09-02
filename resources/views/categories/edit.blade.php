@extends('layouts.pharmacy')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endsection

@section('content')

<div class="form-card">
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group full-width">
                <label class="form-label">Category Name <span style="color: var(--danger);">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input" required>
                @error('name') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-textarea">{{ old('description', $category->description) }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('categories.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i class="bi bi-save"></i> Update Category
            </button>
        </div>
    </form>
</div>

@endsection