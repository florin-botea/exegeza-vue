<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
		//set data
    }

    public function build()
    {
        return $this->from('test@exegeza-biblica.ro')
			->subject('Test')
			->view('mails.welcome_mail');
    }
}