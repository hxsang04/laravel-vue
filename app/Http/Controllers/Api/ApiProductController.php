<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ApiProductController extends Controller
{
    public function getProducts(){
        $products = Product::orderByDesc('id')->paginate(5);
        return ProductResource::collection($products);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $request->validated();
        if($request->image){
            $image = $request->image;
            $nameImage = $image->hashName();
            $image->storeAs('public/uploads/product', $nameImage);
            $product['image'] = 'uploads/product/'. $nameImage;
        }
        Product::create($product);
        return response()->json(['success' => 'Add product successfully!']);
    }
}
