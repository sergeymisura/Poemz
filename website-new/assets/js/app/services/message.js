(function($, app) {

	app.service('message', function() {
		return function(options) {
			app.get('#modal-error').display(options);
		}
	});

})(jQuery, app);
