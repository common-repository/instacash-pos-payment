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
<div id="merchantNotice" class="notice InstaCash-notice is-dismissible">
    <div class="flex">
        <div class="vertical-center">
            <?php require 'logo.svg'; ?>
        </div>
        <div class="col">
            <p>
                <?php _e('Thank you for installing the payment solution of instacash, so the digital installment payment solution will help you to reduce cart abandonment and increase the average cart length.', 'instacash-pos'); ?>
            </p>
            <p>
                <?php _e('If you haven´t signed up for our service yet, click', 'instacash-pos'); ?> <a href="<?php print InstaCash\POS\Config::MERCHANT; ?>" target="_blank"><?php _e('here', 'instacash-pos'); ?></a>
                <?php _e(', to go through the validation completely online, without a personal meeting:', 'instacash-pos'); ?>
            </p>
            <p>
                <?php _e('Buy NOW, Pay later!', 'instacash-pos'); ?>
            </p>
        </div>
        <div class="vertical-center">
            <a href="<?php print InstaCash\POS\Config::MERCHANT; ?>" target="_blank" class="ic-primary ic-btn">
                <?php _e('Merchant Portal', 'instacash-pos'); ?>
            </a>
        </div>
    </div>
</div>
<style>
    .InstaCash-notice {
        border-left-width: 1px !important;
        border-radius: 8px;
        background-color: #f6f9fc !important;
    }
    .vertical-center {
        margin: auto 0;
    }
    .ic-logo {
        width: 111px;
        max-height: 22px;
        padding: 0px 10px;
    }
    .ic-btn {
        height: 32px;
        padding: .375rem .75rem;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
    }
    a.ic-primary {
        border-color: #2A74ED;
        background: #2A74ED;
        color: #fff;
        -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    }
    a.ic-primary:hover, a.ic-primary:active {
        border-color: #051C3A;
        background: #051C3A;
        color: #fff !important;
    }
    .flex {
        display: flex;
    }
    .col {
        padding: auto;
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }
</style>
