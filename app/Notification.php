<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
  protected $table='notifications';
  
  public static function getByData($support_id, $user_id, $role_id, $type) {
   return DB::table((new self)->table)->where(array(
     'user_support_id' => $support_id,
     'user_id' => $user_id,
     'role_id' => $role_id,
     'notification_type' => $type
   ))->count();
  }
}
