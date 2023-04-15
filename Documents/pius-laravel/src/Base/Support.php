<?php

namespace Pius\Shop\Base;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


/**
 * Service providing the supporting functionality
 */
class Support
{
	/**
	 * @var \Pius\Shop\Base\Context
	 */
	private $context;

	/**
	 * @var \Pius\Shop\Base\Locale
	 */
	private $locale;

	/**
	 * @var array
	 */
	private $access = [];


	/**
	 * Initializes the object
	 *
	 * @param \Pius\Shop\Base\Context $context Context provider
	 * @param \Pius\Shop\Base\Locale $locale Locale provider
	 */
	public function __construct( \Pius\Shop\Base\Context $context, \Pius\Shop\Base\Locale $locale )
	{
		$this->context = $context;
		$this->locale = $locale;
	}


	/**
	 * Checks if the user is in the specified group and associatied to the site
	 *
	 * @param \Illuminate\Foundation\Auth\User $user Authenticated user
	 * @param string|array $groupcodes Unique user/customer group codes that are allowed
	 * @return bool True if user is part of the group, false if not
	 */
	public function checkUserGroup( \Illuminate\Foundation\Auth\User $user, $groupcodes ) : bool
	{
		$groups = ( is_array( $groupcodes ) ? implode( ',', $groupcodes ) : $groupcodes );

		if( isset( $this->access[$user->id][$groups] ) ) {
			return $this->access[$user->id][$groups];
		}

		$this->access[$user->id][$groups] = false;

		$context = $this->context->get( false );
		$siteid = current( array_reverse( explode( '.', trim( $user->siteid, '.' ) ) ) );

		if( $siteid ) {
			$site = \Pius\MShop::create( $context, 'locale/site' )->get( $siteid )->getCode();
		} else {
			$site = config( 'shop.mshop.locale.site', 'default' );
		}

		$site = ( Route::current() ? Route::input( 'site', Request::get( 'site', $site ) ) : $site );
		$context->setLocale( $this->locale->getBackend( $context, $site ) );

		foreach( array_reverse( $context->locale()->getSitePath() ) as $siteid )
		{
			if( $user->siteid === '' || $user->siteid === $siteid ) {
				$this->access[$user->id][$groups] = $this->checkGroups( $context, $user->id, $groupcodes );
			}
		}

		return $this->access[$user->id][$groups];
	}


	/**
	 * Returns the available group codes
	 *
	 * @param \Pius\MShop\ContextIface $context Context item
	 * @return string[] List of group codes
	 */
	public function getGroups( \Pius\MShop\ContextIface $context ) : array
	{
		$manager = \Pius\MShop::create( $context, 'customer/group' );

		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'customer.group.id', $context->groups() ) );

		return $manager->search( $search )->getCode()->toArray();
	}


	/**
	 * Checks if one of the groups is associated to the given user ID
	 *
	 * @param \Pius\MShop\ContextIface $context Context item
	 * @param string $userid ID of the logged in user
	 * @param string[]|string $groupcodes List of group codes to check against
	 * @return bool True if the user is in one of the groups, false if not
	 */
	protected function checkGroups( \Pius\MShop\ContextIface $context, string $userid, $groupcodes ) : bool
	{
		$manager = \Pius\MShop::create( $context, 'customer/group' );

		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'customer.group.code', (array) $groupcodes ) );
		$groupIds = $manager->search( $search )->keys()->toArray();

		$manager = \Pius\MShop::create( $context, 'customer/lists' );

		$search = $manager->filter()->slice( 0, 1 );
		$expr = array(
			$search->compare( '==', 'customer.lists.parentid', $userid ),
			$search->compare( '==', 'customer.lists.refid', $groupIds ),
			$search->compare( '==', 'customer.lists.domain', 'customer/group' ),
		);
		$search->setConditions( $search->combine( '&&', $expr ) );

		return !$manager->search( $search )->isEmpty();
	}
}
