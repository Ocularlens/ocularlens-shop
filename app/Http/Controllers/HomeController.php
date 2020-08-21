<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function showProducts()
    {
        $products = Product::all();
        return view('home.products')->with([
            'products' => $products
        ]);
    }

    
}
