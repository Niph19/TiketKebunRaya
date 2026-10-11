<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tiket Kebun Raya' }} | Tiket Kebun Raya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-white text-[#0B1220] antialiased">

    {{-- Navbar --}}
    <header class="bg-white/90 backdrop-blur border-b border-[#E4E8F3] sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-5 h-16 flex items-center justify-between gap-6">
            <a href="{{ route('index') }}"
                class="flex items-center gap-2 font-['Space_Grotesk'] font-bold text-lg tracking-tight text-[#0B1220] no-underline">

            </a>
            <nav class="flex items-center gap-1 text-sm">
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}"
                            class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Panel
                            Admin</a>
                    @else
                        <a href="{{ route('dashboard.index') }}"
                            class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Tiket
                            Saya</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors bg-transparent border-0 cursor-pointer text-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="px-3 py-2 rounded-lg text-[#5B6472] font-medium hover:bg-[#F5F7FF] hover:text-[#2451FF] transition-colors">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="ml-1 px-4 py-2 bg-[#2451FF] text-white text-sm font-semibold rounded-lg hover:bg-[#17348F] transition-colors">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto px-5 mt-4 w-full">
            <div class="px-4 py-3 bg-[#F0FDF4] border border-[#BBF7D0] text-[#166534] rounded-lg text-sm font-medium">
                {{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-6xl mx-auto px-5 mt-4 w-full">
            <div class="px-4 py-3 bg-[#FEF2F2] border border-[#FECACA] text-[#991B1B] rounded-lg text-sm font-medium">
                {{ session('error') }}</div>
        </div>
    @endif

    <main class="flex-1">@yield('content')</main>

    <footer class="bg-white border-t border-[#E4E8F3] py-6 mt-auto">
        <div class="max-w-6xl mx-auto px-5 text-sm text-[#5B6472] flex items-center justify-between flex-wrap gap-2">
            <span class="font-['Space_Grotesk'] font-semibold text-[#0B1220]">E-Tiket Kebun Raya</span>
            <span>&copy; 2026 E-Tiket Kebun Raya (Niph19). All rights reserved.</span>
        </div>
    </footer>
</body>

</html>