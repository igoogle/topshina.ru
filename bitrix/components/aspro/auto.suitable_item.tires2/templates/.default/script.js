if(!funcDefined('getSuitableModel'))
{
	getSuitableModel = function(){
		var obParams = BX.message("PARAMS_SC"),
			count = obParams.REVIEWS_COUNT,
			container = $('#js_response_sc'),
			carMark = $('.car-mark'),
			objUrl = parseUrlQuery(),
			add_url = "";

		if(carMark.length)
		{
			if(carMark.val())
				obParams.AUTO_MARK = carMark.val();
		}

		if("clear_cache" in objUrl)
		{
			if(objUrl.clear_cache == "Y")
				add_url += "?clear_cache=Y";
		}
		container.removeClass('initied');
		BX.ajax({
			url: BX.message("AJAX_PATH_SC")+"/ajax.php"+add_url,
			method: 'POST',
			data: BX.ajax.prepareData(obParams),
			dataType: 'html',
			processData: false,
			start: true,
			headers: [{'name': 'X-Requested-With', 'value': 'XMLHttpRequest'}],
			onfailure: function(data) {
				console.log(data);
				alert('Error connecting server');
			},
			onsuccess: function(html){
				var ob = BX.processHTML(html);

				container.addClass('initied');

				// inject
				BX('js_response_sc').innerHTML = ob.HTML;

			}
		})
	}
	$(document).ready(function(){
		$('.car-mark').change(function(){
			getSuitableModel();
		})
	})
}