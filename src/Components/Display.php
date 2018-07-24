<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 14:22
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;
use tmc\gdprshell\src\App;

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
	 * Gets display of base popup as HTML string.
	 *
	 * @param bool $isHidden
	 *
	 * @return string
	 */
	public function getDisplayOfCookiePopup( $isHidden = false ) {

		//  Prepare classes.

		$rootElClasses = array_filter(
			array(
				'tmc_gdpr_shell_cookie_popup',
				$isHidden ? 'isHidden' : ''
			)
		);

		//  Prepare whole HTML output.

		ob_start();
		?>

        <div class="<?php echo implode( ' ', $rootElClasses ); ?>" data-version="<?php echo App::i()->options->getAcceptancesVersion(); ?>">
            <div class="tmc_gdpr_shell_cookie_inside">

                <div class="tmc_gdpr_shell_cookie_text">
                    <?php echo App::i()->options->getCookieBarContent(); ?>
                </div>
                <div class="tmc_gdpr_shell_cookie_btns">
                    <button class="secondary" data-tmcGdprShell-click="openSettings closeBase">Ustawienia</button>
                    <button class="primary" data-tmcGdprShell-click="acceptAll openAcceptancesOpener closeBase">Akceptuj</button>
                </div>

            </div>
        </div>

		<?php
		return ob_get_clean();

	}

	/**
	 * Gets display of settings popup as HTML string.
	 *
	 * @param bool $isHidden
	 *
	 * @return string
	 */
	public function getDisplayOfSettingsPopup( $isHidden = false ) {

	    //  Prepare classes.

	    $rootElClasses = array_filter(
            array(
                'tmc_gdpr_shell_settings_popup',
                $isHidden ? 'isHidden' : ''
            )
        );

        //  Prepare whole HTML output.

		ob_start();
		?>

		<div class="<?php echo implode( ' ', $rootElClasses ); ?>">
			<div class="tmc_gdpr_shell_settings_close">
				<span data-tmcGdprShell-click="acceptAll closeSettings openAcceptancesOpener"></span>
			</div>
			<div class="tmc_gdpr_shell_settings_inside">

                <form class="tmc_gdpr_shell_settings_form">

                    <div class="tmc_gdpr_shell_settings_list">

                        <?php

                        $acceptedIds    = (array) App::i()->acceptances->getAcceptancesIdsFromCookie();
                        $allAcceptances = (array) App::i()->acceptances->getAllAcceptances();

                        foreach( $allAcceptances as $acceptance ){

                            //  Should checkbox be checked?

                            if( in_array( 'all', $acceptedIds ) ){
                                $isChecked = true;
                            } else {
                                $isChecked = in_array( $acceptance->getId(), $acceptedIds ) ? true : false;
                            }

                            //  Display HTML.

                            echo '<div class="tmc_gdpr_shell_settings_list_row">';
                            echo sprintf( '<h1>%1$s</h1>', apply_filters( 'the_title', $acceptance->getTitle() ) );
	                        echo $acceptance->getCheckboxHtml( $isChecked );
                            echo sprintf( '<desc>%1$s</desc>', apply_filters( 'the_content', $acceptance->getContent() ) );
                            echo '</div>';

                        }

                        ?>

                    </div>
                    <div class="tmc_gdpr_shell_settings_btns">
                        <button type="submit" class="primary" data-tmcGdprShell-click="closeSettings openAcceptancesOpener">Zapisz ustawienia</button>
                    </div>

                </form>

			</div>
		</div>

		<?php
        return ob_get_clean();

	}

	/**
	 * Gets display of settings popup as HTML string.
	 *
	 * @param bool $isHidden
	 */
	public function getDisplayOfAcceptancesOpener( $isHidden = false ) {

		//  Prepare classes.

		$rootElClasses = array_filter(
			array(
				'tmc_gdpr_shell_acceptances_opener',
				$isHidden ? 'isHidden' : ''
			)
		);

		//  Prepare whole HTML output.

		ob_start();
		?>

        <div class="<?php echo implode( ' ', $rootElClasses ); ?>" data-tmcGdprShell-click="openSettings closeAcceptancesOpener">

            <div class="tmc_gdpr_shell_acceptances_opener_icon">
                <img src="<?php echo $this::s()->getUrl( 'assets/img/settings.png' ); ?>" alt="">
            </div>
            <div class="tmc_gdpr_shell_acceptances_opener_description">
                Zmień ustawienia cookies
            </div>

        </div>

		<?php
		return ob_get_clean();

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
			array( 'jquery', 'utils' ),
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

	    echo $this->getDisplayOfCookiePopup( true );
		echo $this->getDisplayOfSettingsPopup( true );

		if( App::i()->options->isAcceptancesOpenerEnabled() ){
			echo $this->getDisplayOfAcceptancesOpener( true );
        }

	}

}