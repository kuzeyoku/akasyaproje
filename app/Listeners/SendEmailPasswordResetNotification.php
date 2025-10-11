<?php

namespace App\Listeners;

use App\Mail\Admin\PasswordResetMail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;

class SendEmailPasswordResetNotification
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
    public function handle(PasswordReset $event): void
    {
        Mail::to($event->user->email)->send(new PasswordResetMail($event->user));
    }
}
