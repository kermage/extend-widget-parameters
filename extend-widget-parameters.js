/*!
 *  Extend Widget Parameters 0.1.0
 *  Copyright (C) 2016 Gene Alyson Fortunado Torcende
 *  Licensed under GNU General Public License v2 or later.
 */

(function($) {
    'use strict';

    var $thisEWP;

    $( document ).on( 'click', 'a[id^="widget-"][id $="-ewp-toggle"]', function( e ) {
        e.preventDefault();

        $thisEWP = $( this ).siblings( '.ewp' );

        if ( $( window ).outerWidth() <= 600 || $( 'body' ).hasClass( 'wp-customizer' ) ) {
            $thisEWP.toggleClass( 'active' ).toggle( 'slide', { direction: 'up' } );
        } else {
            $thisEWP.toggleClass( 'active' ).toggle( 'slide', { direction: 'right' } );
        }

    });

    $( document ).on( 'click', 'a[id^="widget-"][id $="-ewp-clone"]', function( e ) {
        e.preventDefault();

        var $widget_original = $( this ).parents( '.widget' );
        var $widget_clone = $widget_original.clone();

        $widget_clone.insertAfter( $widget_original );
        wpWidgets.save( $widget_clone, 0, 0, 1 );

    });

}(jQuery));
