(function($, app) {

	app.controller('social-login', function($element, services) {
		return {
			init: function() {
				services.events({
					'.social-button.facebook': this.facebook,
					'.social-button.googleplus': this.googlePlus
				});
			},

			facebook: function($source) {
				$source.html('Signing in...');
				FB.getLoginStatus($.proxy(
					function(response) {
						if (response.status == 'connected') {
							this.facebookConnected(response);
						}
						else {
							FB.login($.proxy(this.facebookConnected, this));
						}
					}
					, this));
			},

			facebookConnected: function(response) {
				if (response.status == 'connected') {
					var authResponse = response.authResponse;
					services.api.post(
						'auth/facebook',
						{
							user_id: authResponse.userID,
							access_token: authResponse.accessToken
						}
					).success(
						function(response) {
							services.auth.loginCompleted(response.data.session);
						}
					).error(
						function() {
							$element.find('.social-button.facebook').html('Sign in with Facebook');
						}
					);
				}
				else {
					$element.find('.social-button.facebook').html('Sign in with Facebook');
				}
			},

			googlePlus: function($source) {
				$source.html('Signing in...');
				gapi.auth.signIn({callback: $.proxy(this.googlePlusConnected, this)});
			},

			googlePlusConnected: function(response) {
				if (response.status.signed_in) {
					if (typeof this._gplus_token != 'undefined'
						&& this._gplus_token == response.access_token) {
						return;
					}
					this._gplus_token = response.access_token;
					services.api.post(
						'auth/google-plus',
						{
							access_token: response.access_token
						}
					).success(
						function(response) {
							services.auth.loginCompleted(response.data.session);
						}
					).error(
						function() {
							$element.find('.social-button.facebook').html('Sign in with Google+');
						}
					);
				}
				else {
					$element.find('.social-button.googleplus').html('Sign in with Google+');
				}
			}
		};
	});

	app.controller('login-form', function($element, services) {

		return {
			init: function() {
				services.events({
					'.login-button': this.login,
					'.create-account-button': this.createAccount,
					'.have-account': this.modeChange,
					'.btn-activate': this.activate
				});

				services.events(app, {
					'loginCompleted': this.hide
				});
			},

			hide: function() {
				$element.modal('hide');
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
				$element.find('.activation-form').hide();
				$element.find('.login-form').show();
				$element.find('.have-account').prop('checked', true);
				$element.find('.sign-in-only').show();
				$element.find('.create-account-only').hide();
				$element.modal();
			},

			createAccountMode: function() {
				$element.find('.activation-form').hide();
				$element.find('.login-form').show();
				$element.find('.have-account').prop('checked', false);
				$element.find('.sign-in-only').hide();
				$element.find('.create-account-only').show();
				$element.modal();
			},

			activationMode: function(session) {
				$element.find('.activation-form').show();
				$element.find('.login-form').hide();
				services.rendering('activation', session)
			},

			login: function() {
				$element.find('.login-error').hide();
				var form = services.form($element);
				if (form.validate()) {
					services.api.post(
						'auth',
						form.collect()
					).success(
						this.loginCompleted
					).error(
						function(code) {
							if (code == 403) {
								$element.find('.login-error').html('Please try again...').fadeIn();
								return true;
							}
						},
						this
					)
				}
			},

			createAccount: function() {
				$element.find('.login-error').hide();
				var form = services.form('.login-form');
				if (form.validate()) {
					var data = form.collect();
					if (data.password != data.confirmation) {
						$element.find('.login-error').html('Password confirmation does not match.').fadeIn();
						return;
					}

					services.api.post(
						'auth/register',
						form.collect()
					).success(
						this.loginCompleted
					).error(
						function(code, response) {
							if (code == 400) {
								$element.find('.login-error').html(response.message).fadeIn();
								return true;
							}
						},
						this
					)
				}
			},

			activate: function() {
				var form = services.form('.activation-form');
				$element.find('.login-error').hide();
				if (form.validate()) {
					services.api.post(
						'auth/activate',
						form.collect()
					).success(
						this.loginCompleted
					).error(
						function(code, response) {
							if (code == 400) {
								$element.find('.activation-error').html(response.message).fadeIn();
								return true;
							}
						},
						this
					);
				}
			},

			loginCompleted: function(response) {
				services.auth.loginCompleted(response.data.session);
			}
		};
	});

})(jQuery, app);
