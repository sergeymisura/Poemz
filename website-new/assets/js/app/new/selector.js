(function($, app) {

	app.controller('selector', function($element, services) {

		var _lastRequest = 0;
		var _lastRequestText = null;
		var _apiSettings;

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

			display: function(apiSettings) {
				_apiSettings = apiSettings;
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
							_apiSettings.uri,
							$.extend({ q: q }, _apiSettings.data)
						).success(
							function(response) {
								if (requestIndex == _lastRequest) {
									this.updateObjectsList(response.data[_apiSettings.name], q);
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

			updateObjectsList: function(authors, request) {
				$element.find('.results-area > *').hide();
				if (authors.length > 0) {
					services.rendering('select-object', authors);
					$element.find('.objects-list').fadeIn();
				}
				else {
					var name = $.map(request.split(' '), function (word) {
						if (word.length > 0) {
							return word.substr(0, 1).toUpperCase() + word.substr(1);
						}
						return null;
					}).join(' ');
					services.rendering('add-object', { name: name });
					$element.find('.no-matches').fadeIn();
				}
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
