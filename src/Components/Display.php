<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 14:22
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;

class Display extends IComponent {

	/** @var string */
	public $popupHtmlAjaxCbName;

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		//  ----------------------------------------
		//  Properties
		//  ----------------------------------------

		$this->popupHtmlAjaxCbName = $this::s()->getPrefix( '_popupHtmlAjaxCb' );

		//  ----------------------------------------
		//  Actions
		//  ----------------------------------------

		add_action( 'wp_enqueue_scripts',                       array( $this, '_a_enqueueFrontEndScripts' ) );
		add_action( 'wp_ajax_' . $this->popupHtmlAjaxCbName,    array( $this, '_a_popupHtmlAjaxCb' ) );

	}

	/**
	 * Enqueues all scripts and styles on front-end.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_enqueueFrontEndScripts() {

		//  ----------------------------------------
		//  Script
		//  ----------------------------------------

		wp_enqueue_script(
			$this::s()->getPrefix( '_front' ),
			$this::s()->getUrl( 'assets/js/front.js' ),
			array( 'jquery' ),
			$this::s()->getFullPluginVersion()
		);

	}

	/**
	 * Prints ajax response as a HTML.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_popupHtmlAjaxCb() {



	}

}