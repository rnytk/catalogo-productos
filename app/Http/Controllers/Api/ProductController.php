<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   public function index()
    {
        $products = Product::with(['brand', 'category'])->get();
        return response()->json([
            'status' => true,
                'data' => $products->map(function ($product) {
                return [
                   'id' => $product->id,
                   'sort'=> $product->sort,
                    'name' => $product->name,
                    'description' => $product->description,
                    'brand' => $product->brand->name ?? null,
                    'category' => $product->category->name ?? null,
                    'image_url' => $product->imagen
                        ?  $product->imagen
                        : null,
                    ];
             })->toArray()
        ], 200);
    }

}

