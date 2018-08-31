// JavaScript Document
jQuery(document).ready(function($) {
	$('#matomo-tracker-tracking-mode').on('change', function() {
		if ($(this).val() == 'js') {
			$('#matomoJsMode').show();
			$('#matomoJsDisallowRobot').show();
		} else {
			$('#matomoJsMode').hide();
			$('#matomoJsDisallowRobot').hide();
		}
	});
	$('#matomo-tracker-tracking-mode').trigger('change');
});