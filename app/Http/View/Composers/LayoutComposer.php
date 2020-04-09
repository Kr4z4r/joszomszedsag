<?php
  
  namespace App\Http\View\Composers;
  
  use App\Address;
  use App\UserSupportData;
  use App\UserVolunteerData;
  use App\HelpType;
  use Illuminate\Support\Facades\DB;
  use Illuminate\View\View;
  use App\User;
  use Illuminate\Support\Facades\Auth;
  use TCG\Voyager\Models\Role;

  class LayoutComposer {
    protected $current_user;
    protected $short_name;
    
    public function __construct() {
      if(Auth::user()) {
        $current_user = Auth::user();
        $current_user->volunteer_data = UserVolunteerData::where('user_id', $current_user->id)->first();
        $current_user->user_role = Role::find($current_user->role_id)->display_name;
        $current_user->home_address = Address::find($current_user->home_address_id);
        $current_user->volunteer_addresses = DB::select('
          SELECT a.*
          FROM `addresses` a
          LEFT JOIN `user_data_volunteer_addresses` udva ON a.`id` = udva.`address_id`
          RIGHT JOIN `user_data_volunteer` udv ON udva.`user_data_volunteer_id` = udv.`id`
          WHERE udv.`user_id` = '.$current_user->id
        );

        $current_user->open_help_requests_count = UserSupportData::where(
          array(
            array('user_id', '=' , $current_user->id),
            array('status', '<>' , 1)
          )
        )->count();

        $current_user->in_progress_helping_count = UserSupportData::where(
          array(
            array('volunteer_user_id', '=' , $current_user->id),
            array('status', '<>' , 1)
          )
        )->count();

        $this->current_user = $current_user;
      }
    }
    
    public function compose(View $view) {
      $view->with(array(
        'current_user' => $this->current_user,
        'user_roles' => Role::all(),
        'help_types' => HelpType::all(),
      ));
    }
  }
