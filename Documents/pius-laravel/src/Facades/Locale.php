<?php

namespace Pius\Shop\Facades;


/**
 * Returns the locale frontend controller
 */
class Locale extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new locale frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Locale\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'locale' );
	}
}
