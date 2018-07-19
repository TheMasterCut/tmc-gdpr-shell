jQuery( document ).ready( function( $ ){

    //  ----------------------------------------
    //  Initialize events calling with clicking.
    //  ----------------------------------------

    $( '[data-tmcGdprShell-click]' ).click( function( event ){

        var actionNames = $( this ).attr( 'data-tmcGdprShell-click' ).split( ' ' );

        for( var x = 0; x < actionNames.length; x++ ){
            $( document ).trigger( 'tmc_gdpr_shell:' + actionNames[x] );
        }

    } );

    //  ----------------------------------------
    //  Objects
    //  ----------------------------------------

    var settingsPopup = {

        'elems' :                   {
            'rootEl' :                  null    //  Popup root div.
        },

        /**
         * Initializes elements.
         *
         * @return void
         */
        initElems :                 function() {

            settingsPopup.elems.rootEl = $( '.tmc_gdpr_shell_settings_popup' );

        },

        /**
         * Initializes close actions.
         *
         * @return void
         */
        initEvents :                function() {

            //  ----------------------------------------
            //  Open settings popup
            //  ----------------------------------------

            $( document ).on( 'tmc_gdpr_shell:openSettings', function( event ) {

                settingsPopup.elems.rootEl.removeClass( 'isHidden' );
                document.body.classList.add( 'noScroll' );

            } );

            //  ----------------------------------------
            //  Close settings popup
            //  ----------------------------------------

            $( document ).on( 'tmc_gdpr_shell:closeSettings', function( event ) {

                settingsPopup.elems.rootEl.addClass( 'isHidden' );
                document.body.classList.remove( 'noScroll' );

            } );

        },

        /**
         * @return void
         */
        open :                      function() {

            $( document ).trigger( 'tmc_gdpr_shell:openSettings' );

        },

        /**
         * @return void
         */
        close :                     function() {

            $( document ).trigger( 'tmc_gdpr_shell:closeSettings' );

        }

    };

    var basePopup = {

        'elems' :                   {
            'rootEl' :                  null    //  Popup root div.
        },

        /**
         * Initializes elements.
         *
         * @return void
         */
        initElems :                 function() {

            basePopup.elems.rootEl = $( '.tmc_gdpr_shell_base_popup' );

        },

        /**
         * Initializes events.
         *
         * @return void
         */
        initEvents :                function() {

            //  ----------------------------------------
            //  Open base popup
            //  ----------------------------------------

            $( document ).on( 'tmc_gdpr_shell:openBase', function( event ) {

                basePopup.elems.rootEl.removeClass( 'isHidden' );

            } );

            //  ----------------------------------------
            //  Close base popup
            //  ----------------------------------------

            $( document ).on( 'tmc_gdpr_shell:closeBase', function( event ) {

                basePopup.elems.rootEl.addClass( 'isHidden' );

            } );

        },

        /**
         * @return void
         */
        open :                      function() {

            $( document ).trigger( 'tmc_gdpr_shell:openBase' );

        },

        /**
         * @return void
         */
        close :                     function() {

            $( document ).trigger( 'tmc_gdpr_shell:closeBase' );

        }

    };

    //  ----------------------------------------
    //  Init popup
    //  ----------------------------------------

    settingsPopup.initElems();
    settingsPopup.initEvents();

    basePopup.initElems();
    basePopup.initEvents();

    basePopup.open();

} );