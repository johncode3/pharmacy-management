@extends('layouts.pharmacy')
@section('title', 'Medicine Inventory')
@section('page-title', 'Medicine Inventory')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
@endsection

@section('content')

    <div class="page-action-bar">
        <form method="GET" action="{{ route('medicines.index') }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ $search }}" class="search-input" placeholder="Search medicine, generic, barcode...">
            </div>

            <select name="category_id" class="search-input" style="width: 180px;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="status" class="search-input" style="width: 150px;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="Available" {{ $status === 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Low Stock" {{ $status === 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                <option value="Expired" {{ $status === 'Expired' ? 'selected' : '' }}>Expired</option>
            </select>
        </form>

        <a href="{{ route('medicines.create') }}" class="btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Add Medicine</span>
        </a>
    </div>

    <div class="card-section">
        <div class="card-header-bar">
            <span class="card-title">Inventory Master Records</span>
            <span style="font-size: 0.8rem; color: var(--slate-400);">{{ $medicines->total() }} Total Medicines</span>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Medicine & Generic Name</th>
                    <th>Category</th>
                    <th>Barcode</th>
                    <th>Price / Cost</th>
                    <th>Stock</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $med)
                    <tr>
                        <td>
                            @if($med->image)
                                <img src="{{ asset('storage/' . $med->image) }}" alt="{{ $med->name }}" style="width: 42px; height: 42px; object-fit: cover; border-radius: 8px; border: 1px solid var(--slate-200);">
                            @else
                                <div style="width: 42px; height: 42px; border-radius: 8px; background: var(--slate-100); display: flex; align-items: center; justify-content: center; color: var(--slate-400);">
                                    <i class="bi bi-capsule" style="font-size: 1.2rem;"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('medicines.show', $med) }}" style="text-decoration: none; color: var(--slate-900); font-weight: 700;">{{ $med->name }}</a>
                            <div style="font-size: 0.78rem; color: var(--slate-400);">{{ $med->generic_name ?? 'N/A' }}</div>
                        </td>

                        <td>
                            <span style="font-size: 0.85rem; color: var(--slate-600); font-weight: 500;">
                                {{ $med->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>

                        <td>
                            <span class="invoice-badge">{{ $med->barcode }}</span>
                        </td>

                        <td>
                            <div><strong>${{ number_format($med->price, 2) }}</strong></div>
                            <div style="font-size: 0.75rem; color: var(--slate-400);">Cost: ${{ number_format($med->cost, 2) }}</div>
                        </td>

                        <td>
                            <strong style="color: {{ $med->stock_quantity <= 10 ? 'var(--warning)' : 'var(--slate-800)' }};">
                                {{ $med->stock_quantity }} units
                            </strong>
                        </td>

                        <td>
                            <div style="font-size: 0.85rem; font-weight: 600; color: {{ $med->isExpired() ? 'var(--danger)' : ($med->isNearExpiry() ? 'var(--warning)' : 'var(--slate-700)') }};">
                                {{ $med->expiry_date->format('d M Y') }}
                            </div>
                            @if($med->isExpired())
                                <span style="font-size: 0.7rem; color: var(--danger); font-weight: 700;">Expired</span>
                            @elseif($med->isNearExpiry())
                                <span style="font-size: 0.7rem; color: var(--warning); font-weight: 700;">Expiring in {{ (int) $med->expiry_date->diffInDays(now()) }} days</span>
                            @endif
                        </td>

                        <td>
                            @if($med->status === 'Available')
                                <span class="status-pill available">
                                    <i class="bi bi-check-circle-fill"></i> Available
                                </span>
                            @elseif($med->status === 'Low Stock')
                                <span class="status-pill low-stock">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Low Stock
                                </span>
                            @elseif($med->status === 'Expired')
                                <span class="status-pill expired">
                                    <i class="bi bi-x-octagon-fill"></i> Expired
                                </span>
                            @else
                                <span class="status-pill warning">{{ $med->status }}</span>
                            @endif
                        </td>

                        <td style="text-align: right;">
                            <div class="action-group" style="justify-content: flex-end;">
                                <a href="{{ route('medicines.show', $med) }}" class="btn-icon view" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('medicines.edit', $med) }}" class="btn-icon edit" title="Edit Medicine">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('medicines.destroy', $med) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Delete Medicine">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <i class="bi bi-capsule" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
                            No medicines match your filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-container">
        {{ $medicines->withQueryString()->links() }}
    </div>

@endsection