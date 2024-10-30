<?php
/**
 * Extending WC_Payment_Gateway for custom workflow.
 * Using class without namespace, because have an issue with frontend classname.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */

use InstaCash\POS\Config;
use InstaCash\POS\Handler;
use InstaCash\Symfony\Component\HttpFoundation\Request;

/**
 * Extended WC_Payment_Gateway class.
 */
class InstaCashApplication extends WC_Payment_Gateway
{

    /**
     * Request Handler class.
     *
     * @var InstaCash\POS\Handler
     */
    protected $handler;

    public function __construct()
    {
        $this->id                 = __CLASS__;
        $this->icon               = instaCashPluginUri('assets/image/instacash-icon.png');
        $this->method_title       = __('InstaCashPOS', 'instacash-pos');
        $this->method_description = __('Apply for a loan through InstaCash', 'instacash-pos');
        $this->has_fields         = true;
        $this->container          = $this->get_option( 'container' );
        $this->title              = $this->get_option( 'title' );
        $this->description        = $this->get_option( 'description' );
        $this->supports           = [ 'products' ];
        $this->form_fields        = Config::optionFields();
        $this->handler            = new Handler(
            $this->get_option( 'api_key' ),
        );
        $this->init_settings();
        $this->add_hooks();
    }

    /**
     * Add actions to WC events.
     *
     * @return void
     */
    public function add_hooks()
    {
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [ $this, 'process_admin_options' ] );
        add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thank_you_page_instructions' ) );
        add_action( 'wp_ajax_pos_calculator', [ $this, 'calculation_response' ] );
        add_action( 'wp_ajax_nopriv_pos_calculator', [ $this, 'calculation_response' ] );
        add_action( 'admin_notices', [ $this, 'onboarding_notice' ] );
        add_action( 'add_meta_boxes', [ $this, 'order_status_metabox' ] );
        add_action( 'woocommerce_order_status_changed', [$this, 'update_status_on_change'], 10, 3 );

        // Currently, these functions are unnecessary
        // add_action( 'init', [ $this, 'register_order_states' ] );
        // add_action( 'wc_order_statuses', [ $this, 'add_order_states' ] );
    }

    /**
     * Handle Purchase request.
     *
     * @param int $order_id
     *
     * @return array<string>
     */
    public function process_payment( $order_id )
    {

        $order    = wc_get_order( $order_id );
        $response = $this->send_purchase( $order_id );

        if ( ! $response ) {
            return [
                'result' => 'fail',
                'redirect' => ''
            ];
        }

        $order->update_status('pending-payment', __( 'Pending payment', 'woocommerce' ));
        $order->update_meta_data( 'purchaseId', $response->id );
        $order->save();

        return [
            'result'   => 'success',
            'redirect' => sprintf( '%s&icpid=%s', $this->get_return_url( $order ), $response->publicId),
        ];

    }

    /**
     * Add some extra function to "Thank You" page.
     *
     * @return void
     */
    public function thank_you_page_instructions()
    {
        $request  = Request::createFromGlobals();
        wp_enqueue_style( 'ic-pos', plugin_dir_url( __DIR__ ) . '/assets/css/ic-pos.css', [], '1.0.0' );
        wp_enqueue_script( 'ic-pos', plugin_dir_url( __DIR__ ) . '/assets/js/payment.js', [], '1.0.0' );
        wp_localize_script( 'ic-pos', 'POSObject',[ 'payment' => Config::SERVER . '/checkout/' . $request->query->get('icpid') ] );

        require_once instaCashPluginPath('/template/instructions.php');
    }

    /**
     * Add calculator template and scripts to payment field.
     *
     * @return void
     */
    public function payment_fields()
    {
        require_once instaCashPluginPath('/template/calculator.php');
        add_action( 'wp_footer', function(){
            wp_enqueue_style( 'ic-pos', plugin_dir_url( __DIR__ ) . '/assets/css/ic-pos.css', [], '1.0.0' );
            wp_enqueue_script( 'ic-pos', plugin_dir_url( __DIR__ ) . '/assets/js/calculator.js', [], '1.0.0' );
            wp_localize_script( 'ic-pos', 'POSObject', [ 'calculator' => admin_url( 'admin-ajax.php?action=pos_calculator' ) ] );
        });
    }

    /**
     * Check if API key exists or need to print onboard notice.
     *
     * @return void
     */
    public function onboarding_notice() {
        if ( '' !== $this->get_option( 'api_key' ) ) {
            return;
        }
        require_once instaCashPluginPath('/template/admin/onboardNotice.php');
    }

    /**
     * Send Purchase Request.
     *
     * @param int $orderId
     *
     * @return bool|StdClass
     */
    public function send_purchase( $orderId )
    {
        global $woocommerce;

        $items    = [];
        $request  = Request::createFromGlobals();
        $customer = [
            'id'        => get_current_user_id(),
            'firstName' => $request->request->get('billing_first_name'),
            'lastName'  => $request->request->get('billing_last_name'),
            'email'     => $request->request->get('billing_email'),
            'phone'     => $request->request->get('billing_phone'),
        ];

        foreach($woocommerce->cart->get_cart() as $item){
            $items[] = [
                "externalId" => $orderId,
                "identifier" => $item['data']->get_id(),
                "name"       => $item['data']->get_name(),
                "price"      => intval($item['data']->get_price()),
                "quantity"   => intval($item['quantity']),
            ];
        }

        $response = $this->handler->sendPurcasheRequest( $request, $orderId, $customer, $items );

        if ( ! $response ) {
            return false;
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Calculation ajax response to customer.
     *
     * @return string
     */
    public function calculation_response() {
        $request  = Request::createFromGlobals();
        $response = $this->handler->sendCalculationRequest(
            $request->request->getInt('amount'),
            $request->request->getInt('duration'),
            $request->request->getInt('downPayment')
        );
        if ( !$response ){
            wp_send_json_error(
                [
                    'message' => __('The app is not responding, please try again later', 'instacash-pos')
                ],
                503
            );
            exit;
        }

        return $this->print_json_response($response);
    }

    /**
     * Print response for ajax call.
     *
     * @return void
     */
    public function print_json_response($response) {
        header( 'Content-Type: application/json; charset=UTF-8' );
        print $response->getBody()->getContents();
        exit;
    }

    /**
     * Get Purchase Status.
     *
     * @param string $purchase_id
     *
     * @return StdClass
     */
    public function get_purchase_status($purchase_id) {
        $response = $this->handler->getPurchaseStatus($purchase_id);
        return json_decode($response->getBody()->getContents());
    }

    /**
     * Add a metabox to see the statuses in OLM Application.
     *
     * @return void
     */
    public function order_status_metabox(){
        add_meta_box( 'application_status', __('Application Status', 'instacash-pos'), [$this, 'meta_box_content'], 'shop_order', 'side', 'core' );
    }

    /**
     * Get the Application status for display in metabox.
     *
     * @return void
     */
    public function meta_box_content() {

        $order  = wc_get_order(get_the_ID());
        $status = $this->get_purchase_status($order->get_meta( 'purchaseId' ));
        $notice = false;

        if (
            '' !== Config::orderStates()[$status->status]['state'] &&
            Config::orderStates()[$status->status]['state'] !== $order->get_status()
        ) {
            $notice = true;
            $order->update_status(
                Config::orderStates()[$status->status]['state'],
                __( ucfirst(Config::orderStates()[$status->status]['state']), 'woocommerce' )
            );
            $order->save();
        }

        if ($notice) {
            require_once instaCashPluginPath('/template/admin/boxNotice.php');
        }
        require_once instaCashPluginPath('/template/admin/boxContent.php');

    }

    /**
     * Update the OLM purchase status.
     *
     * @param int    $order_id
     * @param string $old_status
     * @param string $new_status
     *
     * @return void
     */
    public function update_status_on_change($order_id, $old_status, $new_status) {

        $order = wc_get_order($order_id);

        switch ($new_status) {
            case 'completed':
            case 'processing':
                $this->handler->updatePurchaseStatus($order->get_meta( 'purchaseId' ), 'PAID');
                break;
            case 'cancelled':
            case 'refunded':
                $this->handler->deletePurchase($order->get_meta( 'purchaseId' ));
                break;
            default: break;
        }

        return;
    }


    /**
     * Add InstaCash states to post statuses.
     *
     * @return void
     */
    public function register_order_states()
    {
        foreach( Config::orderStates() as $name => $status ) {
            register_post_status(
                $name,
                [
                    'label'                     => $status['name'],
                    'public'                    => true,
                    'show_in_admin_status_list' => true,
                    // TRANSLATORS: %s is the number of orders in this status.
                    'label_count'               => _n_noop('InstaCash Application (%s)', 'InstaCash Application (%s)', 'instacash-pos')
                ]
            );
        }
    }

    /**
     * Add InstaCash states to WC order statuses.
     *
     * @param array<string> $order_statuses
     *
     * @return array<string>
     */
    public function add_order_states($order_statuses)
    {
        foreach( Config::orderStates() as $name => $status ) {
            $order_statuses[$name] = $status['name'];
        }
        return $order_statuses;
    }

}
