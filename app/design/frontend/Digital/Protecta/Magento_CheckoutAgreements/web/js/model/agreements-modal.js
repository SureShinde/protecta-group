/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function ($, modal, $t) {
    'use strict';

    return {
        modalWindow: null,

        /**
         * Create popUp window for provided element.
         *
         * @param {HTMLElement} element
         */
        createModal: function (element) {
            var options;

            this.modalWindow = element;
            options = {
                'type': 'popup',
                'modalClass': 'agreements-modal',
				'title':'Terms and Conditions',
                'responsive': true,
                'innerScroll': true,
                'trigger': '.show-modal'               
            };
            modal(options, $(this.modalWindow));
        },

        /** Show login popup window */
        showModal: function () {
            $(this.modalWindow).modal('openModal');
        }
    };
});
