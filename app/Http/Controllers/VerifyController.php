<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyController extends Controller
{
    //

    public function member()
    {
        $data = array('name'=>"Ocularlens");
        Mail::send('mail.verify', $data, function($message) {
            $message->to('aldous.javier0515@gmai.com', Auth::guard('members')->user()->first_name . ' ' . Auth::guard('members')->user()->last_name)
                    ->subject('Member Verification Email');
            $message->from('aldous.javier0515@gmail.com','Ocularlens');
         });
        return view('member.verify');
    }
}
