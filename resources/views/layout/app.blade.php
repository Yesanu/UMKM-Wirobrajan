<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'E-Catalog UMKM')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- nanti CSS / Bootstrap masuk sini --}}
</head>
<body>

    <header>
        <h1>E-Catalog UMKM</h1>
        <hr>
    </header>

   <style>
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Desktop besar */
    gap: 20px;
}

.product-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    background: #fff;
}

/* Tablet */
@media (max-width: 1024px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 640px) {
    .product-grid {
        grid-template-columns: 1fr;
    }
}
</style>

    @if (session('success'))
        <div style="color: green; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red; margin-bottom:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer>
        <hr>
        <small>&copy; {{ date('Y') }} UMKM Wirobrajan</small>
    </footer>

</body>
</html>