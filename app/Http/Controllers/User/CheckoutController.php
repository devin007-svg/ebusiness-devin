<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Silakan pilih produk dulu.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $qty = (int)($item['qty'] ?? 0);
            $price = (int)($item['price'] ?? 0);
            $total += $qty * $price;
        }

        return view('checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $request->validate([
            'metode' => ['required', 'in:tunai,qris,debit'],
            'bayar'  => ['required', 'numeric', 'min:0'],
        ]);

        // hitung ulang total dari cart (jangan percaya input hidden)
        $total = 0;
        foreach ($cart as $item) {
            $qty = (int)($item['qty'] ?? 0);
            $price = (int)($item['price'] ?? 0);
            $total += $qty * $price;
        }

        $bayar = (int)$request->bayar;
        if ($bayar < $total) {
            return back()->withErrors(['bayar' => 'Uang bayar kurang.'])->withInput();
        }

        $kembalian = $bayar - $total;

        // simpan data transaksi ke session untuk halaman success
        $paymentData = [
            'kode'      => 'TRX-' . now()->format('YmdHis'),
            'tanggal'   => now()->format('d M Y H:i'),
            'metode'    => strtoupper($request->metode),
            'total'     => $total,
            'bayar'     => $bayar,
            'kembalian' => $kembalian,
            'items'     => $cart, // kalau mau tampil detail item di struk
        ];

        // kosongkan cart setelah bayar
        session()->forget('cart');

        // kirim data transaksi ke halaman payment berhasil
        return redirect()->route('payment.success')->with('payment', $paymentData);
    }
}
