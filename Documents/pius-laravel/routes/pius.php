<?php

if( ( $conf = config( 'shop.routes.admin', ['prefix' => 'admin', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), '', array(
			'as' => 'pius_shop_admin',
			'uses' => 'Pius\Shop\Controller\AdminController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jqadm', ['prefix' => 'admin/{site}/jqadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET' ), 'file/{type}', array(
			'as' => 'pius_shop_jqadm_file',
			'uses' => 'Pius\Shop\Controller\JqadmController@fileAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'POST' ), 'batch/{resource}', array(
			'as' => 'pius_shop_jqadm_batch',
			'uses' => 'Pius\Shop\Controller\JqadmController@batchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), 'copy/{resource}/{id}', array(
			'as' => 'pius_shop_jqadm_copy',
			'uses' => 'Pius\Shop\Controller\JqadmController@copyAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), 'create/{resource}', array(
			'as' => 'pius_shop_jqadm_create',
			'uses' => 'Pius\Shop\Controller\JqadmController@createAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), 'delete/{resource}/{id?}', array(
			'as' => 'pius_shop_jqadm_delete',
			'uses' => 'Pius\Shop\Controller\JqadmController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'export/{resource}', array(
			'as' => 'pius_shop_jqadm_export',
			'uses' => 'Pius\Shop\Controller\JqadmController@exportAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), 'get/{resource}/{id}', array(
			'as' => 'pius_shop_jqadm_get',
			'uses' => 'Pius\Shop\Controller\JqadmController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), 'save/{resource}', array(
			'as' => 'pius_shop_jqadm_save',
			'uses' => 'Pius\Shop\Controller\JqadmController@saveAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET', 'POST' ), 'search/{resource}', array(
			'as' => 'pius_shop_jqadm_search',
			'uses' => 'Pius\Shop\Controller\JqadmController@searchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

	});
}


if( ( $conf = config( 'shop.routes.graphql', ['prefix' => 'admin/{site}/graphql', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'POST' ), '', array(
			'as' => 'pius_shop_graphql_post',
			'uses' => 'Pius\Shop\Controller\GraphqlController@indexAction'
		) )->where( ['site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jsonadm', ['prefix' => 'admin/{site}/jsonadm', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}/{id?}', array(
			'as' => 'pius_shop_jsonadm_delete',
			'uses' => 'Pius\Shop\Controller\JsonadmController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'GET' ), '{resource}/{id?}', array(
			'as' => 'pius_shop_jsonadm_get',
			'uses' => 'Pius\Shop\Controller\JsonadmController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'PATCH' ), '{resource}/{id?}', array(
			'as' => 'pius_shop_jsonadm_patch',
			'uses' => 'Pius\Shop\Controller\JsonadmController@patchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'POST' ), '{resource}/{id?}', array(
			'as' => 'pius_shop_jsonadm_post',
			'uses' => 'Pius\Shop\Controller\JsonadmController@postAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'PUT' ), '{resource}/{id?}', array(
			'as' => 'pius_shop_jsonadm_put',
			'uses' => 'Pius\Shop\Controller\JsonadmController@putAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

		Route::match( array( 'OPTIONS' ), '{resource?}', array(
			'as' => 'pius_shop_jsonadm_options',
			'uses' => 'Pius\Shop\Controller\JsonadmController@optionsAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'resource' => '[a-z\/]+'] );

	});
}


if( ( $conf = config( 'shop.routes.jsonapi', ['prefix' => 'jsonapi', 'middleware' => ['web', 'api']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'DELETE' ), '{resource}', array(
			'as' => 'pius_shop_jsonapi_delete',
			'uses' => 'Pius\Shop\Controller\JsonapiController@deleteAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET' ), '{resource}', array(
			'as' => 'pius_shop_jsonapi_get',
			'uses' => 'Pius\Shop\Controller\JsonapiController@getAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PATCH' ), '{resource}', array(
			'as' => 'pius_shop_jsonapi_patch',
			'uses' => 'Pius\Shop\Controller\JsonapiController@patchAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'POST' ), '{resource}', array(
			'as' => 'pius_shop_jsonapi_post',
			'uses' => 'Pius\Shop\Controller\JsonapiController@postAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'PUT' ), '{resource}', array(
			'as' => 'pius_shop_jsonapi_put',
			'uses' => 'Pius\Shop\Controller\JsonapiController@putAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'OPTIONS' ), '{resource?}', array(
			'as' => 'pius_shop_jsonapi_options',
			'uses' => 'Pius\Shop\Controller\JsonapiController@optionsAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.account', ['prefix' => 'profile', 'middleware' => ['web', 'auth']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'favorite/{fav_action?}/{fav_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'pius_shop_account_favorite',
			'uses' => 'Pius\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'watch/{wat_action?}/{wat_id?}/{d_name?}/{d_pos?}', array(
			'as' => 'pius_shop_account_watch',
			'uses' => 'Pius\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'download/{dl_id}', array(
			'as' => 'pius_shop_account_download',
			'uses' => 'Pius\Shop\Controller\AccountController@downloadAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'pius_shop_account',
			'uses' => 'Pius\Shop\Controller\AccountController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.supplier', ['prefix' => 'supplier', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), '{s_name}/{f_supid}', array(
			'as' => 'pius_shop_supplier',
			'uses' => 'Pius\Shop\Controller\SupplierController@detailAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	} );
}


if( ( $conf = config( 'shop.routes.update', [] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'update', array(
			'as' => 'pius_shop_update',
			'uses' => 'Pius\Shop\Controller\CheckoutController@updateAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.confirm', ['prefix' => 'shop', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'confirm/{code?}', array(
			'as' => 'pius_shop_confirm',
			'uses' => 'Pius\Shop\Controller\CheckoutController@confirmAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.default', ['prefix' => 'shop', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), 'count', array(
			'as' => 'pius_shop_count',
			'uses' => 'Pius\Shop\Controller\CatalogController@countAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'suggest', array(
			'as' => 'pius_shop_suggest',
			'uses' => 'Pius\Shop\Controller\CatalogController@suggestAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'stock', array(
			'as' => 'pius_shop_stock',
			'uses' => 'Pius\Shop\Controller\CatalogController@stockAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'basket', array(
			'as' => 'pius_shop_basket',
			'uses' => 'Pius\Shop\Controller\BasketController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'checkout/{c_step?}', array(
			'as' => 'pius_shop_checkout',
			'uses' => 'Pius\Shop\Controller\CheckoutController@indexAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), 'pin', array(
			'as' => 'pius_shop_session_pinned',
			'uses' => 'Pius\Shop\Controller\CatalogController@sessionAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

		Route::match( array( 'GET', 'POST' ), '{f_name}~{f_catid}/{l_page?}', array(
			'as' => 'pius_shop_tree',
			'uses' => 'Pius\Shop\Controller\CatalogController@treeAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'f_name' => '[^~]*', 'l_page' => '[0-9]+'] );

		Route::match( array( 'GET', 'POST' ), '{d_name}/{d_pos?}/{d_prodid?}', array(
			'as' => 'pius_shop_detail',
			'uses' => 'Pius\Shop\Controller\CatalogController@detailAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+', 'd_pos' => '[0-9]*'] );

		Route::match( array( 'GET', 'POST' ), '', array(
			'as' => 'pius_shop_list',
			'uses' => 'Pius\Shop\Controller\CatalogController@listAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}


if( ( $conf = config( 'shop.routes.page', ['prefix' => 'p', 'middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match(['GET', 'POST'], '{path?}', [
			'as' => 'pius_page',
			'uses' => '\Pius\Shop\Controller\PageController@indexAction'
		] )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );
	});
}


if( ( $conf = config( 'shop.routes.home', ['middleware' => ['web']] ) ) !== false ) {

	Route::group( $conf, function() {

		Route::match( array( 'GET', 'POST' ), '/', array(
			'as' => 'pius_home',
			'uses' => 'Pius\Shop\Controller\CatalogController@homeAction'
		) )->where( ['locale' => '[a-z]{2}(\_[A-Z]{2})?', 'site' => '[A-Za-z0-9\.\-]+'] );

	});
}
