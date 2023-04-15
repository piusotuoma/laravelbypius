<?php

namespace Pius\Shop\Facades;


/**
 * Returns the HTML clients
 *
 * @method static \Pius\Client\Html\Iface get()
 */
class Shop extends \Illuminate\Support\Facades\Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'pius.shop';
	}
}
