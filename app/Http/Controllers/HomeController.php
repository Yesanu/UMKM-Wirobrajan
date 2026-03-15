<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $umkms = Umkm::where('status', 'aktif')
                     ->withCount(['products' => fn($q) => $q->where('status', 'tersedia')])
                     ->latest()
                     ->take(6)
                     ->get();

        return view('public.home', compact('umkms'));
    }
}
