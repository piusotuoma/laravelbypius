<?php

namespace Pius\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Pius controller for the GraphQL Admin API
 */
class GraphqlController extends Controller
{
	use AuthorizesRequests;


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function indexAction( ServerRequestInterface $request )
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [GraphqlController::class, ['admin', 'editor', 'api']] );
		}

		$site = Route::input( 'site', Request::get( 'site', config( 'shop.mshop.locale.site', 'default' ) ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );

		$context = app( 'pius.context' )->get( false, 'backend' );
		$context->setI18n( app( 'pius.i18n' )->get( array( $lang, 'en' ) ) );
		$context->setLocale( app( 'pius.locale' )->getBackend( $context, $site ) );
		$context->setView( app( 'pius.view' )->create( $context, [], $lang ) );

		return \Pius\Admin\Graphql::execute( $context, $request );
	}
}
