<?php
/**
 * Instruction section after send order.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */
?>
<section class="woocommerce-ic-details">
    <div><?php echo $this->get_option('instructions'); ?></div>
    <div id="InstaCash" class="pt-3">
        <?php _e('If the application interface did not open on a new tab, please click on the button below.', 'instacash-pos'); ?><br/>
        <div class="pt-3">
            <a href="<?php print InstaCash\POS\Config::SERVER; ?>/checkout/<?php echo $request->query->get('icpid'); ?>" class="font-weight-bold btn btn-primary rounded" target="_blank">
                <?php _e('Start the application', 'instacash-pos'); ?>
            </a>
        </div>
    </div>
</section>
