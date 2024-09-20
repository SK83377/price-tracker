<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PriceUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $updatedPrices;

    public function __construct($updatedPrices)
    {
        $this->updatedPrices = $updatedPrices;
    }

    public function build()
    {
        return $this->subject('Price Updates')
                    ->view('emails.price_update');
    }
}