<?php
namespace tmc\gdprshell\src\AdminPages;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 12:00
 */

use shellpress\v1_2_6\src\Shared\AdminPageFramework\AdminPageTab;

class TabTools extends AdminPageTab {

	/**
	 * Declaration of current element.
	 */
	public function setUp() {

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
		//  Sections
		//  ----------------------------------------

		$this->pageFactory->addSettingSections(
			array(
				'section_id'        =>  'control',
				'title'             =>  __( 'Control', 'tmc_gdpr_shell' )
			)
		);

		//  ----------------------------------------
		//  Fields
		//  ----------------------------------------

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
				)
			),
			array(
				'field_id'          =>  'acceptancesVersion',
				'type'              =>  'text',
				'title'             =>  'acceptanceVersion'
			)
		);

	}
}