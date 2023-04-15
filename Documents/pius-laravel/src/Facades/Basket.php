<?php

namespace Pius\Shop\Facades;


/**
 * Returns the basket frontend controller
 */
class Basket extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new basket frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Basket\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'basket' );
	}
}
