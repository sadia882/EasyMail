<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class MailingController extends Controller
{
    public function getContacts()
    {
        return Contact::all();
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $details = [
            'subject' => $request->subject,
            'body' => $request->message,
        ];

        Mail::to($request->email)->send(new ContactMail($details));

        return response()->json(['message' => 'Email sent successfully']);
    }
}
