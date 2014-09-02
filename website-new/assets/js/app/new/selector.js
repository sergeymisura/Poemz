(function($, app) {

	app.controller('selector', function($element, services) {

		var _lastRequest = 0;
		var _lastRequestText = null;
		var _options;

		return {

			init: function() {
				services.events({
					'.input-query': {
						keyup: this.nameKeyUp
					},
					'.btn-add-new': this.createObject,
					'.select-object': this.selectObjectClick
				});
			},

			display: function(options) {
				_options = options;
				$element.find('.input-query').focus();
			},

			nameKeyUp: function() {
				var q = $element.find('.input-query').val().trim();
				if (q == _lastRequestText) {
					return;
				}

				$element.find('.results-area > *').hide();
				_lastRequest++;

				if (q == '') {
					$element.find('.start-message').fadeIn();
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
							_options.uri,
							$.extend({ q: q }, _options.data)
						).success(
							function(response) {
								if (requestIndex == _lastRequest) {
									this.updateObjectsList(response.data[_options.name], q, response.data.count);
								}
							},
							this
						);
					}, this),
					300
				)
			},

			selectObjectClick: function($source, ev) {
				this.objectSelected(ev.data);
			},

			updateObjectsList: function(objects, request, total) {
				$element.find('.results-area > *').hide();

				var name = $.map(request.split(' '), function (word) {
					if (word.length > 0) {
						return word.substr(0, 1).toUpperCase() + word.substr(1);
					}
					return null;
				}).join(' ');
				services.rendering('add-object', { name: name });

				if (objects.length > 0) {
					services.rendering('select-object', objects, _options.listFilters || {});
					$element.find('.objects-list').fadeIn();

					if (objects.length < total) {
						$element.find('.have-more').fadeIn();
					}
					else {
						$element.find('.no-more').fadeIn();
					}
				}
				else {
					$element.find('.no-matches').fadeIn();
				}

				$element.trigger('listUpdated', objects, request, total);
			},

			createObject: function($source) {
				$source.button('loading');
				$element.trigger('newObject', $source.data('name'));
			},

			objectSelected: function(author) {
				$element.trigger('objectSelected', author);
			}
		};
	});
})(jQuery, app);
