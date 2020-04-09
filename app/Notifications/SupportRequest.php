<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;

class SupportRequest extends Notification
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
  public function toMail($notifiable) {
    $site_title = Voyager::setting('site.title');
    return (new MailMessage)
      ->subject(Lang::get('Új segítségkérés kérelem a körzetében - '.$site_title))
      ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
      ->line(Lang::get('A körzetében új segítségkérés kérelmet adtak le.'))
      ->action(Lang::get('Kérelem megtekintése'), route('admin_open_help_request'));
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
