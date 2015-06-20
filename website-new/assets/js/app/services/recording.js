(function($, app) {

	app.service('recording', function($element, services) {
		return {
			init: function() {
				var result = services.deferred();

				navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
					navigator.mozGetUserMedia || navigator.msGetUserMedia;
				if (navigator.getUserMedia) {
					$.extend(this, services.recordingHtml5);
				}
				else {
					$.extend(this, services.recordingSwf);
				}
				this._init(
					result.successCallback(),
					result.errorCallback()
				);

				return result;
			}
		};
	});

})(jQuery, app);
