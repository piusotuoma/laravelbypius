<?php

namespace Pius\Shop\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Command for initializing or updating the Pius database tables
 */
class SetupCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'pius:setup
		{site? : Site for updating database entries}
		{tplsite=default : Site used as template for creating the new one}
		{--q : Quiet}
		{--v=v : Verbosity level}
		{--option= : Setup configuration, name and value are separated by colon like "setup/default/demo:1"}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize or update the Pius database tables';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		\Pius\MShop::cache( false );
		\Pius\MAdmin::cache( false );

		$template = $this->argument( 'tplsite' );

		if( ( $site = $this->argument( 'site' ) ) === null ) {
			$site = config( 'shop.mshop.locale.site', 'default' );
		}

		$boostrap = $this->getLaravel()->make( 'pius' )->get();
		$ctx = $this->getLaravel()->make( 'pius.context' )->get( false, 'command' );

		$this->info( sprintf( 'Initializing or updating the Pius database tables for site "%1$s"', $site ) );

		\Pius\Setup::use( $boostrap )
			->verbose( $this->option( 'q' ) ? '' : $this->option( 'v' ) )
			->context( $this->addConfig( $ctx->setEditor( 'pius:setup' ) ) )
			->up( $site, $template );
	}


	/**
	 * Adds the configuration options from the input object to the given context
	 *
	 * @param \Pius\MShop\ContextIface $ctx Context object
	 * @return array Associative list of key/value pairs of configuration options
	 */
	protected function addConfig( \Pius\MShop\ContextIface $ctx ) : \Pius\MShop\ContextIface
	{
		$config = $ctx->config();

		foreach( (array) $this->option( 'option' ) as $option )
		{
			list( $name, $value ) = explode( ':', $option );
			$config->set( $name, $value );
		}

		return $ctx;
	}
}
