<?php

namespace App\Http\Controllers;

use App\Member;
use App\Transaction;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'first-name' => 'required|max:50',
            'last-name' => 'required|max:50',
            'email' => 'required|unique:App\Member,email',
            'password' => 'required|min:8',
            'address' => 'required'
        ],
        [
            'first-name.required' => 'Field required',
            'first-name.max' => 'Max length is 50',
            'last-name.required' => 'Field required',
            'last-name.max' => 'Max length is 50',
            'email.required' => 'Field required',
            'email.unique' => 'Email already registered',
            'password.required' => 'Field required',
            'address.required' => 'Field required',
            'password.min' => 'Password length should atleast be 8 characters'
        ]);
        
        $member = new Member([
            'first_name' => $request['first-name'],
            'last_name' => $request['last-name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'address' => $request['address'],
            'verification_token' => str_replace(['.', '/'], '',Hash::make($request['first-name'].$request['last-name'])),
        ]);
        
        $member->save();

        Auth::guard('members')->login($member);

        return redirect('/');
    }

    public function verify($verify_token)
    {
        if(Auth::guard('members')->check()){
            if($verify_token === Auth::guard('members')->user()->verification_token){
                $member = Auth::guard('members')->user();
                $member->email_verified_at = date('Y-m-d H:i:s');
                $member->save();
                return redirect('/')->with([
                    'message' => 'Account verified'
                ]);
            }
            abort(404);
        }
        return redirect('/')->with([
            'message' => 'Member not authenticated',
        ]);
    }

    public function viewTransactions()
    {
        $transactions = Auth::guard('members')->user()->transactions;
        
        return view('home.transaction')->with([
            'transactions' => $transactions
        ]);
    }

    public function requestRefund($id)
    {
        $transaction = Transaction::find($id);
        $transaction->request_refund = true;
        $transaction->save();

        return redirect()->back();
    }

    public function view()
    {
        $member = Auth::guard('members')->user();

        return view('home.edit')->with([
            'member' => $member
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'first-name' => 'required|max:50',
            'last-name' => 'required|max:50',
            'email' => 'required|unique:members,email,'. Auth::guard('members')->user()->id,
            'password' => 'required|min:8',
            'address' => 'required'
        ],
        [
            'first-name.required' => 'Field required',
            'first-name.max' => 'Max length is 50',
            'last-name.required' => 'Field required',
            'last-name.max' => 'Max length is 50',
            'email.required' => 'Field required',
            'email.unique' => 'Email already registered',
            'password.required' => 'Field required',
            'address.required' => 'Field required',
            'password.min' => 'Password length should atleast be 8 characters'
        ]);

        $member = Auth::guard('members')->user();

        $member->first_name = $request['first-name'];
        $member->last_name = $request['last-name'];
        $member->address = $request['address'];
        $member->email = $request['email'];
        $member->password = Hash::make($request['password']);

        $member->save();

        return redirect('/');
    }
}
