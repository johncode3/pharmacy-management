<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            ->paginate(15)
            ->withQueryString();

        return view('pos.index', compact('medicines', 'categories', 'search', 'categoryId'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name'  => 'nullable|string|max:255',
            'payment_method' => 'required|in:Cash,ABA / KHQR,Card',
            'paid_amount'    => 'required|numeric|min:0',
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|exists:medicines,id',
            'items.*.qty'    => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $itemsToInsert = [];

            foreach ($request->items as $item) {

                $medicine = Medicine::where('id', $item['id'])->lockForUpdate()->firstOrFail();

                if ($medicine->isExpired()) {
                    throw new \Exception("Safety Lock: [{$medicine->name}] is expired and cannot be sold!");
                }

                if ($medicine->stock_quantity < $item['qty']) {
                    throw new \Exception("Insufficient stock for [{$medicine->name}]. Only {$medicine->stock_quantity} available.");
                }

                $subtotal = $medicine->price * $item['qty'];
                $totalAmount += $subtotal;

                $medicine->decrement('stock_quantity', $item['qty']);

                if ($medicine->stock_quantity <= 10) {
                    $medicine->update(['status' => 'Low Stock']);
                }

                $itemsToInsert[] = [
                    'medicine_id' => $medicine->id,
                    'quantity'    => $item['qty'],
                    'unit_price'  => $medicine->price,
                    'subtotal'    => $subtotal,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            if ($request->paid_amount < $totalAmount) {
                throw new \Exception("Paid amount (\${$request->paid_amount}) is less than total amount (\${$totalAmount}).");
            }

            $invoiceNumber = 'INV-' . date('YmdHis') . '-' . strtoupper(Str::random(3));

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_name'  => $request->customer_name ?: 'Walk-in Customer',
                'total_amount'   => $totalAmount,
                'paid_amount'    => $request->paid_amount,
                'payment_method' => $request->payment_method,
                'user_id'        => Auth::id(),
            ]);

            foreach ($itemsToInsert as &$row) {
                $row['sale_id'] = $sale->id;
            }
            SaleItem::insert($itemsToInsert);

            DB::commit();

            return redirect()->route('sales.show', $sale)->with('success', 'Sale completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}