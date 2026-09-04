<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $sales = Sale::with(['cashier', 'items.medicine'])
            ->when($search, function ($query, $search) {
                return $query->where('invoice_number', 'like', "%{$search}%")
                             ->orWhere('customer_name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['cashier', 'items.medicine']);
        return view('sales.show', compact('sale'));
    }
}