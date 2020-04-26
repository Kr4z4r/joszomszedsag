<?php
/**
 * Phone Number validator
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    /**
     * List of valid entries
    754-3010
    (541) 754-3010
    +1-541-754-3010
    191 541 754 3010
    001-541-754-3010
    (089) / 636-48018
    +49-89-636-48018
    19-49-89-636-48018
    +40 746 734 763
    0044 847 6354 73
    +44 847 9586
     * ----------------------------
     */
    const REGEX = '/[0-9-+\(\)\ \/]{3,}/m';

    /**
     * Determine if the validation rule passes. (https://en.wikipedia.org/wiki/Telephone_numbering_plan)
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value   = self::normalize($value);
        // 15 plus max 4 extension
        $length     = ( 20 > strlen($value) and 2 < strlen($value) );
        $extensions = $this->hasValidExtensions($value);

        return ( $length and $extensions and !!empty(preg_replace(self::REGEX, '', $value)) );
    }

    public function hasValidExtensions($number, $delimiter='x')
    {
        if( $has = strpos($number, $delimiter)){
            $extensions = explode($delimiter, substr($number, $has+1));

            foreach ($extensions as $ext) {
                if( ! ctype_digit($ext) or 8 < strlen($ext) ){
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter a valid phone number.';
    }

    /**
     * Normalize a phone number
     * @param $value
     * @return mixed|string
     */
    public static function normalize($value)
    {
        $value = trim(strtolower($value));
        $value = ( $e = strpos($value, 'x') ) ? substr($value, 0,$e-1) : $value; // Remove extension
        return preg_replace('/[. \/\\\\]{1,}/m', '-', $value);
    }

    /**
     * Get digits only
     * @param $number
     *
     * @return string|string[]|null
     */
    public static function toDigits($number)
    {
        return preg_replace('/[^0-9]/m', '', $number);
    }
}
