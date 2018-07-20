jQuery( document ).ready( function( $ ){

    //  ----------------------------------------
    //  Initialize events calling with clicking.
    //  ----------------------------------------

    $( '[data-tmcGdprShell-click]' ).click( function( event ){

        var actionNames = $( this ).attr( 'data-tmcGdprShell-click' ).split( ' ' );

        $.each( actionNames, function( key, value ){
            $( document ).trigger( 'tmcGdprShell:' + value );
        } );

    } );

    //  ----------------------------------------
    //  Objects
    //  ----------------------------------------

    var tmcGdprShell = {

        'elems' :                   {
            "settingsPopupRootEl" :                 $( '.tmc_gdpr_shell_settings_popup' ),
            "basePopupRootEl" :                     $( '.tmc_gdpr_shell_base_popup' )
        },

        /**
         * Converts given number of days to timestamp from current time.
         *
         * @param days int
         *
         * @return int
         */
        getDaysAfterNow :           function( days ) {

            return Math.floor( Date.now() / 1000 ) + 3600 * 1000 * 24 * days;

        },

        /**
         * Initializes close actions.
         *
         * @return void
         */
        initEvents :                function() {

            //  ----------------------------------------
            //  Open base popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:openBase', function( event ) {

                tmcGdprShell.elems.basePopupRootEl.removeClass( 'isHidden' );

            } );

            //  ----------------------------------------
            //  Close base popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:closeBase', function( event ) {

                tmcGdprShell.elems.basePopupRootEl.addClass( 'isHidden' );

            } );

            //  ----------------------------------------
            //  Open settings popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:openSettings', function( event ) {

                tmcGdprShell.elems.settingsPopupRootEl.removeClass( 'isHidden' );
                document.body.classList.add( 'noScroll' );

            } );

            //  ----------------------------------------
            //  Close settings popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:closeSettings', function( event ) {

                tmcGdprShell.elems.settingsPopupRootEl.addClass( 'isHidden' );
                document.body.classList.remove( 'noScroll' );

            } );

            //  ----------------------------------------
            //  Accept all
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:acceptAll', function( event ) {

                wpCookies.set( 'tmcGdprShellAccepted', 'all', tmcGdprShell.getDaysAfterNow( 365 ) );

            } );

            //  ----------------------------------------
            //  Accept choosen
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:acceptChoosen', function( event ) {

                //  TODO - maybe form serializing should be here?

            } );

            //  ----------------------------------------
            //  Form submission
            //  ----------------------------------------

            tmcGdprShell.elems.settingsPopupRootEl.find( 'form' ).on( 'submit', function( event ){

                event.preventDefault();

                var acceptedScriptIds = [];

                $.each( $( this ).serializeArray(), function( index, data ){

                    if( data.name === 'scriptId' ){
                        acceptedScriptIds.push( data.value );
                    }

                } );

                wpCookies.set( 'tmcGdprShellAccepted', acceptedScriptIds.join( ',' ), tmcGdprShell.getDaysAfterNow( 365 ) );

            } );

        },

        /**
         * Called after everything is ready.
         *
         * @return void
         */
        ready :                         function() {

            $( document ).trigger( 'tmcGdprShell:openBase' );

        }

    };

    tmcGdprShell.initEvents();
    tmcGdprShell.ready();

} );