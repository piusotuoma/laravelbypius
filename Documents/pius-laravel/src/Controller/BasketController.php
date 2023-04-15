<?php

namespace Pius\Shop\Controller;

use Pius\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;


/**
 * Pius controller for basket related functionality.
 */
class BasketController extends Controller
{
	/**
	 * Returns the html for the standard basket page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function indexAction()
	{
		$params = ['page' => 'page-basket-index'];

		foreach( app( 'config' )->get( 'shop.page.basket-index' ) as $name )
		{
			$params['aiheader'][$name] = Shop::get( $name )->header();
			$params['aibody'][$name] = Shop::get( $name )->body();
		}

		return Response::view( Shop::template( 'basket.index' ), $params )
			->header( 'Cache-Control', 'no-store, , max-age=0' );
	}
}