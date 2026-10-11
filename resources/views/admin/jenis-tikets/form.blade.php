<div>
    <label for="nama_tiket" class="block text-sm font-semibold text-slate-800">Nama tiket</label>
    <input id="nama_tiket" name="nama_tiket" type="text" value="{{ old('nama_tiket', $jenisTiket->nama_tiket ?? '') }}" required maxlength="100" class="mt-2 min-h-11 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
    @error('nama_tiket') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
</div>
<div>
    <label for="lokasi" class="block text-sm font-semibold text-slate-800">Lokasi</label>
    <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $jenisTiket->lokasi ?? '') }}" required maxlength="150" class="mt-2 min-h-11 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
    @error('lokasi') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
</div>
<div>
    <label for="deskripsi" class="block text-sm font-semibold text-slate-800">Deskripsi (opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="2000" class="mt-2 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">{{ old('deskripsi', $jenisTiket->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
</div>
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="harga_dewasa" class="block text-sm font-semibold text-slate-800">Harga dewasa (Rp)</label>
        <input id="harga_dewasa" name="harga_dewasa" type="number" min="1" value="{{ old('harga_dewasa', $jenisTiket->harga_dewasa ?? '') }}" required class="mt-2 min-h-11 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
        @error('harga_dewasa') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="harga_anak" class="block text-sm font-semibold text-slate-800">Harga anak (Rp)</label>
        <input id="harga_anak" name="harga_anak" type="number" min="1" value="{{ old('harga_anak', $jenisTiket->harga_anak ?? '') }}" required class="mt-2 min-h-11 w-full rounded-xl border-slate-300 focus:border-emerald-700 focus:ring-emerald-700">
        @error('harga_anak') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
    </div>
</div>
<label class="flex min-h-11 items-center gap-3 text-sm font-semibold text-slate-800">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $jenisTiket->is_active ?? true)) class="h-5 w-5 rounded border-slate-300 text-emerald-800 focus:ring-emerald-700">
    Tampilkan dan izinkan pemesanan tiket ini
</label>
<button type="submit" class="inline-flex min-h-12 items-center justify-center rounded-xl bg-emerald-800 px-5 py-3 font-semibold text-white hover:bg-emerald-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-800">{{ $buttonText }}</button>
