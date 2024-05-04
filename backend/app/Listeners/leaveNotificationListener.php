<?php

namespace App\Listeners;

use App\Events\leaveNotificationEvent;
use App\Mail\leaveEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class leaveNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(leaveNotificationEvent $event): void
    {
        $user = $event->user;
        $leave = $event->leave;

        Mail::to($user->email)->send(new leaveEmail($user, $leave));
    }
}
