<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Browse all active UMKM (with search/filter).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipe   = $request->input('tipe');

        $query = Umkm::where('status', 'aktif')
                      ->withCount(['products' => fn($q) => $q->where('status', 'tersedia')]);

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

        if ($tipe) {
            $query->where('tipe_umkm', $tipe);
        }

        $umkms = $query->latest()->paginate(10);

        return view('public.stores', [
            'umkms'       => $umkms,
            'search'      => $search,
            'tipe'        => $tipe,
            'tipeOptions' => Umkm::TIPE_OPTIONS,
        ]);
    }

    /**
     * UMKM detail page — show store + products.
     */
    public function show(Umkm $umkm)
    {
        if (!$umkm->isAktif()) {
            abort(404);
        }

        $products = $umkm->products()
                         ->where('status', Product::STATUS_TERSEDIA)
                         ->latest()
                         ->paginate(10);

        return view('public.store-detail', compact('umkm', 'products'));
    }

    /**
     * Product detail page.
     */
    public function product(Umkm $umkm, Product $product)
    {
        if (!$umkm->isAktif() || !$product->isTersedia()) {
            abort(404);
        }

        // Build WhatsApp URL
        $phone = preg_replace('/[^0-9]/', '', $umkm->kontak ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $waMessage = urlencode(
            "Halo, saya tertarik dengan produk *{$product->nama_produk}* "
            . "(Rp" . number_format($product->harga) . ") dari {$umkm->nama_umkm}. "
            . "Apakah masih tersedia?"
        );

        $waUrl = "https://wa.me/{$phone}?text={$waMessage}";

        return view('public.product-detail', compact('umkm', 'product', 'waUrl'));
    }
}
