@extends('layouts.tiket')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
        <a href="{{ route('index') }}" class="text-sm font-semibold text-emerald-800 underline underline-offset-4 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-800">Kembali ke pilihan tiket</a>
        <div class="mt-5 rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Pemesanan</p>
            <h1 class="font-display mt-2 text-3xl text-slate-900">Pesan {{ $jenisTiket->nama_tiket }}</h1>
            <p class="mt-2 text-slate-600">{{ $jenisTiket->lokasi }}</p>

            <form method="POST" action="{{ route('pesanan.store') }}" class="mt-7 space-y-6">
                @csrf
                <input type="hidden" name="jenis_tiket_id" value="{{ $jenisTiket->id }}">

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-semibold text-slate-800">Tanggal kunjungan</label>
                    <input id="tanggal_kunjungan" name="tanggal_kunjungan" type="date" min="{{ now()->toDateString() }}" value="{{ old('tanggal_kunjungan') }}" required class="mt-2 min-h-12 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
                    @error('tanggal_kunjungan') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="jumlah_dewasa" class="block text-sm font-semibold text-slate-800">Tiket dewasa</label>
                        <p class="mt-1 text-sm text-slate-600">Rp {{ number_format($jenisTiket->harga_dewasa, 0, ',', '.') }} per tiket</p>
                        <input id="jumlah_dewasa" name="jumlah_dewasa" type="number" min="0" max="20" value="{{ old('jumlah_dewasa', 1) }}" required class="mt-2 min-h-12 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
                        @error('jumlah_dewasa') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="jumlah_anak" class="block text-sm font-semibold text-slate-800">Tiket anak</label>
                        <p class="mt-1 text-sm text-slate-600">Rp {{ number_format($jenisTiket->harga_anak, 0, ',', '.') }} per tiket</p>
                        <input id="jumlah_anak" name="jumlah_anak" type="number" min="0" max="20" value="{{ old('jumlah_anak', 0) }}" required class="mt-2 min-h-12 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
                        @error('jumlah_anak') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="rounded-xl bg-emerald-50 p-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="font-semibold text-slate-800">Perkiraan total</span>
                        <span id="total_harga" class="text-xl font-bold text-emerald-900" aria-live="polite">Rp 0</span>
                    </div>
                    <p class="mt-1 text-xs text-slate-600">Total akhir dihitung kembali oleh server berdasarkan harga tiket.</p>
                </div>

                <button type="submit" class="inline-flex min-h-12 w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-3 font-semibold text-white transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800 sm:w-auto">Buat pesanan</button>
            </form>
        </div>
    </section>

    <script>
        const adultPrice = {{ $jenisTiket->harga_dewasa }};
        const childPrice = {{ $jenisTiket->harga_anak }};
        const adultInput = document.getElementById('jumlah_dewasa');
        const childInput = document.getElementById('jumlah_anak');
        const totalOutput = document.getElementById('total_harga');

        function updateTotal() {
            const total = (Number(adultInput.value) * adultPrice) + (Number(childInput.value) * childPrice);
            totalOutput.textContent = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(total);
        }

        adultInput.addEventListener('input', updateTotal);
        childInput.addEventListener('input', updateTotal);
        updateTotal();
    </script>
@endsection
