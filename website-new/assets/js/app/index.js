(function($, app) {

	window.facebookLogin = function(result) {
		if (result.status == 'connected')
		{
			app.get('.facebook-button').loggedIn(result.authResponse);
		}
	};

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
				return app.config.baseUrl + 'assets/img/mystery_man.png';
			}
			return app.config.baseUrl + 'images/' + id + '.jpg';
		},

		author: function(author) {
			return app.config.baseUrl + author.slug;
		},

		poem: function(poem, author) {
			author = author || poem.author;
			return app.config.baseUrl + author.slug + '/' + poem.slug;
		},

		recitation: function(recitation, poem, author) {
			poem = poem || recitation.poem;
			author = author || poem.author;
			return app.config.baseUrl + author.slug + '/' + poem.slug + '#listen-' + recitation.id;
		},

		user: function(user) {
			return app.config.baseUrl + 'users/' + user.slug;
		}
	};

})(jQuery, app);
