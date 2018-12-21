<?php
namespace tmc\gdprshell\src\Models;

/**
 * @author jakubkuranda@gmail.com
 * Date: 19.07.2018
 * Time: 13:42
 */

use shellpress\v1_3_2\src\Shared\StorageModels\IPostModel;
use tmc\gdprshell\src\App;

class Acceptance extends IPostModel {

	const POST_TYPE = 'tmc_gdpr_acceptance';

	/**
	 * @param bool $isChecked
	 *
	 * @return string
	 */
	public function getCheckboxHtml( $isChecked = null ) {

		$html = '<label class="tmc_gdpr_shell_settings_checkbox">';
		$html .= sprintf( '<input type="checkbox" name="acceptanceId" value="%1$s" %2$s />', $this->getId(), checked( true, $isChecked, false ) );
		$html .= sprintf( '<span class="toggleOn">Włączone</span>' );
		$html .= sprintf( '<span class="toggleOff">Wyłączone</span>' );
		$html .= '<div></div>';
		$html .= '<i></i>';
		$html .= '</label>';

		return $html;

	}

	/**
	 * Returns code from post metabox.
	 *
	 * @return string
	 */
	public function getHeaderCode() {

		$scripts = (array) $this->getMeta( App::s()->getPrefix( '_scripts' ), array() );

		return isset( $scripts['header'] ) ? $scripts['header'] : '';

	}

	/**
	 * Returns code from post metabox.
	 *
	 * @return string
	 */
	public function getFooterCode() {

		$scripts = (array) $this->getMeta( App::s()->getPrefix( '_scripts' ), array() );

		return isset( $scripts['footer'] ) ? $scripts['footer'] : '';

	}

}