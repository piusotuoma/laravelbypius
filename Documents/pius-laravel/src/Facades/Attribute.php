<?php

namespace Pius\Shop\Facades;


/**
 * Returns the attribute frontend controller
 */
class Attribute extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Returns a new attribute frontend controller object
	 *
	 * @return \Pius\Controller\Frontend\Attribute\Iface
	 */
	protected static function getFacadeAccessor()
	{
		return \Pius\Controller\Frontend::create( app( 'pius.context' )->get(), 'attribute' );
	}
}
