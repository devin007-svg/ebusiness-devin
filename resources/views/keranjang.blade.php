<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang - {{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; }
        .wrap { max-width: 1100px; margin: 30px auto; padding: 0 14px; }
        .cardx { background:#fff; border-radius:14px; border:1px solid #eef1f6; box-shadow:0 4px 25px rgba(0,0,0,.08); overflow:hidden; }
        .cardx-header { padding:18px 20px; border-bottom:1px solid #eef1f6; display:flex; align-items:center; justify-content:space-between; }
        .title { font-weight:900; color:#34395e; margin:0; font-size:20px; }
        .muted { color:#6c757d; font-size:13px; }
        .item-img { width:56px; height:56px; border-radius:12px; object-fit:cover; background:#f2f3f5; display:flex; align-items:center; justify-content:center; }
        .qty-btn { width:36px; height:36px; border-radius:10px; display:inline-flex; align-items:center; justify-content:center; border:1px solid #e5e7eb; background:#fff; }
        .qty-btn:hover { background:#f4f6f9; }
        .price { font-weight:900; color:#34395e; }
        .totalbox {
            background: linear-gradient(135deg, #6777ef 0%, #5a68d8 100%);
            color:#fff; border-radius:14px; padding:18px;
            box-shadow:0 4px 25px rgba(103,119,239,.25);
        }
    </style>
</head>
<body>

<div class="wrap">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="mb-1" style="font-weight:900;color:#34395e;">Keranjang</h1>
            <div class="muted">Kelola item yang akan kamu beli</div>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="cardx">
                <div class="cardx-header">
                    <div>
                        <div class="title">Daftar Item</div>
                        <div class="muted">Tambah/kurangi qty langsung di sini</div>
                    </div>

                    <form method="POST" action="{{ route('cart.clear') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Kosongkan keranjang?')">
                            <i class="fas fa-trash me-2"></i>Clear
                        </button>
                    </form>
                </div>

                <div class="p-3">
                    @if(empty($cart))
                        <div class="text-center p-5">
                            <i class="fas fa-cart-shopping fs-1 text-secondary mb-3"></i>
                            <p class="mb-0 text-secondary">Keranjang masih kosong.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $item)
                                    @php $subtotal = (int)$item['qty'] * (int)$item['price']; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if(!empty($item['image']))
                                                    <img class="item-img" src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                                                @else
                                                    <div class="item-img text-secondary">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight:900;color:#34395e;">{{ $item['name'] }}</div>
                                                    <div class="muted">SKU: {{ $item['sku'] ?? '-' }} @if(!empty($item['unit'])) • Unit: {{ $item['unit'] }} @endif</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="minus">
                                                    <button class="qty-btn" type="submit" title="Kurangi">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </form>

                                                <span class="px-3 py-2 bg-light rounded-3" style="min-width:48px; display:inline-block;">
                                                    {{ $item['qty'] }}
                                                </span>

                                                <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="plus">
                                                    <button class="qty-btn" type="submit" title="Tambah">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="text-end price">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td class="text-end price">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>

                                        <td class="text-end">
                                            <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Hapus item ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="totalbox">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="opacity:.85;">Total</div>
                        <div style="font-weight:900; font-size:24px;">
                            Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <i class="fas fa-receipt fs-2" style="opacity:.9;"></i>
                </div>

                <a href="{{ route('checkout.index') }}"
                class="btn btn-warning w-100 mt-3 fw-bold {{ empty($cart) ? 'disabled' : '' }}"
                @if(empty($cart)) aria-disabled="true" @endif>
                    <i class="fas fa-credit-card me-2"></i>Checkout
                </a>


                <div class="mt-3" style="opacity:.9; font-size:13px;">
                    * Checkout nanti kita buat, yang penting keranjang sudah jalan dulu.
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
