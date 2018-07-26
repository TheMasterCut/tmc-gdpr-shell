<?php
namespace tmc\gdprshell\src;

/**
 * @author jakubkuranda@gmail.com
 * Date: 13.07.2018
 * Time: 13:06
 */

use shellpress\v1_2_6\ShellPress;
use tmc\gdprshell\src\AdminPages\tmc_gdpr_shell_acceptance_scripts_mb;
use tmc\gdprshell\src\Components\Display;
use tmc\gdprshell\src\Components\License;
use tmc\gdprshell\src\Components\Options;
use tmc\gdprshell\src\Components\Acceptances;
use tmc\gdprshell\src\Components\PostTypes;
use tmc\gdprshell\src\Models\Acceptance;
use tmc_gdpr_shell_apf;

class App extends ShellPress {

	/** @var Options */
	public $options;

	/** @var License */
	public $license;

	/** @var Display */
	public $display;

	/** @var Acceptances */
	public $acceptances;

	/** @var PostTypes */
	public $postTypes;

	/**
	 * Called automatically after core is ready.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		//  ----------------------------------------
		//  Autoloading
		//  ----------------------------------------

		$this::s()->autoloading->addNamespace( 'tmc\gdprshell', dirname( $this::s()->getMainPluginFile() ) );

		//  ----------------------------------------
		//  Components
		//  ----------------------------------------

		$this->options      = new Options( $this );
		$this->license      = new License( $this );
		$this->postTypes    = new PostTypes( $this );
		$this->acceptances  = new Acceptances( $this );
		$this->display      = new Display( $this );

		//  ----------------------------------------
		//  Simple lock
		//  ----------------------------------------

		if( strpos( home_url(), 'contentsolutions.pl' ) === false ) return;

		//  ----------------------------------------
		//  AdminPageFramework
		//  ----------------------------------------

		if( is_admin() && ! wp_doing_ajax() && ! wp_doing_cron() ) {    //   Let's keep things lightweight

			$this::s()->requireFile( 'lib/tmc-admin-page-framework/admin-page-framework.php', 'TMC_v1_0_3_AdminPageFramework' );
			$this::s()->requireFile( 'src/AdminPages/tmc_gdpr_shell_apf.php' );
			$this::s()->requireFile( 'src/AdminPages/tmc_gdpr_shell_acceptance_scripts_mb.php' );

			new tmc_gdpr_shell_apf(
				$this::s()->options->getOptionsKey(),           //  Options key
				$this::s()->getMainPluginFile()                 //  Main caller
			);
			new tmc_gdpr_shell_acceptance_scripts_mb(
				$this::s()->getPrefix( '_acceptance_metabox' ), //  Metabox ID
				__( 'Scripts', 'tmc_gdpr_shell' ),              //  Title
				Acceptance::POST_TYPE,                          //  Post type
				'normal',                                       //  Context
				'default'                                       //  Priority
			);

		}

	}
}