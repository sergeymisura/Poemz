(function($, app) {

	app.controller('new', function($element, services) {

		return {

			init: function() {
				services.events({
					'.step-1': {
						"authorSelected": this.authorSelected
					}
				});
			},

			authorSelected: function($source, ev, author) {
				app.get($element.find('.step-2')).display(author);
			}

		};
	});
})(jQuery, app);
