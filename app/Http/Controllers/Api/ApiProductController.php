<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Storage;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ApiProductController extends Controller
{
    public function getProducts(Request $request){

        $keyword = $request->input('search');

        $products = Product::when($keyword, function($query, $keyword){
                $query->where('name', 'like', '%'.$keyword.'%');
            })
            ->orderByDesc('id')
            ->paginate(5);
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

        if($request->image){
            Storage::disk('public')->delete($product->image);

            $image = $request->image;
            $nameImage = $image->hashName();
            $image->storeAs('public/uploads/product', $nameImage);
            $product->image = 'uploads/product/'. $nameImage;
        }

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->save();

        return response()->json(['success' => 'Update product successfully!']);

    }

    public function delete(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['success' => 'Delete product successfully!']);    
    }

    public function trash(){
        $products = Product::onlyTrashed()->orderByDesc('id')->paginate(5);
        return ProductResource::collection($products);
    }

    public function restore(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if(isset($product)){
            $product->restore();
            return response()->json(['success' => 'Restore product successfully!']);    
        }
    }

    public function remove(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return response()->json(['success' => 'Remove product successfully!']);    
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

}
