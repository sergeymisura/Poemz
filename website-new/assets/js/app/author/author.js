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

				this.renderPoems('first_line');
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
			},

			renderPoems: function(order) {
				var data;
				switch(order) {
					case 'title':
						this.renderLetters(app.data.title_letters);
						data = this.sortByLetters(order)
						break;
					case 'first_line':
						this.renderLetters(app.data.line_letters);
						data = this.sortByLetters(order)
						break;
					case 'best':
						$element.find('.letters').hide();
						break;
					case 'newest':
						$element.find('.letters').hide();
						break;
				}
				services.rendering('poems', { columns: data });
			},

			sortByLetters: function(order) {
				var sorted = app.data.author.poems.slice();
				sorted.sort(function(a,b) {
					if (a[order] < b[order]) return -1;
					if (a[order] > b[order]) return 1;
					return 0;
				});
				var currentLetter = null;
				var idx = 0;
				while (idx < sorted.length) {
					var firstChar = sorted[idx][order].substr(0, 1).toUpperCase();
					if (firstChar != currentLetter) {
						sorted.splice(idx, 0, { isHeader: true, link: 'letter-' + firstChar, text: firstChar });
						currentLetter = firstChar;
						idx++;
					}
					idx++;
				}
				var half = Math.ceil(sorted.length / 2);
				if (sorted[half - 1].isHeader) {
					half--;
				}
				if (!sorted[half].isHeader && half < sorted.length) {
					var firstChar = sorted[half][order].substr(0, 1).toUpperCase();
					sorted.splice(half, 0, { isHeader: true, link: 'letter-' + firstChar + '-2', text: firstChar });
				}
				return [sorted.slice(0, half - 1), sorted.slice(half)];
			},

			renderLetters: function(letters) {
				var objects = [];
				for (var i = 65; i <= 90; i++) {
					var letter = String.fromCharCode(i);
					objects.push({
						letter: letter,
						active: letters.indexOf(letter) != -1
					});
				}
				services.rendering('letters', { letters: objects });
				$element.find('.letters').slideDown();
			}
		};
	});
})(jQuery, app);
