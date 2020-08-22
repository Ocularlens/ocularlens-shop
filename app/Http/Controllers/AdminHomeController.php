<?php

namespace App\Http\Controllers;

use App\Member;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminHomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admins');
    }

    public function deleteMember($id)
    {
        $member = Member::find($id);
        $member->transactions()->detach();
        $member->delete();
        return redirect()->back();
    }

    public function approveRefund(Transaction $transaction)
    {
        $stripe = new \Stripe\StripeClient("sk_test_51HIVVDCnBzPClu4p3AT5K7atbirNeVr3G2YEikadOJ4VBS9XrG8FkULnUwXIQIe1zfiCCVAdvO7LPglJDtRXmA5a00hzpM47Ih");
        $refund = $stripe->refunds->create([
            'charge' => $transaction->charge,
        ]);

        $transaction->refund = $refund->id;
        $transaction->save();

        $transaction->members()->detach();
        $transaction->products()->detach();
        $transaction->delete();

        return redirect()->back();
    }

    public function showTransactions()
    {
        $transactions = Transaction::all();
        return view('admin.transactions.index')->with([
            'transactions' => $transactions
        ]);
    }

    public function showRefunded()
    {
        $transactions = Transaction::onlyTrashed()->get();
        return view('admin.transactions.refunded')->with([
            'transactions' => $transactions
        ]);
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
