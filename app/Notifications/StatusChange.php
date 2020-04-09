<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use TCG\Voyager\Facades\Voyager;
use App\RequestStatus;

class StatusChange extends Notification
{
  private $new_status;
  private $previous_status;
  private $user;
  private $user_type;
  private $nickname;
  use Queueable;
  
  /**
   * Create a new notification instance.
   *
   * @param $user App\User
   * @param $new_status int
   * @param $previous_status int
   * @param $user_type int
   * @param string $nickname string
   */
  public function __construct($user, $new_status, $previous_status, $user_type, $nickname = '')
  {
    $this->user = $user;
    $this->new_status = $new_status;;
    $this->previous_status = $previous_status;
    $this->user_type = $user_type;
    $this->nickname = $nickname;
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
    if($this->user_type == 'volunteer') {
      if(in_array($this->new_status, array(0, 2))) {
        return (new MailMessage)
          ->subject(Lang::get('Segítségkérés rögzítve - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Ön sikeresen rögzített egy segítségkérést.'))
          ->action(Lang::get('Segítségkéréseim'), route('admin_my_help_request'));
      }
      elseif ($this->new_status == 3) {
        return (new MailMessage)
          ->subject(Lang::get('Segítségkérés elvállalva - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Ön sikeresen elvállalta '.$this->nickname.' segítségkérését'))
          ->action(Lang::get('Vállalt segítségkérések'), route('admin_own_help_request'));
      }
      elseif ($this->new_status == 1) {
        return (new MailMessage)
          ->subject(Lang::get('Segítségkérés teljesítve - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Ön sikeresen teljesítette '.$this->nickname.' segítségkérését'))
          ->action(Lang::get('Vállalt Segítségkérések'), route('admin_own_help_request'));
      }
      else {
        return (new MailMessage)
          ->subject(Lang::get('Státusz változás - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Az Ön által vállalt egyik kérelem státusza megváltozott'))
          ->line(Lang::get('Előző státusz').': '.RequestStatus::find($this->previous_status)->name)
          ->line(Lang::get('Új státusz').': '.RequestStatus::find($this->new_status)->name)
          ->action(Lang::get('Vállalt Segítségkérések'), route('admin_own_help_request'));
      }
    }
    else {
      if(in_array($this->new_status, array(0, 2))) {
        return (new MailMessage)
          ->subject(Lang::get('Segítségkérés rögzítve - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Ön sikeresen rögzített egy segítségkérést.'))
          ->action(Lang::get('Segítségkéréseim'), route('admin_my_help_request'));
      }
      else {
        return (new MailMessage)
          ->subject(Lang::get('Státusz változás - '.$site_title))
          ->greeting(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
          ->line(Lang::get('Az Ön egyik segítségkérésének státusza megváltozott'))
          ->line(Lang::get('Előző státusz').': '.RequestStatus::find($this->previous_status)->name)
          ->line(Lang::get('Új státusz').': '.RequestStatus::find($this->new_status)->name)
          ->action(Lang::get('Megtekintéséhez kattinson ide'), route('admin_my_help_request'));
      }
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
