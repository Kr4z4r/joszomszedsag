<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVolunteerData extends Model {
  protected $table = 'user_data_volunteer';
  protected $fillable = [
    'has_car',
    'availability',
    'helping_groups',
    'user_id',
    'status'
  ];

  protected static function boot()
  {
    parent::boot();
    static::updating(function ($model) {
      $old = self::find($model->id);

      logModelChange($old->attributes, $model->attributes, $model->user_id, 'Vigyázó:');
    });

    static::created(function ($model) {
      saveLog($model->user_id, 'Regisztrált Vigyázóként.');
    });
  }
}