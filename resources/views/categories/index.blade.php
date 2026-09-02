@extends('layouts.pharmacy')

@section('title', 'Medicine Categories')
@section('page-title', 'Medicine Categories')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
@endsection

@section('content')

    <div class="page-action-bar">
        <form method="GET" action="{{ route('categories.index') }}" class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Search categories...">
        </form>

        <a href="{{ route('categories.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Add New Category</span>
        </a>
    </div>

    <div class="card-section">
        <div class="card-header-bar">
            <span class="card-title">Category Master List</span>
            <span style="font-size: 0.8rem; color: var(--slate-400);">{{ $categories->total() }} Total Records</span>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 80px;">#</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Medicines Count</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td style="color: var(--slate-400); font-weight: 600;">{{ $loop->iteration }}</td>
                        <td>
                            <strong style="color: var(--slate-900);">{{ $category->name }}</strong>
                        </td>
                        <td style="color: var(--slate-500);">
                            {{ $category->description ?? 'No description provided' }}
                        </td>
                        <td>
                            <span class="status-pill warning">
                                <i class="bi bi-capsule"></i>
                                {{ $category->medicines_count }} Items
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-group" style="justify-content: flex-end;">
                                <a href="{{ route('categories.edit', $category) }}" class="btn-icon edit" title="Edit Category">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Delete Category">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="bi bi-tags" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
                            No categories found in the system.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection