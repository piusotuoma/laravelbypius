<?php

namespace Pius\Shop\Controller;

use Pius\Shop\Facades\Shop;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;


/**
 * Pius controller for supplier related functionality.
 */
class SupplierController extends Controller
{
	/**
	 * Returns the html for the supplier detail page.
	 *
	 * @return \Illuminate\Http\Response Response object with output and headers
	 */
	public function detailAction()
	{
		try
		{
			$params = ['page' => 'page-supplier-detail'];

			foreach( app( 'config' )->get( 'shop.page.supplier-detail' ) as $name )
			{
				$params['aiheader'][$name] = Shop::get( $name )->header();
				$params['aibody'][$name] = Shop::get( $name )->body();
			}

			return Response::view( Shop::template( 'supplier.detail' ), $params )
				->header( 'Cache-Control', 'private, max-age=10' );
		}
		catch( \Exception $e )
		{
			if( $e->getCode() >= 400 && $e->getCode() < 600 ) { abort( $e->getCode() ); }
			throw $e;
		}
	}
}