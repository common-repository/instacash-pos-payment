<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber\Leniency;

use InstaCash\libphonenumber\PhoneNumber;
use InstaCash\libphonenumber\PhoneNumberMatcher;
use InstaCash\libphonenumber\PhoneNumberUtil;

class Valid extends AbstractLeniency
{
    protected static $level = 2;

    /**
     * Phone numbers accepted are PhoneNumberUtil::isPossibleNumber() and PhoneNumberUtil::isValidNumber().
     * Numbers written in national format must have their national-prefix present if it is usually written
     * for a number of this type.
     *
     * @param PhoneNumber $number
     * @param string $candidate
     * @param PhoneNumberUtil $util
     * @return bool
     */
    public static function verify(PhoneNumber $number, $candidate, PhoneNumberUtil $util)
    {
        if (!$util->isValidNumber($number)
            || !PhoneNumberMatcher::containsOnlyValidXChars($number, $candidate, $util)) {
            return false;
        }

        return PhoneNumberMatcher::isNationalPrefixPresentIfRequired($number, $util);
    }
}
