<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index(Request $request){
        $perPage = $request->get('per_page', 10);
        $products = Product::with(['brand', 'category'])
        ->where('status', 1)
        ->orderBy('sort')
        ->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => [
                'products' => ProductResource::collection($products),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            ],
        ], 200);
    }

}

