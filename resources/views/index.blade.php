<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Panel Admin</a>
                    @else
                        <a href="{{ route('pesanan.index') }}" class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Pesanan Saya</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors bg-transparent border-0 cursor-pointer text-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="ml-1 px-4 py-2 bg-[#2451FF] text-white text-sm font-semibold rounded-lg hover:bg-[#17348F] transition-colors">Daftar</a>
                @endauth
</body>
</html>