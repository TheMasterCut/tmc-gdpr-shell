<?php
namespace tmc\gpdrshell\src;

/**
 * @author jakubkuranda@gmail.com
 * Date: 13.07.2018
 * Time: 13:06
 */

use shellpress\v1_2_6\ShellPress;
use tmc\gpdrshell\src\Components\Display;
use tmc\gpdrshell\src\Components\License;
use tmc\gpdrshell\src\Components\Options;
use tmc_gpdr_shell_apf;

class App extends ShellPress {

	/** @var Options */
	public $options;

	/** @var License */
	public $license;

	/** @var Display */
	public $display;

	/**
	 * Called automatically after core is ready.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		//  ----------------------------------------
		//  Autoloading
		//  ----------------------------------------

		$this::s()->autoloading->addNamespace( 'tmc\gpdrshell', dirname( $this::s()->getMainPluginFile() ) );

		//  ----------------------------------------
		//  Components
		//  ----------------------------------------

		$this->options = new Options( $this );
		$this->license = new License( $this );
		$this->display = new Display( $this );

		//  ----------------------------------------
		//  AdminPageFramework
		//  ----------------------------------------

		if( is_admin() && ! wp_doing_ajax() && ! wp_doing_cron() ) {    //   Let's keep things lightweight

			$this::s()->requireFile( 'lib/tmc-admin-page-framework/admin-page-framework.php', 'TMC_v1_0_3_AdminPageFramework' );
			$this::s()->requireFile( 'src/AdminPages/tmc_gpdr_shell_apf.php' );

			new tmc_gpdr_shell_apf( $this::s()->options->getOptionsKey(), $this::s()->getMainPluginFile() );

		}

	}
}