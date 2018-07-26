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

	/** @var string - Name of ajax action callback. */
	public $ajaxCbSubmitChosenAcceptances;

	/** @var null|Acceptance[] */
	private $acceptancesTemp = null;

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		//  ----------------------------------------
		//  Properties
		//  ----------------------------------------

		$this->ajaxCbSubmitChosenAcceptances = $this::s()->getPrefix( '_submitChosenAcceptances' );

		//  ----------------------------------------
		//  Actions
		//  ----------------------------------------

		add_action( 'wp_head',                                                  array( $this, '_a_addCodesInHeader' ) );
		add_action( 'wp_footer',                                                array( $this, '_a_addCodesInFooter' ) );
		add_action( 'wp_ajax_' . $this->ajaxCbSubmitChosenAcceptances,          array( $this, '_a_submitChosenAcceptancesAjaxCallback' ) );
		add_action( 'wp_ajax_nopriv_' . $this->ajaxCbSubmitChosenAcceptances,   array( $this, '_a_submitChosenAcceptancesAjaxCallback' ) );

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
	 * Gets accepted IDs of scripts from cookie.
	 * Remember, it may be array of integers or array with one value: all.
	 *
	 * @return string[]|int[]|mixed
	 */
	public function getAcceptancesIdsFromCookie() {

		$acceptances = array();

		if( isset( $_COOKIE['tmcGdprShellAccepted'] ) ){

			$cookie = $_COOKIE['tmcGdprShellAccepted'];

			$acceptances = explode( ',', $cookie );

		}

		return $acceptances;

	}

	/**
	 * Gets accepted scripts from cookie.
	 *
	 * @return Acceptance[]
	 */
	public function getChosenAcceptances() {

		if( is_null( $this->acceptancesTemp ) ){

			$ids = $this->getAcceptancesIdsFromCookie();

			if( in_array( 'all', $ids ) ){
				$this->acceptancesTemp = $this->getAllAcceptances();
			} else {
				$this->acceptancesTemp = $this->getAcceptancesByIds( $ids );
			}

		}

		return $this->acceptancesTemp;

	}

	//  ================================================================================
	//  ACTIONS
	//  ================================================================================

	/**
	 * Prints out code in header.
	 * Called on wp_head.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_addCodesInHeader() {

//		if( ! App::i()->license->isActive() ) return;

		foreach( $this->getChosenAcceptances() as $acceptance ){
			echo $acceptance->getHeaderCode();
		}

	}

	/**
	 * Prints out code in footer.
	 * Called on wp_footer.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_addCodesInFooter() {

//		if( ! App::i()->license->isActive() ) return;

		foreach( $this->getChosenAcceptances() as $acceptance ){
			echo $acceptance->getFooterCode();
		}

	}

	/**
	 * Called on ajax action callback when user submits chosen acceptances.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_submitChosenAcceptancesAjaxCallback() {

		if( isset( $_POST['acceptedIds'] ) ){

			/**
			 * Action called after user saved settings.
			 * May be used to store data in database.
			 *
			 * @param int[]|string[]
			 */
			do_action( 'tmc_gdpr_shell_submit_chosen_acceptances', (array) $_POST['acceptedIds'] );

		}

		wp_die();

	}

}