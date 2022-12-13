<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")){
	echo "failure";
	return;
}

if(\Bitrix\Main\Loader::IncludeModule('aspro.tires2'))
{
	$iblockID=(isset($_GET["iblockID"]) ? $_GET["iblockID"] : 0);
	$arItems=CTires2::getBasketItems($iblockID);
	$bStoreBuy = (\Bitrix\Main\Config\Option::get('aspro.tires2', 'STORE_TYPE_CATALOG_DETAIL', 'normal') == 'ext');
	if($bStoreBuy)
	{
		$arItems2=CTires2::getBasketItemsWithProp($iblockID);
	}
	?>
	<script type="text/javascript">
		if(typeof arBasketWithPropsAspro !== "undefined")
		{
			if('BASKET' in arBasketWithPropsAspro)
			{
				var basketItemsCount = arBasketWithPropsAspro.BASKET.length;
				var lastItem = arBasketWithPropsAspro.BASKET[basketItemsCount - 1];
				var arBasketAspro = <? echo CUtil::PhpToJSObject($arItems, false, true); ?>;
				<?if($bStoreBuy):?>
					var arBasketWithPropsAspro = <? echo CUtil::PhpToJSObject($arItems2, false, true); ?>;
					var newBasketItemsCount = arBasketWithPropsAspro.BASKET.length;
					
					if($('.stores_block_wrap').length && newBasketItemsCount > basketItemsCount){
						var newLastItemStoreName = arBasketWithPropsAspro.BASKET[newBasketItemsCount - 1].STORES;
						
						$('.stores_block_wrap .stores_block').each(function(){
							var _this = $(this),
								storeName = _this.find('.title_stores').text();
								
							if(storeName == newLastItemStoreName){
								_this.addClass('active');
							}
						});
					}
					else if(newBasketItemsCount < basketItemsCount && newBasketItemsCount != 0){
						$('.stores_block_wrap .stores_block').each(function(){
							var _this = $(this),
								storeName = _this.find('.title_stores').text();
								
							if(storeName == lastItem.STORES){
								_this.removeClass('active');
							}
						});
					}
					else if(newBasketItemsCount == 0){
						$('.stores_block_wrap .stores_block').removeClass('active');
					}
				<?endif;?>
			}
		}
		var arBasketAspro = <? echo CUtil::PhpToJSObject($arItems, false, true); ?>;
	</script>
<?}?>