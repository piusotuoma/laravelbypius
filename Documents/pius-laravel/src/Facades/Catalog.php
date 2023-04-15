<?php

namespace Pius\Shop\Facades;


/**
 * Returns the catalog frontend controller
 */
class Catalog extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new catalog frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Catalog\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'catalog' );
	}
}
