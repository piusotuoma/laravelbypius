<?php

namespace Pius\Shop\Base;

/**
 * Service providing the shop object
 */
class Shop
{
	/**
	 * @var \Pius\MShop\ContextIface
	 */
	private $context;

	/**
	 * @var \Pius\Base\View\Iface
	 */
	private $view;

	/**
	 * @var array
	 */
	private $objects = [];


	/**
	 * Initializes the object
	 *
	 * @param \Pius\Shop\Base\Pius $pius Pius object
	 * @param \Pius\Shop\Base\Context $context Context object
	 * @param \Pius\Shop\Base\View $view View object
	 */
	public function __construct( \Pius\Shop\Base\Pius $pius,
		\Pius\Shop\Base\Context $context, \Pius\Shop\Base\View $view )
	{
		$this->context = $context->get();
		$locale = $this->context->locale();

		$tmplPaths = $pius->get()->getTemplatePaths( 'client/html/templates', $locale->getSiteItem()->getTheme() );
		$langid = $locale->getLanguageId();

		$this->view = $view->create( $this->context, $tmplPaths, $langid );
		$this->context->setView( $this->view );
	}


	/**
	 * Returns the HTML client for the given name
	 *
	 * @param string $name Name of the shop component
	 * @return \Pius\Client\Html\Iface HTML client
	 */
	public function get( string $name ) : \Pius\Client\Html\Iface
	{
		if( !isset( $this->objects[$name] ) )
		{
			$client = \Pius\Client\Html::create( $this->context, $name );
			$client->setView( clone $this->view );
			$client->init();

			$this->objects[$name] = $client;
		}

		return $this->objects[$name];
	}


	/** Returns the view template for the given name
	 *
	 * @param string $name View name, e.g. "account.index"
	 * @return string Template name, e.g. "shop::account.indx"
	 */
	public function template( string $name ) : string
	{
		$theme = $this->context->locale()->getSiteItem()->getTheme();
		return \Illuminate\Support\Facades\View::exists( $theme . '::' . $name ) ? $theme . '::' . $name : 'shop::' . $name;
	}
}
