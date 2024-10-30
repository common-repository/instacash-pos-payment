<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

use InstaCash\libphonenumber\Leniency\Possible;
use InstaCash\libphonenumber\Leniency\StrictGrouping;
use InstaCash\libphonenumber\Leniency\Valid;
use InstaCash\libphonenumber\Leniency\ExactGrouping;

class Leniency
{
    public static function POSSIBLE()
    {
        return new Possible;
    }

    public static function VALID()
    {
        return new Valid;
    }

    public static function STRICT_GROUPING()
    {
        return new StrictGrouping;
    }

    public static function EXACT_GROUPING()
    {
        return new ExactGrouping;
    }
}
