(function($, app) {

	app.controller('poem-now-playing', function($element, services) {

		var _recitation;
		var _player;
		var _autoStart;

		return {

			init: function() {
				services.events({

				});
			},

			display: function(recitation, autoStart) {
				_recitation = recitation;
				_autoStart = autoStart;
				if ($element.is(':visible')) {
					$element.slideUp(500, $.proxy(this.prepare, this));
				}
				else {
					this.prepare();
				}
			},

			prepare: function() {
				if (typeof _recitation.media == 'undefined')	{
					services.api.post(
						'poems/' + _recitation.poem_id + '/recitations/' + _recitation.id + '/prepare'
					).success(
						function(response) {
							_recitation.media = response.data.media;
							this.render()
						}, this
					);
				}
				else {
					this.render(_recitation.media);
				}
			},

			render: function() {
				services.rendering('now-playing', _recitation);
				$element.find('audio').mediaelementplayer({
					success: function(player) {
						_player = player;
						if (_autoStart) {
							_player.play();
						}
					}
				});
				$element.slideDown();
			}

		};
	});
})(jQuery, app);
