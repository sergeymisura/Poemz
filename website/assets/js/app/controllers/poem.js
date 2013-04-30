(function($, app) {
	
	app.controller('poem', function($element, services) {
		return {
			init: function() {
				services.bind({
					'.record-yours': {
						click: 'recordPoem'
					},
				});
				services.rendering('poem', app.data.poem, {
					audioUrl: function($index) {
						return app.config.baseUrl + '/assets/media/' + app.data.poem.id + '.mp3';
					}
				});
				$element.find('audio').mediaelementplayer({
					features: ['playpause','current','progress','duration']
				});
			},
			
			recordPoem: function() {
				app.get('.navbar').displayLoginBox($.proxy(this.displayRecorder, this));
			},
			
			displayRecorder: function() {
				$element.find('.popover-content > div').hide();
				$element.find('.popover-content > div.step1').show();
				$element.find('.popover-recorder').css('left', ($('.poem').width() + $('.poem').offset().left - 300) + 'px');
				$element.find('.popover-recorder').fadeIn();
			}
		};
	});
	
})(jQuery, app);