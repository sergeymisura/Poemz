(function($, app) {

	app.controller('poem-recitations', function($element, services) {

		var _order;
		var _index;

		return {

			init: function() {
				services.events({

				});

				this.load('votes');
			},

			load: function(order) {
				_order = order;
				_index = 0;
				this.loadMore();
			},

			loadMore: function() {
				$element.find('.loading').show();
			}

		};
	});
})(jQuery, app);
