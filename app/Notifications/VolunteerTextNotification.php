<?php

namespace App\Notifications;

use App\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;

class VolunteerTextNotification extends Notification
{
  private $user;
  private $fromUser;
  private $text;
  use Queueable;
  
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($fromUser, $user, $text)
  {
    $this->user = $user;
    $this->fromUser = $fromUser;

    $this->text = $text;
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

    $fromWho = $this->fromUser->role_id == 7?'Segítségkérő':'Vigyázó';

    $userAddress = Address::find($this->fromUser->home_address_id);

    $displayAddress = $userAddress->post_code.' '.$userAddress->city.', '.$userAddress->street.' '.$userAddress->house_number;

    return (new MailMessage)
      ->subject(Lang::get('Új üzenet - '.$site_title))
      ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
      ->line(Lang::get($this->fromUser->display_name.' '.$fromWho.' üzenetet küldött Önnek a '.$displayAddress.' címről:'))
      ->line(Lang::get($this->text))
      ->action(Lang::get('Válaszolok'), route('admin_volunteers_list', array('to_user_id' => Auth::user()->id)));
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
