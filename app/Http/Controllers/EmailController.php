<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'file|max:10240'
        ]);

        $to = $request->input('to');
        $subject = $request->input('subject');
        $message = $request->input('message');
        $attachments = $request->file('attachments');

        Mail::send([], [], function ($mail) use ($to, $subject, $message, $attachments) {
            $mail->to($to)
                ->subject($subject)
                ->setBody($message, 'text/html');

            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $mail->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Email sent successfully!'], 200);
    }
}
