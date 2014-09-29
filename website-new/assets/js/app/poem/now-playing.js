(function($, app) {

	app.controller('poem-now-playing', function($element, services) {

		var _recitation;
		var _player;
		var _autoStart;
		var _statHash;

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
					this.render();
				}
			},

			createStatHash: function()
			{
				_statHash = SHA1(Math.random() + '_' + (new Date().valueOf()) + '_' + _recitation.id);
			},

			render: function() {

				var controller = this;
				this.createStatHash();

				services.rendering('now-playing', _recitation);
				$element.find('audio').mediaelementplayer({
					success: function(player) {
						_player = player;

						_player.addEventListener(
							'ended',
							function() {
								services.api.post(
									'tracking',
									{
										recitation_id: _recitation.id,
										hash: _statHash
									}
								)
								controller.createStatHash();
							}
						);

						if (_autoStart) {
							_player.play();
						}
					}
				});
				$element.slideDown();

				$(app).trigger('loadVotes');
			}
		};
	});
})(jQuery, app);
