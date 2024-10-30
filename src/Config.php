<?php
/**
 * Store option fields in class constant.
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
 * Static config class.
 */
class Config
{

    // Server URL
    public const SERVER = 'https://app.instacash.hu';

    // Merchant portal URl
    public const MERCHANT = 'https://merchant.instacash.hu';

    /**
     * Default option field of WC Payment.
     *
     * @return array<string, array<string, string|true>>
     */
    public static function optionFields()
    {
        return [
            'title' => [
                'title'       => __('Title', 'instacash-pos'),
                'type'        => 'text',
                'description' => __('This controls the title which the user sees during checkout.', 'instacash-pos'),
                'default'     => __('InstaCash', 'instacash-pos'),
                'desc_tip'    => true,
            ],
            'description' => [
                'title'       => __('Description', 'instacash-pos'),
                'type'        => 'textarea',
                'description' => __('This controls the description which the user sees during checkout.', 'instacash-pos'),
                'default'     => __('Apply for a loan and pay in installments', 'instacash-pos'),
                'desc_tip'    => true,
            ],
            'instructions' => [
                'title'       => __('Instructions', 'instacash-pos'),
                'type'        => 'textarea',
                'description' => __('Other instructions can be given after placing the order.', 'instacash-pos'),
                'default'     => __('In order to start the loan application, please open the following page and enter the necessary data!', 'instacash-pos'),
                'desc_tip'    => true,
            ],
            'api_key' => [
                'title'       => __('API Key', 'instacash-pos'),
                'type'        => 'text',
                'description' => __('A unique alphanumeric string that identifies the service', 'instacash-pos'),
                'default'     => '',
                'desc_tip'    => true,
            ],
        ];
    }

    /**
     * Order statuses of Loan application system translated to WC payment statuses.
     *
     * @return array<string, array<string, string>>
     */
    public static function orderStates()
    {
        return [
            'CREATED'                  => [
                'name'  => __('Purchase created', 'instacash-pos'),
                'desc'  => __('A purchase has been made in the Instacash system', 'instacash-pos'),
                'color' => '#00a1a1',
                'state' => '',
            ],
            'LINKED'                   => [
                'name'  => __('Purchase linked to customer', 'instacash-pos'),
                'desc'  => __('Customer has logged into their account', 'instacash-pos'),
                'color' => '#008a8a',
                'state' => '',
            ],
            'APPLICATION_STARTED'      => [
                'name'  => __('Loan application started', 'instacash-pos'),
                'desc'  => __('The customer has started the loan application', 'instacash-pos'),
                'color' => '#005e5e',
                'state' => 'on-hold',
            ],
            'APPLICATION_UNDER_REVIEW' => [
                'name'  => __('Loan application under review', 'instacash-pos'),
                'desc'  => __('The bank is now checking whether the requested loan amount can be granted based on the customer´s data', 'instacash-pos'),
                'color' => '#008f8f',
                'state' => '',
            ],
            'LOAN_APPROVED'            => [
                'name'  => __('Loan application approved', 'instacash-pos'),
                'desc'  => __('The loan is being disbursed', 'instacash-pos'),
                'color' => '#039470',
                'state' => '',
            ],
            'REVOKED'                  => [
                'name'  => __('Purchase revoked', 'instacash-pos'),
                'desc'  => __('Loan application has been revoked', 'instacash-pos'),
                'color' => '#ff5b0f',
                'state' => 'cancelled',
            ],
            'CANCELLED'                => [
                'name'  => __('Purchase cancelled', 'instacash-pos'),
                'desc'  => __('Payment process terminated', 'instacash-pos'),
                'color' => '#612006',
                'state' => 'cancelled',
            ],
            'DENIED'                   => [
                'name'  => __('Loan application rejected', 'instacash-pos'),
                'desc'  => __('Unsuccessful Loan Application', 'instacash-pos'),
                'color' => '#ff0000',
                'state' => 'failed',
            ],
            'MONEY_TRANSFERRED'        => [
                'name'  => __('Amount transferred', 'instacash-pos'),
                'desc'  => __('The bank disbursed the amount', 'instacash-pos'),
                'color' => '#015105',
                'state' => 'processing',
            ],
            'PAID'                     => [
                'name'  => __('Payment Completed', 'instacash-pos'),
                'desc'  => __('Payment was confirmed by the merchant', 'instacash-pos'),
                'color' => '#01950a',
                'state' => 'processing',
            ],
        ];
    }

}
