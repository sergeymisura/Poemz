(function($, app) {

	var _callback = null;

	app.service('auth', function($element, services) {

		return {

			isLoggedIn: function() {
				return app.data.session != null;
			},

            getSession: function() {
                return app.data.session;
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
			},

			can: function(permission, callback) {
				if (this.isLoggedIn() == false) {
					callback(false);
					return;
				}
				if (typeof app.data.permissions[permission] != 'undefined') {
					callback(app.data.permissions[permission]);
					return;
				}
				/* TODO: Call the server to verify permission */
				return false;
			}

		};
	});
})(jQuery, app);
