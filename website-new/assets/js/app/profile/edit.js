(function($, app) {

    app.controller('profile-edit', function($element, services) {
        return {
            init: function() {
				services.events({
					'.btn-toggle-profile': this.toggleProfile,
					'.profile-form': { submit: this.saveProfile },
					'.external-avatar': this.setAvatar,
					'.btn-link-facebook': this.linkFacebook
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
					).success(function() { document.location.reload(); }, this)
						.error(function(code, response) {
							if (code == 400) {
								$element.find('.facebook-alert .alert').html(response.message);
							}
							else {
								$element.find('.facebook-alert .alert').html('Oops... Something went wrong.');
							}
							$element.find('.facebook-alert').fadeIn();
						}, this);
				}
			}
        };
    });

})(jQuery, app);
