(function($, app) {

	app.controller('front-poems', function($element, services) {
		return {

			init: function() {
				services.rendering('poem', app.data.poems);
			}

		};
	});
})(jQuery, app);
