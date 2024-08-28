<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $emailMessage;

    public function __construct($subject, $emailMessage)
    {
        $this->subject = $subject;
        $this->emailMessage = $emailMessage;
    }

    public function build()
    {
        return $this->view('emails.contact')
                    ->subject($this->subject)
                    ->with([
                        'emailMessage' => $this->emailMessage,
                    ]);
    }
}
