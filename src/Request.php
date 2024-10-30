<?php
/**
 * Handle request arrays for API communication.
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
 * Format request from the received data.
 */
class Request
{
    /**
     * Array of request data.
     *
     * @var array<array<int|string>|int|string>
     */
    protected $requestArray;

    /**
     * Format request Array to Calculator request.
     *
     * @param int $amount
     * @param int $duration
     * @param int $downPayment
     *
     * @return Request
     */
    public function getCalculationRequest($amount, $duration, $downPayment = 0)
    {
        $this->requestArray = [
            'purchaseAmount' => $amount,
            'downPayment'    => $downPayment,
            'duration'       => $duration,
        ];

        return $this;
    }

    /**
     * Format request Array to Purchase request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int                                       $orderId
     *
     * @return Request
     */
    public function getPurcasheRequest($request, $orderId)
    {
        $this->requestArray = [
            'externalId'            => $orderId,
            'downPayment'           => $request->request->getDigits('downPayment'),
            'selectedOfferId'       => $request->request->getInt('offerId'),
            'totalAmount'           => $request->request->getInt('totalAmount'),
            'checkoutCalculationId' => $request->request->getInt('calculationId'),
        ];

        return $this;
    }

    /**
     * Add items to request array.
     *
     * @param array<int|string> $items
     *
     * @return Request
     */
    public function addItems($items)
    {
        $this->requestArray += ['items' => $items];
        return $this;
    }

    /**
     * Add customer to request array.
     *
     * @param array<string> $customer
     *
     * @return Request
     */
    public function addCustomer($customer)
    {
        $phoneNumber = new Phone($customer['phone']);
        if ($phoneNumber->isValid()) {
            $customer['phone'] = $phoneNumber->stripCountryCode();
        }

        $this->requestArray += [
            'customerId'    => $customer['id'],
            'customerEmail' => $customer['email'],
            'customerName'  => $customer['lastName'] . ' ' . $customer['firstName'],
            'customerPhone' => $customer['phone'],
        ];
        return $this;
    }

    /**
     * Format request Array to updateStatus request.
     *
     * @param string $status
     *
     * @return Request
     */
    public function updatePurcasheStatusRequest($status)
    {
        $this->requestArray = [
            'status' => $status,
        ];

        return $this;
    }

    /**
     * Returns currently request array.
     *
     * @return array<array<int|string>|int|string>
     */
    public function getRequestArray()
    {
        return $this->requestArray;
    }

    /**
     * Returns currentlyrequest array in json format.
     *
     * @return string|false
     */
    public function getRequestJsonArray()
    {
        return json_encode($this->requestArray);
    }
}
