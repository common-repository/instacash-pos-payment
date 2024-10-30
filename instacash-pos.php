<?php
/**
 * Plugin main file.
 * php version 7.4.33
 *
 * Plugin Name:         InstaCash POS payment
 * Plugin URI:          https://instacash.hu/
 * Description:         Point Of Sale payment solution for woocommerce checkout.
 * Version:             1.0.13
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * Author:              Fintrous Group Kft.
 * Author URI:          https://fintrous.com
 * Developer:           Fintrous Group Kft.
 * Developer URI:       https://fintrous.com
 * Text Domain:         instacash-pos
 * Domain Path:         /languages/
 * License:             GNU General Public License v3.0
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */

// Load necessary classes from autoloader.
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define plugin root dir.
 *
 * @param string $path
 *
 * @return string
 */
function instaCashPluginPath($path = '')
{
    return dirname(__FILE__) . $path;
}

/**
 * Define plugin root url.
 *
 * @param string $path
 *
 * @return string
 */
function instaCashPluginUri($path = '')
{
    return plugin_dir_url(__FILE__) . $path;
}

/**
 * Init application handler.
 *
 * @return void
 */
function InitInstacashApplication()
{
    load_plugin_textdomain('instacash-pos', false, plugin_basename(dirname(__FILE__)) . '/languages');
    new InstaCashApplication;
}

/**
 * Add Gateway to payment methods.
 *
 * @param array<string> $methods
 *
 * @return array<string>
 */
function InstaCashApplicationGW( $methods )
{
    $methods[] = InstaCashApplication::class;
    return $methods;
}

/**
 * Flush routes for adding endpoint.
 *
 * @return void
 */
function instaCashActivate()
{
    flush_rewrite_rules();
}

/**
 * Flush routes for removing endpoint and options.
 *
 * @return void
 */
function instaCashRemove()
{
    delete_option('woocommerce_InstacashApplication_settings');
    flush_rewrite_rules();
}

add_action('plugins_loaded', 'InitInstacashApplication');
add_filter('woocommerce_payment_gateways', 'InstaCashApplicationGW');

register_activation_hook(__FILE__, 'instaCashActivate');
register_deactivation_hook(__FILE__, 'instaCashRemove');
