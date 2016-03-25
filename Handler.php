<?php
namespace Dfe\Stripe;
use Dfe\Stripe\Handler\_Default as _Default;
abstract class Handler extends \Df\Core\O {
	/**
	 * 2016-03-25
	 * @used-by \Dfe\Stripe\Handler::process()
	 * @return void
	 */
	abstract protected function process();

	/**
	 * 2016-03-25
	 * @param array(string => mixed) $request
	 * @return void
	 */
	public static function p(array $request) {
		// 2016-03-18
		// https://stripe.com/docs/api#event_object-type
		// Пример события с обоими разделителями: «charge.dispute.funds_reinstated»
		/** @var string $suffix */
		$suffix = df_implode_class(df_explode_multiple(['.', '_'], $request['type']));
		$class = df_convention(__CLASS__, $suffix, _Default::class);
		/** @var Handler $i */
		$i = new $class($request);
		$i->process();
	}
}