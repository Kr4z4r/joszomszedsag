<?php
/**
 * joszomszedsag - Phone Verification Service Interface
 * @author adrian7
 * @version 1.0
 */

namespace App\Services;

interface PhoneVerificationService{
    public function sendCodeViaSMS($phoneNr) : void ;
    public function sendCodeViaVoiceCall($phoneNr) : void ;
    public function checkCode($phoneNr, $code) : bool ;
}