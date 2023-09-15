<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Ichtrojan\Otp\Otp;
class EmailverificationNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $formEmail;
    public $mailer;
    private $otp;

    public $header;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->message='use the below code for verifiction';
       $this->subject='verifiction needed';
       $this->formEmail='test@mohannad.com';
       $this->mailer='smtp';
    //    $this->header='the header';
       $this->otp= new Otp ;

    }

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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $otp= $this->otp->generate($notifiable->email,4,60);
        return (new MailMessage)
                    ->mailer('smtp')
                    ->from($this->formEmail)
                    ->subject($this->subject)
                    ->greeting('hello'.$notifiable->first)
                    ->line($this->message)
                    ->line('code: '.$otp->token);

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
