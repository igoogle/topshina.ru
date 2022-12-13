<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin();?>
<?
if(strlen($arResult["ERROR_MESSAGE"]) > 0)
{
	ShowError($arResult["ERROR_MESSAGE"]);
}

$templateData = array(
	"ELEMENT_ID" => $arParams["ELEMENT_ID"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],

	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"BASKET_URL" => $arParams["BASKET_URL"],
	"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
	"SHOW_DISCOUNT_TIME"=>$arParams["SHOW_DISCOUNT_TIME"],
	"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
	"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
	"USE_RATIO_IN_RANGES" => $arParams["USE_RATIO_IN_RANGES"],
	"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
	"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
	"CURRENCY_ID" => $arParams["CURRENCY_ID"],
	"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
	"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
	"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
	"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
	"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
	"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],

	"SHOW_CHEAPER_FORM" => $arParams["SHOW_CHEAPER_FORM"],
	"CHEAPER_FORM_NAME" => $arParams["CHEAPER_FORM_NAME"],

	"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
	"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
	"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
	"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

	"USE_REGION" => ($arResult["REGION"] ? "Y" : "N")
);
?>
<?if(count($arResult["STORES"]) > 0):?>
	<?
	// get shops
	$arShops = array();
	CModule::IncludeModule('iblock');
	$dbRes = CIBlock::GetList(array(), array('CODE' => 'aspro_tires2_shops', 'ACTIVE' => 'Y', 'SITE_ID' => SITE_ID));
	if($arShospIblock = $dbRes->Fetch())
	{
		$dbRes = CIBlockElement::GetList(array(), array('ACTIVE' => 'Y', 'IBLOCK_ID' => $arShospIblock['ID']), false, false, array('ID', 'DETAIL_PAGE_URL', 'PROPERTY_STORE_ID'));
		while($arShop = $dbRes->GetNext())
		{
			$arShops[$arShop['PROPERTY_STORE_ID_VALUE']] = $arShop;
		}
	}
	static $priceTypeCache, $arPrices = array();
	?>
	<div class="stores_block_wrap ext_block">
		<?$empty_count=0;
		global $USER;

		$count_stores=0;
		$bChecked = false;?>
		<form>
			<?foreach($arResult["STORES"] as $key => $arStores):?>
				<?$count_stores += count($arStores["ITEMS"]);?>
				<div class="stores_item <?=(($arResult["REGION"] && $arResult["REGION"]["ID"] == $key) ? "active-region" : "");?>" data-val="<?=$key;?>">
					<?if($arStores["TITLE"]):?>
						<div class="title_block"><?=$arStores["TITLE"];?></div>
					<?endif;?>
					<div class="item_wrapper <?=(($arResult["REGION"] && $arResult["REGION"]["ID"] == $key) ? "region" : "");?>">
						<?$i = 0;?>
						<?foreach($arStores["ITEMS"] as $pid => $arProperty):
							$amount = (isset($arProperty['REAL_AMOUNT']) ? $arProperty['REAL_AMOUNT'] : $arProperty['AMOUNT']);
							if($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount <= 0)
								$empty_count++;?>
							<div class="stores_block clearfix <?=(isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"]) ? 'w_image' : 'wo_image')?>" <?=($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount <= 0 ? 'style="display: none"' : ''); ?> data-id="<?=$pid;?>">
								<?
								$totalCount = CTires2::CheckTypeCount($arProperty["NUM_AMOUNT"]);
								$arQuantityData = CTires2::GetQuantityArray($totalCount);
								?>
								<div class="quantity-wrapp-block cost prices pull-right">
									<?if(isset($arProperty["PHONE"])):?><span class="store_phone p10"><span><?//=GetMessage('S_PHONE')?> <?=$arProperty["PHONE"]?></span></span><?endif;?>
								
									<?if(strlen($arQuantityData["TEXT"])):?>
										<?=$arQuantityData["HTML"]?>
									<?endif;?>
									<?$quantity = (!$arParams["QUANTITY"] ? 1 : $arParams["QUANTITY"]);
									$arPricesID = $arStores["PRICE_CODE"];
									
									$arPriceList = \Aspro\Functions\CAsproTires2::getPriceList($arParams["ELEMENT_ID"], $arPricesID, $quantity, true);
									$arPricesID = array();
									if($arPriceList)
									{
										foreach($arPriceList as $arPriceTmp)
										{
											$arPricesID[] = $arPriceTmp["CATALOG_GROUP_ID"];
										}
									}

									$templateData["PRICES"][$key][$arProperty['ID']] = $arStores["PRICE_CODE"];
									$templateData["PRICES_ID"][$key][$arProperty['ID']] = $arPricesID;
									$arPrice = CCatalogProduct::GetOptimalPrice($arParams["ELEMENT_ID"], $quantity, $USER->GetUserGroupArray(), 'N', $arPriceList);
									if($arPrice["RESULT_PRICE"]):?>
										<?$price = $arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"];
										$arFormatPrice = $arPrice["RESULT_PRICE"];
										if($arParams["CONVERT_CURRENCY"] != "Y" && $arPrice["RESULT_PRICE"]["CURRENCY"] != $arPrice["PRICE"]["CURRENCY"])
										{
											$price = roundEx(CCurrencyRates::ConvertCurrency($arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"], $arPrice["RESULT_PRICE"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]),CATALOG_VALUE_PRECISION);
											$arFormatPrice = $arPrice["PRICE"];
										}?>
										<span class="price">
											<?if($arPricesID):?>
												<span class="values_wrapper"><?=\Aspro\Functions\CAsproItem::getCurrentPrice($price, $arFormatPrice, false);?></span>
											<?endif;?>
										</span>
									<?endif;?>
									<span class="in_basket"></span>
								</div>
								<div class="filter label_block radio">
									<?
									$checked = "";
									if (!$bChecked) {
										if ($arResult['HAS_AMOUNT_STORE']) {
											if (isset($arStores['ACTIVE_STORE'])) {
												if ($arStores['ACTIVE_STORE'] == $pid) {
													$checked = "checked";
													$bChecked = true;
												}
											} elseif ($arResult["REGION"]) {
												if ($arResult["REGION"]["ID"] == $key) {
													$bShow = (($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount > 0) || ($arParams['SHOW_EMPTY_STORE'] == 'Y' && $amount <= 0));
													if ((!$i && $bShow) || ($i == 1 && $bShow)) {
														$checked = "checked";
														$bChecked = true;
													}
												}
											}
										} else {
											if ($arResult["REGION"]) {
												if ($arResult["REGION"]["ID"] == $key) {
													$bShow = (($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount > 0) || ($arParams['SHOW_EMPTY_STORE'] == 'Y' && $amount <= 0));
													if ((!$i && $bShow) || ($i == 1 && $bShow)) {
														$checked = "checked";
														$bChecked = true;
													}
												}
											} elseif(!$i) {
												$checked = "checked";
												$bChecked = true;
											}
										}
									}
									?>
									<?$i++;?>
									<input type="radio" name="STORE" <?=$checked;?> id="store_<?=$arProperty["ID"]?>_<?=$key;?>_<?=$arParams["ELEMENT_ID"];?>" data-element="<?=$arParams["ELEMENT_ID"];?>" data-offers="<?=($arParams["HAS_OFFERS"] == "Y" ? "Y" : "N")?>" <?if($arParams["HAS_OFFERS"] == "Y"):?>data-params='<?=str_replace('\'', '"', CUtil::PhpToJSObject($templateData, false, true, false))?>'<?endif;?> value="<?=$arProperty["ID"]?>">
									<label for="store_<?=$arProperty["ID"]?>_<?=$key;?>_<?=$arParams["ELEMENT_ID"];?>"></label>
								</div>
								<div class="stores_text_wrapp <?=(isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"]) ? 'image_block' : '')?>">
									<?if (isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"])):?>
										<div class="imgs"><?=GetMessage('S_IMAGE')?> <?=CFile::ShowImage($arProperty["IMAGE_ID"], 100, 100, "border=0", "", true);?></div>
									<?endif;?>
									<div class="main_info">
										<?if (isset($arProperty["TITLE"])):?>
											<span>
												<a class="title_stores" href="<?=$arProperty["URL"]?>" data-storehref="<?=$arProperty["URL"]?>" data-iblockhref="<?=$arShops[$arProperty['ID']]['DETAIL_PAGE_URL']?>"><?=$arProperty["TITLE"].(strlen($arProperty["ADDRESS"]) && strlen($arProperty["TITLE"]) ? ', ' : '').$arProperty["ADDRESS"]?></a>
											</span>
										<?endif;?>
										<?if ($arParams['SHOW_GENERAL_STORE_INFORMATION'] == "Y"){?>
											<?=GetMessage('BALANCE')?>
										<?}?>
									</div>
								</div>
								<div class="quantity-wrapp-block cost prices media">
									<?if(isset($arProperty["PHONE"])):?><span class="store_phone p10"><span><?=$arProperty["PHONE"]?></span></span><?endif;?>
								
									<?if(strlen($arQuantityData["TEXT"])):?>
										<?=$arQuantityData["HTML"]?>
									<?endif;?>
									<?if($arPrice["RESULT_PRICE"]):?>
										<span class="price">
											<span class="values_wrapper"><?=\Aspro\Functions\CAsproItem::getCurrentPrice($price, $arFormatPrice, false);?></span>
										</span>
									<?endif;?>
									<span class="in_basket"></span>
								</div>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?endforeach;?>
		</form>
		<?if($empty_count==$count_stores){?>
			<div class="stores_block">
				<div class="stores_text_wrapp"><?=GetMessage('NO_STORES')?></div>
			</div>
		<?}?>
	</div>
<?else:?>
	<div class="stores_block">
		<div class="stores_text_wrapp"><?=GetMessage('NO_STORES')?></div>
	</div>
<?endif;?>