<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetUrl = env('APP_URL') . '/reset-password?token=' . $this->token . '&email=' . urlencode($this->email);

        return $this->subject('إعادة تعيين كلمة المرور')
                    ->view('emails.password-reset-modern')
                    ->with([
                        'resetUrl' => $resetUrl,
                    ]);
    }
}
