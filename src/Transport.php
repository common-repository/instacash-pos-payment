<?php declare( strict_types = 1 );
/**
 * Transport http messages.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */

namespace InstaCash\POS;

use Exception;
use InstaCash\GuzzleHttp\Client;

/**
 * Transport handler class.
 */
class Transport
{

    /**
     * cURL data transport to OLM API.
     *
     * @param string       $apiKey
     * @param string|false $request
     * @param string       $method
     * @param string       $type
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     * @throws Exception
     */
    public static function send( $apiKey, $request, $method, $type = 'checkout' )
    {
        $client = new Client(['base_uri' => Config::SERVER . '/api/credit/external/']);

        try {

            return $client->request(
                $method,
                $type,
                [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                        'X-API-KEY'    => $apiKey,
                    ],
                    'body'    => $request,
                ]
            );

        } catch ( Exception $e ) {

            // Using WC's own logger so that the log is also available online.
            $logger = wc_get_logger();
            $logger->info(sprintf('Instacash service error: %s', $e->getMessage()), ['source' => 'instacash-errors']);

            // log error message into standard log.
            error_log(sprintf('Instacash service error: %s', $e->getMessage()));
            return false;

        }

    }
}
