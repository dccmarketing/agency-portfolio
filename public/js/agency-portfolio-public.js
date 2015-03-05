(function( $ ) {
	'use strict';

	$(function() {

		/**
		 * Toggles the "hide" class based on the $compare parameter
		 *
		 * @param  {string} $compare The class to compare against
		 */
		var hideShow = function( $compare ) {

			if ( $('.item-link.'+$compare).hasClass('hide') ) {

				$('.item-link.'+$compare).removeClass('hide');

			}

			if ( $('.item-link:not(.'+$compare+'.hide)') ) {

				$('.item-link:not(.'+$compare+')').addClass('hide');

			}

		};

		/**
		 * Toggles a "hide" class based on selected taxonomy/taxonomies
		 *
		 * Logic:
		 * Both selected All 			Remove hide class from all items
		 * Either selected All 			Remove hide from items matching other select and
		 * 									hide items not matching other select
		 * Otherwise 					Remove hide from items matching both selects and
		 * 									hide items not matching both selects
		 */
		$('#portfolio-types-select, #portfolio-industries-select').on( 'change', function(){
			var $typeVal = $('#portfolio-types-select').val();
			var $indVal = $('#portfolio-industries-select').val();

			if ( 'All' === $typeVal && 'All' === $indVal ) {

				$('.item-link').removeClass('hide');

			} else if ( 'All' === $typeVal ) {

				hideShow( $indVal );

			} else if ( 'All' === $indVal ) {

				hideShow( $typeVal );

			} else {

				hideShow( $typeVal+'.'+$indVal );

			}

		});

	});

})( jQuery );