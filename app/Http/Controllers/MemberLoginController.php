<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:members')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('home.login', ['url' => '/']); 
    }

    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],
        [
            'email.required' => 'Field required',
            'password.required' => 'Field required'
        ]);

        $remember_me = $request->has('remember') ? true : false;
        if(Auth::guard('members')->attempt(['email' => $request['email'], 'password' => $request['password']], $remember_me)){
            return redirect('/');
        }
        return redirect('/login')->with([
            'error' => 'Account not registered',
        ]);
    }
}
