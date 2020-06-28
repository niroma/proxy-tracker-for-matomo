// JavaScript Document
jQuery(document).ready(function($) {
	$('#mytomo-tracker-tracking-mode').on('change', function() {
		if ($(this).val() == 'js') {
			$('#mytomoJsMode').show();
			$('#mytomoJsDisallowRobot').show();
		} else {
			$('#mytomoJsMode').hide();
			$('#mytomoJsDisallowRobot').hide();
		}
	});
	$('#mytomo-tracker-tracking-mode').trigger('change');
});