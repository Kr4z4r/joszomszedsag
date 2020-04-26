<?php
namespace App\Http\Controllers;

use App\Address;
use App\HelpType;
use App\Notifications\SupportRequest;
use App\Notifications\UserRegisteredNotification;
use App\User;
use App\UserSupportData;
use App\UserVolunteerData;
use Illuminate\Http\Request;
use App\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontIndexController extends Controller {
  
  public function volunteer_form() {
    if(Auth::check()) return redirect(route('login'));
    return view('forms.volunteer');
  }

  public function helprequest_form() {
    if(Auth::check()) return redirect(route('login'));
    return view('forms.helprequest');
  }

  public function post_code_ajax() {
    $fieldValue = request('post_code');

    $select = DB::select('
      SELECT c.*
      FROM `cities` c
      JOIN `available_post_codes` apc ON c.`post_code` = apc.`post_code`
      WHERE c.`post_code` LIKE "'.$fieldValue.'%";'
    );

    return json_encode($select);
  }

  public function register(Request $request) {
    if($request->user_role == 6) {
      //VOLUNTEER
        // TODO use Form requests instead
      $this->validate($request,[
        'first_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'last_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'display_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'birth_year' => 'required|digits:4',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string',
        'postcode' => 'required|digits:4|exists:available_post_codes,post_code',
        'city' => 'required|alpha|exists:cities,name',
        'street' => 'required|regex:/^[\pL\pM\pN\s]+$/u',
        'house_number' => 'required|string',
        'facebook_profile' => 'nullable|url',
        'has_car' => 'sometimes|accepted',
        'availability' => 'required|string|max:50',
        'area_postcode' => 'required|array|min:1',
        'area_city' => 'required|array|min:1',
        'area_street' => 'required|array|min:1',
        'area_from-house-number' => 'array',
        'area_to-house-number' => 'array',
        'help_types' => 'required|array|min:1',
        'privacy_policy' => 'accepted',
        'health_checkbox' => 'accepted'
      ]);
      $user = $this->saveUserBasic($request);
      $volunteer_data = $this->saveVolunteerData($request, $user->id);
      $volunteer_address = $this->saveVolunteerAddress($request, $volunteer_data->id);

      // Save new user id in session
      session()->put('registration.user_id', $user->id);
  
      if ($user && $volunteer_data && $volunteer_address) {
        $this->sendRegistrationEmail($user);

        if( config('services.nexmo.key') ){
            // Redirect to phone verification route
            // TODO this should be an option in admin,
            return redirect(
                route('phoneverify.form', ['phone'=>$request->get('phone')])
            );
        }

        return redirect(route('login'));
      }
      else return redirect(route('onkentes-regisztracio'));
      
    } else if($request->user_role == 7) {
      //SUPPORT
      $this->validate($request,[
        'first_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'last_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'display_name' => 'required|regex:/^[\pL\pM\pN\s\.\-]+$/u',
        'birth_year' => 'required|digits:4',
        'email' => 'required|email|unique:users',
        'phone' => 'required|string',
        'postcode' => 'required|digits:4|exists:available_post_codes,post_code',
        'city' => 'required|alpha|exists:cities,name',
        'street' => 'required|regex:/^[\pL\pM\pN\s]+$/u',
        'house_number' => 'required|string',
        'facebook_profile' => 'nullable|url',
        'has_corona' => 'sometimes|accepted',
        'in_quarantine' => 'sometimes|accepted',
        'has_chronic' => 'sometimes|accepted',
        'is_healthy' => 'required_without_all:has_corona,in_quarantine,has_chronic',
        'help_types' => 'required|numeric|min:1',
        'privacy_policy' => 'accepted',
        'situation_desc' => 'nullable|string|max:255'
      ]);
  
      $user = $this->saveUserBasic($request);
      $support_data = $this->saveSupportData($request, $user->id, $user->home_address_id);
      if ($user != false && $support_data != false) {
        $this->sendRegistrationEmail($user);
        $volunteer_ids = $this->getVolunteers(Address::find($user->home_address_id));
        foreach ($volunteer_ids as &$volunteer_id) {
          $volunteer = User::find($volunteer_id);
          if($volunteer) {
            $this->sendNewRequestEmail($volunteer);
          }
        }
        return redirect(route('login'), 301);
      }
      else return redirect(route('segitseg-keres'), 301);
      
    } else {
      return redirect(route('home'));
    }
  }
  
  public function saveUserBasic(Request $request)
  {
    $user = new User();
    $user->email = $request->email;
    $user->role_id = $request->user_role;
    $user->first_name = $request->first_name;
    $user->date_birth = $request->birth_year;
    $user->last_name = $request->last_name;
    $user->display_name = $request->display_name;
    $user->facebook_profile = $request->facebook_profile ?? '';
    $user->phone_number = $request->phone;
    $user->home_address_id = $this->saveHomeAddress($request)->id;;
    
    if($user->save()) {
      return $user;
    } else {
      return false;
    }
  }
  
  public function saveHomeAddress(Request $request)
  {
    return Address::firstOrCreate([
      'post_code' => $request->postcode,
      'city' => $request->city,
      'street' => $request->street,
      'house_number' => isset($request->house_number)?trim($request->house_number, ' ,.-*_:/'):null,
      'house_number_2' => null
    ]);
  }
  
  public function saveVolunteerAddress(Request $request, $volunteer_data_id)
  {
    $res = true;
    $address_ids = array();
    $addCounter = 0;
    for($i = 0; $i < count($request->area_street); $i++) {
      if($request->area_street[$i]) {
        $address = Address::firstOrCreate([
          'post_code' => $request->area_postcode[$i],
          'city' => $request->area_city[$i],
          'street' => $request->area_street[$i],
          'house_number' => isset($request->{'area_from-house-number'}[$i])?trim($request->{'area_from-house-number'}[$i], ' ,.-*_:/'):null,
          'house_number_2' => isset($request->{'area_to-house-number'}[$i])?trim($request->{'area_to-house-number'}[$i], ' ,.-*_:/'):null,
        ]);
        $address_ids [] = $address->id;
        $res &= DB::insert(
          'INSERT IGNORE INTO `user_data_volunteer_addresses` (`user_data_volunteer_id`, `address_id`)
                 VALUES ('.$volunteer_data_id.', '.$address->id.')'
        );
        $addCounter = $i;
      }
    }
    saveLog(UserVolunteerData::find($volunteer_data_id)->user_id, 'Hozzáadott '.$addCounter.'db önkéntes címet.');
    
    return $res;
  }
  
  public function saveVolunteerData(Request $request, $user_id) {
    $userData = new UserVolunteerData();
    $userData->user_id = $user_id;
    $userData->has_car = (isset($request->has_car)&&$request->has_car=='on') ? 1 : 0;
    $userData->availability = $request->availability;
    $userData->helping_groups = json_encode($request->help_types);
    $userData->status = 1;
    
    if($userData->save()) {
      return $userData;
    }
    else {
      return false;
    }
  }

  public function saveSupportData(Request $request, $user_id, $address_id) {
    $userData = new UserSupportData;
    $userData->user_id = $user_id;
    $userData->help_request = $request->help_types;
    $userData->has_coronavirus = $request->has_corona=='on' ? 1 : 0;
    $userData->is_in_quarantine = $request->in_quarantine=='on' ? 1 : 0;
    $userData->has_chronic_illness = $request->has_chronic=='on' ? 1 : 0;
    $userData->is_healthy = $request->is_healthy=='on' ? 1 : 0;
    $userData->description = $request->situation_desc;
    $userData->volunteer_user_id = null;
    $userData->status = 2;
    $userData->address_id = $address_id;
    return $userData->save();
  }
  
  public function getVolunteers($address)
  {
    $user_address = $address;
    
    $volunteer_data = DB::select('
      SELECT
        udv.`user_id`,
        a.*
      FROM `user_data_volunteer` udv
      LEFT JOIN `user_data_volunteer_addresses` udva ON udva.`user_data_volunteer_id` = udv.`id`
      RIGHT JOIN `addresses` a ON a.`id` = udva.`address_id`
      WHERE a.`post_code` = '.$user_address->post_code.' AND a.`street`=\''.$user_address->street.'\''
    );
    $volunteer_ids = array();
    foreach ($volunteer_data as $vd) {
      if($vd->house_number && $vd->house_number_2) {
        if(($user_address->house_number >= $vd->house_number && $user_address->house_number <= $vd->house_number_2 )) {
          $volunteer_ids[] = $vd->user_id;
        }
      }
      else {
        $volunteer_ids[] = $vd->user_id;
      }
    }
   
    return $volunteer_ids;
  }
  
  public function sendRegistrationEmail($user) {
    $user->notify(new UserRegisteredNotification($user));
  }
  public function sendNewRequestEmail($user) {
    $user->notify(new SupportRequest($user));
  }
}