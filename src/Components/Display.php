<?php
namespace tmc\gdprshell\src\Components;

/**
 * @author jakubkuranda@gmail.com
 * Date: 16.07.2018
 * Time: 14:22
 */

use shellpress\v1_2_6\src\Shared\Components\IComponent;
use tmc\gdprshell\src\Models\ScriptPost;

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
	public function getDisplayOfBasePopup( $isHidden = false ) {

		//  Prepare classes.

		$rootElClasses = array_filter(
			array(
				'tmc_gdpr_shell_base_popup',
				$isHidden ? 'isHidden' : ''
			)
		);

		//  Prepare whole HTML output.

		ob_start();
		?>

        <div class="<?php echo implode( ' ', $rootElClasses ); ?>">
            <div class="tmc_gdpr_shell_base_inside">

                <div class="tmc_gdpr_shell_base_text">
                    Używamy plików cookie, aby zapewnić najlepszą jakość na naszej stronie. Więcej informacji o plikach cookie, z których korzystamy, lub o ich wyłączeniu znajdziesz w ustawieniach. Pamiętaj zawsze możesz je zmienić.
                </div>
                <div class="tmc_gdpr_shell_base_btns">
                    <button class="secondary" data-tmcGdprShell-click="openSettings closeBase">Ustawienia</button>
                    <button class="primary" data-tmcGdprShell-click="acceptAll closeBase">Akceptuj</button>
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
				<span data-tmcGdprShell-click="acceptAll closeSettings"></span>
			</div>
			<div class="tmc_gdpr_shell_settings_inside">

                <form class="tmc_gdpr_shell_settings_form">

                    <div class="tmc_gdpr_shell_settings_list">

                        <?php
                        $scriptPost = new ScriptPost( get_post( '13047' ) );
                        echo $scriptPost->getCheckboxHtml();

                        $scriptPost = new ScriptPost( get_post( '13048' ) );
                        echo $scriptPost->getCheckboxHtml();
                        ?>

                    </div>
                    <div class="tmc_gdpr_shell_settings_btns">
                        <button type="submit" class="primary" data-tmcGdprShell-click="acceptChoosen closeSettings">Zapisz ustawienia</button>
                    </div>

                </form>

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

	    echo $this->getDisplayOfBasePopup( true );
		echo $this->getDisplayOfSettingsPopup( true );

	}

}