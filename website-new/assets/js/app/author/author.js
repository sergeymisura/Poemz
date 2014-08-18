(function($, app) {

	app.controller('author', function($element, services) {
		return {

			init: function() {
				services.events({

				});

				if (app.data.author.wiki_url == null || app.data.author.wiki_excerpt == null) {
					this.loadWikiExcerpt();
				}
				else {
					this.renderWikiExcerpt();
				}
			},

			loadWikiExcerpt: function() {
				$element.find('.wiki-loading').show();
				services.api.get(
					'authors/' + app.data.author.id,
					{ wiki: 'true' }
				).success(
					function(response) {
						$element.find('.wiki-loading').hide();
						app.data.author.wiki_url = response.data.author.wiki_url;
						app.data.author.wiki_excerpt = response.data.author.wiki_excerpt;
						this.renderWikiExcerpt();
					},
					this
				)
			},

			renderWikiExcerpt: function() {
				services.rendering('wiki', app.data.author);
			}
		};
	});
})(jQuery, app);
