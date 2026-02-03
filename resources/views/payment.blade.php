<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - {{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background:#f4f6f9; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif; }
        .wrap { max-width: 520px; margin: 60px auto; padding: 0 14px; }
        .cardx { background:#fff; border-radius:16px; border:1px solid #eef1f6; box-shadow:0 4px 25px rgba(0,0,0,.08); }
    </style>
</head>
<body>

@php $p = session('payment'); @endphp

<div class="wrap">
    <div class="cardx p-4 text-center">
        <i class="fa-solid fa-circle-check text-success mb-3" style="font-size:70px"></i>
        <h3 class="fw-bold mb-1">Pembayaran Berhasil</h3>
        <div class="text-muted mb-4">Transaksi selesai</div>

        <hr>

        <div class="text-start">
            <div class="d-flex justify-content-between">
                <span class="text-muted">Kode</span>
                <strong>{{ $p['kode'] ?? '-' }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Tanggal</span>
                <strong>{{ $p['tanggal'] ?? '-' }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Metode</span>
                <strong>{{ $p['metode'] ?? '-' }}</strong>
            </div>

            <hr>

            <div class="d-flex justify-content-between fs-5">
                <span>Total</span>
                <strong>Rp {{ number_format($p['total'] ?? 0,0,',','.') }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Dibayar</span>
                <strong>Rp {{ number_format($p['bayar'] ?? 0,0,',','.') }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Kembalian</span>
                <strong class="text-success">Rp {{ number_format($p['kembalian'] ?? 0,0,',','.') }}</strong>
            </div>
        </div>

        <hr>

        <div class="d-grid gap-2">
            <a href="{{ route('cart.index') }}" class="btn btn-primary fw-bold">
                Transaksi Baru
            </a>
            <button class="btn btn-outline-secondary" onclick="window.print()">
                Cetak Struk
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
