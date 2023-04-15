<?php

namespace Pius\Shop\Base;

/**
 * Service providing the config object
 */
class Config
{
	/**
	 * @var \Pius\Shop\Base\Config[]
	 */
	private $objects = [];

	/**
	 * @var \Pius\Shop\Base\Pius
	 */
	private $pius;

	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;


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
	 * Creates a new configuration object.
	 *
	 * @param string $type Configuration type ("frontend" or "backend")
	 * @return \Pius\Base\Config\Iface Configuration object
	 */
	public function get( string $type = 'frontend' ) : \Pius\Base\Config\Iface
	{
		if( !isset( $this->objects[$type] ) )
		{
			$configPaths = $this->pius->get()->getConfigPaths();
			$cfgfile = dirname( dirname( __DIR__ ) ) . '/config/default.php';

			$config = new \Pius\Base\Config\PHPArray( require $cfgfile, $configPaths );

			if( $this->config->get( 'shop.apc_enabled', false ) == true ) {
				$config = new \Pius\Base\Config\Decorator\APC( $config, $this->config->get( 'shop.apc_prefix', 'laravel:' ) );
			}

			$config = new \Pius\Base\Config\Decorator\Memory( $config, $this->config->get( 'shop' ) );

			if( ( $conf = $this->config->get( 'shop.' . $type, array() ) ) !== array() ) {
				$config = new \Pius\Base\Config\Decorator\Memory( $config, $conf );
			}

			$this->objects[$type] = $config;
		}

		return $this->objects[$type];
	}
}
