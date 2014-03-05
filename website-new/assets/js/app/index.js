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
					'.login-button': this.login,
					'.have-account': this.modeChange
				});
			},

			modeChange: function($source) {
				if ($source.prop('checked')) {
					this.signInMode();
				}
				else {
					this.createAccountMode();
				}
			},

			signInMode: function() {
				$element.find('.have-account').prop('checked', true);
				$element.find('.sign-in-only').show();
				$element.find('.create-account-only').hide();
			},

			createAccountMode: function() {
				$element.find('.have-account').prop('checked', false);
				$element.find('.sign-in-only').hide();
				$element.find('.create-account-only').show();
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
					},
					'.sign-in': this.signIn,
					'.create-account': this.createAccount
				});
			},

			searchFocus: function($source) {
				$source.animate({ width: '500px' });
			},

			searchBlur: function($source) {
				$source.animate({ width: '220px' });
			},

			signIn: function() {
				app.get('#modal-sign-in').signInMode();
			},

			createAccount: function() {
				app.get('#modal-sign-in').createAccountMode();
			}
		};
	});

	app.urls = {
		image: function(id) {
			return app.config.baseUrl + '/images/' + id + '.jpg';
		},

		author: function(author) {
			return app.config.baseUrl + '/' + author.slug;
		},

		poem: function(poem) {
			return app.config.baseUrl + '/' + poem.author.slug + '/' + poem.slug;
		}
	};

})(jQuery, app);
