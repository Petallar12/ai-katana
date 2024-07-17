<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HappyBirthdayBriconMail extends Mailable //implements ShouldQueue
{
    // use Queueable, SerializesModels;

    public $recipientName;

    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        // Specify the mail configuration to use the 'bricon' mailer
        return $this->mailer('smtp.bricon')
                    ->subject('Happy Birthday!')
                    ->view('emails.happy_birthday_bricon')
                    ->with('name', $this->recipientName);
    }
}
