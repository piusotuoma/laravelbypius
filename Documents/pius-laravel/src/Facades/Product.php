<?php

namespace Pius\Shop\Facades;


/**
 * Returns the product frontend controller
 */
class Product extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new product frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Product\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'product' );
	}
}
