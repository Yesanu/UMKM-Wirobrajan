<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipe   = $request->input('tipe');

        $query = Umkm::with('products');

        // Search by UMKM name, owner, description, OR by product name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_umkm', 'like', "%{$search}%")
                  ->orWhere('pemilik', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('products', function ($pq) use ($search) {
                      $pq->where('nama_produk', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by UMKM type
        if ($tipe) {
            $query->where('tipe_umkm', $tipe);
        }

        $umkms = $query->get();

        return view('umkm.index', [
            'umkms'       => $umkms,
            'search'      => $search,
            'tipe'        => $tipe,
            'tipeOptions' => Umkm::TIPE_OPTIONS,
        ]);
    }

    public function edit(Umkm $umkm)
    {
        return view('umkm.edit', [
            'umkm'        => $umkm,
            'tipeOptions'  => Umkm::TIPE_OPTIONS,
        ]);
    }

    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'pemilik'   => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kontak'    => 'nullable|string|max:50',
            'alamat'    => 'nullable|string',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tipe_umkm' => 'nullable|string|in:' . implode(',', Umkm::TIPE_OPTIONS),
        ]);

        if ($request->hasFile('logo')) {
            if ($umkm->logo) {
                Storage::disk('public')->delete($umkm->logo);
            }
            $validated['logo'] = $request->file('logo')
                                         ->store('umkm_logos', 'public');
        }

        $umkm->update($validated);

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
        return view('umkm.create', [
            'tipeOptions' => Umkm::TIPE_OPTIONS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'pemilik'   => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kontak'    => 'nullable|string|max:50',
            'alamat'    => 'nullable|string',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tipe_umkm' => 'nullable|string|in:' . implode(',', Umkm::TIPE_OPTIONS),
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('umkm_logos', 'public');
            $validated['logo'] = $path;
        }

        Umkm::create($validated);

        return redirect()
                ->route('umkm.index')
                ->with('success', 'UMKM berhasil ditambahkan');
    }
}
