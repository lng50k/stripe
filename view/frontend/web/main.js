define([
	'Df_StripeClone/main', 'https://js.stripe.com/v2/'
], function(parent) {'use strict'; return parent.extend({
	/**
	 * 2016-03-01
	 * 2016-03-08
	 * Раньше реализация была такой:
	 * return _.keys(this.getCcAvailableTypes())
	 *
	 * https://support.stripe.com/questions/which-cards-and-payment-types-can-i-accept-with-stripe
	 * «Which cards and payment types can I accept with Stripe?
	 * With Stripe, you can charge almost any kind of credit or debit card:
	 * U.S. businesses can accept
			Visa, MasterCard, American Express, JCB, Discover, and Diners Club.
	 * Australian, Canadian, European, and Japanese businesses can accept
	 * 		Visa, MasterCard, and American Express.»
	 *
	 * Не стал делать реализацию на сервере, потому что там меня не устраивал
	 * порядок следования платёжных систем (первой была «American Express»)
	 * https://github.com/magento/magento2/blob/cf7df72/app/code/Magento/Payment/etc/payment.xml#L10-L44
	 * А изменить этот порядок коротко не получается:
	 * https://github.com/magento/magento2/blob/487f5f45/app/code/Magento/Payment/Model/CcGenericConfigProvider.php#L105-L124
	 * 
	 * 2017-02-05
	 * The bank card network codes: https://mage2.pro/t/2647
	 *
	 * @returns {String[]}
	 */
	getCardTypes: function() {
		return ['VI', 'MC', 'AE'].concat(!this.config('isUS') ? [] : ['JCB', 'DI', 'DN']);
	},
	/**
	 * 2016-03-02
	 * @returns {Object}
	*/
	initialize: function() {
		this._super();
		Stripe.setPublishableKey(this.publicKey());
		return this;
	},
	
    /**
	 * 2017-02-16
	 * @override
	 * @see ...
	 * @used-by placeOrder()
	 * @param {Object|Number} status
	 * @returns {Boolean}
	 */
	tokenCheckStatus: function(status) {return 200 === status;},	

    /**
	 * 2017-02-16
	 * @override
	 * @see ...
	 * @used-by placeOrder()
	 * @param {Object} params
	 * @param {Function} callback
	 * @returns {Function}
	 */
	tokenCreate: function(params, callback) {return Stripe.card.createToken(params, callback);},
	
    /**
	 * 2017-02-16
	 * https://stripe.com/docs/api#errors
	 * @override
	 * @see ...
	 * @used-by placeOrder()
	 * @param {Object|Number} status
	 * @param {Object} resp
	 * @returns {String}
	 */
	tokenErrorMessage: function(status, resp) {return resp.error.message;},	
	
    /**
	 * 2017-02-16
	 * @override
	 * @see ...
	 * @used-by placeOrder()
	 * @param {Object} resp
	 * @returns {String}
	 */
	tokenFromResponse: function(resp) {return resp.id;},	

    /**
	 * 2017-02-16
	 * @override
	 * @see ...
	 * @used-by placeOrder()
	 * @returns {Object}
	 */
	tokenParams: function() {return {
		cvc: this.creditCardVerificationNumber()
		,exp_month: this.creditCardExpMonth()
		,exp_year: this.creditCardExpYear()
		// 2017-02-16
		// https://stripe.com/docs/stripe.js#card-createToken
		,name: this.cardholder()
		,number: this.creditCardNumber()
	};}
});});