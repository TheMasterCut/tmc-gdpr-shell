<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 19.07.2018
 * Time: 12:30
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;
use tmc\gdprshell\src\Models\Acceptance;
use WP_Query;

class Acceptances extends IComponent {

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

	}

	/**
	 * Returns acceptance object or null if given id does not exist.
	 *
	 * @param int[]|int $ids
	 *
	 * @return Acceptance[]|null
	 */
	public function getAcceptancesByIds( $ids ) {

		$acceptances = array();

		foreach( (array) $ids as $id ){

			$post = get_post( $id );
			if( $post ){
				$acceptances[] = new Acceptance( $post );
			}

		}

		return $acceptances;

	}

	/**
	 * Does database search and returns all published acceptances.
	 *
	 * @return Acceptance[]
	 */
	public function getAllAcceptances() {

		$query = new WP_Query( array(
			'post_type'     =>  Acceptance::POST_TYPE,
			'nopaging'      =>  true,
			'post_status'   =>  'publish'
		) );

		return $this->getAcceptancesWithQuery( $query );

	}

	/**
	 * Uses given WP_Query object to wrap all found posts with Acceptance object.
	 *
	 * @param WP_Query $query
	 *
	 * @return Acceptance[]
	 */
	public function getAcceptancesWithQuery( $query ) {

		$acceptances = array();

		foreach( $query->get_posts() as $post ){
			$acceptances[] = new Acceptance( $post );
		}

		return $acceptances;

	}

	/**
	 * Gets accepted scripts from cookie.
	 * Remember, it may be array of integers or array with one value: all.
	 *
	 * @return string[]
	 */
	public function getAcceptancesIdsFromCookie() {

		$acceptances = array();

		if( isset( $_COOKIE['tmcGdprShellAccepted'] ) ){

			$cookie = $_COOKIE['tmcGdprShellAccepted'];

			$acceptances = explode( ',', $cookie );

		}

		return $acceptances;

	}

}