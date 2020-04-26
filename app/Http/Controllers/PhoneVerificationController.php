<?php

namespace App\Http\Controllers;

use App\Services\PhoneVerificationService;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PhoneVerificationRequest;

class PhoneVerificationController extends Controller
{
    /**
     * @param PhoneVerificationRequest $request
     * @param PhoneVerificationService $verificationService
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode(
        PhoneVerificationRequest $request,
        PhoneVerificationService $verificationService
    )
    {
        $verificationService->sendCodeViaSMS($request->get('phone'));

        return response()->json(['success'=>true]);
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
        $phoneNr = $request->get('phone');
        $code    = $request->get('code');

        if( $verificationService->checkCode($phoneNr, $code) ){
            return response()->json(['success'=>true]);
        }

        throw ValidationException::withMessages(['code'=>"Please enter the code sent via SMS"]);
    }
}
