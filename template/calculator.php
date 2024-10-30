<?php
/**
 * Calculator display for frontend.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */
?>

<div id="InstaCash" class="rounded shadow-md">
    <div class="overlay rounded" id="posOverlay" style="display: none;">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    <div class="p-3">
        <div class="row">
            <div class="col text-md-center my-auto">
                <?php require 'admin/logo.svg'; ?>
            </div>
            <div class="col d-flex">
                <div class="w-100 text-right d-flex justify-content-end justify-content-md-center">
                    <div class="text-white bg-dark d-flex rounded px-2">
                        <div class="p-2 basket">
                            <svg class="basket-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#ffffff" d="M171.7 191.1H404.3L322.7 35.07C316.6 23.31 321.2 8.821 332.9 2.706C344.7-3.409 359.2 1.167 365.3 12.93L458.4 191.1H544C561.7 191.1 576 206.3 576 223.1C576 241.7 561.7 255.1 544 255.1L492.1 463.5C484.1 492 459.4 512 430 512H145.1C116.6 512 91 492 83.88 463.5L32 255.1C14.33 255.1 0 241.7 0 223.1C0 206.3 14.33 191.1 32 191.1H117.6L210.7 12.93C216.8 1.167 231.3-3.409 243.1 2.706C254.8 8.821 259.4 23.31 253.3 35.07L171.7 191.1zM191.1 303.1C191.1 295.1 184.8 287.1 175.1 287.1C167.2 287.1 159.1 295.1 159.1 303.1V399.1C159.1 408.8 167.2 415.1 175.1 415.1C184.8 415.1 191.1 408.8 191.1 399.1V303.1zM271.1 303.1V399.1C271.1 408.8 279.2 415.1 287.1 415.1C296.8 415.1 304 408.8 304 399.1V303.1C304 295.1 296.8 287.1 287.1 287.1C279.2 287.1 271.1 295.1 271.1 303.1zM416 303.1C416 295.1 408.8 287.1 400 287.1C391.2 287.1 384 295.1 384 303.1V399.1C384 408.8 391.2 415.1 400 415.1C408.8 415.1 416 408.8 416 399.1V303.1z"></path></svg>
                        </div>
                        <div class="p-2 font-weight-bold text-nowrap">
                            <span id="basket-amount"><?php echo number_format(WC()->cart->total, 0, '', ' '); ?></span> <?php _e('$', 'instacash-pos'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mx-0">
            <h3 class="h5 col-12 pt-2 pl-0"><?php _e('Calculation', 'instacash-pos'); ?></h3>
        </div>
        <div class="row">
            <div class="amount-input col-md-12 text-secondary">
                <small class="ml-4 position-relative bottom-negative bg-white rounded font-weight-bold px-2 py-0"><?php _e('Down Payment', 'instacash-pos'); ?></small>
                <div class="input-group border rounded p-2 bg-white">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="downPaymentField"><?php _e('Dollar', 'instacash-pos'); ?></span>
                    </div>
                        <input type="text" id="downPayment" name="downPayment" class="form-control pl-2" aria-label="downPayment" aria-describedby="downPayment" placeholder="0">
                </div>
                <div class="row mx-2 justify-content-between">
                    <small><?php _e('Min.', 'instacash-pos'); ?> <span class="suff-amount-min">0</span> <?php _e('$', 'instacash-pos'); ?></small>
                    <small><?php _e('Max.', 'instacash-pos'); ?> <span class="suff-amount-max"><?php echo WC()->cart->total; ?></span> <?php _e('$', 'instacash-pos'); ?></small>
                </div>
            </div>
        </div>
        <div class="duration-input w-100 pt-3">
            <div class="w-100 row mx-0 text-secondary">
                <small class="col-12 px-0 pb-3 font-weight-bold"><?php _e('Payment installments', 'instacash-pos'); ?></small>

                <div class="btn-group d-flex w-100 justify-content-between" role="group" aria-label="">
                    <input type="radio" class="btn-check" name="duration" id="6" value="6" data-required="true" autocomplete="off">
                    <label class="btn btn-outline-primary rounded" for="6">6 <?php _e('Month', 'instacash-pos'); ?></label>

                    <input type="radio" class="btn-check" name="duration" id="12" value="12" data-required="false" autocomplete="off" checked>
                    <label class="btn btn-outline-primary rounded" for="12">12 <?php _e('Month', 'instacash-pos'); ?></label>

                    <input type="radio" class="btn-check" name="duration" id="24" value="24" data-required="false" autocomplete="off">
                    <label class="btn btn-outline-primary rounded" for="24">24 <?php _e('Month', 'instacash-pos'); ?></label>

                    <input type="radio" class="btn-check" name="duration" id="36" value="36" data-required="false" autocomplete="off">
                    <label class="btn btn-outline-primary rounded" for="36">36 <?php _e('Month', 'instacash-pos'); ?></label>
                </div>
            </div>
            <input type="hidden" id="totalAmount" name="totalAmount" value="<?php echo WC()->cart->total; ?>">
            <input type="hidden" id="offerId" name="offerId">
            <input type="hidden" id="calculationId" name="calculationId">
        </div>
        <div class="col-12 mx-0">
            <h3 class="h5 col-12 pt-2 pl-0"><?php _e('Offer', 'instacash-pos'); ?></h3>
        </div>
    </div>
    <div class="bg-ic p-3 pt-2 offer-box">
        <div class="row justify-content-between">
            <div class="d-flex mw-80">
                <div class="offer-logo">
                    <img src="<?php print instaCashPluginUri('assets/image/instacash-icon.png'); ?>" alt="InstaCash"/>
                </div>
                <div class="px-2">
                    <h3 class="offer-name my-0"><?php _e('InstaCash', 'instacash-pos'); ?></h3>
                    <small class="offer-partner text-nowrap font-weight-bold"><?php _e('InstaCash', 'instacash-pos'); ?></small>
                </div>
            </div>
            <h3 class="text-right offer-apr mw-20 my-0">0 %</h3>
        </div>
        <div class="offer-amounts">
            <div class="pt-2 row text-nowrap">
                <div class="col">
                    <?php _e('Amount', 'instacash-pos'); ?>
                </div>
                <div class="col mw-25 text-right offer-amount">
                    0 <?php _e('$', 'instacash-pos'); ?>
                </div>
            </div>
            <div class="row text-nowrap">
                <div class="col">
                    <?php _e('Installment', 'instacash-pos'); ?>
                </div>
                <div class="col mw-25 text-right offer-repay">
                    0 <?php _e('$', 'instacash-pos'); ?>
                </div>
            </div>
            <div class="row text-nowrap">
                <div class="col">
                    <?php _e('Total Repayment', 'instacash-pos'); ?>
                </div>
                <div class="col mw-25 text-right offer-total">
                    0 <?php _e('$', 'instacash-pos'); ?>
                </div>
            </div>
        </div>
        <div>
            <p class="offer-error text-red font-weight-bold">
            <small class="minAmount" style="display:none;">
                <?php _e('Minimum claimable amount', 'instacash-pos'); ?> <span class="amount"></span> <?php _e('$', 'instacash-pos'); ?><br/>
                <?php _e('We have modified the calculation accordingly.', 'instacash-pos'); ?><br/>
                <?php _e('You can spend the remaining', 'instacash-pos'); ?> <?php _e('amount on your other expenses.', 'instacash-pos'); ?>
            </small>
            <small class="downPayment" style="display:none;">
                <?php _e('The minimum loan amount that can be applied for requires less self-reliance.', 'instacash-pos'); ?><br/>
                <?php _e('You can spend the remaining', 'instacash-pos'); ?>
                <span class="amount"></span> <?php _e('$', 'instacash-pos'); ?>
                <?php _e('amount on your other expenses.', 'instacash-pos'); ?>
            </small>
            <small class="error" style="display:none;">
            </small>
            </p>
        </div>
    </div>
</div>
