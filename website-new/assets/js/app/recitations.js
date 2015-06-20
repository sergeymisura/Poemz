(function($, app) {

	app.controller('recitations', function($element, services) {

		var _order;
		var _index;

		return {

			init: function() {
				services.events({
					'.order a': this.changeOrder,
					'.more-tab': this.loadMore
				});

				this.load('best');
			},

			load: function(order) {
				_order = order;
				_index = 0;
				app.data.recitations = [];
				$element.find('.more-tab').show();
				this.loadMore();
			},

			loadMore: function() {
				$element.find('.loading').show();
				services.api.get(
					$element.data('source'),
					{
						index: _index,
						order: _order
					}
				).success(
					function(response) {
						$element.find('.loading').hide();
						if (response.data.recitations.length == 0) {
							if (app.data.recitations.length == 0) {
								$element.find('.no-recordings').fadeIn();
							}
							$element.find('.more-tab').hide();
							return;
						}
						app.data.recitations = app.data.recitations.concat(response.data.recitations);
						services.rendering.append(
							'recitation',
							response.data.recitations,
							{
								index: function(recitation) {
									return app.data.recitations.indexOf(recitation);
								}
							},
							true
						);

						_index = app.data.recitations.length;
						$(app).trigger('loadVotes');
					},
					this
				)
			},

			changeOrder: function($source)
			{
				$element.find('.order li').removeClass('active');
				$source.parent('li').addClass('active');
				this.load($source.data('sort'));
			}
		};
	});
})(jQuery, app);
