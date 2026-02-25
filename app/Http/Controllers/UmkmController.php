<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        // ambil UMKM beserta produk-produknya
        $umkms = Umkm::with('products')->get();

        return view('umkm.index', compact('umkms'));
    }

    public function edit(Umkm $umkm)
    {
        return view('umkm.edit', compact('umkm'));
    }

    public function update(Request $request, Umkm $umkm)
{
    $request->validate([
        'nama_umkm' => 'required|string|max:255',
        'pemilik'   => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'kontak'    => 'nullable|string|max:50',
        'alamat'    => 'nullable|string',
    ]);

    $umkm->update([
        'nama_umkm' => $request->nama_umkm,
        'pemilik'   => $request->pemilik,
        'deskripsi' => $request->deskripsi,
        'kontak'    => $request->kontak,
        'alamat'    => $request->alamat,
    ]);

    return redirect()->route('umkm.index')
                     ->with('success', 'Data UMKM berhasil diperbarui');
}

    public function destroy(Umkm $umkm)
    {
    $umkm->delete();

    return redirect()->route('umkm.index')
                     ->with('success', 'UMKM berhasil dihapus');
    }


    public function create()
    {
        return view('umkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'pemilik'   => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kontak'    => 'nullable|string|max:50',
            'alamat'    => 'nullable|string',
        ]);

        Umkm::create($request->all());

        return redirect()->route('umkm.index')
                        ->with('success', 'UMKM berhasil ditambahkan');
    }
}
