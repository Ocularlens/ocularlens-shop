<?php

namespace App\Http\Controllers;

use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    //
    private $total;

    private function getTotal($cart)
    {
        foreach($cart as $item){
            $this->total += $item->price * $item->qty;
        }
    }

    public function show()
    {
        $cart = Session::get('my-cart');
        $this->getTotal($cart);
        return view('home.checkout')->with([
            'total' => $this->total,
        ]);
    }

    public function charge(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required|numeric',
            'expiration-m' => 'required|numeric|digits:2',
            'expiration-y' => 'required|numeric|digits:2',
            'cvv' => 'required|numeric|digits:3',
        ],
        [
            'name.alpha' => 'Only letters and spaces are allowed',
            'number.numeric' => 'Only numbers are allowed',
            'cvv.numberic' => 'Only numbers are allowed',
            'expiration-m.numberic' => 'Only numbers are allowed',
            'expiration-y.numberic' => 'Only numbers are allowed',
        ]);

        $cart = Session::get('my-cart');
        $this->getTotal($cart);
        $transaction = new Transaction([
            'total' => $this->total,
            'charge' => 'none',
        ]);
        $transaction->save();
        foreach($cart as $item){
            $product = Product::find($item->id);
            $product->quantity -= $item->qty;
            $product->save();
            $transaction->products()->attach($product->id,['quantity' => $item->qty]);
        }
        $transaction->members()->attach(Auth::guard('members')->user()->id);

        $stripe = new \Stripe\StripeClient("sk_test_51HIVVDCnBzPClu4p3AT5K7atbirNeVr3G2YEikadOJ4VBS9XrG8FkULnUwXIQIe1zfiCCVAdvO7LPglJDtRXmA5a00hzpM47Ih");
        $token = $stripe->tokens->create([
            'card' => [
              'number' => $request->number,
              'exp_month' => $request['expiration-m'],
              'exp_year' => 2000 + $request['expiration-y'],
              'cvc' => $request['cvv'],
            ],
        ]);
        $charge = $stripe->charges->create([
            'amount' => $this->total * 100,
            'currency' => 'PHP',
            'source' => $token,
            'description' => 'Transaction id :'. $transaction->id,
        ]);

        $transaction->charge = $charge->id;
        $transaction->save();
        Session::forget('my-cart');
        return redirect('/');
    }
}
