(function($, app) {

	app.controller('front-poems', function($element, services) {

		var currentList = 'newest';

		return {

			init: function() {
				services.events({
					'.nav-tabs a': this.listSelected
				});

				services.rendering('poem', app.data.poems);
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

					$element.find('.poems').hide();
					$element.find('.loading').show();
					currentList = list;

					services.api.get(
						'poems/' + list
					).success(
						function(response) {
							services.rendering('poem', response.data.poems);
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
