<?php
namespace Dfe\Stripe;
use Magento\Framework\App\ScopeInterface;
class Settings extends \Df\Core\Settings {
	/**
	 * 2016-02-27
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Enable?»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return bool
	 */
	public function enable($s = null) {return $this->b(__FUNCTION__, $s);}
	
	/**
	 * 2016-03-02
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	public function publishableKey($s = null) {
		return $this->test($s) ? $this->testPublishableKey($s) : $this->livePublishableKey($s);
	}

	/**
	 * 2016-03-02
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	public function secretKey($s = null) {
		return $this->test($s) ? $this->testSecretKey($s) : $this->liveSecretKey($s);
	}
	
	/**
	 * 2016-03-02
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Test Mode?»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return bool
	 */
	public function test($s = null) {return $this->b(__FUNCTION__, $s);}	

	/**
	 * @override
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_payment/stripe/';}

	/**
	 * 2016-03-02
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Live Publishable Key»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	private function livePublishableKey($s = null) {return $this->v(__FUNCTION__, $s);}

	/**
	 * 2016-03-02
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Live Secret Key»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	private function liveSecretKey($s = null) {return $this->p(__FUNCTION__, $s);}

	/**
	 * 2016-03-02
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Test Publishable Key»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	private function testPublishableKey($s = null) {return $this->v(__FUNCTION__, $s);}

	/**
	 * 2016-03-02
	 * «Mage2.PRO» → «Payment» → «Stripe» → «Test Secret Key»
	 * @param null|string|int|ScopeInterface $s [optional]
	 * @return string
	 */
	private function testSecretKey($s = null) {return $this->p(__FUNCTION__, $s);}

	/** @return $this */
	public static function s() {static $r; return $r ? $r : $r = df_o(__CLASS__);}
}


