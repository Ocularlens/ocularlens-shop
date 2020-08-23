<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'first-name' => 'required|max:50',
            'last-name' => 'required|max:50',
            'username' => 'required|unique:App\Admin,username',
            'password' => 'required|min:8'
        ],
        [
            'first-name.required' => 'Field required',
            'first-name.max' => 'Max length is 50',
            'last-name.required' => 'Field required',
            'last-name.max' => 'Max length is 50',
            'username.required' => 'Field required',
            'username.unique' => 'Username already registered',
            'password.required' => 'Field required',
            'password.min' => 'Password length should atleast be 8 characters'
        ]);

        $admin = new Admin([
            'first_name' => $request['first-name'],
            'last_name' => $request['last-name'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);

        $admin->save();

        Auth::guard('admins')->login($admin);

        return redirect('/admin');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'first-name' => 'required|max:50',
            'last-name' => 'required|max:50',
            'username' => 'required|unique:App\Admin,username,'.Auth::guard('admins')->user()->id ,
            'password' => 'required|min:8'
        ],
        [
            'first-name.required' => 'Field required',
            'first-name.max' => 'Max length is 50',
            'last-name.required' => 'Field required',
            'last-name.max' => 'Max length is 50',
            'username.required' => 'Field required',
            'username.unique' => 'Username already registered',
            'password.required' => 'Field required',
            'password.min' => 'Password length should atleast be 8 characters'
        ]);

        $admin = Auth::guard('admins')->user();

        $admin->first_name = $request['first-name'];
        $admin->last_name = $request['last-name'];
        $admin->username = $request['username'];
        $admin->password = Hash::make($request['password']);

        $admin->save();

        return redirect('admin');
    }
}
