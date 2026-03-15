<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipe   = $request->input('tipe');

        $query = Umkm::withCount('products')
                      ->with(['products' => fn($q) => $q->latest()->take(4)]);

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

        $umkms = $query->paginate(10);

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
            ImageUploadService::delete($umkm->logo);
            $validated['logo'] = ImageUploadService::upload($request->file('logo'), 'umkm_logos');
        }

        $umkm->update($validated);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Data UMKM berhasil diperbarui');
    }

    public function destroy(Umkm $umkm)
    {
        ImageUploadService::delete($umkm->logo);
        $umkm->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'UMKM berhasil dihapus');
    }

    public function verify(Umkm $umkm)
    {
        $umkm->update(['status' => 'aktif']);

        return redirect()->route('admin.dashboard')
                         ->with('success', "UMKM \"{$umkm->nama_umkm}\" berhasil diverifikasi.");
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

        $validated['status'] = 'aktif'; // Admin-created UMKM are auto-approved

        if ($request->hasFile('logo')) {
            $validated['logo'] = ImageUploadService::upload($request->file('logo'), 'umkm_logos');
        }

        Umkm::create($validated);

        return redirect()
                ->route('admin.dashboard')
                ->with('success', 'UMKM berhasil ditambahkan');
    }
}
