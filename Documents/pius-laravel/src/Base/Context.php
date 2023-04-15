<?php

namespace Pius\Shop\Base;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


/**
 * Service providing the context objects
 */
class Context
{
	/**
	 * @var \Pius\MShop\ContextIface
	 */
	private $context;

	/**
	 * @var \Pius\Shop\Base\Config
	 */
	private $config;

	/**
	 * @var \Pius\Shop\Base\I18n
	 */
	private $i18n;

	/**
	 * @var \Pius\Shop\Base\Locale
	 */
	private $locale;

	/**
	 * @var \Illuminate\Session\Store
	 */
	private $session;


	/**
	 * Initializes the object
	 *
	 * @param \Illuminate\Session\Store $session Laravel session object
	 * @param \Pius\Shop\Base\Config $config Configuration object
	 * @param \Pius\Shop\Base\Locale $locale Locale object
	 * @param \Pius\Shop\Base\I18n $i18n Internationalisation object
	 */
	public function __construct( \Illuminate\Session\Store $session, \Pius\Shop\Base\Config $config, \Pius\Shop\Base\Locale $locale, \Pius\Shop\Base\I18n $i18n )
	{
		$this->session = $session;
		$this->config = $config;
		$this->locale = $locale;
		$this->i18n = $i18n;
	}


	/**
	 * Returns the current context
	 *
	 * @param bool $locale True to add locale object to context, false if not (deprecated, use \Pius\Shop\Base\Locale)
	 * @param string $type Configuration type, i.e. "frontend" or "backend" (deprecated, use \Pius\Shop\Base\Config)
	 * @return \Pius\MShop\ContextIface Context object
	 */
	public function get( bool $locale = true, string $type = 'frontend' ) : \Pius\MShop\ContextIface
	{
		$config = $this->config->get( $type );

		if( $this->context === null )
		{
			$context = new \Pius\MShop\Context();
			$context->setConfig( $config );

			$this->addDataBaseManager( $context );
			$this->addFilesystemManager( $context );
			$this->addMessageQueueManager( $context );
			$this->addLogger( $context );
			$this->addCache( $context );
			$this->addMailer( $context );
			$this->addNonce( $context );
			$this->addPassword( $context );
			$this->addProcess( $context );
			$this->addSession( $context );
			$this->addToken( $context );
			$this->addUser( $context );
			$this->addGroups( $context );

			$this->context = $context;
		}

		$this->context->setConfig( $config );

		if( $locale === true )
		{
			$localeItem = $this->locale->get( $this->context );
			$this->context->setLocale( $localeItem );
			$this->context->setI18n( $this->i18n->get( array( $localeItem->getLanguageId() ) ) );

			$config->apply( $localeItem->getSiteItem()->getConfig() );
		}

		return $this->context;
	}


	/**
	 * Adds the cache object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object including config
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addCache( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$cache = (new \Pius\MAdmin\Cache\Manager\Standard( $context ))->getCache();

		return $context->setCache( $cache );
	}


	/**
	 * Adds the database manager object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addDatabaseManager( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$dbm = new \Pius\Base\DB\Manager\Standard( $context->config()->get( 'resource', [] ), 'DBAL' );

		return $context->setDatabaseManager( $dbm );
	}


	/**
	 * Adds the filesystem manager object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addFilesystemManager( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$config = $context->config()->get( 'resource' );
		$fs = new \Pius\Base\Filesystem\Manager\Laravel( app( 'filesystem' ), $config, storage_path( 'pius' ) );

		return $context->setFilesystemManager( $fs );
	}


	/**
	 * Adds the logger object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addLogger( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$logger = \Pius\MAdmin::create( $context, 'log' );

		return $context->setLogger( $logger );
	}



	/**
	 * Adds the mailer object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addMailer( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$mail = new \Pius\Base\Mail\Laravel( function() { return app( 'mailer' ); } );

		return $context->setMail( $mail );
	}


	/**
	 * Adds the message queue manager object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addMessageQueueManager( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$mq = new \Pius\Base\MQueue\Manager\Standard( $context->config()->get( 'resource', [] ) );

		return $context->setMessageQueueManager( $mq );
	}


	/**
	 * Adds the nonce value for inline JS to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addNonce( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		return $context->setNonce( base64_encode( random_bytes( 16 ) ) );
	}


	/**
	 * Adds the password hasher object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addPassword( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		return $context->setPassword( new \Pius\Base\Password\Standard() );
	}


	/**
	 * Adds the process object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addProcess( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$config = $context->config();
		$max = $config->get( 'pcntl_max', 4 );
		$prio = $config->get( 'pcntl_priority', 19 );

		$process = new \Pius\Base\Process\Pcntl( $max, $prio );
		$process = new \Pius\Base\Process\Decorator\Check( $process );

		return $context->setProcess( $process );
	}


	/**
	 * Adds the session object to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addSession( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$session = new \Pius\Base\Session\Laravel( $this->session );

		return $context->setSession( $session );
	}


	/**
	 * Adds the session token to the context
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addToken( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		if( ( $token = Session::get( 'token' ) ) === null ) {
			Session::put( 'token', $token = Session::getId() );
		}

		return $context->setToken( $token );
	}


	/**
	 * Adds the user ID and name if available
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addUser( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$key = collect( config( 'shop.routes' ) )
			->where( 'prefix', optional( Route::getCurrentRoute() )->getPrefix() )
			->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( $user = Auth::guard( $guard )->user() ) {
			$context->setEditor( $user->name ?? (string) \Request::ip() );
			$context->setUserId( $user->getAuthIdentifier() );
		} elseif( $ip = \Request::ip() ) {
			$context->setEditor( $ip );
		}

		return $context;
	}


	/**
	 * Adds the group IDs if available
	 *
	 * @param \Pius\MShop\ContextIface $context Context object
	 * @return \Pius\MShop\ContextIface Modified context object
	 */
	protected function addGroups( \Pius\MShop\ContextIface $context ) : \Pius\MShop\ContextIface
	{
		$key = collect( config( 'shop.routes' ) )
			->where( 'prefix', optional( Route::getCurrentRoute() )
			->getPrefix() )
			->keys()->first();
		$guard = data_get( config( 'shop.guards' ), $key, Auth::getDefaultDriver() );

		if( $userid = Auth::guard( $guard )->id() )
		{
			$context->setGroupIds( function() use ( $context, $userid ) {
				try {
					return \Pius\MShop::create( $context, 'customer' )->get( $userid, ['customer/group'] )->getGroups();
				} catch( \Exception $e ) {
					return [];
				}
			} );
		}

		return $context;
	}
}
