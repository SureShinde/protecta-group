define([
    'jquery',
    'mage/translate',
    'Magento_Ui/js/model/messageList',
    'Magento_Checkout/js/checkout-data'
], function ($, $t, messageList, checkoutData) {
    'use strict';
    return {
        validate: function () {
            const deliveryPhone = $('#pg_delivery_phone').val();
            const deliveryContact = $('#pg_delivery_contact').val();
            const deliveryDate = $('#mp-delivery-date').val();
            const poNumber = $('#mp-house-security-code').val();

            $("#ship_po_number_validation_msg").hide();
            $("#ship_due_date_validation_msg").hide();
            $("#pg_delivery_phone_validation_msg").hide();
            $("#pg_delivery_contact_validation_msg").hide();

            if (poNumber == '' || deliveryDate == '' || deliveryPhone == '' || deliveryContact == '') {
                if (poNumber == '') {
                    $("#ship_po_number_validation_msg").show();
                }
                if (deliveryDate == '') {
                    $("#ship_due_date_validation_msg").show();
                }
                if (deliveryPhone == '') {
                    $("#pg_delivery_phone_validation_msg").show();
                }

                if (deliveryContact == '') {
                    $("#pg_delivery_contact_validation_msg").show();
                }

                return false;
            }

            return true;
        }
    }
});
