/*
 * *
 *  Copyright © 2016 Mageplaza. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */

/**
 * Customer store credit(balance) application
 */
/*global define,alert*/
define(
    [
        'ko',
        'jquery',
        'mage/storage'
    ],
    function (ko, $, storage) {
        'use strict';
        return function () {
            var deferred = $.Deferred();
            var deliveryDate, oscComment, newsletter, securityCode = '', ship_po_number, ship_due_date, pg_delivery_phone, pg_delivery_contact;
            if ($('input[name="delivery-date"]').length > 0) {
                deliveryDate = $('input[name="delivery-date"]').val();
            } else {
                deliveryDate = '';
            }

            if ($('input[name="delivery-comment"]').length > 0) {
                oscComment = $('input[name="delivery-comment"]').val();
            } else {
                oscComment = '';
            }
            if ($('input[name="delivery-date"]').length > 0) {
                ship_due_date = $('input[name="delivery-date"]').val();
            } else {
                ship_due_date = '';
            }
            if ($('input[name="house-security-code"]').length > 0) {
                securityCode = $('input[name="house-security-code"]').val();
            } else {
                securityCode = '';
            }

            if ($('input[name="newsletter_subscriber_checkbox"]').length > 0) {
                if ($('input[name="newsletter_subscriber_checkbox"]').attr('checked') == 'checked') {
                    newsletter = 1;
                } else {
                    newsletter = 0;
                }
            }
            var deliveryTime = '';
            if ($('input[name="delivery_time"]').length > 0) {
                if ($('input[name="delivery_time"]').val()) {
                    deliveryTime = $('input[name="delivery_time"]').val();
                } else {
                    deliveryTime = '';
                }
            }

            if ($('input[name="house-security-code"]').length > 0) {
                ship_po_number = $('input[name="house-security-code"]').val();
            } else {
                ship_po_number = '';
            }

            if ($('input[name="pg_delivery_phone"]').length > 0) {
                pg_delivery_phone = $('input[name="pg_delivery_phone"]').val();
            } else {
                pg_delivery_phone = '';
            }

            if ($('input[name="pg_delivery_contact"]').length > 0) {
                pg_delivery_contact = $('input[name="pg_delivery_contact"]').val();
            } else {
                pg_delivery_contact = '';
            }

            var params = {
                'osc_delivery_date': deliveryDate,
                'osc_comment': oscComment,
                'osc_newsletter': newsletter,
                'osc_security_code': securityCode,
                'osc_delivery_time': deliveryTime,
                'ship_due_date': ship_due_date,
                'ship_po_number': ship_po_number,
                'pg_delivery_phone': pg_delivery_phone,
                'pg_delivery_contact': pg_delivery_contact
            };
            console.log(params);
            storage.post(
                'onestepcheckout/index/saveCustomCheckoutData',
                JSON.stringify(params),
                false
            ).done(
                function (result) {
                    // console.log('success---------', result)
                }
            ).fail(
                function (result) {
                    console.log('failed-------------', result)
                }
            ).always(
                function (result) {
                    // console.log('always-----------', result)
                    deferred.resolve(result);
                }
            );
            return deferred;
        };
    }
);
