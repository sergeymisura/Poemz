(function($, app) {

	app.controller('poem-recitations', function($element, services) {

		var _order;
		var _index;

		return {

			init: function() {
				services.events({

				});

				this.load('created desc');
			},

			load: function(order) {
				_order = order;
				_index = 0;
				app.data.recitations = [];
				$element.find('.recitation-list').html('');
				this.loadMore();
			},

			loadMore: function() {
				$element.find('.loading').show();
				services.api.get(
					'poems/' + app.data.poem.id + '/recitations',
					{
						index: _index,
						order: _order
					}
				).success(
					function(response) {
						app.data.recitations = app.data.recitations.concat(response.data.recitations);
						services.rendering(
							'recitation',
							response.data.recitations,
							{
								index: function(recitation) {
									return app.data.recitations.indexOf(recitation);
								}
							}
						);
						$element.find('.recitation-list').append($element.find('.recitation-template>div').removeClass('rendered'));
						$element.find('.loading').hide();
					},
					this
				)
			}

		};
	});
})(jQuery, app);
