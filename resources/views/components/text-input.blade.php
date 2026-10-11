@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-700 focus:ring-emerald-700 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500'
    ]) }}
>
