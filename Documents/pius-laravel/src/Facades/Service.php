<?php

namespace Pius\Shop\Facades;


/**
 * Returns the service frontend controller
 */
class Service extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new service frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Service\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'service' );
	}
}
