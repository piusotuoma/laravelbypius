<?php

namespace Pius\Shop\Facades;


/**
 * Returns the CMS frontend controller
 */
class Cms extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new CMS frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Product\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'cms' );
	}
}
