(function($, app) {

	app.service('recording', function($element, services) {
		return {
			init: function() {
				var result = services.deferred.create();
			}
		};
	});

})(jQuery, app);
