(function($, app) {

	app.controller('recorder', function($element, services) {

		var _countdown;

		return {

			init: function() {
				services.events({
					'.start-recording': this.startCountdown
				});
			},

			display: function(width) {
				$element.css({
					width: width + 'px'
				}).fadeIn();
			},

			startCountdown: function() {
				$element.find('.step1').hide();
				$element.find('.step2').fadeIn();
				var countdownValue = 10;
				_countdown = setInterval(
					$.proxy(
						function() {
							countdownValue--;
							if (countdownValue == 0) {
								clearInterval(_countdown);
								this.startRecording();
							}
							$element.find('.countdown').html(countdownValue);
						},
						this
					),
					1000
				);
			},

			startRecording: function() {
				$element.find('.step2').hide();
				$element.find('.step3').fadeIn();
			}

		};
	});
})(jQuery, app);
