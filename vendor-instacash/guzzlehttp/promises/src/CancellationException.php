<?php
/**
 * @license MIT
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\GuzzleHttp\Promise;

/**
 * Exception that is set as the reason for a promise that has been cancelled.
 */
class CancellationException extends RejectionException
{
}
