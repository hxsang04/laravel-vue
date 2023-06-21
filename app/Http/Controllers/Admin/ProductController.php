<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Product/List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Product/Form');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return inertia('Admin/Product/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return inertia('Admin/Product/Form');
    }

    public function trash(){
        return inertia('Admin/Product/Trash');
       
    }

}
