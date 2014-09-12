(function($, app) {

	app.controller('front-poems', function($element, services) {

		var currentList = 'newest';

		return {

			init: function() {
				services.events({
					'.nav-tabs a': this.listSelected
				});

				this.render(app.data.poems, app.data.recitations);
			},

			render: function (poems, recitations) {
				services.rendering(
					'poem',
					poems,
					{
						recitations: function(poemId) {
							return recitations[poemId];
						}
					}
				);
			},

			listSelected: function($source) {
				var list = $source.data('list');
				if (list != currentList)
				{
					if (list == 'favorite' && !services.auth.isLoggedIn())
					{
						services.auth.login($.proxy(
							function () {
								this.listSelected($source);
							},
							this
						));
						return;
					}

					$element.find('.nav-tabs li').removeClass('active');
					$source.parent().addClass('active');

					$element.find('.loading').css('height', $element.find('.poems').height() + 'px').show();
					$element.find('.poems').hide();
					currentList = list;

					services.api.get(
						'poems/' + list
					).success(
						function(response) {
							this.render(response.data.poems, response.data.recitations);
							$element.find('.poems').fadeIn();
							$element.find('.loading').hide();
						},
						this
					);
				}
			}
		};
	});
})(jQuery, app);
