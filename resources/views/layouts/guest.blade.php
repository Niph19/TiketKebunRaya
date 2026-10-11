<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tiket Kebun Raya') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'DM Serif Display', serif; }

        /* Botanical leaf decorations via clip-path shapes */
        .leaf {
            position: absolute;
            border-radius: 50% 0 50% 0;
            opacity: 0.12;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen">

    <div class="min-h-screen flex">

        {{-- Left decorative panel --}}
        <aside class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative flex-col justify-between overflow-hidden bg-emerald-900 px-12 py-14 text-white">

            {{-- Botanical background decorations --}}
            <div aria-hidden="true">
                {{-- Large leaf top-right --}}
                <div class="leaf w-72 h-72 bg-lime-300 -top-16 -right-16 rotate-12"></div>
                {{-- Medium leaf bottom-left --}}
                <div class="leaf w-56 h-56 bg-emerald-600 bottom-8 -left-20 -rotate-12"></div>
                {{-- Small accent dot cluster --}}
                <div class="absolute top-1/3 right-8 w-3 h-3 rounded-full bg-lime-400/30"></div>
                <div class="absolute top-1/3 right-14 w-2 h-2 rounded-full bg-lime-400/20"></div>
                <div class="absolute top-1/3 right-5 w-1.5 h-1.5 rounded-full bg-lime-400/20"></div>
                {{-- Ring ornament --}}
                <div class="absolute bottom-40 right-10 w-40 h-40 rounded-full border-[20px] border-emerald-700/50"></div>
                <div class="absolute -top-8 left-1/3 w-24 h-24 rounded-full border-[12px] border-lime-200/10"></div>
            </div>

            {{-- Brand mark --}}
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-lime-300">
                    Tiket Kebun Raya
                </a>
            </div>

            {{-- Hero text --}}
            <div class="relative z-10 space-y-6">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-lime-300">Sistem Tiketing Digital</p>
                <h1 class="font-display text-4xl leading-snug text-white xl:text-5xl">Luangkan waktu untuk&nbsp;tumbuh bersama&nbsp;alam.</h1>
                <p class="max-w-xs text-sm leading-6 text-emerald-200">Pesan tiket masuk, unggah bukti bayar, dan unduh e-ticket Anda — semuanya dalam satu platform.</p>

                {{-- Trust steps --}}
                <div class="mt-8 space-y-3">
                    @foreach ([
                        ['Pilih tiket & tanggal kunjungan', '01'],
                        ['Upload bukti pembayaran', '02'],
                        ['Unduh e-ticket setelah konfirmasi', '03'],
                    ] as [$step, $num])
                    <div class="flex items-center gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-lime-300/20 text-xs font-bold text-lime-300">{{ $num }}</span>
                        <span class="text-sm text-emerald-100">{{ $step }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer note --}}
            <p class="relative z-10 text-xs text-emerald-400">&copy; {{ now()->year }} Kebun Raya &mdash; Tiket Digital</p>
        </aside>

        {{-- Right form panel --}}
        <main class="flex flex-1 flex-col items-center justify-center px-6 py-12 sm:px-10 lg:px-16 bg-white">

            {{-- Mobile logo --}}
            <div class="mb-8 lg:hidden">
                <a href="{{ url('/') }}" class="text-xl font-bold text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700">
                    Tiket Kebun Raya
                </a>
            </div>

            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>
    </div>

</body>
</html>
