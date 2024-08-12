<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Attachment;

class EmailController extends Controller
{

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,bmp,gif,svg,doc,docx,pdf,txt'
        ]);
    
        $mailData = [
            'title' => $request->subject,
            'body' => $request->body,
        ];
    
        $email = new Email();
        $email->subject = $mailData['title'];
        $email->body = $mailData['body'];
        $email->from = "madjiguened835@gmail.com";
        $email->to = $request->to;
        $email->save();
    
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('attachments');
                
                dd($path);
                Attachment::create([
                    'email_id' => $email->id,
                    'file_path' => $path,
                ]);
                $attachments[] = $attachment;
            }
        }
    
        Mail::to($request->to)->send(new SendMail($mailData, $attachments));
    
        return response()->json(['message' => 'Email envoyé avec succès.'], 200);
    }
}