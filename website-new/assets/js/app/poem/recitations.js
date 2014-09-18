(function($, app) {

	app.controller('poem-recitations', function($element, services) {

		var _order;
		var _index;

		return {

			init: function() {
				services.events({
					'.order a': this.changeOrder,
					'.more-tab': this.loadMore
				});

				this.load('new');
			},

			load: function(order) {
				_order = order;
				_index = 0;
				app.data.recitations = [];
				$element.find('.recitation-list').html('');
				$element.find('.more-tab').show();
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
						$element.find('.loading').hide();
						if (response.data.recitations.length == 0) {
							if (app.data.recitations.length == 0) {
								$element.find('.no-recordings').fadeIn();
							}
							$element.find('.more-tab').hide();
							return;
						}
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
						var copy = $($element.find('.recitation-template').html());
						$element.find('.recitation-list').append($element.find('.recitation-template .recitation-rendered'));
						$element.find('.recitation-template').html(copy);
						$element.find('.recitation-list .recitation-rendered').removeClass('recitation-rendered');
						_index = app.data.recitations.length;
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
