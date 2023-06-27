<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home(){
        return inertia('Frontend/Index/Home');
    }

    public function shop(){
        return inertia('Frontend/Index/Shop');
    }

    public function productDetail(){
        return inertia('Frontend/Product/Detail');
    }

    public function cart(){
        return inertia('Frontend/Index/Cart');
    }

    public function checkout(){
        return inertia('Frontend/Index/Checkout');
    }


}
