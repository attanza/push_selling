<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOutletMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $outlet;
    public $type;

    public function __construct($outlet, $type)
    {
        $this->outlet = $outlet;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 'register') {
            $subject = "New Outlet Registration";
        } elseif ($this->type = 'verify') {
            $subject = "Outlet {$this->outlet->name} has been verified";
        }
        return $this->subject($subject)->view('emails.newOutletRegistration');
    }
}
