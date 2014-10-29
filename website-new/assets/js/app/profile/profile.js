(function($, app) {

	app.controller('profile', function($element, services) {
		return {

			init: function() {
				services.events(app, {
                    loginCompleted: this.render
                });

                this.render();
			},

            render: function() {
                var own = false;
                if (services.auth.isLoggedIn()) {
                    own = services.auth.getSession().user.id == app.data.user.id;
                }

                if (own) {
                    $element.find('.own').removeClass('hide');
                }
                else {
                    $element.find('.own').addClass('hide');
                }
            }
		};
	});
})(jQuery, app);
