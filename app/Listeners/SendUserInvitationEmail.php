<?php

namespace App\Listeners;

use App\Events\UserInvited;
use App\Mail\UserInvitationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserInvitationEmail
{
    public function __construct()
    {
        //
    }

    public function handle(UserInvited $event): void
    {
        try {
            Mail::to($event->user->email)
                ->send(new UserInvitationMail($event->user, $event->role));

            Log::info('Correo de invitación enviado', [
                'email' => $event->user->email,
                'role'  => $event->role,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al enviar correo de invitación', [
                'email' => $event->user->email,
                'error' => $e->getMessage(),
            ]);
        }
    }
}