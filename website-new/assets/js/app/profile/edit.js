(function($, app) {

    app.controller('profile-edit', function($element, services) {
        return {
            init: function() {
				services.events({
					'.btn-toggle-profile': this.toggleProfile
				});
            },

			toggleProfile: function($source) {
				var makeVisible = $source.find('i').hasClass('fa-toggle-off');
				services.api.post(
					'users/' + app.data.user.id + '/toggle-social-profile',
					{
						provider: $source.data('provider'),
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
			}
        };
    });

})(jQuery, app);
