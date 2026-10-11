@extends('layouts.tiket')

@section('content')

{{-- Hero --}}
<section id="hero">

</section>

{{-- TIket --}}
<section id="tiket">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($dataTiket as $tiket)
            <article
                class="bg-white border border-[#E4E8F3] rounded-2xl overflow-hidden flex flex-col hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                <div class="aspect-[4/3] bg-[#F5F7FF] flex items-center justify-center overflow-hidden">
                    @if ($tiket->image)
                        <img src="{{ asset('storage/' . $tiket->image) }}" alt="{{ $tiket->nama_tiket }}"
                            class="w-full h-full object-cover">
                    @else
                        <span class="text-[#8FA3FF] text-sm">Foto tiket</span>
                    @endif
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex gap-2 mb-2">
                        <span
                            class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $tiket->stok > 0 ? 'bg-[#EAF7EF] text-[#15803D]' : 'bg-[#FEF2F2] text-[#B91C1C]' }}">
                            {{ $tiket->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-[#F5F7FF] text-[#2451FF]">Stok
                            {{ $tiket->stok }}</span>
                    </div>
                    <h3 class="font-semibold text-[#0B1220] mb-1">{{ $tiket->nama_tiket }}</h3>
                    <p class="text-[#5B6472] text-sm leading-relaxed flex-1 mb-4">{{ $tiket->deskripsi }}</p>
                    <div class="flex items-center justify-between pt-3 border-t border-[#E4E8F3]">
                        <span class="text-[#2451FF] font-semibold text-lg">Rp
                            {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                        @auth
                            <a href="{{ route('pesanan.create', $tiket) }}"
                                class="px-4 py-2 bg-[#2451FF] text-white text-sm font-semibold rounded-lg hover:bg-[#17348F] transition-colors">Checkout</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 bg-[#2451FF] text-white text-sm font-semibold rounded-lg hover:bg-[#17348F] transition-colors">Masuk
                                untuk beli</a>
                        @endauth
                    </div>
                </div>
                @forelse ($dataTiket as $tiket)

                @empty
                    <div class="text-center py-20 border-2 border-dashed border-[#E4E8F3] rounded-2xl text-[#8A93A6]">
                        Belum ada tiket yang tersedia.
                    </div>
                @endforelse
            </article>
        @endforeach
    </div>
</section>