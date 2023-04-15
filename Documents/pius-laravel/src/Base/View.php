<?php

namespace Pius\Shop\Base;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

/**
 * Service providing the view objects
 */
class View
{
	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Pius\Shop\Base\I18n
	 */
	private $i18n;

	/**
	 * @var \Pius\Shop\Base\Support
	 */
	private $support;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Pius\Shop\Base\I18n $i18n I18n object
	 * @param \Pius\Shop\Base\Support $support Support object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config,
		\Pius\Shop\Base\I18n $i18n, \Pius\Shop\Base\Support $support )
	{
		$this->i18n = $i18n;
		$this->config = $config;
		$this->support = $support;
	}


	/**
	 * Creates the view object for the HTML client.
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @param array $templatePaths List of base path names with relative template paths as key/value pairs
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Pius\Base\View\Iface View object
	 */
	public function create( \Pius\MShop\ContextIface $context, array $templatePaths,
		string $locale = null ) : \Pius\Base\View\Iface
	{
		$engine = new \Pius\Base\View\Engine\Blade( app( 'Illuminate\Contracts\View\Factory' ) );
		$view = new \Pius\Base\View\Standard( $templatePaths, array( '.blade.php' => $engine ) );

		$config = $context->config();
		$session = $context->session();

		$this->addCsrf( $view );
		$this->addAccess( $view, $context );
		$this->addConfig( $view, $config );
		$this->addNumber( $view, $config, $locale );
		$this->addParam( $view );
		$this->addRequest( $view );
		$this->addResponse( $view );
		$this->addSession( $view, $session );
		$this->addTranslate( $view, $locale );
		$this->addUrl( $view );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addAccess( \Pius\Base\View\Iface $view, \Pius\MShop\ContextIface $context ) : \Pius\Base\View\Iface
	{
		if( $this->config->get( 'shop.accessControl', true ) === false
			|| ( ( $user = \Illuminate\Support\Facades\Auth::user() ) !== null && $user->superuser )
		) {
			$helper = new \Pius\Base\View\Helper\Access\All( $view );
		}
		else
		{
			$support = $this->support;

			$fcn = function() use ( $support, $context ) {
				return $support->getGroups( $context );
			};

			$helper = new \Pius\Base\View\Helper\Access\Standard( $view, $fcn );
		}

		$view->addHelper( 'access', $helper );

		return $view;
	}


	/**
	 * Adds the "config" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @param \Pius\Base\Config\Iface $config Configuration object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addConfig( \Pius\Base\View\Iface $view, \Pius\Base\Config\Iface $config ) : \Pius\Base\View\Iface
	{
		$config = new \Pius\Base\Config\Decorator\Protect( clone $config, ['resource/*/baseurl'], ['resource'] );
		$helper = new \Pius\Base\View\Helper\Config\Standard( $view, $config );
		$view->addHelper( 'config', $helper );

		return $view;
	}


	/**
	 * Adds the "access" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addCsrf( \Pius\Base\View\Iface $view ) : \Pius\Base\View\Iface
	{
		$helper = new \Pius\Base\View\Helper\Csrf\Standard( $view, '_token', csrf_token() );
		$view->addHelper( 'csrf', $helper );

		return $view;
	}


	/**
	 * Adds the "number" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @param \Pius\Base\Config\Iface $config Configuration object
	 * @param string|null $locale Code of the current language or null for no translation
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addNumber( \Pius\Base\View\Iface $view, \Pius\Base\Config\Iface $config,
		string $locale = null ) : \Pius\Base\View\Iface
	{
		if( config( 'shop.num_formatter', 'Locale' ) === 'Locale' )
		{
			$pattern = $config->get( 'client/html/common/format/pattern' );
			$helper = new \Pius\Base\View\Helper\Number\Locale( $view, $locale, $pattern );
		}
		else
		{
			$sep1000 = $config->get( 'client/html/common/format/separator1000', '' );
			$decsep = $config->get( 'client/html/common/format/separatorDecimal', '.' );
			$helper = new \Pius\Base\View\Helper\Number\Standard( $view, $decsep, $sep1000 );
		}

		return $view->addHelper( 'number', $helper );
	}


	/**
	 * Adds the "param" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addParam( \Pius\Base\View\Iface $view ) : \Pius\Base\View\Iface
	{
		$params = ( Route::current() ? Route::current()->parameters() : array() ) + Request::all();
		$helper = new \Pius\Base\View\Helper\Param\Standard( $view, $params );
		$view->addHelper( 'param', $helper );

		return $view;
	}


	/**
	 * Adds the "request" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addRequest( \Pius\Base\View\Iface $view ) : \Pius\Base\View\Iface
	{
		$helper = new \Pius\Base\View\Helper\Request\Laravel( $view, Request::instance() );
		$view->addHelper( 'request', $helper );

		return $view;
	}


	/**
	 * Adds the "response" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addResponse( \Pius\Base\View\Iface $view ) : \Pius\Base\View\Iface
	{
		$helper = new \Pius\Base\View\Helper\Response\Laravel( $view );
		$view->addHelper( 'response', $helper );

		return $view;
	}


	/**
	 * Adds the "session" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @param \Pius\Base\Session\Iface $session Session object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addSession( \Pius\Base\View\Iface $view, \Pius\Base\Session\Iface $session ) : \Pius\Base\View\Iface
	{
		$helper = new \Pius\Base\View\Helper\Session\Standard( $view, $session );
		$view->addHelper( 'session', $helper );

		return $view;
	}


	/**
	 * Adds the "translate" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @param string|null $locale ISO language code, e.g. "de" or "de_CH"
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addTranslate( \Pius\Base\View\Iface $view, string $locale = null ) : \Pius\Base\View\Iface
	{
		if( $locale !== null )
		{
			$i18n = $this->i18n->get( array( $locale ) );
			$translation = $i18n[$locale];
		}
		else
		{
			$translation = new \Pius\Base\Translation\None( 'en' );
		}

		$helper = new \Pius\Base\View\Helper\Translate\Standard( $view, $translation );
		$view->addHelper( 'translate', $helper );

		return $view;
	}


	/**
	 * Adds the "url" helper to the view object
	 *
	 * @param \Pius\Base\View\Iface $view View object
	 * @return \Pius\Base\View\Iface Modified view object
	 */
	protected function addUrl( \Pius\Base\View\Iface $view ) : \Pius\Base\View\Iface
	{
		$fixed = [
			'site' => env( 'SHOP_MULTISHOP' ) ? config( 'shop.mshop.locale.site', 'default' ) : '',
			'locale' => env( 'SHOP_MULTILOCALE' ) ? app()->getLocale() : '',
			'currency' => ''
		];

		if( Route::current() )
		{
			$fixed['site'] = Request::route( 'site', $fixed['site'] );
			$fixed['locale'] = Request::route( 'locale', $fixed['locale'] );
			$fixed['currency'] = Request::route( 'currency', $fixed['currency'] );
		}

		$fixed['site'] = Request::input( 'site', $fixed['site'] );
		$fixed['locale'] = Request::input( 'locale', $fixed['locale'] );
		$fixed['currency'] = Request::input( 'currency', $fixed['currency'] );

		$helper = new \Pius\Base\View\Helper\Url\Laravel( $view, app( 'url' ), array_filter( $fixed ) );
		$view->addHelper( 'url', $helper );

		return $view;
	}
}