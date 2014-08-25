(function($, app) {

	app.controller('new-poem', function($element, services) {

		var _author;

		return {

			init: function() {
				services.events({

				});
			},

			display: function(author) {
				_author = author;
				$element.fadeIn();
				app.get($element.find('.poem-selector')).display({
					uri: 'authors/' + author.id + '/poems',
					data: {},
					name: 'poems'
				});
			}

		};
	});
})(jQuery, app);
