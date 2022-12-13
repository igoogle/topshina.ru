<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="basket_props_block" id="bx_basket_div_<?=$arResult["ID"];?>" style="display: none;">
	<?if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])){
		foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
			<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
			<?if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
				unset($arResult['PRODUCT_PROPERTIES'][$propID]);
		}
	}
	$arResult["EMPTY_PROPS_JS"]="Y";
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if (!$emptyProductProperties){
		$arResult["EMPTY_PROPS_JS"]="N";?>
		<div class="wrapper">
			<table>
				<?foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
					<tr>
						<td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
						<td>
							<?if('L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']){
								foreach($propInfo['VALUES'] as $valueID => $value){?>
									<label>
										<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
									</label>
								<?}
							}else{?>
								<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
									<?foreach($propInfo['VALUES'] as $valueID => $value){?>
										<option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
									<?}?>
								</select>
							<?}?>
						</td>
					</tr>
				<?}?>
			</table>
		</div>
	<?}?>
</div>
<?
$arItemIDs=CTires2::GetItemsIDs($arResult, "Y");
$totalCount = CTires2::GetTotalCount($arResult, $arParams);

$arQuantityData = CTires2::GetQuantityArray($totalCount, $arItemIDs["ALL_ITEM_IDS"], "Y");

$strMeasure='';
$arAddToBasketData = array();

if (($arParams["SHOW_MEASURE"]=="Y")&&($arResult["CATALOG_MEASURE"])){
	$arMeasure = CCatalogMeasure::getList(array(), array("ID"=>$arResult["CATALOG_MEASURE"]), false, false, array())->GetNext();
	$strMeasure=$arMeasure["SYMBOL_RUS"];
}
$arAddToBasketData = CTires2::GetAddToBasketArray($arResult, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, $arItemIDs["ALL_ITEM_IDS"], 'btn-lg w_icons', $arParams);
?>
<?$frame = $this->createFrame()->begin();?>
<div class="prices_block">
	<div class="cost prices clearfix">
		<?
		$item_id = $arResult["ID"];
		if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']) // USE_PRICE_COUNT
		{
			if($arResult['PRICE_MATRIX']['COLS'])
			{
				$arCurPriceType = current($arResult['PRICE_MATRIX']['COLS']);
				$min_price_id = $arCurPriceType['ID'];?>
			<?}?>
			<?if($arResult['ITEM_PRICE_MODE'] == 'Q' && count($arResult['PRICE_MATRIX']['ROWS']) > 1):?>
				<?=CTires2::showPriceRangeTop($arResult, $arParams, GetMessage("CATALOG_ECONOMY"));?>
			<?endif;?>
			<?=CTires2::showPriceMatrix($arResult, $arParams, $strMeasure, $arAddToBasketData);?>
		<?
		}
		else
		{?>
			<?\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arResult["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
		<?}?>
	</div>
	<?if($arParams["SHOW_DISCOUNT_TIME"]=="Y"){?>
		<?$arUserGroups = $USER->GetUserGroupArray();?>
		<?if($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] != 'Y' || ($arParams['SHOW_DISCOUNT_TIME_EACH_SKU'] == 'Y' && !$arResult['OFFERS'])):?>
			<?$arDiscounts = CCatalogDiscount::GetDiscountByProduct($item_id, $arUserGroups, "N", $min_price_id, SITE_ID);
			$arDiscount=array();
			if($arDiscounts)
				$arDiscount=current($arDiscounts);
			if($arDiscount["ACTIVE_TO"]){?>
				<div class="view_sale_block <?=($arQuantityData["HTML"] ? '' : 'wq');?>">
					<div class="count_d_block">
						<span class="active_to hidden"><?=$arDiscount["ACTIVE_TO"];?></span>
						<div class="title"><?=GetMessage("UNTIL_AKC");?></div>
						<span class="countdown values"><span class="item"></span><span class="item"></span><span class="item"></span><span class="item"></span></span>
					</div>
					<?if($arQuantityData["HTML"]):?>
						<div class="quantity_block">
							<div class="title"><?=GetMessage("TITLE_QUANTITY_BLOCK");?></div>
							<div class="values">
								<span class="item">
									<span class="value" <?=((count( $arResult["OFFERS"] ) > 0 && $arParams["TYPE_SKU"] == 'TYPE_1' && $arResult["OFFERS_PROP"]) ? 'style="opacity:0;"' : '')?>><?=$totalCount;?></span>
									<span class="text"><?=GetMessage("TITLE_QUANTITY");?></span>
								</span>
							</div>
						</div>
					<?endif;?>
				</div>
			<?}?>
		<?else:?>
			<div class="view_sale_block" style="display:none;">
				<div class="count_d_block">
						<span class="active_to_<?=$arResult["ID"]?> hidden"><?=$arDiscount["ACTIVE_TO"];?></span>
						<div class="title"><?=GetMessage("UNTIL_AKC");?></div>
						<span class="countdown countdown_<?=$arResult["ID"]?> values"></span>
				</div>
				<?if($arQuantityData["HTML"]):?>
					<div class="quantity_block">
						<div class="title"><?=GetMessage("TITLE_QUANTITY_BLOCK");?></div>
						<div class="values">
							<span class="item">
								<span class="value"><?=$totalCount;?></span>
								<span class="text"><?=GetMessage("TITLE_QUANTITY");?></span>
							</span>
						</div>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
	<?}?>
	<div class="quantity_block_wrapper">
		<div class="p_block">
			<?=$arQuantityData["HTML"];?>
		</div>
		<?if($arParams["SHOW_CHEAPER_FORM"] == "Y"):?>
			<div class="cheaper_form">
				<span class="animate-load" data-event="jqm" data-param-form_id="CHEAPER" data-name="cheaper" data-autoload-product_name="<?=CTires2::formatJsName($arResult["NAME"]);?>" data-autoload-product_id="<?=$arResult["ID"];?>"><?=($arParams["CHEAPER_FORM_NAME"] ? $arParams["CHEAPER_FORM_NAME"] : GetMessage("CT_BCE_CATALOG_FIND_CHEAPER"));?></span>
			</div>
		<?endif;?>
	</div>
</div>
<div class="buy_block">
	<?if(!$arResult["OFFERS"]):?>
		<div class="counter_wrapp" data-store="<?=$arParams["STORES"][0]?>" data-prices="<?=($arParams["PRICE_CODE_IDS"] ? (implode(",", $arParams["PRICE_CODE_IDS"])) : "");?>">
			<?if(($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] && $arAddToBasketData["ACTION"] == "ADD") && $arAddToBasketData["CAN_BUY"]):?>
				<div class="counter_block big_basket" data-offers="<?=($arResult["OFFERS"] ? "Y" : "N");?>" data-item="<?=$arResult["ID"];?>" <?=(($arResult["OFFERS"] && $arParams["TYPE_SKU"]=="N") ? "style='display: none;'" : "");?>>
					<span class="minus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_DOWN']; ?>">-</span>
					<input type="text" class="text" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
					<span class="plus" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['QUANTITY_UP']; ?>" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
				</div>
			<?endif;?>
			<div id="<? echo $arItemIDs["ALL_ITEM_IDS"]['BASKET_ACTIONS']; ?>" class="button_block <?=(($arAddToBasketData["ACTION"] == "ORDER" /*&& !$arResult["CAN_BUY"]*/) || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] || ($arAddToBasketData["ACTION"] == "SUBSCRIBE" && $arResult["CATALOG_SUBSCRIBE"] == "Y")  ? "wide" : "");?>">
				<!--noindex-->
					<?=$arAddToBasketData["HTML"]?>
				<!--/noindex-->
			</div>
			<?if(isset($arResult['PRICE_MATRIX']) && $arResult['PRICE_MATRIX']) // USE_PRICE_COUNT
			{?>
				<?if($arResult['ITEM_PRICE_MODE'] == 'Q' && count($arResult['PRICE_MATRIX']['ROWS']) > 1):?>
					<?$arOnlyItemJSParams = array(
						"ITEM_PRICES" => $arResult["ITEM_PRICES"],
						"ITEM_PRICE_MODE" => $arResult["ITEM_PRICE_MODE"],
						"ITEM_QUANTITY_RANGES" => $arResult["ITEM_QUANTITY_RANGES"],
						"MIN_QUANTITY_BUY" => $arAddToBasketData["MIN_QUANTITY_BUY"],
						"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
						"ID" => $arItemIDs["strMainID"],
					)?>
					<script type="text/javascript">
						var <? echo $arItemIDs["strObName"]; ?>el = new JCCatalogOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
					</script>
				<?endif;?>
			<?}?>
			<?if($arAddToBasketData["ACTION"] !== "NOTHING"):?>
				<?if($arAddToBasketData["ACTION"] == "ADD" && $arAddToBasketData["CAN_BUY"] && $arParams["SHOW_ONE_CLICK_BUY"]!="N"):?>
					<div class="wrapp_one_click">
						<span class="btn btn-default btn-lg white one_click" data-item="<?=$arResult["ID"]?>" data-iblockID="<?=$arParams["IBLOCK_ID"]?>" data-quantity="<?=$arAddToBasketData["MIN_QUANTITY_BUY"];?>" onclick="oneClickBuy('<?=$arResult["ID"]?>', '<?=$arParams["IBLOCK_ID"]?>', this)">
							<span><?=GetMessage('ONE_CLICK_BUY')?></span>
						</span>
					</div>
				<?endif;?>
			<?endif;?>			
		</div>
	<?endif;?>
</div>
<?$frame->end();?>