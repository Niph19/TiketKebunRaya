<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tiket Kebun Raya' }} | Tiket Kebun Raya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'DM Serif Display', serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-emerald-50/50 text-slate-900 antialiased">
    <header class="sticky top-0 z-20 border-b border-emerald-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
            <a href="{{ route('index') }}" class="rounded-lg text-lg font-bold text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-emerald-700">
                Tiket Kebun Raya
            </a>

            <nav class="flex items-center gap-2 text-sm" aria-label="Navigasi utama">
                <a href="{{ route('index') }}" @class([
                    'rounded-lg px-3 py-2 font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700',
                    'bg-emerald-50 text-emerald-900' => request()->routeIs('index'),
                    'text-emerald-800 hover:bg-emerald-50' => ! request()->routeIs('index'),
                ]) @if (request()->routeIs('index')) aria-current="page" @endif>
                    Beranda
                </a>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">Dashboard Admin</a>
                        <a href="{{ route('admin.jenis-tiket.index') }}" class="hidden rounded-lg px-3 py-2 font-semibold text-emerald-800 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700 sm:inline-flex">Jenis Tiket</a>
                    @elseif (Auth::user()->hasVerifiedEmail())
                        <a href="{{ route('dashboard.index') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">Pesanan Saya</a>
                    @else
                        <a href="{{ route('verification.notice') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">Verifikasi Email</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="min-h-11 rounded-lg px-3 py-2 font-semibold text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-slate-700">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800 hover:bg-emerald-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-emerald-800 px-4 py-2 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="mx-auto mt-5 w-full max-w-6xl px-4 sm:px-6" role="status">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="mx-auto mt-5 w-full max-w-6xl px-4 sm:px-6" role="alert">
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-900">{{ session('error') }}</div>
        </div>
    @endif
    @if ($errors->any())
        <div class="mx-auto mt-5 w-full max-w-6xl px-4 sm:px-6" role="alert" tabindex="-1" aria-labelledby="error-title">
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
                <h2 id="error-title" class="font-semibold">Periksa kembali isian berikut:</h2>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-12 border-t border-emerald-100 bg-white py-6">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-2 px-4 text-sm text-slate-600 sm:px-6">
            <span class="font-semibold text-emerald-900">E-Tiket Kebun Raya</span>
            <span>&copy; {{ now()->year }} Sistem Tiketing Kebun Raya</span>
        </div>
    </footer>
</body>

</html>
