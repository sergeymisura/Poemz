(function($, app) {

	app.controller('poem', function($element, services) {
		return {

			init: function() {
				services.bind({
					'.toggle-comments': this.toggleComments
				});
			},

			toggleComments: function($source) {
				var $comments = null;
				var $parent = $source.parent();
				while ($comments == null) {
					if ($parent.length == 0) break;

					$comments = $parent.find('.comments');
					if ($comments.length == 0) {
						$comments = null;
					}

					$parent = $parent.parent();
				}

				if ($comments) {
					if ($comments.is(':visible')) {
						$comments.slideUp();
						$source.html($source.data('count') + ' comments');
					}
					else {
						$comments.slideDown();
						$source.html('hide comments');
					}
				}
			}

		};
	});
})(jQuery, app);
