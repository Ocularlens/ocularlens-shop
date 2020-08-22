<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.home:members');
    }

    public function addToCart(Product $product)
    {
        $cart = Session::get('my-cart');
        if(isset($cart[$product['id']])){
            $cart[$product['id']]['qty'] += 1;
        }
        else{
            $cart[$product['id']] = $product;
            $cart[$product['id']]['qty'] = 1;
        }

        Session::put('my-cart', $cart);
        return redirect()->back();
    }

    public function view()
    {
        $cart = Session::get('my-cart');
        $total = 0; 
        foreach($cart as $item){
            $total += $item->price * $item->qty;
        }
        return view('home.view-cart')->with([
            'total' => $total,
        ]);
    }

    public function removeProduct(Product $product)
    {
        $cart = Session::get('my-cart');
        
        if(isset($cart[$product['id']])){
            unset($cart[$product['id']]);
        }

        Session::put('my-cart', $cart);
        return redirect()->back();
    }

    public function deductSpecificProduct(Product $product)
    {
        $cart = Session::get('my-cart');
        if(isset($cart[$product['id']])){
            $cart[$product['id']]['qty'] -= 1;
        }

        Session::put('my-cart', $cart);
        return redirect()->back();
    }

    public function clearCart()
    {
        Session::forget('my-cart');
        return redirect()->back();
    }
}
