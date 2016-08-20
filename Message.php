<?php
namespace Dfe\Stripe;
use Magento\Sales\Model\Order\Payment\Transaction as T;
// 2016-08-20
class Message extends \Df\Core\O {
	/**
	 * 2016-08-20
	 * @param string $key
	 * @param string|null $default
	 * @return string|null|array(string => mixed)
	 */
	public function a($key, $default = null) {return dfa_deep($this->_data, $key, $default);}

	/**
	 * 2016-08-20
	 * @param T $t
	 * @return self
	 */
	public static function i(T $t) {
		/** @var string $class */
		$class = static::class;
		return new $class(df_json_decode(df_trans_raw_details($t, self::key())));
	}

	/**
	 * 2016-08-20
	 * @used-by \Dfe\Stripe\Message::i()
	 * @return string
	 */
	public static function key() {return df_class_last(static::class);}
}


