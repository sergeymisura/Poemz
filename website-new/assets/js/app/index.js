(function($, app) {

	window.facebookLogin = function(result) {
		if (result.status == 'connected')
		{
			app.get('.facebook-button').loggedIn(result.authResponse);
		}
	};

	app.controller('facebook-button', function($element, services) {
		return {
			init: function() {},

			loggedIn: function(authResponse) {
				services.api.post(
					'auth/facebook',
					{
						user_id: authResponse.userID,
						access_token: authResponse.accessToken
					}
				).success(
					function(response) {
						$.cookie('poemz_session_id', response.data.session.id);
						document.location.reload();
					}
				);
			}
		};
	});

	app.controller('login-form', function($element, services) {
		return {
			init: function() {
				services.bind({
					'.btn-primary': this.login
				});
			},

			login: function() {
				$element.find('.login-error').hide();
				var form = services.form($element);
				if (form.validate()) {
					services.api.post(
						'auth',
						form.collect()
					).success(
						function(response) {
							$.cookie('poemz_session_id', response.data.session.id);
							document.location.reload();
						},
						this
					).error(
						function(code) {
							if (code == 403) {
								$element.find('.login-error').fadeIn();
								return true;
							}
						},
						this
					)
				}
			}
		};
	});

	app.controller('navbar', function($element, services) {
		return {
			init: function() {
				services.bind({
					'.search-field': {
						'focus': this.searchFocus,
						'blur': this.searchBlur
					}
				});
			},

			searchFocus: function($source) {
				$source.animate({ width: '500px' });
			},

			searchBlur: function($source) {
				$source.animate({ width: '220px' });
			}
		};
	});

})(jQuery, app);
