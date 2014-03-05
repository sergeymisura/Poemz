(function($, app) {

	app.controller('front-poems', function($element, services) {
		return {

			init: function() {
				services.bind({

				});

				services.rendering('poem', app.data.poems);
			}

		};
	});
})(jQuery, app);
