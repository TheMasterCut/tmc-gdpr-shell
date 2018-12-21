<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 11:55
 */

use shellpress\v1_3_2\src\Shared\Components\IComponentLicenseManagerSLM;

class License extends IComponentLicenseManagerSLM {

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

//		$this->registerNotices();
//		$this->registerAutomaticChecker();
//		$this->registerAPFForm( 'tmc_gdpr_shell_apf', 'tmc_gdpr_shell_settings', 'tools' );

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