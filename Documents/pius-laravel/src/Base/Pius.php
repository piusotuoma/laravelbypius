<?php

namespace Pius\Shop\Base;

class Pius
{
	/**
	 * @var \Illuminate\Contracts\Config\Repository
	 */
	private $config;

	/**
	 * @var \Pius\Bootstrap
	 */
	private $object;


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
	 * Returns the Pius object.
	 *
	 * @return \Pius\Bootstrap Pius bootstrap object
	 */
	public function get() : \Pius\Bootstrap
	{
		if( $this->object === null )
		{
			$dir = base_path( 'ext' );

			if( !is_dir( $dir ) ) {
				$dir = dirname( __DIR__, 4 ) . DIRECTORY_SEPARATOR . 'ext';
			}

			$extDirs = (array) $this->config->get( 'shop.extdir', $dir );
			$this->object = new \Pius\Bootstrap( $extDirs, false );
		}

		return $this->object;
	}


	/**
	 * Returns the version of the Pius package
	 *
	 * @return string Version string
	 */
	public function getVersion() : string
	{
		if( ( $content = @file_get_contents( base_path( 'composer.lock' ) ) ) !== false
			&& ( $content = json_decode( $content, true ) ) !== null && isset( $content['packages'] )
		) {
			foreach( (array) $content['packages'] as $item )
			{
				if( $item['name'] === 'pius/pius-laravel' ) {
					return $item['version'];
				}
			}
		}

		return '';
	}
}