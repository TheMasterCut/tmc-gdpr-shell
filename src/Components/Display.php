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
		add_action( 'wp_footer',                                array( $this, '_a_printPopupDisplayInFooter' ) );

	}

	/**
	 * Gets display of popup as HTML string.
	 *
	 * @param bool $isHidden
	 *
	 * @return string
	 */
	public function getDisplayOfPopup( $isHidden = false ) {

		$html = '';

		?>

		<div class="tmc_gdpr_shell_popup">
			<div class="tmc_gdpr_shell_close">
				<span></span>
			</div>
			<div class="tmc_gdpr_shell_inside">



			</div>
		</div>

		<?php

		return $html;

	}

	//  ================================================================================
	//  ACTIONS
	//  ================================================================================

	/**
	 * Enqueues all scripts and styles on front-end.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_enqueueFrontEndScripts() {

		wp_enqueue_script(
			$this::s()->getPrefix( '_front.js' ),
			$this::s()->getUrl( 'assets/js/front.js' ),
			array( 'jquery' ),
			$this::s()->getFullPluginVersion()
		);

		wp_enqueue_style(
			$this::s()->getPrefix( '_front.scss' ),
			$this::s()->getUrl( 'assets/css/front.css' ),
			array(),
			$this::s()->getFullPluginVersion()
		);

	}

	/**
	 * Prints out popup HTML elements in footer.
	 *
	 * @internal
	 *
	 * @return void
	 */
	public function _a_printPopupDisplayInFooter() {

		echo $this->getDisplayOfPopup( true );

	}

}