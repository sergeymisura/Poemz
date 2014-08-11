(function($, app) {

	var _session = null;

	app.service('auth', function($element, services) {

		return {

			session: function(callback) {
				if (_session != null) {
					callback(_session);
					return;
				}
				if ($.cookie('poemz_session_id')) {
					_session = {
						id: $.cookie('poemz_session_id')
					};
					callback(_session);
					return;
				}
				else {
					app.get('#modal-sign-in').signInMode(
						function(session) {
							_session = session;
							callback(_session);
						}
					);
				}
			}

		};
	});
})(jQuery, app);
