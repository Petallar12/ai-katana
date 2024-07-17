<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewalBriconMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recipientName;
 
    /**
     * Create a new message instance.
     *
     * @param string $recipientName Name of the birthday person
     * @return void
     */
    public function __construct($recipientName)
    {
        $this->recipientName = $recipientName;
    }
     

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
{
    return $this->subject('Renewal!')->view('emails.renewal_email_bricon')->with('name', $this->recipientName);
}
}
