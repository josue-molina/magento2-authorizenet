define([
    'Magento_Payment/js/view/payment/cc-form'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Pronko_Authorizenet/payment/cc-form',
            code: 'pronko_authorizenet'
        },

        getCode: function () {
            return this.code;
        },

        isActive: function () {
            return this.getCode() == this.isChecked();
        }
    });
});
