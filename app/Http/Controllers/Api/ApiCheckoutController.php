<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CheckOutRequest;
use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Order;

class ApiCheckoutController extends Controller
{
    public function placeOrder(CheckOutRequest $request){
        $data = $request->validated();
        $data['total_price'] = convertToNumber(session('total_price'));
        $data['user_id'] = \Auth::id();
        $order = Order::create($data);

        $cart = session('cart');
        foreach($cart as $item){
            $order->products()->attach($item['product_id'], [
                'quantity' => $item['quantity'],
                'unit_price' => convertToNumber($item['unit_price']),
            ]);
        }
        session()->forget(['cart','total_price']);
        SendOrderConfirmationEmail::dispatch($order);

        return response()->json(['success' => 'Send mail successfully!']);

    }
}
