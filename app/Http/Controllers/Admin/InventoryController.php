<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.inventory', compact('products'));
    }

    public function adjust(Request $request, Product $product)
    {
        $data = $request->validate([
            'action' => ['required', 'in:increase,decrease'],
            'qty'    => ['required', 'integer', 'min:1'],
        ]);

        $qty = (int) $data['qty'];

        if ($data['action'] === 'increase') {
            $product->increment('stock', $qty);
            return back()->with('success', "Stok {$product->name} berhasil ditambah +{$qty}.");
        }

        // decrease
        if ((int)$product->stock < $qty) {
            return back()->with('error', "Stok tidak cukup. Stok saat ini: {$product->stock}.");
        }

        $product->decrement('stock', $qty);
        return back()->with('success', "Stok {$product->name} berhasil dikurangi -{$qty}.");
    }
}
