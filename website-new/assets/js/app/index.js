(function($, app) {

	window.facebookLogin = function(result) {
		if (result.status == 'connected')
		{
			app.get('.facebook-button').loggedIn(result.authResponse);
		}
	};

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
						services.auth.loginCompleted(response.data.session);
					}
				);
			}
		};
	});

	app.controller('login-form', function($element, services) {

		var _callback;

		return {
			init: function() {
				services.events({
					'.login-button': this.login,
					'.create-account-button': this.createAccount,
					'.have-account': this.modeChange
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

			signInMode: function(callback) {
				_callback = callback || null;
				$element.find('.have-account').prop('checked', true);
				$element.find('.sign-in-only').show();
				$element.find('.create-account-only').hide();
				$element.modal();
			},

			createAccountMode: function(callback) {
				_callback = callback || null;
				$element.find('.have-account').prop('checked', false);
				$element.find('.sign-in-only').hide();
				$element.find('.create-account-only').show();
				$element.modal();
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
							services.auth.loginCompleted(response.data.session);
						},
						this
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
				var form = services.form($element);
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
						function(response) {
							services.auth.loginCompleted(response.data.session);
						},
						this
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
			}
		};
	});

	app.controller('navbar', function($element, services) {
		return {
			init: function() {
				services.events({
					'.search-field': {
						'focus': this.searchFocus,
						'blur': this.searchBlur
					},
					'.sign-in': this.signIn,
					'.create-account': this.createAccount
				});

				services.events(app, {
					'loginCompleted': this.render
				});

				this.render();
			},

			render: function() {
				services.rendering('login-area', app.data.session || {});
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

	app.controller('error-message', function($element, services) {
		return {
			init: function() {},

			display: function(options) {
				options = $.extend(
					{
						title: 'Oops...',
						type: 'danger',
						text: 'Something just happened'
					},
					options);
				services.rendering('error', options);
				$element.modal();
			}
		};
	});

	app.transformation('.btn-icon, .btn-icon-lg', function($element) {
		$element.tooltip({
			placement: 'top',
			title: $element.attr('title')
		});
	});

	app.transformation('[data-permission]', function($element, services) {
		$element.addClass('hide');
		if (services.auth.isLoggedIn()) {
			services.auth.can($element.data('permission'), function(can) {
				if (can) {
					$element.removeClass('hide');
				}
			});
		}
	});

	app.urls = {
		image: function(id) {
			if (id == null) {
				return app.config.baseUrl + '/assets/img/mystery_man.png';
			}
			return app.config.baseUrl + '/images/' + id + '.jpg';
		},

		author: function(author) {
			return app.config.baseUrl + '/' + author.slug;
		},

		poem: function(poem, author) {
			author = author || poem.author;
			return app.config.baseUrl + '/' + author.slug + '/' + poem.slug;
		},

		recitation: function(recitation, poem, author) {
			poem = poem || recitation.poem;
			author = author || poem.author;
			return app.config.baseUrl + '/' + author.slug + '/' + poem.slug + '#listen-' + recitation.id;
		},

		user: function(user) {
			return app.config.baseUrl + '/users/' + user.slug;
		}
	};

})(jQuery, app);
