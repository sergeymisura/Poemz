(function($, app) {
	
	app.controller('poem', function($element, services) {
		return {
			init: function() {
				services.bind({
					'.record-yours': {
						click: 'recordPoem'
					},
					'.stop-recording': {
						click: 'stopRecording'
					}
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
				Wami.setup({
					id: 'poem-page-record',
					swfUrl: app.config.baseUrl + '/assets/Wami.swf',
					onReady: function() {
						Wami.startRecording(app.config.baseUrl + '/test/record/' + app.data.poem.id);
					}
				});
			},
			
			stopRecording: function() {
				Wami.stopRecording();
			}
		};
	});
	
})(jQuery, app);