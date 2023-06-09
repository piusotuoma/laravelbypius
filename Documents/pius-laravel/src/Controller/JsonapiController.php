<?php

namespace Pius\Shop\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Factory\Psr17Factory;


/**
 * Pius controller for the JSON REST API
 */
class JsonapiController extends Controller
{
	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function deleteAction( ServerRequestInterface $request )
	{
		return $this->createClient()->delete( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Returns the requested resource object or list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function getAction( ServerRequestInterface $request )
	{
		return $this->createClient()->get( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Updates a resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function patchAction( ServerRequestInterface $request )
	{
		return $this->createClient()->patch( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Creates a new resource object or a list of resource objects
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function postAction( ServerRequestInterface $request )
	{
		return $this->createClient()->post( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Creates or updates a single resource object
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function putAction( ServerRequestInterface $request )
	{
		return $this->createClient()->put( $request, ( new Psr17Factory )->createResponse() );
	}


	/**
	 * Returns the available HTTP verbs and the resource URLs
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request Request object
	 * @return \Psr\Http\Message\ResponseInterface Response object containing the generated output
	 */
	public function optionsAction( ServerRequestInterface $request )
	{
		return $this->createClient()->options( $request, ( new Psr17Factory )->createResponse() )
			->withHeader( 'access-control-allow-headers', 'authorization,content-type' )
			->withHeader( 'access-control-allow-methods', 'DELETE, GET, OPTIONS, PATCH, POST, PUT' )
			->withHeader( 'access-control-allow-origin', $request->getHeaderLine( 'origin' ) );
	}


	/**
	 * Returns the JsonAdm client
	 *
	 * @return \Pius\Client\JsonApi\Iface JsonApi client
	 */
	protected function createClient() : \Pius\Client\JsonApi\Iface
	{
		$resource = Route::input( 'resource' );
		$related = Route::input( 'related', Request::get( 'related' ) );

		$pius = app( 'pius' )->get();
		$context = app( 'pius.context' )->get();
		$tmplPaths = $pius->getTemplatePaths( 'client/jsonapi/templates', $context->locale()->getSiteItem()->getTheme() );

		$langid = $context->locale()->getLanguageId();

		$context->setView( app( 'pius.view' )->create( $context, $tmplPaths, $langid ) );

		return \Pius\Client\JsonApi::create( $context, $resource . '/' . $related );
	}
}
