<?php
  
  namespace App;
  
  use App\Notifications\VerifyEmail;
  use Illuminate\Contracts\Auth\MustVerifyEmail;
  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use App\Notifications\ResetPassword as ResetPassword;
  use TCG\Voyager\Models\Role;
  use TCG\Voyager\Models\User as VoyagerUser;
  
  class User extends VoyagerUser implements MustVerifyEmail
  {
    public $user_roles;
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'avatar',
        'settings',
        'date_birth',
        'description',
        'facebook_profile',
        'facebook_group'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'phone_verified_at' => 'datetime',
      'email_verified_at' => 'datetime',
    ];
    
    public function __construct(array $attributes = []) {
      parent::__construct($attributes);
      foreach (Role::all() as $role) {
        $this->user_roles[$role->id] = $role->name;
      }
    }
    
    public function sendPasswordResetNotification($token) {
      $this->notify(new ResetPassword($token));
    }
    public function sendEmailVerificationNotification() {
      $this->notify(new VerifyEmail());
    }
    
    public function canOpen() {
      Role::all(['name']);
    }
    
    
    public function getVolunteerDataByAddress() {
      //$volunteer_data = App\UserVolunteerData::where('user_id' => )
    }

    protected static function boot()
    {
      parent::boot();
      static::updating(function ($model) {
        $old = self::find($model->id);

        logModelChange($old->attributes, $model->attributes,$model->id, 'Felhasználó: ');
      });

      static::created(function ($model) {
        saveLog($model->id, 'Új '.$model->role_id.' regisztrálva '.$model->email.' emaillel');
      });
    }
  }
