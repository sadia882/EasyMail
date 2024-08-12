<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Email;
use App\Models\EmailAttachment;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $attachments;

    public function __construct(Email $email, $attachments)
    {
        $this->email = $email;
        $this->attachments = $attachments;
    }

    public function build()
    {
        $email = $this->view('mail.sendmail')
            ->subject($this->email->subject)
            ->with('body', $this->email->body);

        foreach ($this->attachments as $attachment) {
            $email->attach(storage_path('app/' . $attachment->filepath), [
                'as' => $attachment->filename,
            ]);
        }

        return $email;
    }
}
