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
            "settingsPopupRootEl" :     null,
            "cookiePopupRootEl" :       null,
            "acceptancesOpenerRootEl" : null
        },
        'version' :                 null,

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
         * Initializes all of properties.
         *
         * @return void
         */
        initProperties :            function() {

            tmcGdprShell.elems.settingsPopupRootEl      = $( '.tmc_gdpr_shell_settings_popup' );
            tmcGdprShell.elems.cookiePopupRootEl        = $( '.tmc_gdpr_shell_cookie_popup' );
            tmcGdprShell.elems.acceptancesOpenerRootEl  = $( '.tmc_gdpr_shell_acceptances_opener' );
            tmcGdprShell.version                        = tmcGdprShell.elems.cookiePopupRootEl.attr( 'data-version' );

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

                if( tmcGdprShell.elems.cookiePopupRootEl ){
                    tmcGdprShell.elems.cookiePopupRootEl.removeClass( 'isHidden' );
                }

            } );

            //  ----------------------------------------
            //  Close base popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:closeBase', function( event ) {

                if( tmcGdprShell.elems.cookiePopupRootEl ) {
                    tmcGdprShell.elems.cookiePopupRootEl.addClass('isHidden');
                }

            } );

            //  ----------------------------------------
            //  Open settings popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:openSettings', function( event ) {

                if( tmcGdprShell.elems.settingsPopupRootEl ) {
                    tmcGdprShell.elems.settingsPopupRootEl.removeClass('isHidden');
                    document.body.classList.add('noScroll');
                }

            } );

            //  ----------------------------------------
            //  Close settings popup
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:closeSettings', function( event ) {

                if( tmcGdprShell.elems.settingsPopupRootEl ) {
                    tmcGdprShell.elems.settingsPopupRootEl.addClass('isHidden');
                    document.body.classList.remove('noScroll');
                }

            } );

            //  ----------------------------------------
            //  Open acceptance opener
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:openAcceptancesOpener', function( event ) {

                if( tmcGdprShell.elems.acceptancesOpenerRootEl ) {
                    tmcGdprShell.elems.acceptancesOpenerRootEl.removeClass('isHidden');
                }

            } );

            //  ----------------------------------------
            //  Close acceptance opener
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:closeAcceptancesOpener', function( event ) {

                if( tmcGdprShell.elems.acceptancesOpenerRootEl ) {
                    tmcGdprShell.elems.acceptancesOpenerRootEl.addClass('isHidden');
                }

            } );

            //  ----------------------------------------
            //  Accept all
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:acceptAll', function( event ) {

                wpCookies.set( 'tmcGdprShellAccepted', 'all', tmcGdprShell.getDaysAfterNow( 365 ) );
                wpCookies.set( 'tmcGdprShellVersion', tmcGdprShell.version, tmcGdprShell.getDaysAfterNow( 365 ) );

            } );

            //  ----------------------------------------
            //  Accept chosen
            //  ----------------------------------------

            $( document ).on( 'tmcGdprShell:acceptChosen', function( event ) {

                tmcGdprShell.elems.settingsPopupRootEl.find( 'form' ).submit();

            } );

            //  ----------------------------------------
            //  Form submission
            //  ----------------------------------------

            tmcGdprShell.elems.settingsPopupRootEl.find( 'form' ).on( 'submit', function( event ) {

                event.preventDefault();

                var acceptedScriptIds = [];

                $.each( $( this ).serializeArray(), function( index, data ){

                    if( data.name === 'acceptanceId' ){
                        acceptedScriptIds.push( data.value );
                    }

                } );

                wpCookies.set( 'tmcGdprShellAccepted', acceptedScriptIds.join( ',' ), tmcGdprShell.getDaysAfterNow( 365 ) );
                wpCookies.set( 'tmcGdprShellVersion', tmcGdprShell.version, tmcGdprShell.getDaysAfterNow( 365 ) );

            } );

        },

        /**
         * Called after everything is ready.
         *
         * @return void
         */
        ready :                         function() {

            if( wpCookies.get( 'tmcGdprShellVersion' ) !== tmcGdprShell.version ){
                $( document ).trigger( 'tmcGdprShell:openBase' );
            } else {
                $( document ).trigger( 'tmcGdprShell:openAcceptancesOpener' );
            }

        }

    };

    tmcGdprShell.initProperties();
    tmcGdprShell.initEvents();
    tmcGdprShell.ready();

} );