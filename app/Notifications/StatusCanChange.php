<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;

class StatusCanChange extends Notification
{
    private $user;
    private $role_id;
    use Queueable;
  
  /**
   * Create a new notification instance.
   *
   * @param $user App\User
   * @param $role_id int
   */
    public function __construct($user, $role_id)
    {
      $this->user = $user;
      $this->role_id = (int)$role_id;
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
      if($this->role_id == 7) {
        return (new MailMessage)
          ->subject(Lang::get('Egyik kérelmének státusza megváltoztatható - '.Voyager::setting('site.title')))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Azért kapja Ön ezt az emailt, mert az Ön által létrehozott egyik kérelme 2 napja nem lett teljesítve.'))
          ->line(Lang::get('A kérelem státuszát meg tudja változtatni.'))
          ->action(Lang::get('Megváltoztatás'), route('admin_my_help_request'));
      }
      else {
        return (new MailMessage)
          ->subject(Lang::get('Egyik elvállalt kérelmének státusza megváltoztatható - '.Voyager::setting('site.title')))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Azért kapja Ön ezt az emailt, mert az Ön által elvállalt egyik kérelme 2 napja nem lett teljesítve.'))
          ->line(Lang::get('A kérelmező mostantól meg tudja változtatni a kérelem státuszát'));
      }
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
