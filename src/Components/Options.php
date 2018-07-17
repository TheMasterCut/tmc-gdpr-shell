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

		) );

		//  ----------------------------------------
		//  Events
		//  ----------------------------------------

		$this::s()->event->addOnActivate( array( $this, '_a_provideDefaultOptions' ) );
		$this::s()->event->addOnUpdate( array( $this, '_a_provideDefaultOptions' ) );

	}

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