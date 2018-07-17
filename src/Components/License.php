<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 11:55
 */

use shellpress\v1_2_6\src\Shared\Components\LicenseManagerSLM;

class License extends LicenseManagerSLM {

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		$this->registerNotices();
		$this->registerAutomaticChecker();
		$this->registerAPFForm( 'tmc_gdpr_shell_apf', 'tmc_gdpr_shell_settings', 'tools' );

	}

	/**
	 * Called when key has been activated.
	 *
	 * @return void
	 */
	protected function onKeyActivationCallback() {
		// TODO: Implement onKeyActivationCallback() method.
	}

	/**
	 * Called when key has been deactivated.
	 *
	 * @return void
	 */
	protected function onKeyDeactivationCallback() {
		// TODO: Implement onKeyDeactivationCallback() method.
	}
}