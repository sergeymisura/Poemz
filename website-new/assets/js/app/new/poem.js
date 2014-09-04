(function($, app) {

	app.controller('new-poem', function($element, services) {

		var _author;

		return {

			init: function() {
				services.events({
					'.poem-selector': {
						'newObject': this.newPoemForm,
						'listUpdated': this.poemListUpdated
					},
					'.new-poem-form': {
						submit: this.submitPoem
					}
				});
			},

			display: function(author) {
				_author = author;
				$element.fadeIn();
				app.get($element.find('.poem-selector')).display({
					uri: 'authors/' + author.id + '/poems',
					data: {},
					name: 'poems',
					listFilters: {
						author: function() {
							return _author;
						}
					}
				});
			},

			poemListUpdated: function($source, ev, objects, query, total) {
				if (query != '') {
					$source.find('.add-new-poem').show();
				}
				else {
					$source.find('.add-new-poem').hide();
				}
			},

			newPoemForm: function($source, ev, title) {
				$element.find('.poem-selector').hide();
				$element.find('.new-poem-form').fadeIn();
				$element.find('.new-poem-form #new-poem-title').val(title).focus();
			},

			submitPoem: function($source) {
				var form = services.form($source);
				if (!form.validate()) {
					return false;
				}

				services.auth.login($.proxy(
					function() {
						services.api.post(
							'authors/' + _author.id + '/poems',
							form.collect()
						).success(
							function(response) {
								document.location = app.urls.poem(response.data.poem, _author) + '#record';
							},
							this
						);
					},
					this
				));
				return false;
			}

		};
	});
})(jQuery, app);
