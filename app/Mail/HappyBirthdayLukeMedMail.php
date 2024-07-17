<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HappyBirthdayLukeMedMail extends Mailable
{
    

    public $recipientName;

    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        return $this->subject('Happy Birthday!')
                    ->view('emails.happy_birthday_lukemed')
                    ->with('name', $this->recipientName);
    }
}
