<?php

namespace Pius\Shop\Base;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


/**
 * Service providing the context objects
 */
class Locale
{
	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Pius\MShop\Locale\Item\Iface
	 */
	private $locale;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config )
	{
		$this->config = $config;
	}


	/**
	 * Returns the locale item for the current request
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\Locale\Item\Iface Locale item object
	 */
	public function get( \Pius\MShop\ContextIface $context ) : \Pius\MShop\Locale\Item\Iface
	{
		if( $this->locale === null )
		{
			$site = config( 'shop.mshop.locale.site', 'default' );
			$lang = app()->getLocale();
			$currency = '';

			if( Route::current() )
			{
				$site = Request::route( 'site', $site );
				$lang = Request::route( 'locale', $lang );
				$currency = Request::route( 'currency', $currency );
			}

			$site = Request::input( 'site', $site );
			$lang = Request::input( 'locale', $lang );
			$currency = Request::input( 'currency', $currency );

			$localeManager = \Pius\MShop::create( $context, 'locale' );
			$disableSites = $this->config->get( 'shop.disableSites', true );

			$this->locale = $localeManager->bootstrap( $site, $lang, $currency, $disableSites );
		}

		return $this->locale;
	}


	/**
	 * Returns the locale item for the current request
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @param string $site Unique site code
	 * @return \Pius\MShop\Locale\Item\Iface Locale item object
	 */
	public function getBackend( \Pius\MShop\ContextIface $context, string $site ) : \Pius\MShop\Locale\Item\Iface
	{
		$localeManager = \Pius\MShop::create( $context, 'locale' );

		try {
			$localeItem = $localeManager->bootstrap( $site, '', '', false, null, true );
		} catch( \Pius\MShop\Exception $e ) {
			$localeItem = $localeManager->create();
		}

		return $localeItem->setCurrencyId( null )->setLanguageId( null );
	}
}
