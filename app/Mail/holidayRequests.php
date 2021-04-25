<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class holidayRequests extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $path, $date;

    /**
     * holidayRequests constructor.
     * @param $user
     * @param $path
     * @param $date
     */
    public function __construct($user, $path, $date)
    {
        $this->user = $user;
        $this->path = $path;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Holiday Requests - {$this->date}")->view('mail.holidayRequestsMail')->attachFromStorage($this->path);
    }
}
