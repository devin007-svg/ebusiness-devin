<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name or SKU
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        // Distinct categories for filter dropdown
        $categories = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku'            => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'category'       => 'nullable|string|max:255',
            'unit'           => 'required|string|max:50',
            'purchase_price' => 'required',
            'selling_price'  => 'required',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        // Bersihkan format rupiah (hapus titik, koma, spasi)
        $validated['purchase_price'] = (int) str_replace(['.', ',', ' '], '', $request->purchase_price);
        $validated['selling_price']  = (int) str_replace(['.', ',', ' '], '', $request->selling_price);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Kirim data JSON untuk modal edit
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product   = Product::findOrFail($id);

        $validated = $request->validate([
            'sku'            => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'category'       => 'nullable|string|max:255',
            'unit'           => 'required|string|max:50',
            'purchase_price' => 'required',
            'selling_price'  => 'required',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|max:2048',
        ]);

        $validated['purchase_price'] = (int) str_replace(['.', ',', ' '], '', $request->purchase_price);
        $validated['selling_price']  = (int) str_replace(['.', ',', ' '], '', $request->selling_price);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
