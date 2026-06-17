<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $mailData;
    public function __construct($mailData)
    {
        //
        $this->mailData= $mailData;
    }
    public function build(){
        $subject = $this->mailData['title'];
        $body = "Your OTP is " . $this->mailData['body'];
        return $this->subject($subject)
        ->html("Your OTP is: <b>$body</b>");
    }

}
