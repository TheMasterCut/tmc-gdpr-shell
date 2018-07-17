jQuery( document ).ready( function( $ ){

    var popup = {

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

            popup.elems.rootEl      = $( '.tmc_gdpr_shell_popup' );
            popup.elems.closeEl     = $( '.tmc_gdpr_shell_close' );

        },

        /**
         * Initializes close actions.
         *
         * @return void
         */
        initMechanics :             function() {

            popup.elems.closeEl.click( function(){
                popup.close();
            } );

            popup.elems.rootEl.click( function( event ){

                if( event.target === this ){    //  Root div acts like background.
                    popup.close();
                }

            } );

        },

        /**
         * @return void
         */
        open :                      function() {

            popup.elems.rootEl.removeClass( 'isHidden' );

        },

        /**
         * @retjurn void
         */
        close :                     function() {

            popup.elems.rootEl.addClass( 'isHidden' );

        }

    };

    //  ----------------------------------------
    //  Init popup
    //  ----------------------------------------

    popup.initElems();
    popup.initMechanics();

} );