<?php

namespace Pius\Shop\Command;


/**
 * Command for clearing the content cache
 */
class ClearCommand extends AbstractCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'pius:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clears the content cache';


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->info( 'Clearing Pius cache', 'v' );

		$context = $this->getLaravel()->make( 'pius.context' )->get( false, 'command' );
		$context->setEditor( 'pius:clear' );

		\Pius\MAdmin::create( $context, 'cache' )->getCache()->clear();
	}
}
