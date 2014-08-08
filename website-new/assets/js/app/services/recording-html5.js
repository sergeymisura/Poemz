(function($, app) {

	var _recorder;

	app.service('recordingHtml5', function($element, services) {
		return {
			init: function(success, error) {
				navigator.getUserMedia(
					{ audio: true },
					this.mediaReceivedCallback(success),
					error
				);
			},

			mediaReceivedCallback: function(success) {
				return $.proxy(
					function(stream) {
						var context = new AudioContext;
						var source = context.createMediaStreamSource(stream);
						_recorder = new Recorder(
							source,
							{
								workerPath: app.config.baseUrl + '/assets/js/lib/html5-recorder/recorderWorker.js'
							}
						);
						success();
					},
					this
				);
			},

			start: function() {
				_recorder.record();
			},

			stop: function() {
				_recorder.stop();
				_recorder.exportWAV($.proxy(this.received, this));
			},

			received: function(blob) {
				var data = new FormData;
				data.append('content', blob);
				$.ajax(
					app.config.baseUrl + '/api/recording/upload',
					{
						type: 'POST',
						data: data,
						processData: false,
						contentType: false
					}
				);
			}
		};
	});
})(jQuery, app);
