(function($, app) {

	app.controller('navbar', function($element, services) {
		var _searchProgress = 0;
		return {
			init: function() {
				services.bind({
					'.login-box': {
						click: 'displayLoginBox',
					},
					'.switch-to-create': {
						click: 'switchToCreateAccount'
					},
					'.switch-to-login': {
						click: 'switchToLogin'
					},
					'.login-button': {
						click: 'login'
					},
					'.create-account-button': {
						click: 'register'
					},
					'.search-query': {
						focus: 'performSearch',
						keyup: 'performSearch',
						blur: 'closeSearch'
					}
				});
				if (app.data.user) {
					services.rendering('user-box', app.data.user);
					$element.find('.login-box').hide();
					$element.find('.user-box').show();
				}
				else {
					$element.find('.login-box').show();
					$element.find('.user-box').hide();
				}
			},
			
			displayLoginBox: function() {
				if ($element.find('.popover-login').is(':visible')) {
					$element.find('.popover-login').fadeOut();
				}
				else {
					$element.find('.popover-login').fadeIn();
				}
			},
						
			switchToCreateAccount: function() {
				$element.find('.log-in-controls').hide();
				$element.find('.create-account-controls').fadeIn();
			},
			
			switchToLogin: function() {
				$element.find('.create-account-controls').hide();
				$element.find('.log-in-controls').fadeIn();
			},

			login: function() {
				$element.find('.login-error').hide();
				if (services.validation($element.find('.popover-login'))) {
					services.api.post(
						'auth/login',
						{
							email: $element.find('.auth-email').val(),
							password: $element.find('.auth-password').val()
						}
					).success(function(data) {
						document.location = document.location.href;
					}).error(function(status, data) {
						$element.find('.login-error').fadeIn();
					});
				}
			},

			register: function() {
				$element.find('.create-error').hide();
				if (services.validation($element.find('.popover-login'))) {
					var password = $element.find('.auth-password').val();
					var confirmation = $element.find('.auth-confirm').val();
					if (password != confirmation) {
						services.validation.displayError($element.find('.auth-confirm'), 'Please re-type confirmation.');
						return;
					}

					services.api.post(
						'auth/register',
						{
							email: $element.find('.auth-email').val(),
							password: password,
							username: $element.find('.auth-username').val()
						}
					).success(function() {
						document.location = app.config.baseUrl + '/welcome';
					}).error(function(status, data) {
						if (status == 401) {
							services.validation.displayError(
								$element.find(data.error == 'ERR_EMAIL_EXISTS' ? '.auth-email' : '.auth-username'),
								data.message
							);
							$element.find('.create-error').html(data.message).fadeIn();
						}
					})
				}
			},
			
			performSearch: function($source) {
				var q = $source.val();
				var $box = $element.find('.popover-search');
				if (q != '' /*&& _searchProgress == 0*/) {
					_searchProgress = 2;
					services.api.get(
						'search/poem',
						{ q: q }
					).success(function (data){
						_searchProgress--;
						services.rendering('search-poem', data);
						if (!$box.is(':visible')) {
							$box.fadeIn();
						}
					}).error(function() { _searchProgress--; });
					services.api.get(
						'search/author',
						{ q: q }
					).success(function (data){
						_searchProgress--;
						services.rendering('search-author', data);
						if (!$box.is(':visible')) {
							$box.fadeIn();
						}
					}).error(function() { _searchProgress--; });
				}
				else {
					this.closeSearch();
				}
			},
			
			closeSearch: function() {return;
				setTimeout(function() { $element.find('.popover-search').hide() }, 500);
			}
		}
	});

})(jQuery, app);