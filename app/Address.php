<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Address extends Model {
  protected $table='addresses';
  protected $fillable=['post_code', 'city', 'street', 'house_number', 'house_number_2'];

  protected static function boot()
  {
    parent::boot();
    static::updating(function ($model) {
      $old = self::find($model->id);

      logModelChange($old->attributes, $model->attributes, $model->user_id, 'Cím: ');
    });
  }
}