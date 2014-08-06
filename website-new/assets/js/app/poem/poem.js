(function($, app) {

	app.controller('poem', function($element, services) {
		return {

			init: function() {
				services.events({
					'.toggle-comments': this.toggleComments,
					'.record-now': this.displayRecorder
				});

				$element.find('.nice-scroll').niceScroll({
					cursorcolor: '#e3e3e3'
				});

				//this.displayRecorder();
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
			},

			displayRecorder: function() {
				$element.find('.recording-fade').animate({opacity: 0.3});
				$element.find('.recorder').css({
					width: ($element.find('.now-playing').width() + 40) + 'px'
				}).show();
			}

		};
	});
})(jQuery, app);
