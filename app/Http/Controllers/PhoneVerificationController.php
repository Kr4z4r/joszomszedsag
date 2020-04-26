<?php

namespace App\Http\Controllers;

use App\Rules\PhoneNumber;
use App\Services\PhoneVerificationService;
use App\User;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PhoneVerificationRequest;
use Nexmo\Client\Exception\Exception;

class PhoneVerificationController extends Controller
{


    public function index()
    {
        return view('forms.phone-verification');
    }

    /**
     * @param PhoneVerificationRequest $request
     * @param PhoneVerificationService $verificationService
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendCode(
        PhoneVerificationRequest $request,
        PhoneVerificationService $verificationService
    )
    {
        $user  = User::find(session()->get('registration.user_id'));
        $phone = PhoneNumber::toDigits($request->get('phone'));

        // Check phone number for minimum digits
        if( 10 > strlen($phone) ){
            throw ValidationException::withMessages(['phone'=>[
                // TODO move to phone validator
                "Phone number should have at least 10 digits. Please include country and region prefix."
            ]]);
        }

        // Can verify your phone only after registration
        if( empty($user) ){
            return redirect(route('/'));
        }

        $verificationService->sendCodeViaSMS($phone);

        return view('forms.phone-verification', ['sent'=>TRUE]);
        // TODO support json
        //return response()->json(['success'=>true]);
    }

    /**
     * @param PhoneVerificationRequest $request
     * @param PhoneVerificationService $verificationService
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function checkCode(
        PhoneVerificationRequest $request,
        PhoneVerificationService $verificationService
    )
    {
        /**
         * @var User $user
         */
        $user    = User::find(session()->get('registration.user_id'));
        $phoneNr = $request->get('phone');
        $code    = $request->get('code');

        if( $verificationService->checkCode($phoneNr, $code) ){
            $user->update(['phone_verified_at'=>now()]);
            return redirect(route('login'));
            //return response()->json(['success'=>true]);
        }

        throw ValidationException::withMessages(['code'=>"Please enter the code sent via SMS"]);
    }
}
