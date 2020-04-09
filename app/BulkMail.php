<?php

namespace App;

use App\Notifications\BulkEmail;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Role;

class BulkMail extends Model {
  protected $table='bulk_mails';
  
  public function save(array $options = []) {
    $this->user_id = Auth::user()->id;
    $groups = json_decode($this->groups);
    $group_names = array();
    
    foreach ($groups as &$group) {
      $group_names[] = Role::find($group)->display_name;
      $users = User::where('role_id', $group)->get();
      foreach ($users as &$user) {
        $user->notify(new BulkEmail($user, $this));
      }
    }
    saveLog(Auth::user()->id,'Küldött egy köremailt az alábbi csoportoknak: '. implode(', ', $group_names));
    parent::save();
  }
}