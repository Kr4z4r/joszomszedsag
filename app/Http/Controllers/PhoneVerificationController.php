<?php

namespace App\Http\Controllers;

use App\Rules\PhoneNumber;
use App\Services\PhoneVerificationService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PhoneVerificationRequest;

class PhoneVerificationController extends Controller
{

    public function index()
    {
        if( $id = session()->get('registration.user_id') ){
            return view('forms.phone-verification');
        }
        else{
            return redirect(route('onkentes-regisztracio'));
        }
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
        $phone = PhoneNumber::toDigits($request->get('phone'));

        // Check phone number for minimum digits
        if( 10 > strlen($phone) ){
            throw ValidationException::withMessages(['phone'=>[
                // TODO move to phone validator
                "Phone number should have at least 10 digits. Please include country and region prefix."
            ]]);
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
        $user    = $request->getUser();
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
