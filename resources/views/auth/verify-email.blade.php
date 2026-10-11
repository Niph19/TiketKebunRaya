<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-display text-3xl text-slate-900">Verifikasi email Anda</h2>
        <p class="mt-2 text-sm text-slate-500">Terima kasih telah mendaftar! Klik tautan yang kami kirim ke email Anda untuk mengaktifkan akun.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
            Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-2.5 font-semibold text-white transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800"
            >
                Kirim ulang email verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-slate-500"
            >
                Keluar dari akun
            </button>
        </form>
    </div>
</x-guest-layout>
