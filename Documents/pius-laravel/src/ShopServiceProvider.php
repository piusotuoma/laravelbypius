<?php

namespace Pius\Shop;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Pius\Shop\ReportMedia\CSVReport;
use Pius\Shop\ReportMedia\ExcelReport;
use Pius\Shop\ReportMedia\PdfReport;

/**
 * Pius shop service provider for Laravel
 */
class ShopServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom( dirname( __DIR__ ) . '/views', 'shop' );
		$this->loadRoutesFrom( dirname( __DIR__ ) . '/routes/pius.php' );

		$this->publishes( [dirname( __DIR__ ) . '/config/shop.php' => config_path( 'shop.php' )], 'config' );
		$this->publishes( [dirname( __DIR__ ) . '/public' => public_path( 'vendor/shop' )], 'public' );
		
		$this->loadViewsFrom(__DIR__ . '/views', 'pius');

        $this->publishes([
            __DIR__ . '/../config/report-generator.php' => config_path('report-generator.php')
        ], 'laravel-report:config');

        
		if( file_exists( $basepath = base_path( 'ext' ) ) )
		{
			foreach( new \DirectoryIterator( $basepath ) as $entry )
			{
				if( $entry->isDir() && !$entry->isDot() && file_exists( $entry->getPathName() . '/themes/client/html' ) ) {
					$this->publishes( [$entry->getPathName() . 'themes/client/html/' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}

		$class = '\Composer\InstalledVersions';

		if( class_exists( $class ) && method_exists( $class, 'getInstalledPackagesByType' ) )
		{
			$extdir = base_path( 'ext' );
			$packages = \Composer\InstalledVersions::getInstalledPackagesByType( 'pius-extension' );

			foreach( $packages as $package )
			{
				$path = realpath( \Composer\InstalledVersions::getInstallPath( $package ) );

				if( strncmp( $path, $extdir, strlen( $extdir ) ) && file_exists( $path . '/themes/client/html' ) ) {
					$this->publishes( [$path . '/themes/client/html' => public_path( 'vendor/shop/themes' )], 'public' );
				}
			}
		}
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom( dirname( __DIR__ ) . '/config/default.php', 'shop' );

		$this->app->singleton( 'pius', function( $app ) {
			return new \Pius\Shop\Base\Pius( $app['config'] );
		});

		$this->app->singleton( 'pius.config', function( $app ) {
			return new \Pius\Shop\Base\Config( $app['config'], $app['pius'] );
		});

		$this->app->singleton( 'pius.i18n', function( $app ) {
			return new \Pius\Shop\Base\I18n( $this->app['config'], $app['pius'] );
		});

		$this->app->singleton( 'pius.locale', function( $app ) {
			return new \Pius\Shop\Base\Locale( $app['config'] );
		});

		$this->app->singleton( 'pius.context', function( $app ) {
			return new \Pius\Shop\Base\Context( $app['session.store'], $app['pius.config'], $app['pius.locale'], $app['pius.i18n'] );
		});

		$this->app->singleton( 'pius.support', function( $app ) {
			return new \Pius\Shop\Base\Support( $app['pius.context'], $app['pius.locale'] );
		});

		$this->app->singleton( 'pius.view', function( $app ) {
			return new \Pius\Shop\Base\View( $app['config'], $app['pius.i18n'], $app['pius.support'] );
		});

		$this->app->singleton( 'pius.shop', function( $app ) {
			return new \Pius\Shop\Base\Shop( $app['pius'], $app['pius.context'], $app['pius.view'] );
		});
        
		$this->app->singleton(Mpesa::class, function () {
            return new Mpesa();
        });

         $this->app->singleton('pdf.report.generator', function ($app) {
            return new PdfReport ($app);
        });
        $this->app->singleton('excel.report.generator', function ($app) {
            return new ExcelReport ($app);
        });
        $this->app->singleton('csv.report.generator', function ($app) {
            return new CSVReport ($app);
        });

		$this->commands( array(
			'Pius\Shop\Command\AccountCommand',
			'Pius\Shop\Command\ClearCommand',
			'Pius\Shop\Command\SetupCommand',
			'Pius\Shop\Command\JobsCommand',
		) );
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
			'Pius\Shop\Base\Pius', 'Pius\Shop\Base\I18n', 'Pius\Shop\Base\Context',
			'Pius\Shop\Base\Config', 'Pius\Shop\Base\Locale', 'Pius\Shop\Base\View',
			'Pius\Shop\Base\Support', 'Pius\Shop\Base\Shop',
			'Pius\Shop\Command\AccountCommand', 'Pius\Shop\Command\ClearCommand',
			'Pius\Shop\Command\SetupCommand', 'Pius\Shop\Command\JobsCommand',
		);
	}

}