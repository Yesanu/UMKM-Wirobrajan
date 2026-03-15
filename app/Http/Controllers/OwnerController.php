<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Owner dashboard — overview of their UMKM.
     */
    public function dashboard()
    {
        $umkm = auth()->user()->umkm;

        return view('owner.dashboard', compact('umkm'));
    }

    /**
     * Edit own UMKM info.
     */
    public function editUmkm()
    {
        $umkm = auth()->user()->umkm;

        if (!$umkm) {
            return redirect()->route('owner.createUmkm');
        }

        return view('owner.umkm-edit', [
            'umkm'        => $umkm,
            'tipeOptions'  => Umkm::TIPE_OPTIONS,
        ]);
    }

    /**
     * Show create UMKM form (for owners without one yet).
     */
    public function createUmkm()
    {
        if (auth()->user()->umkm) {
            return redirect()->route('owner.dashboard');
        }

        return view('owner.umkm-create', [
            'tipeOptions' => Umkm::TIPE_OPTIONS,
        ]);
    }

    /**
     * Store a new UMKM for the current owner.
     */
    public function storeUmkm(Request $request)
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

        $validated['user_id'] = auth()->id();
        $validated['status']  = 'pending';

        if ($request->hasFile('logo')) {
            $validated['logo'] = ImageUploadService::upload($request->file('logo'), 'umkm_logos');
        }

        Umkm::create($validated);

        return redirect()->route('owner.dashboard')
                         ->with('success', 'UMKM berhasil didaftarkan! Menunggu verifikasi admin.');
    }

    /**
     * Update own UMKM info.
     */
    public function updateUmkm(Request $request)
    {
        $umkm = auth()->user()->umkm;

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

        return redirect()->route('owner.dashboard')
                         ->with('success', 'Data UMKM berhasil diperbarui.');
    }

    /**
     * Toggle store status (aktif/nonaktif).
     */
    public function toggleStoreStatus()
    {
        $umkm = auth()->user()->umkm;

        if ($umkm->status === 'pending') {
            return back()->with('error', 'Toko masih menunggu verifikasi admin.');
        }

        $umkm->status = $umkm->status === 'aktif' ? 'nonaktif' : 'aktif';
        $umkm->save();

        return back()->with('success', 'Status toko diubah menjadi ' . $umkm->status . '.');
    }

    // ── Product Management ──

    public function products()
    {
        $umkm = auth()->user()->umkm;

        if (!$umkm) {
            return redirect()->route('owner.createUmkm');
        }

        $products = $umkm->products()->latest()->paginate(10);

        return view('owner.products', compact('umkm', 'products'));
    }

    public function createProduct()
    {
        $umkm = auth()->user()->umkm;
        return view('owner.product-form', ['umkm' => $umkm, 'product' => null]);
    }

    public function storeProduct(Request $request)
    {
        $umkm = auth()->user()->umkm;

        // Strip thousand separators from harga (e.g. "15.000" → "15000")
        $request->merge(['harga' => str_replace(['.', ','], '', $request->input('harga', ''))]);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = ImageUploadService::upload($request->file('foto'), 'products');
        }

        $umkm->products()->create($validated);

        return redirect()->route('owner.products')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct(Product $product)
    {
        $this->authorizeProduct($product);
        $umkm = auth()->user()->umkm;
        return view('owner.product-form', compact('umkm', 'product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        // Strip thousand separators from harga
        $request->merge(['harga' => str_replace(['.', ','], '', $request->input('harga', ''))]);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            ImageUploadService::delete($product->foto);
            $validated['foto'] = ImageUploadService::upload($request->file('foto'), 'products');
        }

        $product->update($validated);

        return redirect()->route('owner.products')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct(Product $product)
    {
        $this->authorizeProduct($product);

        ImageUploadService::delete($product->foto);

        $product->delete();

        return redirect()->route('owner.products')
                         ->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleProductStatus(Product $product)
    {
        $this->authorizeProduct($product);

        $product->status = match ($product->status) {
            'tersedia' => 'habis',
            'habis'    => 'tersedia',
            default    => 'tersedia',
        };
        $product->save();

        return back()->with('success', "Status produk diubah menjadi {$product->status}.");
    }

    /**
     * Ensure product belongs to the authenticated owner.
     */
    private function authorizeProduct(Product $product): void
    {
        $umkm = auth()->user()->umkm;

        if (!$umkm || $product->umkm_id !== $umkm->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
    }
}
