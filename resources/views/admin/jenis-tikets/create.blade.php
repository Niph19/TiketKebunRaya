@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-10 sm:px-6">
        <a href="{{ route('admin.jenis-tiket.index') }}" class="text-sm font-semibold text-emerald-800 underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kembali ke jenis tiket</a>
        <div class="mt-5 rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="font-display text-3xl text-slate-900">Tambah jenis tiket</h1>
            <form method="POST" action="{{ route('admin.jenis-tiket.store') }}" class="mt-6 space-y-5">
                @csrf
                @include('admin.jenis-tikets.form', ['buttonText' => 'Simpan jenis tiket'])
            </form>
        </div>
    </section>
@endsection
