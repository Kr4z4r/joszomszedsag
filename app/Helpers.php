<?php

use App\Log;

if (!function_exists('logModelChange')) {
  function logModelChange($before, $after, $user_id, $modelName)
  {
    $diff = array_diff_assoc((array)$before, (array)$after);

    if (count($diff)) {
      foreach ($diff as $key => $value) {
        if($key == 'password') {
          saveLog($user_id, $modelName.': Jelszót változtatott.');
          continue;
        } else if($key == 'remember_token') {
          continue;
        }
        saveLog($user_id, $modelName.': "' . $key . '" változtatva "' . $before[$key] . '"-ról "' . $after[$key] . '"-re');
      }
    }
  }
}

if (!function_exists('saveLog')) {
  function saveLog($user_id, $text)
  {
    Log::saveLog($user_id, $text);
  }
}