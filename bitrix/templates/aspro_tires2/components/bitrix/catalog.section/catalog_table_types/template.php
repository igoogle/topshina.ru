<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<? global $arTheme;?>
<?if($arResult["GROUPS"]):?>
	<?$arParams["BASKET_ITEMS"]=($arParams["BASKET_ITEMS"] ? $arParams["BASKET_ITEMS"] : array());?>

	<?/*show section stickers*/?>
	<?if($arResult["SECTION_STICKERS"]):?>
		<?$this->SetViewTarget('section_stickers');?>
			<div class="stickers">
				<?foreach($arResult["SECTION_STICKERS"] as $arSticker):?>
					<div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
				<?endforeach;?>
			</div>
		<?$this->EndViewTarget();?>
	<?endif;?>
	<?/**/?>

	<?/*show section rating*/?>
	<?$this->SetViewTarget('section_rating');?>
		<?$frame = $this->createFrame('dv_'.$arResult["ID"])->begin('');?>
			<div class="rating rating_wrapper">
				<div class="iblock-vote">
					<?$rating = (round($arResult["SUMM_RATING"]/$arResult["ITEMS_COUNT"]));?>
					<table>
						<tbody>
							<tr>
								<?for($i=0; $i < 5; $i++):?>
									<td><div class="star-<?=(($rating > $i) ? "voted" : "empty");?>" title="<?=$i+1;?>"></div></td>
								<?endfor;?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		<?$frame->end();?>
	<?$this->EndViewTarget();?>
	<?/**/?>

	<?/*show section price*/?>
	<?$this->SetViewTarget('section_price');?>
		<?$frame = $this->createFrame('price_'.$arResult["ID"])->begin('');?>
			<div class="prices_block">
				<div class="cost prices clearfix">
					<div class="price">
						<?=$arResult["SECTION_PRICE"];?>
					</div>
				</div>
			</div>
		<?$frame->end();?>
	<?$this->EndViewTarget();?>
	<?/**/?>

	<?/*show section price*/?>
	<?if($arResult["SECTION_PROPS"]):?>
		<?$this->SetViewTarget('section_item_props');?>
			<?$frame = $this->createFrame('props_'.$arResult["ID"])->begin('');?>
				<div class="top_props">
					<div class="props props_list">
						<?foreach($arResult["SECTION_PROPS"] as $key => $arProp):?>
							<div class="prop">
								<div class="name">
									<div class="char_name">
										<div class="props_item">
											<span><?=$key;?></span>
										</div>
									</div>
								</div>
								<div class="value">
									<?foreach($arProp["PROPS"] as $arValue):?>
										<div class="char_value <?=($arValue["CLASS"] ? "wicon ".$arValue["CLASS"] : "")?>">
											<?=$arValue["VALUE"];?>
										</div>
									<?endforeach;?>
								</div>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?$frame->end();?>
		<?$this->EndViewTarget();?>
	<?endif;?>
	<?/**/?>

	<?$currencyList = '';
	if (!empty($arResult['CURRENCIES'])){
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList,
		'YM_ELEMENT_ID' => $arParams["YM_ELEMENT_ID"],
	);
	unset($currencyList, $templateLibrary);?>
	
	<?$nAllQuantity = 0;?>
	<?$bShowGroups = (!empty($arResult["USE_GROUPS"]))?>

	

		<div class="tabs_section type_more">


			<div class="tabs catalog_detail">
<?//if($arParams["AJAX_REQUEST"]=="N"):?>
				<ul class="nav nav-tabs">
					<li class="types_item_tab active">
						<a href="#types_item" data-toggle="tab"><span><?=Loc::getMessage("SECTION_ITEM_TYPES_AND_PRICE")?></span></a>
					</li>
					<?if($arParams["USE_REVIEW"] == "Y" && $arParams["FORUM_ID"]):?>
						<li class="reviews_item_tab">
							<a href="#reviews_item" data-toggle="tab"><span><?=Loc::getMessage("SECTION_ITEM_REVIEWS")?></span><span class="count empty"></span></a>
						</li>
					<?endif;?>
					<?if($arParams["VIDEO"]):?>
						<li class="video_item_tab">
							<?$count_video = count($arParams["VIDEO"]);?>
							<a href="#video_item" data-toggle="tab"><span><?=Loc::getMessage("SECTION_ITEM_VIDEO")?></span><?=($count_video > 1 ? '<span class="count">('.$count_video.')</span>' : '');?></a>
						</li>
					<?endif;?>
					<?if($arParams["DESCRIPTION"]):?>
						<li class="desc_item_tab">
							<a href="#desc_item" data-toggle="tab"><span><?=Loc::getMessage("SECTION_ITEM_DESCRIPTION")?></span></a>
						</li>
					<?endif;?>
				</ul>
				<div class="tab-content">
					<div class="tab-pane types_item_tab active" id="types_item">
						<div class="title-tab-heading visible-xs"><?=Loc::getMessage("SECTION_ITEM_TYPES_AND_PRICE")?></div>
						<div>
						<?if(count($arResult["ITEMS_GROUPS"]) > 1):?>
							<div class="item_types_block">
								<div class="block_wrapper">
									<div class="title"><?=Loc::getMessage("SECTION_ITEM_TYPES")?></div>
								</div>
								<div class="block_wrapper">
									<div class="items">
										<div class="item colored active" data-group="all"><span><?=Loc::getMessage("SECTION_ITEM_TYPES_ALL")?></span></div>
										<?foreach($arResult["ITEMS_GROUPS"]  as $key => $arGroups):?>
											<div class="item colored" data-group="<?=$key;?>"><span>R<?=$key;?></span></div>
										<?endforeach;?>
									</div>
								</div>
							</div>
						<?endif;?>
						<table class="module_products_list list_model_items_wrapper">
							<?if($bShowGroups):?>
								<thead>
									<tr>
										<th></th>
										<th><?=Loc::getMessage("ITEM_TABLE_TITLE")?></th>
										<th><?=Loc::getMessage("ITEM_TABLE_SIZE")?></th>
										<th class="text-center"><?=Loc::getMessage("ITEM_TABLE_PRICE")?></th>
										<th class="text-center hidden-media"><?=Loc::getMessage("ITEM_TABLE_AMOUNT")?></th>
										<th class="hidden-media"></th>
										<th></th>
									</tr>
								</thead>
							<?endif;?>
							<tbody>
	<?//endif;?>
	<?
	// echo '<pre>';
	// print_r($arParams["AJAX_REQUEST"]);
	// echo '</pre>';
	$bFromAjax = $arParams["AJAX_REQUEST"]=="Y";
	?>
				<?foreach($arResult["GROUPS"] as $key => $arGroups){
					$countSubItems = count($arGroups["ITEMS"]);
					foreach($arGroups["ITEMS"] as $key2 => $arItem){
						if(!$bFromAjax) {
							if(!$key2) {
								$ShowGroup = true;
							} else {
								$ShowGroup = false;
							}
						} else {
							if(!$key2) {
								$ShowGroup = true;
							} else {
								$ShowGroup = false;
							}
						}
						
						
						$propGroup = ($arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"] && isset($arItem["PROPERTIES"][$arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"]])? $arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"] : "");
						// echo '<pre>';
						// print_r($ShowGroup);
						// echo '</pre>';
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));

						$totalCount = CTires2::GetTotalCount($arItem, $arParams);
						$arQuantityData = CTires2::GetQuantityArray($totalCount);
						$nAllQuantity += $totalCount;
						$strMeasure = '';
						if(!$arItem["OFFERS"] || $arParams['TYPE_SKU'] === 'TYPE_2'){
							if($arParams["SHOW_MEASURE"] == "Y" && $arItem["CATALOG_MEASURE"]){
								$arMeasure = CCatalogMeasure::getList(array(), array("ID" => $arItem["CATALOG_MEASURE"]), false, false, array())->GetNext();
								$strMeasure = $arMeasure["SYMBOL_RUS"];
							}
							$arItem["OFFERS_MORE"]="Y";
						}
						elseif($arItem["OFFERS"]){
							$strMeasure = $arItem["MIN_PRICE"]["CATALOG_MEASURE_NAME"];
							$arItem["OFFERS_MORE"]="Y";
						}
						$elementName = ((isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arItem['NAME']);
						?>
						<?$arAddToBasketData = CTires2::GetAddToBasketArray($arItem, $totalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'small', $arParams);?>
						<tr class="item main_item_wrapper" data-group="<?=$key;?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<?if($bShowGroups && $ShowGroup):?>
								<td class="dia-cell" rowspan="<?=$countSubItems;?>"><?=$key;?>''</td>
							<?endif;?>
							<?if($arParams["AJAX_REQUEST"] == 'Y' && !$ShowGroup && !$key2):?>
								<td class="dia-cell" rowspan="<?=$countSubItems;?>"></td>
							<?endif;?>
							<td class="item-name-cell">
								<div class=""><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class=""><?=$elementName?></a></div>
							</td>
							<td class="item-size-cell">
								<div class="title"><?=$arItem["SIZE"]?></div>
								<!--noindex-->
									<div class="stock_media"><span class="item_stock_title"><?=Loc::getMessage('QUANTITY_TITLE');?></span><?=$arQuantityData["HTML"]?></div>
								<!--/noindex-->
							</td>
							<td class="price-cell">
								<div class="cost prices clearfix">
									<?if( count( $arItem["OFFERS"] ) > 0 ){?>
										<?\Aspro\Functions\CAsproSku::showItemPrices($arParams, $arItem, $item_id, $min_price_id, array(), ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
									<?}else{?>
										<?if(isset($arItem['PRICE_MATRIX']) && $arItem['PRICE_MATRIX']) // USE_PRICE_COUNT
										{?>
											<?if($arItem['ITEM_PRICE_MODE'] == 'Q' && count($arItem['PRICE_MATRIX']['ROWS']) > 1):?>
												<?=CTires2::showPriceRangeTop($arItem, $arParams, GetMessage("CATALOG_ECONOMY"));?>
											<?endif;?>
											<?=CTires2::showPriceMatrix($arItem, $arParams, $strMeasure, $arAddToBasketData);?>
										<?}
										else
										{?>
											<?\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arItem["PRICES"], $strMeasure, $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
										<?}?>
									<?}?>
								</div>

								<div class="basket_props_block" id="bx_basket_div_<?=$arItem["ID"];?>" style="display: none;">
									<?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])){
										foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo){?>
											<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
											<?if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
												unset($arItem['PRODUCT_PROPERTIES'][$propID]);
										}
									}
									$arItem["EMPTY_PROPS_JS"]="Y";
									$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
									if (!$emptyProductProperties){
										$arItem["EMPTY_PROPS_JS"]="N";?>
										<div class="wrapper">
											<table>
												<?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo){?>
													<tr>
														<td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
														<td>
															<?if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE']	&& 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']){
																foreach($propInfo['VALUES'] as $valueID => $value){?>
																	<label>
																		<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
																	</label>
																<?}
															}else{?>
																<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
																	foreach($propInfo['VALUES'] as $valueID => $value){?>
																		<option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
																	<?}?>
																</select>
															<?}?>
														</td>
													</tr>
												<?}?>
											</table>
										</div>
										<?
									}?>
								</div>
								<div class="adaptive_button_buy">
									<!--noindex-->
										<?=$arQuantityData["HTML"]?>
										<?=$arAddToBasketData["HTML"]?>
									<!--/noindex-->
								</div>
							</td>
							<td class="store-cell item_<?=$arItem["ID"]?>">
								<!--noindex-->
									<?=$arQuantityData["HTML"]?>
								<!--/noindex-->
							</td>
							<td class="but-cell item_<?=$arItem["ID"]?>">
								<div class="counter_wrapp">
									<?if($arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] && !count($arItem["OFFERS"]) && $arAddToBasketData["ACTION"] == "ADD" && $arAddToBasketData["CAN_BUY"]):?>
										<div class="counter_block" data-item="<?=$arItem["ID"];?>" <?=(in_array($arItem["ID"], $arParams["BASKET_ITEMS"]) ? "style='display: none;'" : "");?>>
											<span class="minus">-</span>
											<input type="text" class="text" name="quantity" value="<?=$arAddToBasketData["MIN_QUANTITY_BUY"]?>" />
											<span class="plus" <?=($arAddToBasketData["MAX_QUANTITY_BUY"] ? "data-max='".$arAddToBasketData["MAX_QUANTITY_BUY"]."'" : "")?>>+</span>
										</div>
									<?endif;?>
									<div class="button_block <?=(in_array($arItem["ID"], $arParams["BASKET_ITEMS"])  || $arAddToBasketData["ACTION"] == "ORDER" || !$arAddToBasketData["CAN_BUY"] || !$arAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_LIST"] ? "wide" : "");?>">
										<!--noindex-->
											<?=$arAddToBasketData["HTML"]?>
										<!--/noindex-->
									</div>
								</div>
								<?
								if(isset($arItem['PRICE_MATRIX']) && $arItem['PRICE_MATRIX']) // USE_PRICE_COUNT
								{?>
									<?if($arItem['ITEM_PRICE_MODE'] == 'Q' && count($arItem['PRICE_MATRIX']['ROWS']) > 1):?>
										<?$arOnlyItemJSParams = array(
											"ITEM_PRICES" => $arItem["ITEM_PRICES"],
											"ITEM_PRICE_MODE" => $arItem["ITEM_PRICE_MODE"],
											"ITEM_QUANTITY_RANGES" => $arItem["ITEM_QUANTITY_RANGES"],
											"MIN_QUANTITY_BUY" => $arAddToBasketData["MIN_QUANTITY_BUY"],
											"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
											"ID" => $this->GetEditAreaId($arItem["ID"]),
										)?>
										<script type="text/javascript">
											var ob<? echo $this->GetEditAreaId($arItem["ID"]); ?>el = new JCCatalogSectionOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
										</script>
									<?endif;?>
								<?}?>
							</td>
							<td class="like_icons <?=(((!$arItem["OFFERS"] && $arParams["DISPLAY_WISH_BUTTONS"] != "N" && $arAddToBasketData["CAN_BUY"]) && ($arParams["DISPLAY_COMPARE"] == "Y")) ? " full" : "")?>">
								<div class="wrapp_stockers">
									<div class="like_icons">
										<?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
											<?if(!$arItem["OFFERS"]):?>
												<div class="wish_item_button" <?=($arAddToBasketData["CAN_BUY"] ? '' : 'style="display:none"');?>>
													<span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
													<span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added" style="display: none;" data-item="<?=$arItem["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>"><i></i></span>
												</div>
											<?elseif($arItem["OFFERS"]):?>
												<?foreach($arItem["OFFERS"] as $arOffer):?>
													<?if($arAddToBasketData['CAN_BUY']):?>
														<div class="wish_item_button o_<?=$arOffer["ID"];?>" style="display: none;">
															<span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$arOffer["ID"]?>" data-iblock="<?=$arItem["IBLOCK_ID"]?>" data-offers="Y" data-props="<?=$arOfferProps?>"><i></i></span>
															<span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$arOffer["ID"]?>" data-iblock="<?=$arOffer["IBLOCK_ID"]?>"><i></i></span>
														</div>
													<?endif;?>
												<?endforeach;?>
											<?endif;?>
										<?endif;?>
										<?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
											<?if(!$arItem["OFFERS"] || $arParams["TYPE_SKU"] !== 'TYPE_1'):?>
												<div class="compare_item_button">
													<span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>" ><i></i></span>
													<span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arItem["ID"]?>"><i></i></span>
												</div>
											<?elseif($arItem["OFFERS"]):?>
												<?foreach($arItem["OFFERS"] as $arOffer):?>
													<div class="compare_item_button o_<?=$arOffer["ID"];?>" style="display: none;">
														<span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arOffer["ID"]?>" ><i></i></span>
														<span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arOffer["ID"]?>"><i></i></span>
													</div>
												<?endforeach;?>
											<?endif;?>
										<?endif;?>
									</div>
								</div>
							</td>
						</tr>
					<?}?>
				<?}?>
	<?//if(!$bFromAjax):?>
				</tbody>
			</table>
	<?//endif;?>
		</div> <?// .tab-pane types_item_tab div?>

			
			<?if($arParams["DISPLAY_BOTTOM_PAGER"] == 'Y'):?>
				<div class="bottom_nav <?=$arParams["DISPLAY_TYPE"];?>" <?=($bFromAjax ? "style='display: none; '" : "");?> data-filter="<?=$_REQUEST['filter']?>">
					<?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?><?=$arResult["NAV_STRING"]?><?}?>
				</div>
			<?endif;?>
			
	<?//if(!$bFromAjax):?>
		</div> <?// .tab-pane types_item_tab?>
	<?//endif;?>

	<?/*show section quantity*/?>
	<?$this->SetViewTarget('section_quantity');?>
		<?$frame = $this->createFrame('quantity_'.$arResult["ID"])->begin('');?>
			<?$arQuantityData = CTires2::GetQuantityArray($nAllQuantity);?>
			<?if($arQuantityData["HTML"] || $arParams["SHOW_CHEAPER_FORM"] == "Y"):?>
				<div class="quantity_block_wrapper">
					<?=$arQuantityData["HTML"];?>
					<?if($arParams["SHOW_CHEAPER_FORM"] == "Y"):?>
						<?$strSectionName = $arResult["NAME"];
						if($arResult["PATH"])
						{
							$arTmpPath = array();
							foreach($arResult["PATH"] as $arPath)
							{
								$arTmpPath[] = $arPath["NAME"];
							}
							if($arTmpPath)
								$strSectionName = implode("/", $arTmpPath);
						}?>
						<div class="cheaper_form">
							<span class="animate-load" data-event="jqm" data-param-form_id="CHEAPER" data-name="cheaper<?=$arResult["ID"];?>" data-autoload-product_name="<?=$strSectionName;?>" data-autoload-product_id="<?=$arResult["ID"];?>"><?=($arParams["CHEAPER_FORM_NAME"] ? $arParams["CHEAPER_FORM_NAME"] : Loc::getMessage("CHEAPER"));?></span>
						</div>
					<?endif;?>
				</div>
			<?endif;?>
		<?$frame->end();?>
	<?$this->EndViewTarget();?>
	<?/**/?>

<?endif;?>