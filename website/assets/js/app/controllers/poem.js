(function($, app) {
	
	app.controller('poem', function($element, services) {
		var _countdown = 10;
		var _recordingStarted = null;

		return {
			init: function() {
				window._recordingUploadedProxy = $.proxy(this.recordingUploaded, this);
				window._recordingFailedProxy = $.proxy(this.recordingFailed, this);
				
				services.bind({
					'.record-yours': {
						click: 'recordPoem'
					},
					'.start-recording': {
						click: 'startRecording'
					},
					'.i-am-chicken': {
						click: 'stopCountdown'
					},
					'.save-recording': {
						click: 'saveRecording'
					},
					'.cancel-recording': {
						click: 'cancelRecording'
					},
					'.submit-recording': {
						click: 'submitRecording'
					}
				});
				this.renderPoem();
			},
			
			renderPoem: function() {
				services.rendering('poem', app.data.poem, {
					audioUrl: function(id) {
						return app.config.baseUrl + '/assets/media/recital.' + id + '.mp3';
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
				this.displayRecordingStep('step1');
				$element.find('.popover-recorder').css('left', ($('.poem').width() + $('.poem').offset().left - 300) + 'px');
				$element.find('.popover-recorder').fadeIn();
			},
	
			displayRecordingStep: function(step) {
				$element.find('.popover-content > div').hide();
				$element.find('.popover-content > div.' + step).show();
			},
			
			startRecording: function() {
				$element.find('.popover-recorder .wami-placeholder').html('').append($('<div/>').attr('id', 'wami-recorder'));
				Wami.setup({
					id: 'wami-recorder',
					swfUrl: app.config.baseUrl + '/assets/Wami.swf',
					onReady: $.proxy(this.startCountdown, this)
				});
			},

			startCountdown: function() {
				$element.find('.wami-placeholder object').attr('height', '10');
				_countdown = 5;
				this.displayRecordingStep('step2');
				this.continueCountdown();
			},
			
			continueCountdown: function() {
				if (_countdown) {
					$element.find('.popover-recorder .countdown').html(_countdown);
					_countdown--;
					if (_countdown) {
						setTimeout($.proxy(this.continueCountdown, this), 1000);
					}
					else {
						setTimeout($.proxy(this.countdownSuccess, this), 1000);
					}
				}
			},

			stopCountdown: function() {
				_countdown = 0;
				this.resetRecorder();
				$element.find('.popover-recorder').fadeOut();
			},

			countdownSuccess: function() {
				this.displayRecordingStep('step3');
				_recordingStarted = new Date().valueOf();
				this.updateTimer(_recordingStarted);
				Wami.startRecording(app.config.baseUrl + '/api/recording', null, '_recordingUploadedProxy', '_recordingFailedProxy');
			},

			updateTimer: function() {
				if (_recordingStarted) {
					var seconds = Math.floor((new Date().valueOf() - _recordingStarted) / 1000);
					var minutes = Math.floor(seconds / 60);
					var format = function (value) {
						return value < 10 ? "0" + value : value;
					}
					seconds = seconds - minutes * 60;
					$element.find('.popover-recorder .timer').html(format(minutes) + ":" + format(seconds));
					setTimeout($.proxy(this.updateTimer, this), 500);
				}
			},
			
			resetRecorder: function() {
				$element.find('.popover-recorder .wami-placeholder').html('');
				Wami.reset();
			},
			
			cancelRecording: function() {
				_recordingStarted = null;
				this.resetRecorder();
				$element.find('.popover-recorder').fadeOut();
			},

			saveRecording: function() {
				_recordingStarted = null;
				this.displayRecordingStep('step4');
				Wami.stopRecording();
			},

			recordingUploaded: function() {
				this.resetRecorder();
				//this.checkPreviewReady();
				setTimeout($.proxy(function() {
					var $preview = $element.find('.preview-placeholder');
					$preview.html('').append(
						$('<audio>')
							.attr('src', app.config.baseUrl + '/assets/media/' + app.data.user.id + '.preview.mp3')
							.attr('width', '275px')
					);
					$preview.find('audio').mediaelementplayer({
						features: ['playpause','current','progress','duration']
					});
					this.displayRecordingStep('step5');
				}, this), 1000);
			},
			
			recordingFailed: function() {
				console.log('failed');
			},
			
			submitRecording: function() {
				services.api.post('recording/submit/' + app.data.poem.id)
					.success(function(data) {
						app.data.poem.recitals.push(data.recital);
						this.renderPoem();
					}, this)
			}
		};
	});
	
})(jQuery, app);