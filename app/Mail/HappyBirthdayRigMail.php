<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HappyBirthdayRigMail extends Mailable 
{
 

    public $recipientName;

    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        // Specify the mail configuration to use the 'bricon' mailer
        return $this->mailer('smtp.rig')
                    ->subject('Happy Birthday!')
                    ->view('emails.happy_birthday_rig')
                    ->with('name', $this->recipientName);
    }
}
