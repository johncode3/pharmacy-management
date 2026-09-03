<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $categories = Category::orderBy('name')->get();

        $medicines = Medicine::where('status', '!=', 'Expired')
            ->where('expiry_date', '>', Carbon::today())
            ->where('stock_quantity', '>', 0)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%")
                      ->orWhere('generic_name', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pos.index', compact('medicines', 'categories', 'search', 'categoryId'));
    }
}