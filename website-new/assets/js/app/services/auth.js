(function($, app) {

	var _callback = null;

	app.service('auth', function($element, services) {

		return {

			isLoggedIn: function() {
				return app.data.session != null;
			},

			login: function(callback) {
				if (this.isLoggedIn()) {
					callback(app.data.session);
					return;
				}
				_callback = callback;
				app.get('#modal-sign-in').signInMode();
			},

			loginCompleted: function(session) {
				app.data.session = session;
				if (_callback) {
					_callback(session);
				}
				$(app).triggerHandler('loginCompleted');
			}

		};
	});
})(jQuery, app);
