<?php

namespace App\Notifications;

use App\User;
use App\BulkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use TCG\Voyager\Facades\Voyager;

class BulkEmail extends Notification
{
  private $user;
  private $mail_data;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $mail_data)
    {
        $this->user = $user;
        $this->mail_data = $mail_data;
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
        ->subject($this->mail_data->subject.' - '.Voyager::setting('site.title'))
        ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
        ->line(new HtmlString($this->mail_data->mail))
        ->line('')
        ->line('');
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
