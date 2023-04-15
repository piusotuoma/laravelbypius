<?php

namespace Pius\Shop\Base;


/**
 * Service providing the internationalization objects
 */
class I18n
{
	/**
	 * @var \Pius\Shop\Base\Pius
	 */
	private $pius;

	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var array
	 */
	private $i18n = [];


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Contracts\Config\Repository $config Configuration object
	 * @param \Pius\Shop\Base\Pius $pius Pius object
	 */
	public function __construct( \Illuminate\Contracts\Config\Repository $config, \Pius\Shop\Base\Pius $pius )
	{
		$this->pius = $pius;
		$this->config = $config;
	}


	/**
	 * Creates new translation objects.
	 *
	 * @param array $languageIds List of two letter ISO language IDs
	 * @return \Pius\Base\Translation\Iface[] List of translation objects
	 */
	public function get( array $languageIds ) : array
	{
		$i18nPaths = $this->pius->get()->getI18nPaths();

		foreach( $languageIds as $langid )
		{
			if( !isset( $this->i18n[$langid] ) )
			{
				$i18n = new \Pius\Base\Translation\Gettext( $i18nPaths, $langid );

				if( $this->config->get( 'shop.apc_enabled', false ) == true ) {
					$i18n = new \Pius\Base\Translation\Decorator\APC( $i18n, $this->config->get( 'shop.apc_prefix', 'laravel:' ) );
				}

				if( $this->config->has( 'shop.i18n.' . $langid ) ) {
					$i18n = new \Pius\Base\Translation\Decorator\Memory( $i18n, $this->config->get( 'shop.i18n.' . $langid ) );
				}

				$this->i18n[$langid] = $i18n;
			}
		}

		return $this->i18n;
	}
}