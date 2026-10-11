<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $pesanans = Pesanan::with(['user', 'jenisTiket'])
            ->latest()
            ->paginate(20);

        return view('admin.dashboard', compact('pesanans'));
    }

    public function showProof(Pesanan $pesanan)
    {
        abort_unless($pesanan->bukti_pembayaran !== null, 404);
        abort_unless(Storage::disk('local')->exists($pesanan->bukti_pembayaran), 404);

        return response()->file(Storage::disk('local')->path($pesanan->bukti_pembayaran));
    }

    public function approve(Pesanan $pesanan): RedirectResponse
    {
        if ($pesanan->status !== 'menunggu_konfirmasi' || ! $pesanan->bukti_pembayaran) {
            return back()->with('error', 'Pesanan belum memiliki bukti pembayaran yang menunggu konfirmasi.');
        }

        $pesanan->update([
            'status' => 'lunas',
            'kode_tiket' => $pesanan->kode_tiket ?? (string) Str::uuid(),
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi. E-ticket sekarang tersedia untuk pengunjung.');
    }

    public function reject(Pesanan $pesanan): RedirectResponse
    {
        if ($pesanan->status !== 'menunggu_konfirmasi' || ! $pesanan->bukti_pembayaran) {
            return back()->with('error', 'Pesanan ini tidak sedang menunggu konfirmasi.');
        }

        $pesanan->update(['status' => 'ditolak']);

        return back()->with('success', 'Pembayaran ditolak. Pengunjung dapat mengunggah bukti pembayaran kembali.');
    }
}
