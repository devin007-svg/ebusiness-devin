<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += ((int)$item['qty']) * ((int)$item['price']);
        }

        return view('keranjang', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $qty = (int)($request->qty ?? 1);

        if ((int)$product->stock < $qty) {
            return back()->with('error', 'Stok tidak cukup.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQty = (int)$cart[$product->id]['qty'] + $qty;
            if ($newQty > (int)$product->stock) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $cart[$product->id]['qty'] = $newQty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku ?? '-',
                'unit' => $product->unit ?? '',
                'image' => $product->image,
                'price' => (int)($product->selling_price ?? ($product->price ?? 0)),
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'action' => ['required', 'in:plus,minus,set'],
            'qty' => ['nullable', 'integer', 'min:1']
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return back()->with('error', 'Produk tidak ada di keranjang.');
        }

        $currentQty = (int)$cart[$product->id]['qty'];
        $stock = (int)$product->stock;

        if ($request->action === 'plus') {
            if ($currentQty + 1 > $stock) return back()->with('error', 'Stok tidak cukup.');
            $cart[$product->id]['qty'] = $currentQty + 1;
        }

        if ($request->action === 'minus') {
            $newQty = $currentQty - 1;
            if ($newQty <= 0) unset($cart[$product->id]);
            else $cart[$product->id]['qty'] = $newQty;
        }

        if ($request->action === 'set') {
            $qty = (int)($request->qty ?? 1);
            if ($qty > $stock) return back()->with('error', 'Jumlah melebihi stok tersedia.');
            $cart[$product->id]['qty'] = $qty;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
