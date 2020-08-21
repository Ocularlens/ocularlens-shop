<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:admins')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view('admin.login', ['url' => 'admin']); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],
        [
            'username.required' => 'Field required',
            'password.required' => 'Field required'
        ]);

        $remember_me = $request->has('remember') ? true : false;
        if(Auth::guard('admins')->attempt(['username' => $request['username'], 'password' => $request['password']], $remember_me)){
            return redirect('/admin');
        }
        return redirect('/admin/login')->with([
            'error' => 'Account not registered',
        ]);
    }
}
