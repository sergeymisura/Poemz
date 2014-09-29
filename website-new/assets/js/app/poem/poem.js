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
					'.listen': this.listen,
					'.btn-toggle-edit': this.toggleEdit,
					'.btn-reset': this.resetEditing,
					'.btn-save-poem': this.savePoem,
					'.vote-link': this.vote
				});

				services.events(app, {
					ready: this.appReady,
					loadVotes: this.loadVotes
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

			toggleEdit: function($button) {
				$element.toggleClass('editing');
				$button.toggleClass('active-icon');
			},

			resetEditing: function() {
				$element.find('.poem-title-control').val(app.data.poem.title);
				$element.find('.poem-text-control').val(app.data.poem.poem_text.text);
			},

			savePoem: function() {
				services.auth.login($.proxy(
					function() {
						if (services.form().validate()) {
							services.api.post(
								'authors/' + app.data.poem.author_id + '/poems/' + app.data.poem.id,
								{
									title: $element.find('.poem-title-control').val(),
									text: $element.find('.poem-text-control').val()
								}
							).success(
								function() {
									document.location.reload();
								}
							);
						}
					},
					this
				));
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
			},

			vote: function($source) {
				var id = $source.data('id');
				var action = $source.data('action');
				services.auth.login($.proxy(
					function() {
						services.api.post(
							'poems/' + app.data.poem.id + '/recitations/' + id + '/' + action
						).success(
							function(response) {
								this.updateVoteLink(id, response.data.votes, action == 'vote');
							},
							this
						).error(
							function(code, response) {
								var options = {};
								if (code == 400) {
									options.text = response.message
								}
								services.message(options);
							},
							this
						)
					},
					this
				));
			},

			updateVoteLink: function(id, votes, hasVoted) {
				var $link = $element.find('.vote-link[data-id="' + id + '"]');
				$link.find('span').html(votes);
				if (hasVoted) {
					$link.addClass('active-icon');
					$link.data('action', 'revoke');
					$link.attr('data-original-title', 'Recall your vote');
				}
				else {
					$link.removeClass('active-icon');
					$link.data('action', 'vote');
					$link.attr('data-original-title', 'Vote for this recitation');
				}
			},

			loadVotes: function() {
				if (!services.auth.isLoggedIn()) {
					return;
				}

				app.data.votes = app.data.votes || {};
				var missing = [];
				$element.find('.vote-link').each($.proxy(function(idx, link) {
					var $link = $(link);
					var recitationId = $link.data('id');
					if (typeof app.data.votes[recitationId] == 'undefined') {
						missing.push(recitationId);
					}
					else {
						this.updateVoteLink(recitationId, $link.find('span').html(), app.data.votes[recitationId]);
					}
				}, this));

				if (missing.length > 0) {
					services.api.get(
						'self/votes',
						{ recitations: missing.join(',') }
					).success(
						function(response) {
							$.each(response.data.votes, function(id, voted) {
								app.data.votes[id] = voted;
							});
							this.loadVotes();
						},
						this
					);
				}
			}
		};
	});
})(jQuery, app);
