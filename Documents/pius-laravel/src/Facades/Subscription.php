<?php

namespace Pius\Shop\Facades;


/**
 * Returns the subscription frontend controller
 */
class Subscription extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new subscription frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Subscription\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'subscription' );
	}
}
