<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Umkm $umkm)
{
    $products = $umkm->products()->latest()->paginate(6);
    return view('products.index', compact('umkm', 'products'));
}

public function store(Request $request, Umkm $umkm)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga'       => 'required|numeric',
        'deskripsi'   => 'nullable|string',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

     $data = $request->only([
        'nama_produk',
        'harga',
        'deskripsi'
    ]);

    if ($request->hasFile('foto')) {
        $data['foto'] = $request->file('foto')
                                ->store('products', 'public');
    }

    $umkm->products()->create($data);

    return redirect()->route('umkm.products.index', $umkm->id)
                     ->with('success', 'Produk berhasil ditambahkan');
}

    public function edit(Umkm $umkm, Product $product)
    {
        return view('products.edit', compact('umkm', 'product'));
    }

    public function update(Request $request, Umkm $umkm, Product $product)
{
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga'       => 'required|numeric',
        'deskripsi'   => 'nullable|string',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only([
        'nama_produk',
        'harga',
        'deskripsi',
    ]);

    if ($request->hasFile('foto')) {
        if ($product->foto) {
        Storage::disk('public')->delete($product->foto);
    }

    $data['foto'] = $request->file('foto')
                            ->store('products', 'public');
    }

    $product->update($data);

    return redirect()->route('umkm.products.index', $umkm->id)
                     ->with('success', 'Produk berhasil diperbarui');
}

public function create(Umkm $umkm)
{
    return view('products.create', compact('umkm'));
}

public function destroy(Umkm $umkm, Product $product)
{
    if ($product->foto) {
        Storage::disk('public')->delete($product->foto);
    }

    $product->delete();

    return back()->with('success', 'Produk dihapus');
}

}
