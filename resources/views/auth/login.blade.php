<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-display text-3xl text-slate-900">Selamat datang kembali</h2>
        <p class="mt-2 text-sm text-slate-500">Masuk untuk melihat pesanan dan mengunduh e-ticket Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
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
                autocomplete="username"
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Kata sandi')" />
                @if (Route::has('password.request'))
                    <a
                        class="text-xs font-medium text-emerald-700 hover:text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700 rounded"
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif
            </div>
            <x-text-input
                id="password"
                class="mt-1.5 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input
                id="remember_me"
                type="checkbox"
                class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                name="remember"
            >
            <label for="remember_me" class="text-sm text-slate-600">{{ __('Ingat saya') }}</label>
        </div>

        <!-- Submit -->
        <div class="pt-1">
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-emerald-800 px-5 py-2.5 font-semibold text-white transition hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800"
            >
                Masuk
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="mt-6 text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-700 rounded">
                Daftar sekarang
            </a>
        </p>
    @endif
</x-guest-layout>
