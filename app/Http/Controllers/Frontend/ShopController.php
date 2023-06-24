<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(){
        return inertia('Frontend/Index/Shop');
    }

    public function productDetail(){
        return inertia('Frontend/Product/Detail');
    }

}
