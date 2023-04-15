<?php

namespace Pius\Shop\Controller;

use Pius\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;


/**
 * Pius controller for account related functionality.
 */
class AccountController extends Controller
{
	/**
	 * Returns the html for the "My account" page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function indexAction()
	{
		$params = ['page' => 'page-account-index'];

		foreach( app( 'config' )->get( 'shop.page.account-index' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'account.index' ), $params )
			->header( 'Cache-Control', 'no-store, max-age=0' );
	}


	/**
	 * Returns the html for the "My account" download page.
	 *
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	public function downloadAction()
	{
		$response = Shop::get( 'account/download' )->response();
		return Response::make( (string) $response->getBody(), $response->getStatusCode(), $response->getHeaders() );
	}
}