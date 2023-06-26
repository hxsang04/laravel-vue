<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiCartController extends Controller
{
    public function cart(){
        dd(session()->all());
    }

    public function addToCart(Request $request){
        $quantity = $request->input('quantity');
        $product_id = $request->input('product_id');
        $cart = session('cart');
        $product = Product::find($product_id);

        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $quantity;
            
        }
        else{
            $cart[$product->id] = [
                'product_id' => $product->id,
                'image' => $product->image,
                'name' => $product->name,
                'quantity' => $quantity,
                'price'=> $product->price,
            ];
        }
        if(session()->put('cart', $cart)){
            $this->totalPrice();
            return response()->json(['success' => 'Add product to cart successfully!']);
        }
    }

    protected function totalPrice(){
        $total_price = 0;
        foreach(session('cart') as $item){
            $total_price += $item['quantity'] * $item['price'];
        }
        session()->put('total_price', $total_price);
    }
}
