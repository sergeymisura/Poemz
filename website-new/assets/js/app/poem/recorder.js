(function($, app) {

	app.controller('recorder', function($element, services) {

		var _countdown;

		return {

			init: function() {
				services.events({
					'.start-recording': this.initRecording,
					'.finish-recording': this.finishRecording
				});
			},

			display: function(width) {
				services.auth.login(function() {
					$element.css({
						width: width + 'px'
					}).fadeIn();
				})
			},

			initRecording: function() {
				$element.find('.step1').hide();
				$element.find('.step2').fadeIn();
				services.recording.init()
					.success(this.startRecording, this)
					.error(this.notAllowed, this)
			},

			startRecording: function() {
				$element.find('.step2').hide();
				$element.find('.step3').fadeIn();
				services.recording.start();
			},

			finishRecording: function() {
				services.recording.stop();
			},

			notAllowed: function() {
				$element.find('.step2 h4').html('Oh no! How are you going to record your voice without a mic?');
			}

		};
	});
})(jQuery, app);
