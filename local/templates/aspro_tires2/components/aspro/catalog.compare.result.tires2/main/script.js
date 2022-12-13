BX.namespace("BX.Iblock.Catalog");

BX.Iblock.Catalog.CompareClass = (function()
{
	var CompareClass = function(wrapObjId)
	{
		this.wrapObjId = wrapObjId;
	};

	CompareClass.prototype.MakeAjaxAction = function(url, refresh)
	{
		BX.showWait(BX(this.wrapObjId));
		BX.ajax.post(
			url,
			{
				ajax_action: 'Y'
			},
			BX.proxy(function(result)
			{
				BX(this.wrapObjId).innerHTML = result;
				if(typeof refresh !== undefined){
					getActualBasket('','Compare');
					if($('#compare_fly').length){
						jsAjaxUtil.InsertDataToNode(arTires2Options['SITE_DIR'] + 'ajax/show_compare_preview_fly.php', 'compare_fly', false);
					}

				}
				BX.closeWait();
			}, this)
		);
	};

	return CompareClass;
})();

$(document).ready(function(){
	$(document).on('click', '.table_compare .filter_type_block > span', function(){
		var _this = $(this);
		if(!_this.hasClass('active'))
		{
			if(_this.data('iblock'))
			{
				$('.frame .compare_view td:not(.static)').addClass('hidden');
				$('.frame .compare_view td[data-iblock="'+_this.data('iblock')+'"]').removeClass('hidden');
			}
			else
			{
				$('.frame .compare_view td').removeClass('hidden');
			}
			_this.siblings().removeClass('active');
			_this.addClass('active');

			initSly();
		}
	})
})