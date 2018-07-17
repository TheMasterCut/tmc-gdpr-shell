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
		// TODO: Implement load() method.
	}
}