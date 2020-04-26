<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class PhoneVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getUser() ? TRUE : FALSE;
    }

    /**
     * @return array|string[]
     */
    public function messages() {
        return ['code.min' => 'Please enter a valid code.'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => ['required', new PhoneNumber],
            'code'  => 'sometimes|min:4'
        ];
    }

    /**
     * Get currently registered user
     * @return User|void
     */
    public function getUser()
    {
        if( $id = session()->get('registration.user_id') and $user = User::find($id) ){
            return $user;
        }

        return NULL;
    }
}
