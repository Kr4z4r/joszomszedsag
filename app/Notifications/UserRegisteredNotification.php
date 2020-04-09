<?php
  
  namespace App\Notifications;
  
  use Illuminate\Bus\Queueable;
  use Illuminate\Contracts\Auth\MustVerifyEmail;
  use Illuminate\Contracts\Queue\ShouldQueue;
  use Illuminate\Notifications\Messages\MailMessage;
  use Illuminate\Notifications\Notification;
  use App\User;
  use Illuminate\Support\Carbon;
  use Illuminate\Support\Facades\Config;
  use Illuminate\Support\Facades\Lang;
  use Illuminate\Support\Facades\URL;
  use TCG\Voyager\Facades\Voyager;
  
  class UserRegisteredNotification extends Notification
  {
    private $user;
    use Queueable;
    
    public function __construct($user) {
      $this->user = $user;
    }
  
    public function via($notifiable) {
      return ['mail'];
    }
  
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
      $verification_url = $this->verificationUrl($notifiable);
      $site_title = Voyager::setting('site.title');
      return (new MailMessage)
        ->subject(Lang::get('Regisztráció - '.$site_title))
        ->line(Lang::get('Tisztelt '.$this->user->first_name.' '.$this->user->last_name).'!')
        ->line(Lang::get('Köszönjük regisztrációját'))
        ->line(Lang::get('Bejelentkezéshez használja a következő adatokat:'))
        ->line(Lang::get('E-mail cím: '.$this->user->email))
        ->line(Lang::get('Mielőtt belépne meg kell erősítenie a felhasználóját.'))
        ->line(Lang::get('A legelső belépésénél megadott jelszót menti el Önnek a rendszer.'))
        ->line(Lang::get('A továbbiakban ezzel a jelszóval tud belépni.'))
        ->action(Lang::get('A felhasználója megerősítéséhez kattintson ide: '), $verification_url)
        ->line(Lang::get('Ha nem Ön küldte a kérelmet, akkor törölje az emailt!'));
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
  
    private function verificationUrl($notifiable) {
      return URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        [
          'id' => $notifiable->getKey(),
          'hash' => sha1($notifiable->getEmailForVerification()),
        ]
      );
    }
  }
