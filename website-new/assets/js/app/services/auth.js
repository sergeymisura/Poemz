(function($, app) {

	var _callback = null;

	app.service('auth', function($element, services) {

		return {

			login: function(callback) {
				if (app.data.session != null) {
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
