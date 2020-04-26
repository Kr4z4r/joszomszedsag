<?php
/**
 * joszomszedsag - [file description]
 * @author adrian7
 * @version 1.0
 */

namespace App\Services;

use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Log;
use Nexmo\Client\Exception\Request as NexmoRequestException;

class NexmoPhoneVerificationService implements PhoneVerificationService{

    protected $verificationCodeLength = 4;
    protected $senderName = '[Sender not configured]';
    protected $client     = NULL;

    /**
     * NexmoPhoneVerificationService constructor.
     *
     * @param string $key
     * @param string $secret
     * @param string|null $senderName
     *
     * @throws \ErrorException
     */
    public function __construct($key, $secret, $senderName=NULL)
    {

        if( empty($key) or empty($secret) ){
            throw new \ErrorException("Nexmo API key and secret are missing!");
        }

        $credentials  = new \Nexmo\Client\Credentials\Basic($key, $secret);
        $this->client = new \Nexmo\Client($credentials);

        $this->senderName = $senderName ?? config('app.name');

    }

    /**
     * @param $phoneNr
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function sendCodeViaSMS($phoneNr): void
    {
        if( $this->verificationId($phoneNr) ){
            // A verification is already registered for this number
            return;
        }

        $verification = $this->client->verify()->start([
            'number' => $phoneNr, // Normalize phone nr.
            'brand'  => $this->senderName,
            'code_length'  => $this->verificationCodeLength
        ]);

        $this->registerVerification($phoneNr, $verification);
    }

    public function sendCodeViaVoiceCall( $phoneNr ): void
    {
        // TODO: Implement sendCodeViaVoiceCall() method.
    }

    /**
     * @param string $phoneNr
     * @param string $code
     *
     * @return bool
     * @throws \ErrorException
     */
    public function checkCode($phoneNr, $code ): bool
    {
        try {
            $this->client->verify()->check($this->getVerification($phoneNr), $code);
            return TRUE;
        }
        catch (NexmoRequestException $exception) {
            Log::notice("Verification failed for number {$phoneNr}:" . $exception->getMessage());
        }

        return FALSE;
    }

    /**
     * @param string $phoneNr
     * @param \Nexmo\Verify\Verification $verification
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    protected function registerVerification($phoneNr, \Nexmo\Verify\Verification $verification)
    {
        cache()->set(
            ( PhoneNumber::toDigits($phoneNr) . ".verification_id" ),
            $verification->getRequestId(),
            now()->addMinutes(15)
        );
    }

    protected function verificationId($phoneNr)
    {
        return cache()->get(PhoneNumber::toDigits($phoneNr) . ".verification_id");
    }

    protected function getVerification($phoneNr)
    {
        if( $request_id = $this->verificationId($phoneNr) ){
            return new \Nexmo\Verify\Verification($request_id);
        }

        throw new \ErrorException("No verification registered for {$phoneNr}");
    }
}