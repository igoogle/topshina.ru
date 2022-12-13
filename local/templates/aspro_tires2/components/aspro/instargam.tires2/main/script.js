$(document).ready(function() {
	$.ajax({
		url: arTires2Options['SITE_DIR']+'include/mainpage/comp_instagramm.php',
		data: {'AJAX_REQUEST_INSTAGRAM': 'Y', 'SHOW_INSTAGRAM': arTires2Options['THEME']['INSTAGRAMM_INDEX']},
		type: 'POST',
		async: false,
		success: function(html){
			$('.instagram_ajax').html(html).addClass('loaded');
			InitFlexSlider();
			var eventdata = {action:'instagrammLoaded'};
			BX.onCustomEvent('onCompleteAction', [eventdata]);
		}
	});
});