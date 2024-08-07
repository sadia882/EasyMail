<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use Mail;
use App\Mail\BoiteReceptionMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'to' => 'required|email',
        ]);

        $mailData = [
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
        ];

        Mail::to($validatedData['to'])->send(new BoiteReceptionMail($mailData));

        $email = new Email();
        $email->subject = $mailData['title'];
        $email->body = $mailData['body'];
        $email->from = "madjiguened835@gmail.com";
        $email->to = $validatedData['to'];
        $email->save();

        return response()->json(['message' => 'Email envoyé avec succès.'], 200);
    }

    public function getEmails()
    {
        $emails = Email::all();
        return response()->json($emails);
    }

    public function deleteEmail($id)
    {
        $email = Email::find($id);

        if ($email) {
            $email->delete();
            return response()->json(['message' => 'Email supprimé avec succès'], 200);
        } else {
            return response()->json(['message' => 'Email non trouvé'], 404);
        }
    }
}
