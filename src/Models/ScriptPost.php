<?php
namespace tmc\gdprshell\src\Models;

/**
 * @author jakubkuranda@gmail.com
 * Date: 19.07.2018
 * Time: 13:42
 */

use shellpress\v1_2_6\src\Shared\StorageModels\IPostModel;

class ScriptPost extends IPostModel {

	const POST_TYPE = 'tmc_gdpr_shell_script';

	/**
	 * @param bool $isChecked
	 *
	 * @return string
	 */
	public function getCheckboxHtml( $isChecked = null ) {

		$html = '<label class="tmc_gdpr_shell_settings_checkbox">';
		$html .= sprintf( '<input type="checkbox" name="scriptIds[]" value="%1$s" %2$s />', $this->getId(), checked( true, $isChecked, false ) );
		$html .= '<div></div>';
		$html .= '<i></i>';
		$html .= '</label>';

		return $html;

	}

}