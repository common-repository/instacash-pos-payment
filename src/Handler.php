<?php
/**
 * Handle API connection to OLM for sending and getting Purcashe information.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */

namespace InstaCash\POS;

/**
 * Communication handler class.
 */
class Handler
{
    /**
     * Loan application handler API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Request handler class.
     *
     * @var Request
     */
    protected $request;

    /**
     * Init class.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey     = $apiKey;
        $this->request    = new Request();
    }

    /**
     * Send calculation data.
     *
     * @param int $amount
     * @param int $duration
     * @param int $downPayment
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function sendCalculationRequest($amount, $duration, $downPayment)
    {
        return Transport::send(
            $this->apiKey,
            $this->request->getCalculationRequest($amount, $duration, $downPayment)->getRequestJsonArray(),
            'POST'
        );
    }

    /**
     * Send purchase data.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int                                       $orderId
     * @param array<string>                             $customer
     * @param array<int|string>                         $items
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function sendPurcasheRequest($request, $orderId, $customer, $items)
    {
        return Transport::send(
            $this->apiKey,
            $this->request->getPurcasheRequest($request, $orderId)->addCustomer($customer)->addItems($items)->getRequestJsonArray(),
            'POST',
            'purchase'
        );

    }

    /**
     * Update Purchase Status.
     *
     * @param string $purchaseId
     * @param string $status
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function updatePurchaseStatus($purchaseId, $status)
    {
        return Transport::send(
            $this->apiKey,
            $this->request->updatePurcasheStatusRequest($status)->getRequestJsonArray(),
            'PATCH',
            'purchase/' . $purchaseId
        );

    }

    /**
     * Get Purchase Status.
     *
     * @param string $purchaseId
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function getPurchaseStatus($purchaseId)
    {
        return Transport::send(
            $this->apiKey,
            '',
            'GET',
            'purchase/' . $purchaseId
        );

    }

    /**
     * Delete Purchase Status.
     *
     * @param string $purchaseId
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function deletePurchase($purchaseId)
    {
        return Transport::send(
            $this->apiKey,
            '',
            'DELETE',
            'purchase/' . $purchaseId
        );

    }
}
