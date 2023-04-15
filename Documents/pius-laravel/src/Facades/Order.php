<?php

namespace Pius\Shop\Facades;


/**
 * Returns the order frontend controller
 */
class Order extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new order frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Order\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'order' );
	}
}
