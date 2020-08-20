<?php

namespace App\Http\Controllers;

use App\Member;
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
            'password' => 'required|min:8'
        ],
        [
            'first-name.required' => 'Field required',
            'first-name.max' => 'Max length is 50',
            'last-name.required' => 'Field required',
            'last-name.max' => 'Max length is 50',
            'email.required' => 'Field required',
            'email.unique' => 'Email already registered',
            'password.required' => 'Field required',
            'password.min' => 'Password length should atleast be 8 characters'
        ]);

        $member = new Member([
            'first_name' => $request['first-name'],
            'last_name' => $request['last-name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
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
}
