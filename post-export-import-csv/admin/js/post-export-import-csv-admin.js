(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$( function() {
        $('hr.wp-header-end').before('<a href="javascript:void(0);" class="page-title-action" id="export-post-to-csv">Export</a>');
        $('#export-post-to-csv').after('<span style="float: none; margin-top: -10px;" class="spinner"></span>');
    });

    $( window ).load(function() {

	    $( '#export-post-to-csv' ).click(function(e){ 

	        e.preventDefault();

	        $( '.spinner' ).addClass( 'is-active' ); // add the spinner is-active class before the Ajax posting 

	        $.post(
	            ajaxurl,
	            {
	                action : 'fetch_csv_with_post_data',
	            },
	            function( response ) {
					window.location.href = response;
	                $( '.spinner' ).removeClass( 'is-active' ); // remove the class after the data has been posted 
	            }
	        );
	    });

	});

})( jQuery );
