<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

/**
 * Interface MatcherAPIInterface
 *
 * Internal phonenumber matching API used to isolate the underlying implementation of the
 * matcher and allow different implementations to be swapped in easily.
 *
 * @package libphonenumber
 * @internal
 */
interface MatcherAPIInterface
{
    /**
     * Returns whether the given national number (a string containing only decimal digits) matches
     * the national number pattern defined in the given {@code PhoneNumberDesc} message.
     *
     * @param string $number
     * @param PhoneNumberDesc $numberDesc
     * @param boolean $allowPrefixMatch
     * @return boolean
     */
    public function matchNationalNumber($number, PhoneNumberDesc $numberDesc, $allowPrefixMatch);
}
