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