<?php

namespace App;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $link;
    public $url;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $token, $email)
    {
        $this->link = urldecode($url).'/'.$token;
        $this->url = $url;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Reset')->view('mail');
    }
}