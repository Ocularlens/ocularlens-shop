<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminHomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showMembers()
    {
        $members = Member::all();

        return view('admin.members.index')->with([
            'members' => $members
        ]);
    }

    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect('/admin/login');
    }
}
