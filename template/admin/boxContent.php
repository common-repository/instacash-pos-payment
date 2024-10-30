<?php
/**
 * Admin side notice for onboard.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */
?>
<p><?php esc_html_e('Status', 'instacash-pos'); ?>: <strong style="color:<?php print InstaCash\POS\Config::orderStates()[$status->status]['color']; ?>">
  <?php print InstaCash\POS\Config::orderStates()[$status->status]['name']; ?></strong>
</p>
<p><?php print InstaCash\POS\Config::orderStates()[$status->status]['desc']; ?></p>
<p><?php esc_html_e('Self-reliance', 'instacash-pos'); ?>: <strong><?php print number_format($status->downPayment, 0, '', ' '); ?> Ft</strong></p>
<p><?php esc_html_e('Amount requested', 'instacash-pos'); ?>: <strong><?php print number_format($status->totalAmount, 0, '', ' '); ?> Ft</strong></p>
<p><?php esc_html_e('Last modify', 'instacash-pos'); ?>: <strong><?php print explode('+', $status->lastStatusChange)[0]; ?></strong></p>
<p><?php esc_html_e('Date of purchase', 'instacash-pos'); ?>: <strong><?php print explode('+', $status->lastStatusChange)[0]; ?></strong></p>
<a class="button save_order button-primary" href="%s/purchase/%d" target="_blank">
  <?php esc_html_e('Merchant Portal', 'instacash-pos'); ?> <strong>></strong>
</a>
