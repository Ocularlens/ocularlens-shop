<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //

    public function showProducts()
    {
        $products = Product::all();
        if(Session::get('my-cart')){
            $cart = Session::get('my-cart');
            foreach($products as $product){
                if(isset($cart[$product->id])){
                    $product->qty = $cart[$product->id]['qty'];
                }
            }
        }
        return view('home.products')->with([
            'products' => $products
        ]);
    }

    
}
