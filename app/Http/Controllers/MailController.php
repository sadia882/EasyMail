<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
use Mail;
use App\Mail\BoiteReceptionMail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title'=> 'Mail from Easymail',
            'body'=> 'This is for testing email using SMTP',
        ];

        Mail::to("madjiguened835@gmail.com")->send(new BoiteReceptionMail($mailData));
        dd('Email sent successfully.');
    }

}
