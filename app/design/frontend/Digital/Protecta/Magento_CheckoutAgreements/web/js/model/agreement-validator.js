/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/validation'
], function ($) {
    'use strict';

    var checkoutConfig = window.checkoutConfig,
        agreementsConfig = checkoutConfig ? checkoutConfig.checkoutAgreements : {},
        agreementsInputPath = '.payment-method._active div.checkout-agreements input';

    return {
        /**
         * Validate checkout agreements
         *
         * @returns {Boolean}
         */
        validate: function () {
            var isValid = true;

            if (!agreementsConfig.isEnabled || $(agreementsInputPath).length === 0) {
                return true;
            }

            $(agreementsInputPath).each(function (index, element) {
                if (!$.validator.validateSingleElement(element, {
                    errorElement: 'div'
                })) {
                    isValid = false;
                }
            });

            if(isValid == false){
                jQuery('html, body').animate({scrollTop: jQuery('.payment-method').offset().top}, 1500);
            }

            return isValid;
        }
    };
});
