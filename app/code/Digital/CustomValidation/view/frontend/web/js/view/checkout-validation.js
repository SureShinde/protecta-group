define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Digital_CustomValidation/js/model/checkout-validation',
    ],
    function (
        Component,
        additionalValidators,
        checkoutValidator,
    ) {
        'use strict';
        additionalValidators.registerValidator(checkoutValidator);
        return Component.extend({});
    }
);
