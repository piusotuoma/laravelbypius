<?php

namespace Pius\Shop\Controller;

use Pius\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;


/**
 * Pius controller for support page request.
 */
class PageController extends Controller
{
	/**
	 * Returns the html for the content pages.
	 *
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function indexAction()
	{
		$params = ['page' => 'page-index'];

		foreach( app( 'config' )->get( 'shop.page.cms', ['cms/page', 'catalog/tree', 'basket/mini'] ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		if( empty( $params['aibody']['cms/page'] ) ) {
			abort( 404 );
		}

		return Response::view( Shop::template( 'page.index' ), $params )
			->header( 'Cache-Control', 'private, max-age=10' );
	}
}
