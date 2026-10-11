<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-display text-3xl text-slate-900">Lupa kata sandi?</h2>
        <p class="mt-2 text-sm text-slate-500">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat email')" />
            <x-text-input
                id="email"
                class="mt-1.5 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-1">
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-2.5 font-semibold text-white transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800"
            >
                Kirim tautan reset kata sandi
            </button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Ingat kata sandi Anda?
        <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700 rounded">
            Kembali masuk
        </a>
    </p>
</x-guest-layout>
