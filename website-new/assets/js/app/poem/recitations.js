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
				);
			}

		};
	});
})(jQuery, app);
