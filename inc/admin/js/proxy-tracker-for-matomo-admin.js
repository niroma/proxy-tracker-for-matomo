// JavaScript Document
jQuery(document).ready(function($) {
	$('#proxy-tracker-for-matomo-tracking-mode').on('change', function() {
		if ($(this).val() == 'js') {
			$('#proxyTrackerForMatomoJsMode').show();
			$('#proxyTrackerForMatomoJsDisallowRobot').show();
		} else {
			$('#proxyTrackerForMatomoJsMode').hide();
			$('#proxyTrackerForMatomoJsDisallowRobot').hide();
		}
	});
	$('#proxy-tracker-for-matomo-tracking-mode').trigger('change');
});