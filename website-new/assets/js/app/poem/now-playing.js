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

			updateVoteLink: function() {
				if (!services.auth.isLoggedIn()) {
					this.toggleVoteLink(true);
				}
				else {
					app.data.votes = app.data.votes || {};
					if (typeof app.data.votes[_recitation.id] == 'undefined')	{
						services.api.get(
							'poems/' + _recitation.poem_id + '/recitations/' + _recitation.id + '/vote'
						).success(
							function(response) {
								app.data.votes[_recitation.id] = response.data.vote == null;
								this.toggleVoteLink(app.data.votes[_recitation.id]);
							},
							this
						);
					}
					else {
						this.toggleVoteLink(app.data.votes[_recitation.id]);
					}
				}
			},

			toggleVoteLink: function(vote) {
				if (vote) {
					$element.find('.vote-link').html('Vote!').data('action', 'vote');
				}
				else {
					$element.find('.vote-link').html('Voted').data('action', 'revoke');
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
				this.updateVoteLink();
				$element.slideDown();
			},

			vote: function($source) {
				var action = $source.data('action');
				$element.find('.vote-error').hide();

				services.auth.login($.proxy(
					function() {
						services.api.post(
							'poems/' + _recitation.poem_id + '/recitations/' + _recitation.id + '/' + action
						).success(
							function(response) {
								app.data.votes = app.data.votes || {};
								app.data.votes[_recitation.id] = response.data.vote == null;
								this.toggleVoteLink(app.data.votes[_recitation.id]);
							},
							this
						).error(
							function(code, response) {
								if (response.error == 'ERR_SELF' || response.error == 'ERR_LISTEN') {
									$element.find('.vote-error').html(response.message).fadeIn();
									return true;
								}
							},
							this
						);
					},
					this
				));
			}

		};
	});
})(jQuery, app);
