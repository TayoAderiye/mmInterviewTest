<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreditAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $userEmail;
    public $creditAmount;
    public $balance;
    public $title;
    public function __construct($title ,$userEmail, $creditAmount)
    {
        //
        $this->userEmail = $userEmail;
        $this->creditAmount = $creditAmount;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('CreditAlertMail');
    }
}
