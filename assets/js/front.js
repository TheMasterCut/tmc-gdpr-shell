jQuery( document ).ready( function( $ ){

    var settingsPopup = {

        'elems' :                   {
            'rootEl' :                  null,   //  Popup root div.
            'closeEl' :                 null    //  Close element.
        },

        /**
         * Initializes elements.
         *
         * @return void
         */
        initElems :                 function() {

            settingsPopup.elems.rootEl      = $( '.tmc_gdpr_shell_settings_popup' );
            settingsPopup.elems.closeEl     = $( '.tmc_gdpr_shell_settings_close' );

        },

        /**
         * Initializes close actions.
         *
         * @return void
         */
        initMechanics :             function() {

            settingsPopup.elems.closeEl.click( function(){
                settingsPopup.close();
            } );

            settingsPopup.elems.rootEl.click( function( event ){

                if( event.target === this ){    //  Root div acts like background.
                    settingsPopup.close();
                }

            } );

        },

        /**
         * @return void
         */
        open :                      function() {

            settingsPopup.elems.rootEl.removeClass( 'isHidden' );
            document.body.classList.add( 'noScroll' );

        },

        /**
         * @return void
         */
        close :                     function() {

            settingsPopup.elems.rootEl.addClass( 'isHidden' );
            document.body.classList.remove( 'noScroll' );

        }

    };

    var basePopup = {

        'elems' :                   {
            'rootEl' :                  null,   //  Popup root div.
            'closeEl' :                 null,   //  Closes and accepts settings popup.
            'openSettingsEl' :          null    //  Opens settings popup.
        },

        /**
         * Initializes elements.
         *
         * @return void
         */
        initElems :                 function() {

            basePopup.elems.rootEl          = $( '.tmc_gdpr_shell_base_popup' );
            basePopup.elems.closeEl         = $( '.tmc_gdpr_shell_base_close' );
            basePopup.elems.openSettingsEl  = $( '.tmc_gdpr_shell_base_open_settings' );

        },

        /**
         * Initializes close actions.
         *
         * @return void
         */
        initMechanics :             function() {

            basePopup.elems.closeEl.click( function(){
                basePopup.close();
            } );

        },

        /**
         * @return void
         */
        open :                      function() {

            basePopup.elems.rootEl.removeClass( 'isHidden' );

        },

        /**
         * @return void
         */
        close :                     function() {

            basePopup.elems.rootEl.addClass( 'isHidden' );

        }

    };

    //  ----------------------------------------
    //  Init popup
    //  ----------------------------------------

    settingsPopup.initElems();
    settingsPopup.initMechanics();

    basePopup.initElems();
    basePopup.initMechanics();

    basePopup.open();

} );