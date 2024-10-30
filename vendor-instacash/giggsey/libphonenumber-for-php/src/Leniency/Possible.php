<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber\Leniency;

use InstaCash\libphonenumber\PhoneNumber;
use InstaCash\libphonenumber\PhoneNumberUtil;

class Possible extends AbstractLeniency
{
    protected static $level = 1;

    /**
     * Phone numbers accepted are PhoneNumberUtil::isPossibleNumber(), but not necessarily
     * PhoneNumberUtil::isValidNumber().
     *
     * @param PhoneNumber $number
     * @param string $candidate
     * @param PhoneNumberUtil $util
     * @return bool
     */
    public static function verify(PhoneNumber $number, $candidate, PhoneNumberUtil $util)
    {
        return $util->isPossibleNumber($number);
    }
}
