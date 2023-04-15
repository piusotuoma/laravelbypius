<?php

namespace Pius\Shop\Command;

use Illuminate\Console\Command;


/**
 * Common base class for all commands
 */
abstract class AbstractCommand extends Command
{
	/**
	 * Executes the function for all given sites
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @param \Closure $fcn Function to execute
	 * @param array|string|null $sites Site codes
	 */
	protected function exec( \Pius\MShop\ContextIface $context, \Closure $fcn, $sites )
	{
		$process = $context->process();
		$pius = $this->getLaravel()->make( 'pius' )->get();

		$siteManager = \Pius\MShop::create( $context, 'locale/site' );
		$localeManager = \Pius\MShop::create( $context, 'locale' );
		$filter = $siteManager->filter();
		$start = 0;

		if( !empty( $sites ) ) {
			$filter->add( ['locale.site.code' => !is_array( $sites ) ? explode( ' ', (string) $sites ) : $sites] );
		}

		do
		{
			$siteItems = $siteManager->search( $filter->slice( $start ) );

			foreach( $siteItems as $siteItem )
			{
				\Pius\MShop::cache( true );
				\Pius\MAdmin::cache( true );

				$localeItem = $localeManager->bootstrap( $siteItem->getCode(), '', '', false );
				$localeItem->setLanguageId( null );
				$localeItem->setCurrencyId( null );

				$lcontext = clone $context;
				$lcontext->setLocale( $localeItem );

				$tmplPaths = $pius->getTemplatePaths( 'controller/jobs/templates', $siteItem->getTheme() );
				$view = $this->getLaravel()->make( 'pius.view' )->create( $lcontext, $tmplPaths );
				$lcontext->setView( $view );

				$config = $lcontext->config();
				$config->apply( $siteItem->getConfig() );

				$process->start( $fcn, [$lcontext, $pius], false );
			}

			$count = count( $siteItems );
			$start += $count;
		}
		while( $count === $filter->getLimit() );

		$process->wait();
	}
}