<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use App\Mail\VerifyEmail as Mailable;

class VerifyEmail extends VerifyEmailBase
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // if (static::$toMailCallback) {
        //     return call_user_func(static::$toMailCallback, $notifiable);
        // }
        // return (new MailMessage)

        $subject = sprintf("[%s] %s", config('app.name'), "Confirmação do Endereço de Email");
        return (new Mailable($this->verificationUrl($notifiable), $notifiable))->subject($subject)->to($notifiable->email);

            // ->subject(Lang::getFromJson('Confirmação do Endereço de Email'))
            // ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
            // ->action(
            //     Lang::getFromJson('Verify Email Address'),
            //     $this->verificationUrl($notifiable)
            // )
            // ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));
    }
        
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}