<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewalLukeMedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $csvData;
    public $recipientName; // Define the recipientName property

    // Update the constructor to accept the recipientName
    public function __construct($csvData, $recipientName)
    {
        $this->csvData = $csvData;
        $this->recipientName = $recipientName; // Set the recipientName property
    }
    
    public function build()
    {
        // Use the recipientName property in the view
        return $this->mailer('smtp.lukemed')
                    ->subject('Account Renewal!')
                    ->view('emails.email_hazel')
                    ->attachData($this->csvData, 'renewal.csv', [
                        'mime' => 'text/csv',
                    ])
                    ->with('name', $this->recipientName); // Pass recipientName to the view
    }
}
