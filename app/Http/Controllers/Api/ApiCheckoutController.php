<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CheckOutRequest;

class ApiCheckoutController extends Controller
{
    public function placeOrder(CheckOutRequest $request){
        
        $data = $request->validated();
        // $data['total_price'] = session('total_price');
        // $data['user_id'] = Auth::id();
        // $order = Order::create($data);

        // $cart = session('cart');
        // foreach($cart as $item){
        //     $order->products()->attach($item['product_id'], [
        //         'quantity' => $item['quantity'],
        //         'unit_price' => $item['price'],
        //     ]);
        // }
        // session()->forget(['cart','total_price']);
        // SendOrderConfirmationEmail::dispatch($order);

        // return redirect()->route('orderHistory');

    }
}
