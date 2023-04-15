<?php

namespace Pius\Shop\Facades;


/**
 * Returns the customer frontend controller
 */
class Customer extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new customer frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Customer\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'customer' );
	}
}
