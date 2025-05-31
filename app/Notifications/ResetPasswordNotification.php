<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    protected $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($this->email);

        return (new MailMessage)
            ->subject('إعادة تعيين كلمة المرور')
            ->line('أنت تتلقى هذا البريد الإلكتروني لأننا تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك.')
            ->action('إعادة تعيين كلمة المرور', $url)
            ->line('ستنتهي صلاحية رابط إعادة تعيين كلمة المرور هذا في غضون 60 دقيقة.')
            ->line('إذا لم تطلب إعادة تعيين كلمة المرور، فلا يلزم اتخاذ أي إجراء آخر.');
    }
}
