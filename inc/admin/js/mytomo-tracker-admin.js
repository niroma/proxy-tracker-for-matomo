// JavaScript Document
jQuery(document).ready(function($) {
	$('#mytomo-tracker-tracking-mode').on('change', function() {
		if ($(this).val() == 'js') {
			$('#matomoJsMode').show();
			$('#matomoJsDisallowRobot').show();
		} else {
			$('#matomoJsMode').hide();
			$('#matomoJsDisallowRobot').hide();
		}
	});
	$('#mytomo-tracker-tracking-mode').trigger('change');
});