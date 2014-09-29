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

	app.transformation('.btn-icon', function($element) {
		$element.tooltip({
			placement: 'top',
			title: $element.attr('title')
		});
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
		}
	};

})(jQuery, app);
