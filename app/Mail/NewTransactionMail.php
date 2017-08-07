<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewTransactionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this->subject('New Transaction Submited')->view('emails.new_transaction_mail');
    }
}
