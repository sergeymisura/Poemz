(function($, app) {
	
	app.controller(
		'submit-poem',
		function($element, services) {
			return {
				
				init: function() {
					services.bind({
						'[name="author"]': {
							keyup: 'searchAuthor',
							focus: 'searchAuthor',
							blur: 'closeSearch'
						}
					});
				},
				
				searchAuthor: function($source) {
					var query = $source.val();
					if (query != '') {
						services.api.get('search/author', { q: query})
							.success(function(result) {
								$element.find('.popover-search').fadeIn();
							}, this);
					}
				}
				
			};
		}
	);
})(jQuery, app);
