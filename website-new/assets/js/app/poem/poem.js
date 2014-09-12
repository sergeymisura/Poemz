(function($, app) {

	app.controller('poem', function($element, services) {
		return {

			init: function() {
				services.events({
					'.toggle-comments': this.toggleComments,
					'.record-now': this.displayRecorder,
					'.recorder': {
						'created': this.recitationCreated
					},
					'.listen': this.listen
				});

				services.events(app, {
					ready: this.appReady
				});

				$element.find('.nice-scroll').niceScroll({
					cursorcolor: '#e3e3e3'
				});


			},

			appReady: function() {
				if (document.location.hash == '#record') {
					this.displayRecorder();
				}

				if (document.location.hash.indexOf('#listen-') == 0) {
					var id = parseInt(document.location.hash.split('-')[1]);
					services.api.get(
						'poems/' + app.data.poem.id + '/recitations/' + id
					).success(
						function(response) {
							app.get('.now-playing').display(response.data.recitation, false);
						},
						this
					);
				}
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
				app.get('.recorder').display($element.find('.recitations').width() + 40);
			},

			recitationCreated: function() {
				$element.find('.now-playing').hide();
				$element.find('.recitation-created').fadeIn();
			},

			listen: function($source) {
				var recitation = app.data.recitations[$source.data('index')];
				app.get('.now-playing').display(recitation, true);
			}
		};
	});
})(jQuery, app);
