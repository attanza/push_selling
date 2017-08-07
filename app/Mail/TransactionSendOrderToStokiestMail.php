<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionSendOrderToStokiestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    public $stokiest;
    public $market;
    public $today;


    public function __construct($transaction, $stokiest, $market, $today)
    {
        $this->transaction = $transaction;
        $this->stokiest = $stokiest;
        $this->market = $market;
        $this->today = $today;
    }

    public function build()
    {
        $subject = 'New Order Request #'.$this->transaction->code;
        return $this->subject($subject)->view('emails.transaction_send_order_to_stokiest');
    }
}
