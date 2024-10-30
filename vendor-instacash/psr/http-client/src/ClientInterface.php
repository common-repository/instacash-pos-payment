<?php
/**
 * @license MIT
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\Psr\Http\Client;

use InstaCash\Psr\Http\Message\RequestInterface;
use InstaCash\Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     *
     * @throws \InstaCash\Psr\Http\Client\ClientExceptionInterface If an error happens while processing the request.
     */
    public function sendRequest(RequestInterface $request): ResponseInterface;
}
