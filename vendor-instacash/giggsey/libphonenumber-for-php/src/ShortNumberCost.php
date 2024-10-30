<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

/**
 * Cost categories of short numbers
 * @package libphonenumber
 */
class ShortNumberCost
{
    const TOLL_FREE = 3;
    const PREMIUM_RATE = 4;
    const STANDARD_RATE = 30;
    const UNKNOWN_COST = 10;
}
