<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalRevenue = Sale::sum('total_amount');
        $todaySales = Sale::whereDate('created_at', $today)->sum('total_amount');
        $activeMedicinesCount = Medicine::where('status', 'Available')->count();
        $lowStockCount = Medicine::where('stock_quantity', '<=', 10)->where('status', '!=', 'Expired')->count();
        $expiredMedicinesCount = Medicine::where('expiry_date', '<=', $today)->orWhere('status', 'Expired')->count();

        $recentSales = Sale::with('cashier')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalRevenue',
            'todaySales',
            'activeMedicinesCount',
            'lowStockCount',
            'expiredMedicinesCount',
            'recentSales'
        ));
    }
}