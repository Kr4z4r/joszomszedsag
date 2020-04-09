<?php

namespace App;

use App\Notification;
use App\Notifications\RequestCompleted;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NotCompleted;
use App\Notifications\StatusCanChange;

class UserSupportData extends Model {
  private $one_day  = 86400;
  protected $table='user_data_support';
  public $fillable = [
    'user_id',
    'help_request',
    'has_coronavirus',
    'is_in_quarantine',
    'has_chronic_illness',
    'is_healthy',
    'description',
    'status',
    'volunteer_user_id',
    'address_id'
  ];
  
  protected static function boot()
  {
    parent::boot();
    static::updating(function ($model) {
      $old = self::find($model->id);
      
      logModelChange($old->attributes, $model->attributes, $model->user_id, 'Segítség Kérés');
    });
    
    static::created(function ($model) {
      saveLog($model->user_id, 'Regisztrált egy segítségkérést.');
    });
  }
  
  public static function cronEmails() {
    $current_time = now()->timestamp;
    $yesterday = $current_time - (new self)->one_day;
    $two_days_before = $current_time - (2 * (new self)->one_day);
    $all_help_requests = UserSupportData::whereRaw('(status != ? AND status != ?) AND volunteer_user_id IS NOT NULL', [0, 1])->get();
    foreach($all_help_requests as $help_request) {
      $volunteer = User::find($help_request->volunteer_user_id);
      $requester = User::find($help_request->user_id);
      $request_time = strtotime($help_request->updated_at);
      if($request_time < $yesterday && $request_time > $two_days_before) {
        (new self)->saveNotification($help_request->id, $volunteer, 1, 6);
        continue;
      }
      else {
        (new self)->saveNotification($help_request->id, $volunteer, 2, 6);
        (new self)->saveNotification($help_request->id,$requester, 2, 7);
      }
    }
  }
  private function saveNotification($support_id, $user, $type, $role_id) {
    switch($type) {
      case 2:
        $this->saveSecondNotification($support_id, $user, $role_id);
        break;
      default:
        $this->saveFirstNotification($support_id, $user, $role_id);
        break;
    }
  }
  private function saveFirstNotification($support_id, $user, $role_id) {
    $exists = Notification::getByData($support_id, $user->id, $role_id, 1);
    if(!(int)$exists) {
      $notification = new Notification();
      $notification->user_support_id = $support_id;
      $notification->user_id = $user->id;
      $notification->role_id = $role_id;
      $notification->notification_type = 1;
      $notification->save();
      $user->notify(new NotCompleted($user));
    }
  }
  private function saveSecondNotification($support_id, $user, $role_id) {
    $exists = Notification::getByData($support_id, $user->id, $role_id, 2);
    if(!(int)$exists) {
      $notification = new Notification();
      $notification->user_support_id = $support_id;
      $notification->user_id = $user->id;
      $notification->role_id = $role_id;
      $notification->notification_type = 2;
      $notification->save();
      $user->notify(new StatusCanChange($user, $role_id));
    }
  }
  
  public static function requestCompleted() {
    $current_time = now()->timestamp;
    $yesterday = $current_time - (new self)->one_day;
    $all_help_requests = UserSupportData::whereRaw('status = ? OR status = ?', [4,5])->get();
    foreach ($all_help_requests as $request) {
      $request_time = strtotime($request->updated_at);
      if($request_time < $yesterday) {
        $support_request = UserSupportData::find($request->id);
        $volunteer = User::find($request->volunteer_user_id);
        $requester = User::find($request->user_id);
        $volunteer->notify(new RequestCompleted($volunteer, $request->status, 1));
        $requester->notify(new RequestCompleted($requester, $request->status, 1));
        $support_request->status = 1;
        $support_request->save();
      }
    }
  }
}
