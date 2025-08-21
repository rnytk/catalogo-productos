<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catalogo DRC</title>
   <style>
        @page {
            margin: 0; /* Quita márgenes del PDF */
        }
        body {
            margin: 0;
            padding: 0;
        }
        .page {
            page-break-after: always;
            width: 100%;
            height: 100%;
        }

        .page:last-child {
            page-break-after: auto; /* evita salto en la última */
        }
        img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* 🔹 llena toda la hoja, aunque recorte */
            display: block;
        }
    </style>
</head>
<body>
    @foreach($products as $product)
        <div class="page">
            @if($product->imagen)
                <img src="{{ public_path('storage/' . $product->imagen) }}" alt="Imagen de producto">
            @endif
        </div>
    @endforeach
</body>
</html>
