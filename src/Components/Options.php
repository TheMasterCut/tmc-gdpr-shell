<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 13.07.2018
 * Time: 14:38
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;

class Options extends IComponent {

	/**
	 * Called on creation of component.
	 *
	 * @return void
	 */
	protected function onSetUp() {

		//  ----------------------------------------
		//  Defaults
		//  ----------------------------------------

		$this::s()->options->setDefaultOptions( array(
			'control'                           =>  array(
				'acceptancesUpdateBehaviour'        =>  'resetEveryTime',
				'acceptancesVersion'                =>  time()
			),
			'acceptancesOpener'                 =>  array(
				'isEnabled'                         =>  true
			)
		) );

		//  ----------------------------------------
		//  Events
		//  ----------------------------------------

		$this::s()->event->addOnActivate( array( $this, '_a_provideDefaultOptions' ) );
		$this::s()->event->addOnUpdate( array( $this, '_a_provideDefaultOptions' ) );

	}

	/**
	 * @return string
	 */
	public function getAcceptancesUpdateBehaviour() {

		return $this::s()->options->get( 'control/acceptancesUpdateBehaviour' );

	}

	/**
	 * @return string|null
	 */
	public function getAcceptancesVersion() {

		return $this::s()->options->get( 'control/acceptancesVersion' );

	}

	/**
	 * @param string $version
	 *
	 * @return void
	 */
	public function setAcceptancesVersion( $version ) {

		$this::s()->options->set( 'control/acceptancesVersion', $version );

	}

	/**
	 * @return string|null
	 */
	public function getCookieBarContent() {

		return $this::s()->options->get( 'cookieBar/content' );

	}

	/**
	 * @return bool
	 */
	public function isAcceptancesOpenerEnabled() {

		return (bool) $this::s()->options->get( 'acceptancesOpener/isEnabled' );

	}

	//  ================================================================================
	//  ACTIONS
	//  ================================================================================

	/**
	 * @internal
	 *
	 * @return void
	 */
	public function _a_provideDefaultOptions() {

		$this::s()->options->fillDifferencies();
		$this::s()->options->flush();

	}

}