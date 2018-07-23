<?php
namespace tmc\gdprshell\src\AdminPages;

/**
 * @author jakubkuranda@gmail.com
 * Date: 23.07.2018
 * Time: 10:00
 */

use tmc\gdprshell\src\App;
use tmc\gdprshell\src\Models\Acceptance;
use TMC_v1_0_3_AceCustomFieldType;
use TMC_v1_0_3_AdminPageFramework_MetaBox;

class tmc_gdpr_shell_acceptance_scripts_mb extends TMC_v1_0_3_AdminPageFramework_MetaBox {

	public function load() {

		//  ----------------------------------------
		//  Scripts
		//  ----------------------------------------

		$this->enqueueStyle(
			App::s()->getUrl( 'lib/ShellPress/assets/css/AdminPage/style.css' ),
			array( Acceptance::POST_TYPE ),
			array( 'version' => App::s()->getFullPluginVersion() )
		);

		//  ----------------------------------------
		//  Custom field types
		//  ----------------------------------------

		App::s()->requireFile( 'lib/tmc-admin-page-framework/custom-field-types/ace-custom-field-type/AceCustomFieldType.php' );

		new TMC_v1_0_3_AceCustomFieldType();

		//  ----------------------------------------
		//  Sections
		//  ----------------------------------------

		$this->addSettingSections(
			array(
				'section_id'        =>  App::s()->getPrefix( '_scripts' ),
				'title'             =>  null,
				'description'       =>  array(
					__( 'These code parts will be used only, if user accepts them.', 'tmc_gdpr_shell' )
				)
			)
		);

		//  ----------------------------------------
		//  Fields
		//  ----------------------------------------

		$this->addSettingFields(
			App::s()->getPrefix( '_scripts' ),
			array(
				'field_id'          =>  'header',
				'type'              =>  'ace',
				'title'             =>  __( 'Code in header', 'tmc_gdpr_shell' ),
				'description'       =>  array(
					sprintf( __( 'Code above will be used right before closing <code>%1$s</code> tag.', 'tmc_gdpr_shell' ), esc_html( '</head>' ) )
				),
				'options'           =>  array(
					'theme'             =>  'chrome',
					'language'          =>  'html',
					'gutter'            =>  true
				),
				'attributes'        =>  array(
					'cols'              =>  100,
					'rows'              =>  10,
				)
			),
			array(
				'field_id'          =>  'footer',
				'type'              =>  'ace',
				'title'             =>  __( 'Code in footer', 'tmc_gdpr_shell' ),
				'description'       =>  array(
					sprintf( __( 'Code above will be used right before closing <code>%1$s</code> tag.', 'tmc_gdpr_shell' ), esc_html( '</body>' ) )
				),
				'options'           =>  array(
					'theme'             =>  'chrome',
					'language'          =>  'html',
					'gutter'            =>  true
				),
				'attributes'        =>  array(
					'cols'              =>  100,
					'rows'              =>  10,
				)
			)
		);

	}

}