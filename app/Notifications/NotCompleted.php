<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;

class NotCompleted extends Notification
{
  private $user;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
      $this->user = $user;
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
      return (new MailMessage)
        ->subject(Lang::get('Nem teljesített kérelem - '.Voyager::setting('site.title')))
        ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
        ->line(Lang::get('Azért kapja Ön ezt az emailt, mert az Ön által elvállalt egyik kérelme nem lett teljesítve.'))
        ->line(Lang::get('Tekintse át az elvállalt kérelmeit'))
        ->action(Lang::get('Megtekintés'), route('admin_own_help_request'));
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
