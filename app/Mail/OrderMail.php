<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
  use Queueable, SerializesModels;

  public $request;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($request)
  {
    $this->request = $request;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    //return $this->markdown('email.order');
    return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject('Su orden de Vinyl Shop')
                ->markdown('email.order');
  }
}