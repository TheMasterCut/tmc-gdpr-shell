<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 20.07.2018
 * Time: 10:46
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;
use tmc\gdprshell\src\Models\Acceptance;

class PostTypes extends IComponent {

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		add_action( 'init', array( $this, '_a_registerPostTypes' ) );

	}

	//  ================================================================================
	//  ACTIONS
	//  ================================================================================

	/**
	 * Called on init.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_registerPostTypes() {

		$result = register_post_type( Acceptance::POST_TYPE, array(
			'label'                 =>  __( 'Cookie Acceptances', 'tmc_gdpr_shell' ),
			'labels'                =>  array(
				'menu_name'             =>  'GDPR Shell TMC',
				'name'                  =>  __( 'Cookie Acceptances', 'tmc_gdpr_shell' ),
				'singular_name'         =>  __( 'Cookie Acceptance', 'tmc_gdpr_shell' ),
				'add_new'               =>  __( 'Add new Acceptance', 'tmc_gdpr_shell' ),
				'add_new_item'          =>  __( 'Add new Acceptance', 'tmc_gdpr_shell' ),
				'edit_item'             =>  __( 'Edit Acceptance', 'tmc_gdpr_shell' ),
				'new_item'              =>  __( 'New Acceptance', 'tmc_gdpr_shell' ),
				'view_item'             =>  __( 'View Acceptance', 'tmc_gdpr_shell' ),
				'view_items'            =>  __( 'View Acceptances', 'tmc_gdpr_shell' ),
				'search_items'          =>  __( 'Search Acceptances', 'tmc_gdpr_shell' ),
				'not_found'             =>  __( 'No Acceptances found', 'tmc_gdpr_shell' ),
				'not_found_in_trash'    =>  __( 'No Acceptances found in trash', 'tmc_gdpr_shell' )
			),
			'description'           =>  array(),
			'public'                =>  false,
			'show_ui'               =>  true,
			'show_in_rest'          =>  false,
			'menu_position'         =>  5,
			'menu_icon'             =>  'dashicons-forms',
			'supports'              =>  array( 'title', 'editor' )
		) );

		if( is_wp_error( $result ) ) wp_die( $result->get_error_message() );

	}

}