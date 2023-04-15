<?php

namespace Pius\Shop\Facades;


/**
 * Returns the stock frontend controller
 */
class Stock extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new stock frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Stock\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'stock' );
	}
}
