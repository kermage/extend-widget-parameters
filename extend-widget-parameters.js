/*!
 *  Extend Widget Parameters 1.0.0
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
        var id_base = $widget_clone.find( '.id_base[name="id_base"]' ).val();
        var widget_number = $widget_clone.find( '.widget_number[name="widget_number"]' ).val();
        var $widget_base = $( '#widget-list .id_base[value="' + id_base + '"]' ).parents( '.widget' );
        var multi_number = $widget_base.find( '.multi_number' ).val();

        $widget_clone.html(
            $widget_clone.html().replace( /<[^<>]+>/g, function( m ) {
                var regex = new RegExp( widget_number, 'g' );
                return m.replace( regex, multi_number );
            })
        );
        $widget_clone.attr( 'id', 'widget-1_' + id_base + '-' + multi_number );
        multi_number++;
        $widget_base.find('input.multi_number').val( multi_number ) ;

        $widget_clone.insertAfter( $widget_original );
        wpWidgets.save( $widget_clone, 0, 0, 1 );

    });

}(jQuery));
