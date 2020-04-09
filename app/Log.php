<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{
    public $timestamps = false;

    public static function saveLog($user_id, $text) {
      $log = new self();
      $log->user_id = $user_id;
      $log->text = $text;
      $log->save();
    }
}
