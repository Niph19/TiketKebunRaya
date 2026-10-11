<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Tiket {{ $pesanan->kode_invoice }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #17352c; font-size: 12px; }
        .ticket { border: 2px solid #176b4d; border-radius: 14px; padding: 28px; }
        .heading { color: #176b4d; font-size: 24px; margin-bottom: 4px; }
        .muted { color: #52645c; }
        .details { width: 100%; border-collapse: collapse; margin-top: 22px; }
        .details td { border-bottom: 1px solid #dce8e1; padding: 10px 0; }
        .label { color: #52645c; width: 40%; }
        .total { font-size: 16px; font-weight: bold; }
        .qr { margin-top: 18px; text-align: center; }
        .qr img { width: 180px; height: 180px; }
        .code { font-family: monospace; font-size: 11px; }
    </style>
</head>
<body>
    <div class="ticket">
        <p class="muted">SISTEM TIKETING DIGITAL</p>
        <h1 class="heading">E-Tiket Kebun Raya</h1>
        <p class="muted">Pembayaran terverifikasi · Tunjukkan tiket ini saat kunjungan</p>

        <table class="details">
            <tr><td class="label">Kode invoice</td><td><strong>{{ $pesanan->kode_invoice }}</strong></td></tr>
            <tr><td class="label">Nama pengunjung</td><td>{{ $pesanan->user->name }}</td></tr>
            <tr><td class="label">Jenis tiket</td><td>{{ $pesanan->jenisTiket?->nama_tiket ?? 'Tiket Kebun Raya' }}</td></tr>
            <tr><td class="label">Lokasi</td><td>{{ $pesanan->jenisTiket?->lokasi ?? '-' }}</td></tr>
            <tr><td class="label">Tanggal kunjungan</td><td>{{ $pesanan->tanggal_kunjungan->format('d F Y') }}</td></tr>
            <tr><td class="label">Jumlah tiket</td><td>{{ $pesanan->jumlah_dewasa }} dewasa, {{ $pesanan->jumlah_anak }} anak</td></tr>
            <tr><td class="label total">Total dibayar</td><td class="total">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Status</td><td><strong>LUNAS / TERVERIFIKASI</strong></td></tr>
        </table>

        <div class="qr">
            <img src="{{ $qrCode }}" alt="Kode QR tiket {{ $pesanan->kode_invoice }}">
            <p class="code">{{ $pesanan->kode_tiket }}</p>
        </div>
        <p class="muted" style="text-align:center">Simpan tiket ini dan tunjukkan kepada petugas saat berkunjung.</p>
    </div>
</body>
</html>
