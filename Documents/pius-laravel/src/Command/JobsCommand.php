<?php

namespace Pius\Shop\Command;

use Illuminate\Console\Command;


/**
 * Command for executing the Pius job controllers
 */
class JobsCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'pius:jobs
		{jobs : One or more job controller names like "admin/job customer/email/watch"}
		{site? : Site codes to execute the jobs for like "default unittest" (none for all)}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Executes the job controllers';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$jobs = $this->argument( 'jobs' );
		$jobs = !is_array( $jobs ) ? explode( ' ', (string) $jobs ) : $jobs;

		$fcn = function( \Pius\MShop\ContextIface $lcontext, \Pius\Bootstrap $pius ) use ( $jobs )
		{
			$jobfcn = function( $context, $pius, $jobname ) {
				\Pius\Controller\Jobs::create( $context, $pius, $jobname )->run();
			};

			$process = $lcontext->process();
			$site = $lcontext->locale()->getSiteItem()->getCode();

			foreach( $jobs as $jobname )
			{
				$this->info( sprintf( 'Executing Pius jobs "%s" for "%s"', $jobname, $site ), 'v' );
				$process->start( $jobfcn, [$lcontext, $pius, $jobname], false );
			}

			$process->wait();
		};

		$this->exec( $this->context(), $fcn, $this->argument( 'site' ) );
	}


	/**
	 * Returns a context object
	 *
	 * @return \Pius\MShop\ContextIface Context object
	 */
	protected function context() : \Pius\MShop\ContextIface
	{
		$lv = $this->getLaravel();
		$context = $lv->make( 'pius.context' )->get( false, 'command' );

		$langManager = \Pius\MShop::create( $context, 'locale/language' );
		$langids = $langManager->search( $langManager->filter( true ) )->keys()->toArray();
		$i18n = $lv->make( 'pius.i18n' )->get( $langids );

		$context->setEditor( 'pius:jobs' );
		$context->setI18n( $i18n );

		return $context;
	}
}
