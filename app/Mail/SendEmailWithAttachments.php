<?php

namespace App\Mail;

use App\Models\Emailes;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendEmailWithAttachments extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct(Emailes $email)
    {
        $this->email = $email;
    }

    public function build()
    {
        $email = $this->email;

        $mail = $this->subject($email->subject)
                     ->view('emails.template') // Spécifiez la vue Blade pour le contenu de l'email
                     ->with([
                         'body' => $email->body,
                     ])
                     ->to($email->to); // Définir le destinataire

        // Ajouter les pièces jointes
        if (isset($email->attachments)) {
            foreach ($email->attachments as $attachment) {
                $filePath = 'attachments/' . $attachment->path;

                // Vérifiez si le fichier existe en utilisant la façade Storage
                if (Storage::exists($filePath)) {
                    $mail->attach(Storage::path($filePath), [
                        'as' => $attachment->filename,
                    ]);
                } else {
                    \Log::warning("Le fichier joint n'existe pas: $filePath");
                }
            }
        }

        return $mail;
    }
}
