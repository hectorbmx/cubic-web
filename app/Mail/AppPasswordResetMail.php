<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $rid;
    public ?string $link;

    public function __construct(string $code, string $rid, ?string $link = null)
    {
        $this->code = $code;
        $this->rid  = $rid;
        $this->link = $link;
    }

    public function build()
    {
        return $this
            ->subject('Password Reset Code')
            ->view('emails.app-password-reset')
            ->with([
                'code' => $this->code,
                'rid'  => $this->rid,
                'link' => $this->link,
            ]);
    }
}
