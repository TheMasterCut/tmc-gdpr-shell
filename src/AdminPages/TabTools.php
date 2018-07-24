<?php
namespace tmc\gdprshell\src\AdminPages;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 12:00
 */

use shellpress\v1_2_6\src\Shared\AdminPageFramework\AdminPageTab;
use tmc\gdprshell\src\App;
use TMC_v1_0_3_AdminPageFramework;
use TMC_v1_0_3_ToggleCustomFieldType;

class TabTools extends AdminPageTab {

	/**
	 * Declaration of current element.
	 */
	public function setUp() {

		//  ----------------------------------------
		//  Filters
		//  ----------------------------------------

		add_filter( 'validation_' . $this->pageFactoryClassName, array( $this, '_f_processForceResetSubmit' ), 10, 4 );

		//  ----------------------------------------
		//  Definition
		//  ----------------------------------------

		$this->pageFactory->addInPageTab( array(
			'page_slug'     =>  $this->pageSlug,
			'tab_slug'      =>  $this->tabSlug,
			'title'         =>  __( 'Tools', 'tmc_gdpr_shell' ),
			'order'         =>  '10'
		) );

	}

	/**
	 * Called while current component is loaded.
	 */
	public function load() {

		//  ----------------------------------------
		//  Custom field types
		//  ----------------------------------------

		App::s()->requireFile( 'lib/tmc-admin-page-framework/custom-field-types/toggle-custom-field-type/ToggleCustomFieldType.php' );

		new TMC_v1_0_3_ToggleCustomFieldType();

		//  ----------------------------------------
		//  Sections
		//  ----------------------------------------

		$this->pageFactory->addSettingSections(
			array(
				'section_id'        =>  'cookieBar',
				'title'             =>  __( 'Cookie bar', 'tmc_gdpr_shell' ),
				'page_slug'         =>  $this->pageSlug,
				'tab_slug'          =>  $this->tabSlug,
			),
			array(
				'section_id'        =>  'acceptancesOpener',
				'title'             =>  __( 'Acceptances opener', 'tmc_gdpr_shell' ),
				'page_slug'         =>  $this->pageSlug,
				'tab_slug'          =>  $this->tabSlug,
				'description'       =>  array(
					__( 'If user close cookie bar, it will provide the way to edit settings later.', 'tmc_gdpr_shell' )
				)
			),
			array(
				'section_id'        =>  'control',
				'title'             =>  __( 'Control', 'tmc_gdpr_shell' ),
				'page_slug'         =>  $this->pageSlug,
				'tab_slug'          =>  $this->tabSlug,
			)
		);

		//  ----------------------------------------
		//  Fields
		//  ----------------------------------------

		$this->pageFactory->addSettingFields(
			'acceptancesOpener',
			array(
				'field_id'          =>  'isEnabled',
				'type'              =>  'toggle',
				'title'             =>  __( 'Enabled', 'tmc_gdpr_shell' ),
				'theme'             =>  'light',
			)
		);

		$this->pageFactory->addSettingFields(
			'cookieBar',
			array(
				'field_id'          =>  'content',
				'type'              =>  'textarea',
				'title'             =>  __( 'Content', 'tmc_gdpr_shell' ),
				'rich'              =>  true,
				'attributes'        =>  array(
					'cols'              =>  '100',
					'rows'              =>  '10'
				)
			)
		);

		$this->pageFactory->addSettingFields(
			'control',
			array(
				'field_id'          =>  'acceptancesUpdateBehaviour',
				'type'              =>  'radio',
				'title'             =>  __( 'Acceptances update behaviour', 'tmc_gdpr_shell' ),
				'label'             =>  array(
					'resetEveryTime'    =>  __( 'Reset cookies every time any of acceptances has been modified.', 'tmc_gdpr' ),
					'ignore'            =>  __( 'Ignore modifications. I will force reset manually.', 'tmc_gdpr' ),
				)
			),
			array(
				'field_id'          =>  'acceptancesVersionSubmit',
				'type'              =>  'submit',
				'title'             =>  __( 'Version of acceptance', 'tmc_gdpr_shell' ),
				'save'              =>  false,
				'value'             =>  __( 'Force reset acceptances now', 'tmc_gdpr_shell' ),
				'description'       =>  array(
					__( 'When you press this button, visitors will have to accept cookies again.', 'tmc_gdpr_shell' )
				),
				'attributes'        =>  array(
					'class'             =>  'button button-secondary'
				)
			),
			array(
				'field_id'          =>  'acceptancesVersion',
				'type'              =>  'text',
				'title'             =>  'acceptanceVersion',
				'hidden'            =>  true
			),
			array(
				'field_id'          =>  'submit',
				'type'              =>  'submit',
				'value'             =>  __( 'Update settings', 'tmc_gdpr_shell' ),
				'save'              =>  false
			)
		);

	}

	//  ================================================================================
	//  FILTERS
	//  ================================================================================

	/**
	 * @param array $newInput
	 * @param array $oldInput
	 * @param TMC_v1_0_3_AdminPageFramework $factory
	 * @param array $submitInput
	 *
	 * @return array
	 */
	public function _f_processForceResetSubmit( $newInput, $oldInput, $factory, $submitInput ) {

		if( $submitInput['input_name'] === App::s()->options->getOptionsKey() . '|control|acceptancesVersionSubmit' ){

			$newInput['control']['acceptancesVersion'] = time();

			$factory->setSettingNotice( __( 'Done. Every user will have to accept cookies again.', 'tmc_gdpr_shell' ), 'updated' );

		}

		return $newInput;

	}

}