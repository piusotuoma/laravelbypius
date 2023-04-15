<?php

namespace Pius\Shop\Facades;


/**
 * Returns the supplier frontend controller
 */
class Supplier extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new supplier frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Supplier\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'supplier' );
	}
}
