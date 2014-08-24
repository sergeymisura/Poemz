(function($, app) {

	app.controller('new', function($element, services) {

		var _lastRequest = 0;
		var _lastRequestText = null;

		return {

			init: function() {
				services.events({
					'.author-name': {
						keyup: this.nameKeyUp
					},
					'.btn-add-author': this.createAuthor,
					'.select-author': this.selectAuthorClick
				});
			},

			nameKeyUp: function() {
				var q = $element.find('.author-name').val().trim();
				if (q == _lastRequestText) {
					return;
				}

				$element.find('.results-area > *').hide();
				_lastRequest++;

				if (q == '') {
					$element.find('.new-author-message').fadeIn();
					return;
				}

				_lastRequestText = q;
				var requestIndex = _lastRequest;
				$element.find('.results-area .loading').show();

				setTimeout(
					$.proxy(function() {
						if (_lastRequest != requestIndex) {
							return;
						}
						services.api.get(
							'authors',
							{ q: q }
						).success(
							function(response) {
								if (requestIndex == _lastRequest) {
									this.updateAuthorsList(response.data.authors, q);
								}
							},
							this
						);
					}, this),
					300
				)
			},

			selectAuthorClick: function($source, ev) {
				this.authorSelected(ev.data);
			},

			updateAuthorsList: function(authors, request) {
				$element.find('.results-area > *').hide();
				if (authors.length > 0) {
					services.rendering('select-author', authors);
					$element.find('.authors-list').fadeIn();
				}
				else {
					var name = $.map(request.split(' '), function (word) {
						if (word.length > 0) {
							return word.substr(0, 1).toUpperCase() + word.substr(1);
						}
						return null;
					}).join(' ');
					services.rendering('add-author', { name: name });
					$element.find('.no-matches').fadeIn();
				}
			},

			createAuthor: function($source) {
				services.auth.login($.proxy(
					function() {
						$source.button('loading');
						services.api.post(
							'authors',
							{
								name: $source.data('name')
							}
						).success(
							function(response) {
								this.authorSelected(response.data.author);
							},
							this
						);
					},
					this
				));
			},

			authorSelected: function(author) {
				$element.find('.author-finder').hide();
				services.rendering('selected-author', author).fadeIn();

			}
		};
	});
})(jQuery, app);
