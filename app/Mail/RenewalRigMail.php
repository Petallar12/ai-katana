<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewalRigMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;

    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
    }

    public function build()
    {
        // Specify the mail configuration to use the 'bricon' mailer
        return $this->mailer('smtp.rig')
                    ->subject('Account Renewal!')
                    ->view('emails.renewal_email_rig')
                    ->with('name', $this->recipientName);
    }
}
