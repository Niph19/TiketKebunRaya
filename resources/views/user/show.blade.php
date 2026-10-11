@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <a href="{{ route('dashboard.index') }}" class="text-sm font-semibold text-emerald-800 underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kembali ke pesanan</a>

        <div class="mt-5 rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Detail pesanan</p>
                    <h1 class="font-display mt-2 text-3xl text-slate-900">{{ $pesanan->kode_invoice }}</h1>
                </div>
                <span class="rounded-full px-3 py-1 text-sm font-semibold
                    {{ $pesanan->status === 'lunas' ? 'bg-emerald-100 text-emerald-900' : ($pesanan->status === 'ditolak' ? 'bg-red-100 text-red-900' : 'bg-amber-100 text-amber-900') }}">
                    {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                </span>
            </div>

            <dl class="mt-6 grid gap-4 rounded-xl bg-slate-50 p-4 sm:grid-cols-2">
                <div><dt class="text-sm text-slate-600">Jenis tiket</dt><dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->jenisTiket?->nama_tiket ?? 'Jenis tiket' }}</dd></div>
                <div><dt class="text-sm text-slate-600">Lokasi</dt><dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->jenisTiket?->lokasi ?? '-' }}</dd></div>
                <div><dt class="text-sm text-slate-600">Tanggal kunjungan</dt><dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->tanggal_kunjungan->format('d F Y') }}</dd></div>
                <div><dt class="text-sm text-slate-600">Jumlah pengunjung</dt><dd class="mt-1 font-semibold text-slate-900">{{ $pesanan->jumlah_dewasa }} dewasa, {{ $pesanan->jumlah_anak }} anak</dd></div>
            </dl>

            <div class="mt-5 space-y-2 border-t border-slate-100 pt-5">
                <div class="flex justify-between gap-4 text-sm"><span class="text-slate-600">{{ $pesanan->jumlah_dewasa }} × dewasa</span><span class="font-medium">Rp {{ number_format($pesanan->jumlah_dewasa * $pesanan->harga_dewasa, 0, ',', '.') }}</span></div>
                <div class="flex justify-between gap-4 text-sm"><span class="text-slate-600">{{ $pesanan->jumlah_anak }} × anak</span><span class="font-medium">Rp {{ number_format($pesanan->jumlah_anak * $pesanan->harga_anak, 0, ',', '.') }}</span></div>
                <div class="flex justify-between gap-4 border-t border-slate-100 pt-3 text-lg font-bold"><span>Total tagihan</span><span class="text-emerald-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></div>
            </div>

            @if ($pesanan->status === 'lunas')
                <div class="mt-7 rounded-xl border border-emerald-200 bg-emerald-50 p-5">
                    <h2 class="font-semibold text-emerald-950">Pembayaran terverifikasi</h2>
                    <p class="mt-1 text-sm text-emerald-900">E-ticket Anda sudah siap diunduh.</p>
                    <a href="{{ route('pesanan.tiket', $pesanan) }}" class="mt-4 inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-5 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Unduh e-ticket PDF</a>
                </div>
            @elseif (in_array($pesanan->status, ['pending', 'ditolak'], true))
                <div class="mt-7 rounded-xl border border-amber-200 bg-amber-50 p-5">
                    <h2 class="font-semibold text-amber-950">Instruksi pembayaran</h2>
                    <p class="mt-2 text-sm leading-6 text-amber-950">Transfer sejumlah <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                    <dl class="mt-3 space-y-1 text-sm text-amber-950">
                        <div><dt class="inline font-semibold">Bank:</dt> <dd class="inline">{{ config('ticketing.payment_bank') ?: 'Lengkapi TICKET_PAYMENT_BANK di .env' }}</dd></div>
                        <div><dt class="inline font-semibold">Nomor rekening:</dt> <dd class="inline">{{ config('ticketing.payment_account') ?: 'Lengkapi TICKET_PAYMENT_ACCOUNT di .env' }}</dd></div>
                        <div><dt class="inline font-semibold">Atas nama:</dt> <dd class="inline">{{ config('ticketing.payment_name') ?: 'Lengkapi TICKET_PAYMENT_NAME di .env' }}</dd></div>
                    </dl>
                    @if ($pesanan->status === 'ditolak')
                        <p class="mt-3 text-sm font-medium text-red-800">Bukti sebelumnya ditolak. Silakan unggah bukti pembayaran yang benar.</p>
                    @endif

                    <form method="POST" action="{{ route('pesanan.bukti', $pesanan) }}" enctype="multipart/form-data" class="mt-5">
                        @csrf
                        <label for="bukti_pembayaran" class="block text-sm font-semibold text-slate-800">Unggah bukti pembayaran</label>
                        <p id="bukti-help" class="mt-1 text-sm text-slate-600">JPG, PNG, atau PDF. Maksimal 2 MB.</p>
                        <input id="bukti_pembayaran" name="bukti_pembayaran" type="file" accept=".jpg,.jpeg,.png,.pdf" required aria-describedby="bukti-help" class="mt-2 block min-h-11 w-full rounded-lg border border-slate-300 bg-white text-sm file:mr-4 file:min-h-11 file:border-0 file:bg-emerald-50 file:px-4 file:font-semibold file:text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">
                        @error('bukti_pembayaran') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                        <button type="submit" class="mt-4 inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-5 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Kirim bukti pembayaran</button>
                    </form>
                </div>
            @else
                <div class="mt-7 rounded-xl border border-sky-200 bg-sky-50 p-5">
                    <h2 class="font-semibold text-sky-950">Menunggu konfirmasi admin</h2>
                    <p class="mt-1 text-sm text-sky-900">Bukti pembayaran sudah diterima. E-ticket dapat diunduh setelah pembayaran disetujui.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
