(function($, app) {

    app.controller('profile-edit', function($element, services) {
        return {
            init: function() {
				services.events({
					'.btn-toggle-profile': this.toggleProfile,
					'.profile-form': { submit: this.saveProfile },
					'.password-form': { submit: this.savePassword },
					'.external-avatar': this.setAvatar,
					'.btn-link-facebook': this.linkFacebook,
					'.btn-link-googleplus': this.linkGooglePlus,
					'.btn-unlink-profile': this.unlinkProfile
				});

				$element.find('.fileinput-button').fileupload({
					dataType: 'json',
					url: app.config.baseUrl + '/api/users/' + app.data.user.id + '/upload-avatar',
					done: $.proxy(this.uploaded, this),
					dropZone: null
				});
            },

			toggleProfile: function($source) {
				var makeVisible = $source.find('i').hasClass('fa-toggle-off');
				services.api.post(
					'users/' + app.data.user.id + '/social/' + $source.data('provider') + '/toggle',
					{
						is_public: makeVisible ? 1 : 0
					}
				).success(
					function() {
						$source.find('i').toggleClass('fa-toggle-off').toggleClass('fa-toggle-on');
						$source.attr('data-original-title',
							makeVisible
								? 'A link to this profile is visible to others'
								: 'Make it visible to others'
						);
					}
				);
			},

			savePassword: function($source) {
				$source.find('.alert-danger').hide();
				var form = services.form($source);
				if (form.validate())
				{
					var data = form.collect();
					if (data.new_password != data.confirm_password)
					{
						$source.find('.alert-danger').html('The password confirmation does not match').fadeIn();
						return false;
					}

					services.api.post(
						'auth/change-password',
						data
					).success(
						function() {
							$source.find('input').val('');
							$source.find('.alert-info').addClass('hide');
							$source.find('.old-password-group').removeClass('hide');
							$source.find('.alert-success').fadeIn();
						},
						this
					).error(
						function(code, response) {
							if (code == 403) {
								$source.find('.alert-danger').html('The old password does not match').fadeIn();
							}
						}
					)
				}
				return false;
			},

			saveProfile: function($source) {
				var form = services.form($source);
				$source.find('.alert').hide();
				if (form.validate())
				{
					var data = form.collect();
					services.api.post(
						'users/' + app.data.user.id,
						data
					).success(this.profileSaved, this).error(this.profileError, this);
				}
				return false;
			},

			profileSaved: function(response) {
				$element.find('.profile-form .alert-success').fadeIn();
			},

			profileError: function(code, response) {
				var $alert = $element.find('.profile-form .alert-danger');
				if (code == 400) {
					$alert.html(response.message);
				}
				else {
					$alert.html('Oops... something just went wrong.');
				}
				$alert.fadeIn();
			},

			setAvatar: function($source) {
				$element.find('.avatar-message').hide();
				services.api.post(
					'users/' + app.data.user.id + '/set-avatar',
					{ source: $source.data('source') }
				).success(
					function(response) {
						$element.find('img.avatar').attr('src', response.data.user.avatar);
						$element.find('.avatar-message').fadeIn();
					},
					this
				);
			},

			uploaded: function(event, obj) {
				$element.find('img.avatar').attr('src', obj.jqXHR.responseJSON.data.user.avatar);
				$element.find('.avatar-message').fadeIn();
			},

			unlinkProfile: function($source) {
				var provider = $source.data('provider');

				var $alert = $element.find('.' + provider.toLowerCase() + '-alert');
				$alert.hide();

				services.api.post(
					'users/' + app.data.user.id + '/social/' + provider + '/detach'
				).success(
					function() {document.location.reload(); }
				).error(
					function(code, response) {
						if (code == 400) {
							$alert.find('.alert').html(response.message);
						}
						else {
							$alert.find('.alert').html('Oops... Something wrong.');
						}
						$alert.fadeIn();
					}
				);
			},

			linkFacebook: function() {
				FB.getLoginStatus(
					$.proxy(function(response) {
						if (response.status == 'connected') {
							this.facebookCallback(response);
						}
						else {
							FB.login($.proxy(this.facebookCallback), this);
						}
					}, this));
			},

			facebookCallback: function(response) {
				if (response.status == 'connected') {
					services.api.post(
						'users/' + app.data.user.id + '/social/Facebook/attach',
						{
							uid: response.authResponse.userID,
							access_token: response.authResponse.accessToken
						}
					).success(
						function() { document.location.reload(); }, this
					).error(
						function(code, response) {
							if (code == 400) {
								$element.find('.facebook-alert .alert').html(response.message);
							}
							else {
								$element.find('.facebook-alert .alert').html('Oops... Something went wrong.');
							}
							$element.find('.facebook-alert').fadeIn();
						},
						this
					);
				}
			},

			linkGooglePlus: function() {
				gapi.auth.signIn({callback: $.proxy(this.googlePlusCallback, this)});
			},

			googlePlusCallback: function(response) {
				if (response.status.signed_in) {
					if (typeof this._gplus_token != 'undefined'
						&& this._gplus_token == response.access_token) {
						return;
					}
					this._gplus_token = response.access_token;
					services.api.post(
						'users/' + app.data.user.id + '/social/GooglePlus/attach',
						{
							access_token: response.access_token
						}
					).success(
						function() { document.location.reload(); }, this
					).error(
						function(code, response) {
							if (code == 400) {
								$element.find('.googleplus-alert .alert').html(response.message);
							}
							else {
								$element.find('.googleplus-alert .alert').html('Oops... Something went wrong.');
							}
							$element.find('.googleplus-alert').fadeIn();
						},
						this
					);
				}
				else {
					$element.find('.social-button.googleplus').html('Sign in with Google+');
				}
			}
        };
    });

})(jQuery, app);
