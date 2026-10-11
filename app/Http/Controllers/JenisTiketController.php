<?php

namespace App\Http\Controllers;

use App\Models\JenisTiket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JenisTiketController extends Controller
{
    public function index(): View
    {
        $jenisTikets = JenisTiket::latest()->paginate(10);

        return view('admin.jenis-tikets.index', compact('jenisTikets'));
    }

    public function create(): View
    {
        return view('admin.jenis-tikets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        JenisTiket::create($this->validateTicket($request));

        return redirect()->route('admin.jenis-tiket.index')->with('success', 'Jenis tiket berhasil ditambahkan.');
    }

    public function edit(JenisTiket $jenisTiket): View
    {
        return view('admin.jenis-tikets.edit', compact('jenisTiket'));
    }

    public function update(Request $request, JenisTiket $jenisTiket): RedirectResponse
    {
        $jenisTiket->update($this->validateTicket($request));

        return redirect()->route('admin.jenis-tiket.index')->with('success', 'Jenis tiket berhasil diperbarui.');
    }

    private function validateTicket(Request $request): array
    {
        return $request->validate([
            'nama_tiket' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'harga_dewasa' => ['required', 'integer', 'min:1'],
            'harga_anak' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
