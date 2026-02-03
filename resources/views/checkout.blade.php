<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout Kasir - {{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f4f6f9; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; }
        .wrap { max-width: 1100px; margin: 30px auto; padding: 0 14px; }
        .cardx { background:#fff; border-radius:14px; border:1px solid #eef1f6; box-shadow:0 4px 25px rgba(0,0,0,.08); overflow:hidden; }
        .cardx-header { padding:18px 20px; border-bottom:1px solid #eef1f6; display:flex; align-items:center; justify-content:space-between; }
        .title { font-weight:900; color:#34395e; margin:0; font-size:20px; }
        .muted { color:#6c757d; font-size:13px; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="mb-1" style="font-weight:900;color:#34395e;">Checkout Kasir</h1>
            <div class="muted">Masukkan pembayaran pelanggan</div>
        </div>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="cardx">
                <div class="cardx-header">
                    <div>
                        <div class="title">Ringkasan Item</div>
                        <div class="muted">Cek sebelum bayar</div>
                    </div>
                </div>

                <div class="p-3 table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cart as $item)
                            @php $sub = (int)$item['qty'] * (int)$item['price']; @endphp
                            <tr>
                                <td style="font-weight:800;color:#34395e;">{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['qty'] }}</td>
                                <td class="text-end">Rp {{ number_format($item['price'],0,',','.') }}</td>
                                <td class="text-end">Rp {{ number_format($sub,0,',','.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="cardx p-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold">Rp {{ number_format($total,0,',','.') }}</span>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" class="mt-3" id="payForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode</label>
                        <select name="metode" class="form-select" required>
                            <option value="tunai" {{ old('metode','tunai')==='tunai'?'selected':'' }}>Tunai</option>
                            <option value="qris"  {{ old('metode')==='qris'?'selected':'' }}>QRIS</option>
                            <option value="debit" {{ old('metode')==='debit'?'selected':'' }}>Debit</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Uang Dibayar</label>
                        <input type="number" name="bayar" id="bayar" class="form-control"
                               placeholder="Masukkan uang" value="{{ old('bayar') }}" min="0" required>
                    </div>

                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Kembalian</span>
                        <span id="kembalian">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <i class="fas fa-check me-2"></i>Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
(function(){
    const total = {{ (int)$total }};
    const bayarEl = document.getElementById('bayar');
    const outEl = document.getElementById('kembalian');

    function rupiah(n){
        n = isNaN(n) ? 0 : n;
        return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function calc(){
        const bayar = parseInt(bayarEl.value || '0', 10);
        const k = bayar - total;
        outEl.textContent = rupiah(k > 0 ? k : 0);
    }

    bayarEl.addEventListener('input', calc);
    calc();
})();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
