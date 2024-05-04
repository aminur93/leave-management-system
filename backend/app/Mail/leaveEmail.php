<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class leaveEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $leave;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $leave)
    {
        $this->user = $user;
        $this->leave = $leave;
    }

    public function build(): self
    {
        return $this->subject('Leave Email')->view('mail.LeaveEmail');
    }
}
