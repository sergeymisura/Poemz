(function($, app) {

	app.controller('new-author', function($element, services) {

		return {

			init: function() {
				services.events({
					'.author-finder': {
						objectSelected: this.authorSelected,
						newObject: this.newAuthor
					}
				});

				services.events(app, {
					'ready': this.appReady
				});
			},

			appReady: function() {
				app.get($element.find('.author-finder')).display({
					uri: 'authors',
					data: {},
					name: 'authors'
				});
			},

			authorSelected: function($source, ev, author) {
				$element.find('.author-finder').hide();
				services.rendering('selected-author', author).fadeIn();

				$element.trigger('authorSelected', author);
			},

			newAuthor: function($source, ev, name) {
				services.auth.login($.proxy(
					function() {
						services.api.post(
							'authors',
							{
								name: name
							}
						).success(
							function(response) {
								this.authorSelected($source, ev, response.data.author);
							},
							this
						);
					},
					this
				));
			}
		};
	});
})(jQuery, app);
