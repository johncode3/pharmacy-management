<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $status = $request->query('status');

        $categories = Category::orderBy('name')->get();

        $medicines = Medicine::with('category')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('generic_name', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('medicines.index', compact('medicines', 'categories', 'search', 'categoryId', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'generic_name'   => 'nullable|string|max:255',
            'barcode'        => 'nullable|string|max:50|unique:medicines,barcode',
            'price'          => 'required|numeric|min:0.01',
            'cost'           => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date'    => 'required|date',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if (empty($validated['barcode'])) {
            $validated['barcode'] = 'MED-' . strtoupper(Str::random(6));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        }

        $expiry = \Carbon\Carbon::parse($validated['expiry_date']);
        if ($expiry->isPast() || $expiry->isToday()) {
            $validated['status'] = 'Expired';
        } elseif ($validated['stock_quantity'] <= 10) {
            $validated['status'] = 'Low Stock';
        } else {
            $validated['status'] = 'Available';
        }

        Medicine::create($validated);

        return redirect()->route('medicines.index')->with('success', 'Medicine registered into inventory successfully.');
    }

    public function show(Medicine $medicine)
    {
        return view('medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::orderBy('name')->get();
        return view('medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:255',
            'generic_name'   => 'nullable|string|max:255',
            'barcode'        => 'required|string|max:50|unique:medicines,barcode,' . $medicine->id,
            'price'          => 'required|numeric|min:0.01',
            'cost'           => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'expiry_date'    => 'required|date',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
                Storage::disk('public')->delete($medicine->image);
            }
            $validated['image'] = $request->file('image')->store('medicines', 'public');
        }
        
        $expiry = \Carbon\Carbon::parse($validated['expiry_date']);
        if ($expiry->isPast() || $expiry->isToday()) {
            $validated['status'] = 'Expired';
        } elseif ($validated['stock_quantity'] <= 10) {
            $validated['status'] = 'Low Stock';
        } else {
            $validated['status'] = 'Available';
        }

        $medicine->update($validated);

        return redirect()->route('medicines.index')->with('success', 'Medicine details updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        if ($medicine->saleItems()->count() > 0) {
            return back()->with('error', 'Cannot delete this medicine because it exists in past sales invoices.');
        }

        if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'Medicine deleted from inventory.');
    }
}