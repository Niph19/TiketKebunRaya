@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <a href="{{ route('admin.index') }}" class="text-sm font-semibold text-emerald-800 underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kembali ke dashboard</a>
                <h1 class="font-display mt-3 text-3xl text-slate-900">Jenis tiket</h1>
                <p class="mt-2 text-slate-600">Atur lokasi kunjungan dan harga tiket dewasa maupun anak.</p>
            </div>
            <a href="{{ route('admin.jenis-tiket.create') }}" class="inline-flex min-h-11 items-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Tambah jenis tiket</a>
        </div>

        <div class="mt-7 overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-sm">
            @if ($jenisTikets->isEmpty())
                <div class="px-6 py-14 text-center">
                    <h2 class="text-lg font-semibold text-slate-900">Belum ada jenis tiket</h2>
                    <p class="mt-2 text-slate-600">Tambahkan jenis tiket agar pengunjung dapat mulai memesan.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($jenisTikets as $jenisTiket)
                        <article class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-semibold text-slate-900">{{ $jenisTiket->nama_tiket }}</h2>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $jenisTiket->is_active ? 'bg-emerald-100 text-emerald-900' : 'bg-slate-200 text-slate-700' }}">{{ $jenisTiket->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">{{ $jenisTiket->lokasi }}</p>
                                <p class="mt-2 text-sm text-slate-700">Dewasa Rp {{ number_format($jenisTiket->harga_dewasa, 0, ',', '.') }} · Anak Rp {{ number_format($jenisTiket->harga_anak, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('admin.jenis-tiket.edit', $jenisTiket) }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-emerald-800 px-4 py-2 text-sm font-semibold text-emerald-900 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Ubah</a>
                        </article>
                    @endforeach
                </div>
                <div class="border-t border-slate-100 px-5 py-4">{{ $jenisTikets->links() }}</div>
            @endif
        </div>
    </section>
@endsection
