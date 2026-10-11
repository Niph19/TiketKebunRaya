@extends('layouts.tiket')

@section('content')
    <section class="relative overflow-hidden bg-emerald-900">
        <div class="absolute inset-0 opacity-20" aria-hidden="true">
            <div class="absolute -right-10 -top-24 h-80 w-80 rounded-full border-[36px] border-emerald-200"></div>
            <div class="absolute -bottom-32 left-1/4 h-72 w-72 rounded-full border-[28px] border-lime-200"></div>
        </div>
        <div class="relative mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-emerald-200">Jelajahi alam, dekatkan diri dengan hijau</p>
            <h1 class="font-display max-w-3xl text-4xl leading-tight text-white sm:text-5xl">Luangkan waktu untuk tumbuh bersama alam.</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-emerald-100">Pilih tiket dan tanggal kunjungan Anda. Pesan tiket secara online, lalu tunjukkan e-ticket setelah pembayaran terkonfirmasi.</p>
            <a href="#pilih-tiket" class="mt-8 inline-flex min-h-12 items-center rounded-xl bg-lime-300 px-6 py-3 font-bold text-emerald-950 transition hover:bg-lime-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Lihat pilihan tiket</a>
        </div>
    </section>

    <section id="pilih-tiket" class="mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
        <div class="mb-8 max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Rencanakan kunjungan</p>
            <h2 class="font-display mt-2 text-3xl text-slate-900 sm:text-4xl">Pilih tiket kebun raya</h2>
            <p class="mt-3 leading-7 text-slate-600">Harga tiket dewasa dan anak ditampilkan sebelum Anda memesan.</p>
        </div>

        @if ($dataTiket->isEmpty())
            <div class="rounded-2xl border border-dashed border-emerald-300 bg-white px-6 py-14 text-center">
                <h3 class="text-lg font-semibold text-slate-900">Belum ada tiket yang tersedia</h3>
                <p class="mt-2 text-slate-600">Silakan kembali lagi nanti untuk melihat pilihan kunjungan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($dataTiket as $tiket)
                    <article class="flex flex-col rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <span class="w-fit rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">{{ $tiket->lokasi }}</span>
                        <h3 class="mt-4 text-xl font-bold text-slate-900">{{ $tiket->nama_tiket }}</h3>
                        <p class="mt-2 flex-1 leading-6 text-slate-600">{{ $tiket->deskripsi ?: 'Nikmati kunjungan dan pengalaman alam di Kebun Raya.' }}</p>
                        <dl class="mt-5 space-y-2 border-t border-slate-100 pt-4 text-sm">
                            <div class="flex justify-between gap-3">
                                <dt class="text-slate-600">Dewasa</dt>
                                <dd class="font-semibold text-slate-900">Rp {{ number_format($tiket->harga_dewasa, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt class="text-slate-600">Anak</dt>
                                <dd class="font-semibold text-slate-900">Rp {{ number_format($tiket->harga_anak, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                        @auth
                            @if (Auth::user()->role === 'user' && Auth::user()->hasVerifiedEmail())
                                <a href="{{ route('pesanan.create', $tiket) }}" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-white transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">Pesan tiket</a>
                            @elseif (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.jenis-tiket.index') }}" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl border border-emerald-800 px-4 py-2 font-semibold text-emerald-900 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kelola tiket</a>
                            @else
                                <a href="{{ route('verification.notice') }}" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Verifikasi email untuk memesan</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-800 px-4 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Masuk untuk memesan</a>
                        @endauth
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
