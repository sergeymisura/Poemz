(function($, app) {

	app.controller('recorder', function($element, services) {

		var _started;

		return {

			init: function() {
				services.events({
                    '.cancel-step1': this.hide,
					'.start-recording': this.initRecording,
					'.finish-recording': this.finishRecording,
					'.cancel-recording': this.cancelRecording,
					'.keep-recording': this.keepRecording,
					'.try-again-recording': this.tryAgain
				});

				$element.find('.fileinput-button').fileupload({
					dataType: 'json',
					url: app.config.baseUrl + 'api/recording/upload',
					done: $.proxy(this.uploaded, this),
					send: $.proxy(this.startFileUploading, this),
					progress: $.proxy(this.uploadingProgress, this),
					dropZone: null
				});
			},

			display: function(width) {
				services.auth.login($.proxy(
					function() {
						$('.recording-fade').animate({opacity: 0.1});
						this.selectStep('.step1');
						$element.css({
							width: width + 'px'
						}).fadeIn();
					},
					this
				));
				this.setProgress(0);
			},

			setProgress: function(v) {
				$element.find('.progress-bar').css('width', v + '%').html(v ? (v + '%') : '');
			},

			startFileUploading: function() {
				this.setProgress(0);
				this.selectStep('.step4');
			},

			uploadingProgress: function(e, data) {
				this.setProgress(parseInt(data.loaded / data.total * 100));
			},

			hide: function() {
				$element.hide();
				$('.recording-fade').animate({opacity: 1});
			},

			selectStep: function(step) {
				$element.find('.panel-body>div').hide();
				$element.find(step).fadeIn();
			},

			initRecording: function() {
				this.selectStep('.step2');
				services.recording.init()
					.success(this.startRecording, this)
					.error(this.notAllowed, this)
			},

			startRecording: function() {
				this.selectStep('.step3');;
				_started = new Date();
				this.updateTimer();
				services.recording.start();
			},

			updateTimer: function() {
				var seconds = Math.floor((new Date() - _started) / 1000);
				var minutes = Math.floor(seconds / 60);
				seconds = seconds - minutes * 60;

				var strSec = seconds.toString();
				if (strSec.length < 2) strSec = '0' + strSec;

				var strMin = minutes.toString();
				if (strMin.length < 2) strMin = '0' + strMin;

				$element.find('.timer').html(strMin + ':' + strSec);
				setTimeout($.proxy(this.updateTimer, this), 1000);
			},

			finishRecording: function() {
				services.recording.stop();
				this.selectStep('.step4')
				services.recording.upload($.proxy(this.uploadingProgress, this))
					.success(this.uploaded, this)
					.error(this.error, this)
			},

			cancelRecording: function() {
				services.recording.cancel();
				this.hide();
			},

			keepRecording: function() {
				services.api
					.post(
						'recording/keep',
						{
							poem_id: app.data.poem.id
						}
					)
					.success(
						function() {
							this.hide();
							$element.trigger('created');
						},
						this
					)
					.error(this.error, this)
			},

			tryAgain: function() {
				this.selectStep('.step1');
			},

			uploaded: function() {
				this.selectStep('.step5');
				var $audio = $('<audio />').attr('src', app.config.baseUrl + 'assets/previews/' + app.data.session.user_id + '.mp3');
				$element.find('.preview-container').html('').append($audio);
				$audio.mediaelementplayer({
					audioWidth: $element.find('.preview-container').width()
				});
			},

			notAllowed: function() {
				$element.find('.step2 h4').html('Oh no! How are you going to record your voice without a mic?');
			}

		};
	});
})(jQuery, app);
