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

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();

        // if($request->image){
        //     $image = $request->image;
        //     $nameImage = $image->hashName();
        //     $image->storeAs('public/uploads/product', $nameImage);
        //     $data['image'] = 'uploads/product/'. $nameImage;

        //     Storage::disk('public')->delete($product->image);
        // }

        // $product->update($data);
        return response()->json(['success' => 'Update product successfully!']);

    }
}
