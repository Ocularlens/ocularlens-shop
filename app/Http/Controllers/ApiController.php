<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Member;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    
    public function getAllProducts()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ]);
    }

    public function getProduct($id)
    {
        if(Product::find($id)){
            $product = Product::find($id);

            return response()->json([
                'product' => $product
            ]);
        }
        else{
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

    }

    public function createProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'max:100',
            'price' => 'required',
            'quantity' => 'required|min:1'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        $product = new Product([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
        ]);

        $product->save();
        return response()->json([
            'product' => $product,
            'message' => 'Product added'
        ], 200);
    }

    public function editProduct($id, Request $request)
    {
        if(Product::find($id)){
            $product = Product::find($id);

            $validator = Validator::make($request->all(), [
                'name' => 'max:50',
                'description' => 'max:100',
                'quantity' => 'min:1'
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'message' => $validator->messages(),
                ], 400);
            }

            
            $product->name = is_null($request->name) ? $product->name : $request->name ;
            $product->description = is_null($request->description) ? $product->description : $request->description;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->quantity = is_null($request->quantity) ? $product->quantity : $request->quantity;

            $product->save();

            return response()->json([
                'product' => $product,
                'message' => 'Product updated'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    }

    public function deleteProduct($id)
    {
        if(Product::find($id)){
            $product = Product::find($id);
            $product->transactions()->detach();
            $product->delete();

            return response()->json([
                'message' => 'Product deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('admin-api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function getAdminCredentials()
    {
        return response()->json([
            'account' => auth('admin-api')->user(),
        ], 200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin-api')->factory()->getTTL() * 60,
            'account' => auth('admin-api')->user(),
        ]);
    }

    public function adminRefresh()
    {
        return $this->respondWithToken(auth('admin-api')->refresh());
    }

    public function adminLogout()
    {
        auth('admin-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function adminRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'username' => 'required|unique:App\Admin,username',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }
        
        $admin = new Admin([
            'first_name' => $request['firstname'],
            'last_name' => $request['lastname'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);

        $admin->save();

        return response()->json([
            'account' => $admin,
            'message' => 'Account created'
        ], 200);
    }



    public function memberLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('member-api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithTokenMember($token);
    }

    public function getMemberCredentials()
    {
        return response()->json([
            'account' => auth('member-api')->user(),
        ], 200);
    }

    protected function respondWithTokenMember($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('member-api')->factory()->getTTL() * 60,
            'account' => auth('member-api')->user(),
        ]);
    }

    public function memberRefresh()
    {
        return $this->respondWithToken(auth('member-api')->refresh());
    }

    public function memberLogout()
    {
        auth('member-api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function memberRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|unique:App\Member,email',
            'password' => 'required|min:8',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages(),
            ], 400);
        }

        $member = new Member([
            'first_name' => $request['firstname'],
            'last_name' => $request['lastname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'address' => $request['address'],
            'verification_token' => str_replace(['.', '/'], '',Hash::make($request['first-name'].$request['last-name'])),
        ]);

        $member->save();

        return response()->json([
            'account' => $member,
            'message' => 'Account created'
        ], 200);
    }

    public function checkout(Request $request)
    {
        $transaction = new Transaction([
            'total' => $request->total,
            'charge' => 'none'
        ]);
        $transaction->save();
        foreach($request->products as $product){
            $item = Product::find( (int) $product['id']);
            $item->quantity -= (int) $product['qty'];
            $item->save();
            $transaction->products()->attach($item->id,['quantity' => (int) $product['qty']]);
        }
        
        $transaction->members()->attach(auth('member-api')->user()->id);

        $stripe = new \Stripe\StripeClient("sk_test_51HIVVDCnBzPClu4p3AT5K7atbirNeVr3G2YEikadOJ4VBS9XrG8FkULnUwXIQIe1zfiCCVAdvO7LPglJDtRXmA5a00hzpM47Ih");
        $token = $stripe->tokens->create([
            'card' => [
              'number' => $request->card['number'],
              'exp_month' => $request->card['exp_month'],
              'exp_year' => $request->card['exp_year'],
              'cvc' => $request->card['cvv'],
            ],
        ]);
        $charge = $stripe->charges->create([
            'amount' => $request->total * 100,
            'currency' => 'PHP',
            'source' => $token,
            'description' => 'Transaction id :'. $transaction->id,
        ]);

        $transaction->charge = $charge->id;
        $transaction->save();

        return response()->json([
            'transaction' => $transaction->id,
            'message' => 'Transaction success',
        ]);
    }

    public function requestRefund(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);
        $transaction->request_refund = true;
        $transaction->save();

        return response()->json([
            'message' => 'Request sent'
        ]);
    }

    public function approveRefund(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);
        $stripe = new \Stripe\StripeClient("sk_test_51HIVVDCnBzPClu4p3AT5K7atbirNeVr3G2YEikadOJ4VBS9XrG8FkULnUwXIQIe1zfiCCVAdvO7LPglJDtRXmA5a00hzpM47Ih");
        $refund = $stripe->refunds->create([
            'charge' => $transaction->charge,
        ]);

        $transaction->refund = $refund->id;
        $transaction->save();

        $transaction->members()->detach();
        $transaction->products()->detach();
        $transaction->delete();

        return response()->json([
            'message' => 'Refund request approved'
        ]);
    }

    public function getTransactions()
    {
        $transactions = Transaction::all();
        return response()->json([
            'transactions' => $transactions,
        ], 200);
    }

    public function memberTransactions()
    {
        $transactions = auth('member-api')->user()->transactions;

        return response()->json([
            'transactions' => $transactions
        ], 200);
    }

    public function getRefunded()
    {
        $transactions = Transaction::onlyTrashed()->get();
        return response()->json([
            'refunded transactions' => $transactions
        ], 200);
    }

    public function deleteMember($id)
    {
        $member = Member::find($id);
        $member->transactions()->detach();
        $member->delete();

        return response()->json([
            'message' => 'Member deleted'
        ], 200);
    }
}
