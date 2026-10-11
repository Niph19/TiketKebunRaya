@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Pengelola</p>
                <h1 class="font-display mt-2 text-3xl text-slate-900">Dashboard admin</h1>
                <p class="mt-2 text-slate-600">Tinjau pesanan dan verifikasi pembayaran pengunjung.</p>
            </div>
            <a href="{{ route('admin.jenis-tiket.index') }}" class="inline-flex min-h-11 items-center rounded-xl border border-emerald-800 px-4 py-2 font-semibold text-emerald-900 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kelola jenis tiket</a>
        </div>

        <div class="mt-7 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
            @if ($pesanans->isEmpty())
                <div class="px-6 py-14 text-center">
                    <h2 class="text-lg font-semibold text-slate-900">Belum ada pesanan</h2>
                    <p class="mt-2 text-slate-600">Pesanan pengunjung akan muncul di halaman ini.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($pesanans as $pesanan)
                        <article class="p-5 sm:p-6">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h2 class="font-semibold text-slate-900">{{ $pesanan->kode_invoice }}</h2>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                            {{ $pesanan->status === 'lunas' ? 'bg-emerald-100 text-emerald-900' : ($pesanan->status === 'ditolak' ? 'bg-red-100 text-red-900' : 'bg-amber-100 text-amber-900') }}">
                                            {{ str_replace('_', ' ', ucfirst($pesanan->status)) }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-slate-700">{{ $pesanan->user->name }} · {{ $pesanan->user->email }}</p>
                                    <p class="mt-1 text-sm text-slate-600">{{ $pesanan->jenisTiket?->nama_tiket ?? 'Jenis tiket dihapus' }} · {{ $pesanan->tanggal_kunjungan->format('d/m/Y') }}</p>
                                    <p class="mt-1 text-sm text-slate-600">{{ $pesanan->jumlah_dewasa }} dewasa, {{ $pesanan->jumlah_anak }} anak · Total Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                </div>

                                @if ($pesanan->bukti_pembayaran)
                                    <a href="{{ route('admin.pesanan.bukti', $pesanan) }}" target="_blank" rel="noopener" class="inline-flex min-h-11 items-center rounded-xl border border-emerald-800 px-4 py-2 text-sm font-semibold text-emerald-900 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Lihat bukti bayar</a>
                                @else
                                    <span class="text-sm text-slate-500">Belum ada bukti pembayaran</span>
                                @endif
                            </div>

                            @if ($pesanan->status === 'menunggu_konfirmasi' && $pesanan->bukti_pembayaran)
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <form method="POST" action="{{ route('admin.pesanan.approve', $pesanan) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex min-h-11 items-center rounded-xl bg-emerald-800 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Konfirmasi pembayaran</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.pesanan.reject', $pesanan) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex min-h-11 items-center rounded-xl border border-red-700 px-4 py-2 text-sm font-semibold text-red-800 hover:bg-red-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-700">Tolak bukti</button>
                                    </form>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
                <div class="border-t border-slate-100 px-5 py-4">{{ $pesanans->links() }}</div>
            @endif
        </div>
    </section>
@endsection
