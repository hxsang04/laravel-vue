<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApiCartController extends Controller
{
    public function cart(){
        $sessionData = session()->all();
        return response()->json($sessionData);
    }

    public function addToCart(Request $request){
        $quantity = $request->input('quantity');
        $product_id = $request->input('product_id');
        $cart = session('cart');
        $product = Product::find($product_id);

        if(isset($cart[$product->id])){
            $new_quantity = $cart[$product->id]['quantity'] += $quantity;
            $cart[$product->id]['total'] = number_format($product->price * $new_quantity);
            
        }
        else{
            $cart[$product->id] = [
                'product_id' => $product->id,
                'image' => '/storage/' . $product->image,
                'name' => $product->name,
                'quantity' => $quantity,
                'unit_price'=> number_format($product->price),
                'total'=> number_format($product->price * $quantity),
            ];
        }
        session()->put('cart', $cart);
        $this->totalPrice();
        
        return response()->json(['success' => 'Add product to cart successfully!']);
    }
    
    public function delete($id){
        session()->pull('cart.'.$id);
        $this->totalPrice();
        return response()->json(['success' => 'Delete cart item successfully!']);
    }

    protected function totalPrice(){
        $total_price = 0;
        foreach(session('cart') as $item){
            $total_price += $item['quantity'] * filter_var($item['unit_price'], FILTER_SANITIZE_NUMBER_INT);
        }
        session()->put('total_price', number_format($total_price));
    }
}
