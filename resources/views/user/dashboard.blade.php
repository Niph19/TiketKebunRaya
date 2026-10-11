@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Area pengunjung</p>
                <h1 class="font-display mt-2 text-3xl text-slate-900">Pesanan saya</h1>
                <p class="mt-2 text-slate-600">Lihat status pembayaran dan akses e-ticket Anda.</p>
            </div>
            <a href="{{ route('index') }}" class="inline-flex min-h-11 items-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Pesan tiket</a>
        </div>

        <div class="mt-7 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
            @if ($pesanans->isEmpty())
                <div class="px-6 py-14 text-center">
                    <h2 class="text-lg font-semibold text-slate-900">Belum ada pesanan</h2>
                    <p class="mt-2 text-slate-600">Pilih tiket kebun raya untuk memulai pemesanan.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($pesanans as $pesanan)
                        <article class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-semibold text-slate-900">{{ $pesanan->kode_invoice }}</h2>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $pesanan->status === 'lunas' ? 'bg-emerald-100 text-emerald-900' : ($pesanan->status === 'ditolak' ? 'bg-red-100 text-red-900' : 'bg-amber-100 text-amber-900') }}">
                                        {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600">{{ $pesanan->jenisTiket?->nama_tiket ?? 'Jenis tiket' }} · {{ $pesanan->tanggal_kunjungan->format('d/m/Y') }}</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('pesanan.show', $pesanan) }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-emerald-800 px-4 py-2 text-sm font-semibold text-emerald-900 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Detail pesanan</a>
                                @if ($pesanan->status === 'lunas')
                                    <a href="{{ route('pesanan.tiket', $pesanan) }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Unduh e-ticket</a>
                                @else
                                    <button type="button" disabled class="inline-flex min-h-11 cursor-not-allowed items-center justify-center rounded-xl bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-500" aria-describedby="ticket-locked-{{ $pesanan->id }}">Unduh e-ticket</button>
                                    <span id="ticket-locked-{{ $pesanan->id }}" class="sr-only">Tiket tersedia setelah pembayaran dikonfirmasi.</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="border-t border-slate-100 px-5 py-4">{{ $pesanans->links() }}</div>
            @endif
        </div>
    </section>
@endsection
