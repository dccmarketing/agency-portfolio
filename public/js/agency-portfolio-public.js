(function( $ ) {
	'use strict';

	$( function() {

		var $container = $('.portfolio-items-wrap');
		var $select = $('.portfolio-filters-select');
		var filters = {};

		$container.isotope({
			itemSelector: '.item-link',
			layoutMode: 'fitRows'
		});

		$select.on( 'change', function() {
			var $this = $(this);

			var $optionSet = $this;
			var group = $optionSet.attr('id');
			filters[group] = $this.find('option:selected').attr('data-filter');

			var isoFilters = [];
			for (var prop in filters) {
				isoFilters.push(filters[prop]);
			}
			var selector = isoFilters.join('');

			$container.isotope({
				filter: selector
			});

			return false;
		});

	});

})( jQuery );