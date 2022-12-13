<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
__IncludeLang($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lang/".LANGUAGE_ID."/template.php");
	
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

global $arTheme, $arRegion;

$useStores = $arParams["USE_STORE"] == "Y" && $templateData["STORES_COUNT"] && $templateData['QUANTITY_DATA']["RIGHTS"]["SHOW_QUANTITY"];
$showCustomOffer=(($templateData['OFFERS'] && $arParams["TYPE_SKU"] !="N") ? true : false);
if($showCustomOffer){
	$templateData['JS_OBJ'] = $strObName;
}

$arTabOrder = explode(",", $arParams["LIST_PRODUCT_BLOCKS_TAB_ORDER"]);
if (!in_array('char', $arTabOrder)) {
	array_unshift($arTabOrder, 'char');
}
?>
<?
if($templateData['SECTION_BNR_CONTENT'])
{
	global $SECTION_BNR_CONTENT, $bHasFrontBanners;
	$SECTION_BNR_CONTENT = true;
	$bHasFrontBanners = true;
}
?>

<?if($arResult["ID"]):?>
	<div class="row">
		<?$disply_elements=($arParams["DISPLAY_ELEMENT_SLIDER"] ? $arParams["DISPLAY_ELEMENT_SLIDER"] : 32);?>
		<div class="col-md-9">
			<div class="tabs_section type_more">
				<?
				$arVideo = array();
				if(strlen($templateData["DISPLAY_PROPERTIES"]["VIDEO"]["VALUE"])){
					$arVideo[] = $templateData["DISPLAY_PROPERTIES"]["VIDEO"]["~VALUE"];
				}
				if(isset($templateData["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
					if(is_array($templateData["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
						$arVideo = $arVideo + $templateData["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["~VALUE"];
					}
					elseif(strlen($templateData["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["VALUE"])){
						$arVideo[] = $templateData["DISPLAY_PROPERTIES"]["VIDEO_YOUTUBE"]["~VALUE"];
					}
				}
				if(count($templateData["SECTION_FULL"]["UF_VIDEO_YOUTUBE"])){
					$arVideo = array_merge($arVideo, $templateData["SECTION_FULL"]["UF_VIDEO_YOUTUBE"]);
				}

				/*suitable cars*/
				$typeFilter = '';

				if($arParams["IBLOCK_ID"] == \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_tires"][0]))
				{
					$typeFilter = 'tires';
					$filterTWidth = $templateData["PROPERTIES"][$arParams["TYRE_SHIRINA_PROFILYA"]]["VALUE"];
					$filterTHeight = $templateData["PROPERTIES"][$arParams["TYRE_VYSOTA_PROFILYA"]]["VALUE"];
					$filterTDia =$templateData["PROPERTIES"][$arParams["TYRE_POSADOCHNYY_DIAMETR"]]["VALUE"];
					if(!$filterTWidth || !$filterTHeight || !$filterTDia)
						$typeFilter = '';
				}

				if($arParams["IBLOCK_ID"] == \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0]))
				{
					$typeFilter = 'wheels';
					$filterDWidth = $templateData["PROPERTIES"][$arParams["DISK_SHIRINA_DISKA"]]["VALUE"];
					$filterDDia =$templateData["PROPERTIES"][$arParams["DIKS_POSADOCHNYY_DIAMETR_DISKA"]]["VALUE"];
					$filterDLZ = $templateData["PROPERTIES"][$arParams["DISK_COUNT_OTVERSTIY"]]["VALUE"];
					$filterDPCD = $templateData["PROPERTIES"][$arParams["DISK_MEZHBOLTOVOE_RASSTOYANIE"]]["VALUE"];
					if(!$filterDWidth || !$filterDLZ || !$filterDDia || !$filterDPCD)
						$typeFilter = '';
				}

				if($arParams["IBLOCK_ID"] == \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0]))
				{
					$typeFilter = 'akb';

					$filterALength = $templateData["PROPERTIES"][$arParams["AKB_LENGTH"]]["VALUE"];
					$filterAWidth = $templateData["PROPERTIES"][$arParams["AKB_WIDTH"]]["VALUE"];
					$filterAHeight = $templateData["PROPERTIES"][$arParams["AKB_HEIGHT"]]["VALUE"];
					$filterAEmkost = $templateData["PROPERTIES"][$arParams["AKB_EMKOST"]]["VALUE"];

					if($templateData["PROPERTIES"][$arParams["AKB_POLARNOST"]]["VALUE"])
						$filterAPolarnost = \Aspro\Functions\CAsproTires2::foramtPolarityValue($templateData["PROPERTIES"][$arParams["AKB_POLARNOST"]]["VALUE"]);

					$filterAType = '';
					$filterAVoltag = $templateData["PROPERTIES"][$arParams["AKB_VOLTAG"]]["VALUE"];
					if($filterAEmkost)
					if(!$filterAEmkost)
						$typeFilter = '';
				}
				
				$instr_prop = ($arParams["DETAIL_DOCS_PROP"] ? $arParams["DETAIL_DOCS_PROP"] : "INSTRUCTIONS");
				$bShowSuitableCars = ($arParams["USE_SUITABLE_CAR"] != "N" && $typeFilter);
				
				$bShowTabs = ($templateData["OFFERS"] || $templateData["DETAIL_TEXT"] || count($templateData["PROPERTIES"][$instr_prop]["VALUE"]) || is_array($templateData["PROPERTIES"][$instr_prop]["VALUE"]) || count($templateData["SECTION_FULL"]["UF_FILES"]) || $arParams["SHOW_HOW_BUY"] == "Y" || $arParams["SHOW_PAYMENT"] == "Y" || $arParams["SHOW_DELIVERY"] == "Y" || $useStores && ($showCustomOffer || !$templateData["OFFERS"] ) || $arVideo || $arParams["USE_REVIEW"] == "Y" || $bShowSuitableCars || $arParams["SHOW_ASK_BLOCK"] == "Y" && intVal($arParams["ASK_FORM_ID"]) || $arParams["SHOW_ADDITIONAL_TAB"] == "Y" ? true : false);
				?>

				<?//check props?>
				<?
				$showProps = $htmlProps = false;
				$iCountProps = count($templateData["VISIBLE_PROPS"]);
				
				if($templateData["VISIBLE_PROPS"]){
					foreach($templateData["VISIBLE_PROPS"] as $arProp){
						if(!is_array($arProp["DISPLAY_VALUE"]))
							$arProp["DISPLAY_VALUE"] = array($arProp["DISPLAY_VALUE"]);
						
						if(is_array($arProp["DISPLAY_VALUE"])){
							foreach($arProp["DISPLAY_VALUE"] as $value){
								if(strlen($value)){
									$showProps = true;
									break 2;
								}
							}
						}
					}
				}
				
				if(!$showProps && $templateData['OFFERS']){
					foreach($templateData['OFFERS'] as $arOffer){
						foreach($arOffer['DISPLAY_PROPERTIES'] as $arProp){
							if(!$templateData["TMP_OFFERS_PROP"][$arProp['CODE']])
							{
								if(!is_array($arProp["DISPLAY_VALUE"]))
									$arProp["DISPLAY_VALUE"] = array($arProp["DISPLAY_VALUE"]);

								foreach($arProp["DISPLAY_VALUE"] as $value){
									if(strlen($value)){
										$showProps = true;
										break 3;
									}
								}
							}
						}
					}
				}
				if (($iCountProps < $arParams['VISIBLE_PROP_COUNT'] && $arTheme['LEFT_BLOCK_CATALOG_DETAIL']['VALUE'] != 'Y') && $showProps) {
					$showProps = false;
				}?>
				<?$strGrupperType = $arParams["GRUPPER_PROPS"];?>
				<?$bPropTab = ($arParams["PROPERTIES_DISPLAY_LOCATION"] == "TAB");?>
				<?if ($showProps):?>
					<?ob_start();?>
						<?if($strGrupperType == "GRUPPER"):?>
							<div class="char_block colored_char">
								<?$APPLICATION->IncludeComponent(
									"redsign:grupper.list",
									"",
									Array(
										"CACHE_TIME" => "3600000",
										"CACHE_TYPE" => "A",
										"COMPOSITE_FRAME_MODE" => "A",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"DISPLAY_PROPERTIES" => $templateData["GROUPS_PROPS"]
									),
									$component, array('HIDE_ICONS'=>'Y')
								);?>
								<table class="props_list colored_char" id="props"></table>
							</div>
						<?elseif($strGrupperType == "WEBDEBUG"):?>
							<div class="char_block">
								<?$APPLICATION->IncludeComponent(
									"webdebug:propsorter",
									"linear",
									array(
										"IBLOCK_TYPE" => $templateData['IBLOCK_TYPE'],
										"IBLOCK_ID" => $templateData['IBLOCK_ID'],
										"PROPERTIES" => $templateData['GROUPS_PROPS'],
										"EXCLUDE_PROPERTIES" => array(),
										"WARNING_IF_EMPTY" => "N",
										"WARNING_IF_EMPTY_TEXT" => "",
										"NOGROUP_SHOW" => "Y",
										"NOGROUP_NAME" => "",
										"MULTIPLE_SEPARATOR" => ", "
									),
									$component, array('HIDE_ICONS'=>'Y')
								);?>
								<table class="props_list" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>"></table>
							</div>
						<?elseif($strGrupperType == "YENISITE_GRUPPER"):?>
							<div class="char_block">
								<?$APPLICATION->IncludeComponent(
									'yenisite:ipep.props_groups',
									'',
									array(
										'DISPLAY_PROPERTIES' => $templateData['GROUPS_PROPS'],
										'IBLOCK_ID' => $arParams['IBLOCK_ID']
									),
									$component, array('HIDE_ICONS'=>'Y')
								)?>
								<table class="props_list colored_char" id="props"></table>
							</div>
						<?else:?>							
							<?if($arParams["PROPERTIES_DISPLAY_TYPE"] != "TABLE"):?>
								<div class="props_block" id="<? echo $arItemIDs["ALL_ITEM_IDS"]['DISPLAY_PROP_DIV']; ?>">
									<?foreach($templateData["PROPERTIES"] as $propCode => $arProp):?>
										<?if(isset($templateData["DISPLAY_PROPERTIES"][$propCode])):?>
											<?$arProp = $templateData["DISPLAY_PROPERTIES"][$propCode];?>
											<?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE", "POPUP_VIDEO"))):?>
												<?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
													<div class="char" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
														<div class="char_name">
															<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
															<div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
																<span itemprop="name"><?=$arProp["NAME"]?></span>
															</div>
														</div>
														<div class="char_value" itemprop="value">
															<?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
																<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
															<?else:?>
																<?=$arProp["DISPLAY_VALUE"];?>
															<?endif;?>
														</div>
													</div>
												<?endif;?>
											<?endif;?>
										<?endif;?>
									<?endforeach;?>
								</div>
							<?else:?>
								<div class="char_block">
									<table class="props_list colored_char">
										<?foreach($templateData["DISPLAY_PROPERTIES"] as $arProp):?>
											<?if(!in_array($arProp["CODE"], array("SERVICES", "BRAND", "HIT", "RECOMMEND", "NEW", "STOCK", "VIDEO", "VIDEO_YOUTUBE", "CML2_ARTICLE", "POPUP_VIDEO"))):?>
												<?if((!is_array($arProp["DISPLAY_VALUE"]) && strlen($arProp["DISPLAY_VALUE"])) || (is_array($arProp["DISPLAY_VALUE"]) && implode('', $arProp["DISPLAY_VALUE"]))):?>
													<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
														<td class="char_name">
															<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
															<div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
																<span itemprop="name"><?=$arProp["NAME"]?></span>
															</div>
														</td>
														<td class="char_value">
															<span itemprop="value">
																<?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
																	<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
																<?else:?>
																	<?=$arProp["DISPLAY_VALUE"];?>
																<?endif;?>
															</span>
														</td>
													</tr>
												<?endif;?>
											<?endif;?>
										<?endforeach;?>
									</table>
									<table class="props_list colored_char sku" id="props"></table>
								</div>
							<?endif;?>
						<?endif;?>
					<?$htmlProps = ob_get_clean();?>
				<?endif;?>
				
				<?if($bShowTabs):?>
					<div class="tabs arrow_scroll">
						<ul class="nav nav-tabs">
							<?$iTab = 0;?>
							<?$instr_prop = ($arParams["DETAIL_DOCS_PROP"] ? $arParams["DETAIL_DOCS_PROP"] : "INSTRUCTIONS");?>
							<?foreach($arTabOrder as $value):?>
								<?if ($value == 'offers' && $templateData["OFFERS"] && $arParams["TYPE_SKU"]=="TYPE_2"):?>
									<li class="prices_tab<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#prices_offer" data-toggle="tab"><span><?=($arParams["TAB_OFFERS_NAME"] ? $arParams["TAB_OFFERS_NAME"] : GetMessage("OFFER_PRICES"));?></span></a>
									</li>
								<?endif;?>
								<?if ($value == 'char' && $bPropTab && $showProps):?>
									<li class="chars_tab<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#char_tab" data-toggle="tab">
											<span>
												<?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("CT_NAME_DOP_CHAR"));?>
											</span>
										</a>
									</li>
								<?endif;?>
								<?if ($value == 'desc'):?>
									<?if(
										$templateData["DETAIL_TEXT"]
										|| (
											(
											count($templateData["PROPERTIES"][$instr_prop]["VALUE"])
											&& is_array($templateData["PROPERTIES"][$instr_prop]["VALUE"])
											)
											|| count($templateData["SECTION_FULL"]["UF_FILES"])
										)
										|| (
											!$bPropTab
											&& $showProps
										)
										):?>
										<li class="desc_tab <?=(!($iTab++) ? ' active' : '')?>">
											<a href="#descr" data-toggle="tab">
												<span>
													<?=($arParams["TAB_DESCR_NAME"] ? $arParams["TAB_DESCR_NAME"] : GetMessage("DESCRIPTION_TAB"));?>
												</span>
											</a>
										</li>
									<?endif;?>
								<?endif;?>
								<?if($value == 'buy' && $arParams["SHOW_HOW_BUY"] == "Y"):?>
									<li class="<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#hbuy" data-toggle="tab"><span><?=$arParams["TITLE_HOW_BUY"];?></span></a>
									</li>
								<?endif;?>			
								<?if($value == 'cash' && $arParams["SHOW_PAYMENT"] == "Y"):?>
									<li class="<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#payment" data-toggle="tab"><span><?=$arParams["TITLE_PAYMENT"];?></span></a>
									</li>
								<?endif;?>
								<?if($value == 'delivery' && $arParams["SHOW_DELIVERY"] == "Y"):?>
									<li class="<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#delivery" data-toggle="tab"><span><?=$arParams["TITLE_DELIVERY"];?></span></a>
									</li>
								<?endif;?>
								<?if($value == 'available' && $useStores && ($showCustomOffer || !$templateData["OFFERS"] )):?>
									<li class="stores_tab<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#stores" data-toggle="tab"><span><?=($arParams["TAB_STOCK_NAME"] ? $arParams["TAB_STOCK_NAME"] : GetMessage("STORES_TAB"));?></span></a>
									</li>
								<?endif;?>
								
								<?if($value == 'video' && $arVideo):?>
									<li class="<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#video" data-toggle="tab">
											<span><?=($arParams["TAB_VIDEO_NAME"] ? $arParams["TAB_VIDEO_NAME"] : GetMessage("VIDEO_TAB"));?></span>
											<?if(count($arVideo) > 1):?>
												<span class="count empty">&nbsp;(<?=count($arVideo)?>)</span>
											<?endif;?>
										</a>
									</li>
								<?endif;?>
								<?if($value == 'reviews' && $arParams["USE_REVIEW"] == "Y"):?>
									<li class="product_reviews_tab<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#review" data-toggle="tab"><span><?=($arParams["TAB_REVIEW_NAME"] ? $arParams["TAB_REVIEW_NAME"] : GetMessage("REVIEW_TAB"))?></span><span class="count empty"></span></a>
									</li>
								<?endif;?>
								<?if($value == 'suitable' && $bShowSuitableCars):?>
									<li class="product_suitable_tab<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#suitable_cars" data-toggle="tab"><span><?=($arParams["TAB_SUITABLE_NAME"] ? $arParams["TAB_SUITABLE_NAME"] : GetMessage("SUITABLE_TAB"))?></span></a>
									</li>
								<?endif;?>
								<?if($value == 'question' && ($arParams["SHOW_ASK_BLOCK"] == "Y") && (intVal($arParams["ASK_FORM_ID"]))):?>
									<li class="product_ask_tab <?=(!($iTab++) ? ' active' : '')?>">
										<a href="#ask" data-toggle="tab"><span><?=($arParams["TAB_FAQ_NAME"] ? $arParams["TAB_FAQ_NAME"] : GetMessage('ASK_TAB'))?></span></a>
									</li>
								<?endif;?>
								<?if($value == 'dop' && $arParams["SHOW_ADDITIONAL_TAB"] == "Y"):?>
									<li class="<?=(!($iTab++) ? ' active' : '')?>">
										<a href="#dops" data-toggle="tab"><span><?=($arParams["TAB_DOPS_NAME"] ? $arParams["TAB_DOPS_NAME"] : GetMessage("ADDITIONAL_TAB"));?></span></a>
									</li>
								<?endif;?>
							<?endforeach;?>
						</ul>
					</div>
					<div class="tab-content">
						<?$show_tabs = false;?>
						<?$iTab = 0;?>
						<?
						$showSkUName = ((in_array('NAME', $arParams['OFFERS_FIELD_CODE'])));
						$showSkUImages = false;
						if(((in_array('PREVIEW_PICTURE', $arParams['OFFERS_FIELD_CODE']) || in_array('DETAIL_PICTURE', $arParams['OFFERS_FIELD_CODE'])))){
							foreach ($arResult["OFFERS"] as $key => $arSKU){
								if($arSKU['PREVIEW_PICTURE'] || $arSKU['DETAIL_PICTURE']){
									$showSkUImages = true;
									break;
								}
							}
						}?>
						<?if($templateData["OFFERS"] && $arParams["TYPE_SKU"] !== "TYPE_1"):?>
							<script>
								$(document).ready(function() {
									$('.catalog_detail .tabs_section .tabs_content .form.inline input[data-sid="PRODUCT_NAME"]').attr('value', $('h1').text());
								});
							</script>
						<?endif;?>
						<?foreach($arTabOrder as $value):?>
							<?if($value == 'offers' && $templateData["OFFERS"] && $arParams["TYPE_SKU"] !== "TYPE_1"):?>
								<div class="tab-pane prices_tab<?=(!($iTab++) ? ' active' : '')?>" id="prices_offer">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_OFFERS_NAME"] ? $arParams["TAB_OFFERS_NAME"] : GetMessage("OFFER_PRICES"));?></div>
									<div>
									<div class="bx_sku_props" style="display:none;">
										<?$arSkuKeysProp='';
										$propSKU=$arParams["OFFERS_CART_PROPERTIES"];
										if($propSKU){
											$arSkuKeysProp=base64_encode(serialize(array_keys($propSKU)));
										}?>
										<input type="hidden" value="<?=$arSkuKeysProp;?>"></input>
									</div>
									<table class="offers_table">
										<thead>
											<tr>
												<?if($useStores):?>
													<td class="str"></td>
												<?endif;?>
												<?if($showSkUImages):?>
													<td class="property img" width="50"></td>
												<?endif;?>
												<?if($showSkUName):?>
													<td class="property names"><?=GetMessage("CATALOG_NAME")?></td>
												<?endif;?>
												<?if($templateData["SKU_PROPERTIES"]){
													foreach ($templateData["SKU_PROPERTIES"] as $key => $arProp){?>
														<?if(!$arProp["IS_EMPTY"]):?>
															<td class="property">
																<div class="props_item char_name <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
																	<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint"><span class="icon"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
																	<span><?=$arProp["NAME"]?></span>
																</div>
															</td>
														<?endif;?>
													<?}
												}?>
												<td class="price_th"><?=GetMessage("CATALOG_PRICE")?></td>
												<?if($arQuantityData["RIGHTS"]["SHOW_QUANTITY"]):?>
													<td class="count_th"><?=GetMessage("AVAILABLE")?></td>
												<?endif;?>
												<?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"  || $arParams["DISPLAY_COMPARE"] == "Y"):?>
													<td class="like_icons_th"></td>
												<?endif;?>
												<td colspan="3"></td>
											</tr>
										</thead>
										<tbody>
											<?$numProps = count($templateData["SKU_PROPERTIES"]);
											if($templateData["OFFERS"]){
												foreach ($templateData["OFFERS"] as $key => $arSKU){?>
													<?
													if($templateData["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]){
														$sMeasure = $templateData["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"].".";
													}
													else{
														$sMeasure = GetMessage("MEASURE_DEFAULT").".";
													}
													$skutotalCount = CTires2::GetTotalCount($arSKU, $arParams);
													$arskuQuantityData = CTires2::GetQuantityArray($skutotalCount, array('quantity-wrapp', 'quantity-indicators'));
													$arSKU["IBLOCK_ID"]=$templateData["IBLOCK_ID"];
													$arSKU["IS_OFFER"]="Y";
													$arskuAddToBasketData = CTires2::GetAddToBasketArray($arSKU, $skutotalCount, $arParams["DEFAULT_COUNT"], $arParams["BASKET_URL"], false, array(), 'small w_icons', $arParams);
													$arskuAddToBasketData["HTML"] = str_replace('data-item', 'data-props="'.$arOfferProps.'" data-item', $arskuAddToBasketData["HTML"]);
													?>
													<?$collspan = 1;?>
													<tr class="main_item_wrapper" id="<?=$this->GetEditAreaId($arSKU["ID"]);?>">
														<?if($useStores):?>
															<td class="opener top">
																<?$collspan++;?>
																<span class="opener_icon"><i></i></span>
															</td>
														<?endif;?>
														<?if($showSkUImages):?>
															<?$collspan++;?>
															<td class="property">
																<?
																$srcImgPreview = $srcImgDetail = false;
																$imgPreviewID = ($templateData['OFFERS'][$key]['PREVIEW_PICTURE'] ? (is_array($templateData['OFFERS'][$key]['PREVIEW_PICTURE']) ? $templateData['OFFERS'][$key]['PREVIEW_PICTURE']['ID'] : $templateData['OFFERS'][$key]['PREVIEW_PICTURE']) : false);
																$imgDetailID = ($templateData['OFFERS'][$key]['DETAIL_PICTURE'] ? (is_array($templateData['OFFERS'][$key]['DETAIL_PICTURE']) ? $templateData['OFFERS'][$key]['DETAIL_PICTURE']['ID'] : $templateData['OFFERS'][$key]['DETAIL_PICTURE']) : false);
																if($imgPreviewID || $imgDetailID){
																	$arImgPreview = CFile::ResizeImageGet($imgPreviewID ? $imgPreviewID : $imgDetailID, array('width' => 50, 'height' => 50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
																	$srcImgPreview = $arImgPreview['src'];
																}
																if($imgDetailID){
																	$srcImgDetail = CFile::GetPath($imgDetailID);
																}
																?>
																<?if($srcImgPreview || $srcImgDetail):?>
																	<a href="<?=($srcImgDetail ? $srcImgDetail : $srcImgPreview)?>" class="fancy" data-fancybox-group="item_slider"><img src="<?=$srcImgPreview?>" alt="<?=$arSKU['NAME']?>" /></a>
																<?endif;?>
															</td>
														<?endif;?>
														<?if($showSkUName):?>
															<?$collspan++;?>
															<td class="property names"><?=$arSKU['NAME']?></td>
														<?endif;?>
														<?foreach( $templateData["SKU_PROPERTIES"] as $arProp ){?>
															<?if(!$arProp["IS_EMPTY"]):?>
																<?$collspan++;?>
																<td class="property">
																	<?if($templateData["TMP_OFFERS_PROP"][$arProp["CODE"]]){
																		echo $templateData["TMP_OFFERS_PROP"][$arProp["CODE"]]["VALUES"][$arSKU["TREE"]["PROP_".$arProp["ID"]]]["NAME"];?>
																	<?}else{
																		if (is_array($arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"])){
																			echo implode("/", $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]);
																		}else{
																			if($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE"]=="directory" && isset($arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])){
																				$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('=TABLE_NAME'=>$arSKU["PROPERTIES"][$arProp["CODE"]]["USER_TYPE_SETTINGS"]["TABLE_NAME"])));
																				if ($arData = $rsData->fetch()){
																					$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
																					$entityDataClass = $entity->getDataClass();
																					$arFilter = array(
																						'limit' => 1,
																						'filter' => array(
																							'=UF_XML_ID' => $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"]
																						)
																					);
																					$arValue = $entityDataClass::getList($arFilter)->fetch();
																					if(isset($arValue["UF_NAME"]) && $arValue["UF_NAME"]){
																						echo $arValue["UF_NAME"];
																					}else{
																						echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
																					}
																				}
																			}else{
																				echo $arSKU["PROPERTIES"][$arProp["CODE"]]["VALUE"];
																			}
																		}
																	}?>
																</td>
															<?endif;?>
														<?}?>
														<td class="price">
															<div class="cost prices clearfix">
																<?
																$collspan++;
																$arCountPricesCanAccess = 0;
																if(isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX'] && count($arSKU['PRICE_MATRIX']['ROWS']) > 1) // USE_PRICE_COUNT
																{?>
																	<?=CTires2::showPriceRangeTop($arSKU, $arParams, GetMessage("CATALOG_ECONOMY"));?>
																	<?echo CTires2::showPriceMatrix($arSKU, $arParams, $arSKU["CATALOG_MEASURE_NAME"]);
																}
																else
																{?>
																	<?\Aspro\Functions\CAsproItem::showItemPrices($arParams, $arSKU["PRICES"], $arSKU["CATALOG_MEASURE_NAME"], $min_price_id, ($arParams["SHOW_DISCOUNT_PERCENT_NUMBER"] == "Y" ? "N" : "Y"));?>
																<?}?>
															</div>
														</td>
														<?if(strlen($arskuQuantityData["TEXT"])):?>
															<?$collspan++;?>
															<td class="count">
																<?=$arskuQuantityData["HTML"]?>
															</td>
														<?endif;?>
														<!--noindex-->
															<?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"  || $arParams["DISPLAY_COMPARE"] == "Y"):?>
																<td class="like_icons">
																	<?$collspan++;?>
																	<?if($arParams["DISPLAY_WISH_BUTTONS"] != "N"):?>
																		<?if($arskuAddToBasketData['CAN_BUY']):?>
																			<div class="wish_item_button o_<?=$arSKU["ID"];?>">
																				<span title="<?=GetMessage('CATALOG_WISH')?>" class="wish_item text to <?=$arParams["TYPE_SKU"];?>" data-item="<?=$arSKU["ID"]?>" data-iblock="<?=$arResult["IBLOCK_ID"]?>" data-offers="Y" data-props="<?=$arOfferProps?>"><i></i></span>
																				<span title="<?=GetMessage('CATALOG_WISH_OUT')?>" class="wish_item text in added <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-item="<?=$arSKU["ID"]?>" data-iblock="<?=$arSKU["IBLOCK_ID"]?>"><i></i></span>
																			</div>
																		<?endif;?>
																	<?endif;?>
																	<?if($arParams["DISPLAY_COMPARE"] == "Y"):?>
																		<div class="compare_item_button o_<?=$arSKU["ID"];?>">
																			<span title="<?=GetMessage('CATALOG_COMPARE')?>" class="compare_item to text <?=$arParams["TYPE_SKU"];?>" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arSKU["ID"]?>" ><i></i></span>
																			<span title="<?=GetMessage('CATALOG_COMPARE_OUT')?>" class="compare_item in added text <?=$arParams["TYPE_SKU"];?>" style="display: none;" data-iblock="<?=$arParams["IBLOCK_ID"]?>" data-item="<?=$arSKU["ID"]?>"><i></i></span>
																		</div>
																	<?endif;?>
																</td>
															<?endif;?>
															<?if($arskuAddToBasketData["ACTION"] == "ADD"):?>
																<?if($arskuAddToBasketData["OPTIONS"]["USE_PRODUCT_QUANTITY_DETAIL"] && !count($arSKU["OFFERS"]) && $arskuAddToBasketData["ACTION"] == "ADD" && $arskuAddToBasketData["CAN_BUY"]):?>
																	<td class="counter_wrapp counter_block_wr">
																		<div class="counter_block" data-item="<?=$arSKU["ID"];?>">
																			<?$collspan++;?>
																			<span class="minus">-</span>
																			<input type="text" class="text" name="quantity" value="<?=$arskuAddToBasketData["MIN_QUANTITY_BUY"];?>" />
																			<span class="plus">+</span>
																		</div>
																	</td>
																<?endif;?>
															<?endif;?>
															<?if(isset($arSKU['PRICE_MATRIX']) && $arSKU['PRICE_MATRIX'] && count($arSKU['PRICE_MATRIX']['ROWS']) > 1) // USE_PRICE_COUNT
															{?>
																<?$arOnlyItemJSParams = array(
																	"ITEM_PRICES" => $arSKU["ITEM_PRICES"],
																	"ITEM_PRICE_MODE" => $arSKU["ITEM_PRICE_MODE"],
																	"ITEM_QUANTITY_RANGES" => $arSKU["ITEM_QUANTITY_RANGES"],
																	"MIN_QUANTITY_BUY" => $arskuAddToBasketData["MIN_QUANTITY_BUY"],
																	"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
																	"ID" => $this->GetEditAreaId($arSKU["ID"]),
																)?>
																<script type="text/javascript">
																	var ob<? echo $this->GetEditAreaId($arSKU["ID"]); ?>el = new JCCatalogOnlyElement(<? echo CUtil::PhpToJSObject($arOnlyItemJSParams, false, true); ?>);
																</script>
															<?}?>
															<td class="buy" <?=($arskuAddToBasketData["ACTION"] !== "ADD" || !$arskuAddToBasketData["CAN_BUY"] || $arParams["SHOW_ONE_CLICK_BUY"]=="N" ? 'colspan="3"' : "")?>>
																<?if($arskuAddToBasketData["ACTION"] !== "ADD"  || !$arskuAddToBasketData["CAN_BUY"]):?>
																	<?$collspan += 3;?>
																<?else:?>
																	<?$collspan++;?>
																<?endif;?>
																<div class="counter_wrapp">
																	<?=$arskuAddToBasketData["HTML"]?>
																</div>
															</td>
															<?if($arskuAddToBasketData["ACTION"] == "ADD" && $arskuAddToBasketData["CAN_BUY"] && $arParams["SHOW_ONE_CLICK_BUY"]!="N"):?>
																<td class="one_click_buy">
																	<?$collspan++;?>
																	<span class="btn btn-default white one_click" data-item="<?=$arSKU["ID"]?>" data-offers="Y" data-iblockID="<?=$arParams["IBLOCK_ID"]?>" data-quantity="<?=$arskuAddToBasketData["MIN_QUANTITY_BUY"];?>" data-props="<?=$arOfferProps?>" onclick="oneClickBuy('<?=$arSKU["ID"]?>', '<?=$arParams["IBLOCK_ID"]?>', this)">
																		<span><?=GetMessage('ONE_CLICK_BUY')?></span>
																	</span>
																</td>
															<?endif;?>
														<!--/noindex-->
														<?if($useStores):?>
															<td class="opener bottom">
																<?$collspan++;?>
																<span class="opener_icon"><i></i></span>
															</td>
														<?endif;?>
													</tr>
													<?if($useStores):?>
														<?$collspan--;?>
														<tr class="offer_stores"><td colspan="<?=$collspan?>">
															<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "main", array(
																	"PER_PAGE" => "10",
																	"USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
																	"SCHEDULE" => $arParams["SCHEDULE"],
																	"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
																	"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
																	"ELEMENT_ID" => $arSKU["ID"],
																	"STORE_PATH"  =>  $arParams["STORE_PATH"],
																	"MAIN_TITLE"  =>  $arParams["MAIN_TITLE"],
																	"MAX_AMOUNT"=>$arParams["MAX_AMOUNT"],
																	"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
																	"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
																	"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
																	"USER_FIELDS" => $arParams['USER_FIELDS'],
																	"FIELDS" => $arParams['FIELDS'],
																	"STORES" => $arParams['STORES'],
																	"CACHE_TYPE" => "A",
																),
																$component
															);?>
														</tr>
													<?endif;?>
												<?}
											}?>
										</tbody>
									</table>
									</div>
								</div>
							<?endif;?>
							<?if ($value == 'char' && $bPropTab && $showProps):?>
								<div class="tab-pane <?=(!($iTab++) ? ' active' : '')?> chars_tab" id="char_tab">
									<div class="title-tab-heading visible-xs">
										<?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("CT_NAME_DOP_CHAR"));?>
									</div>
									<div class="char_inner_wrapper">
										<?=$htmlProps;?>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'desc'):?>
								<?if(
									$templateData["DETAIL_TEXT"]
									|| (
										(
										count($templateData["PROPERTIES"][$instr_prop]["VALUE"])
										&& is_array($templateData["PROPERTIES"][$instr_prop]["VALUE"])
										)
										|| count($templateData["SECTION_FULL"]["UF_FILES"])
									)
									|| (
										!$bPropTab
										&& $showProps
									)
									):?>
									<div class="tab-pane <?=(!($iTab++) ? ' active' : '')?> desc_tab" id="descr">
										<div class="title-tab-heading visible-xs"><?=($arParams["TAB_DESCR_NAME"] ? $arParams["TAB_DESCR_NAME"] : GetMessage("DESCRIPTION_TAB"));?></div>
										<div class="char_inner_wrapper">
											<?if(strlen($templateData["DETAIL_TEXT"])):?>
												<div class="detail_text"><?=$templateData["DETAIL_TEXT"]?></div>
											<?endif;?>
											<?
											$arFiles = array();
											if($templateData["PROPERTIES"][$instr_prop]["VALUE"]){
												$arFiles = $templateData["PROPERTIES"][$instr_prop]["VALUE"];
											}
											else{
												$arFiles = $templateData["SECTION_FULL"]["UF_FILES"];
											}
											if(is_array($arFiles)){
												foreach($arFiles as $key => $value){
													if(!intval($value)){
														unset($arFiles[$key]);
													}
												}
											}
											?>
											<?if (!$bPropTab && $showProps):?>
												<?if($templateData["DETAIL_TEXT"]):?>
													<div class="wraps">
												<?endif;?>
												<h4><?=($arParams["TAB_CHAR_NAME"] ? $arParams["TAB_CHAR_NAME"] : GetMessage("PROPERTIES_TAB"));?></h4>
												<?=$htmlProps;?>
												<?if($templateData["DETAIL_TEXT"]):?>
													</div>
												<?endif;?>
											<?endif;?>
											<?if($arFiles):?>
												<?if($templateData["DETAIL_TEXT"]):?>
													<div class="wraps">
												<?endif;?>
													<h4><?=($arParams["BLOCK_DOCS_NAME"] ? $arParams["BLOCK_DOCS_NAME"] : GetMessage("DOCUMENTS_TITLE"))?></h4>
													<div class="files_block">
														<div class="row flexbox">
															<?foreach($arFiles as $arItem):?>
																<div class="col-md-3 col-sm-6">
																	<?$arFile=CTires2::GetFileInfo($arItem);?>
																	<div class="file_type clearfix <?=$arFile["TYPE"];?>">
																		<i class="icon"></i>
																		<div class="description">
																			<a target="_blank" href="<?=$arFile["SRC"];?>" class="dark_link"><?=$arFile["DESCRIPTION"];?></a>
																			<span class="size">
																				<?=$arFile["FILE_SIZE_FORMAT"];?>
																			</span>
																		</div>
																	</div>
																</div>
															<?endforeach;?>
														</div>
													</div>
												<?if($templateData["DETAIL_TEXT"]):?>
													</div>
												<?endif;?>
											<?endif;?>
										</div>
									</div>
								<?endif;?>
							<?endif;?>
							
							<?if($value == 'buy' && $arParams["SHOW_HOW_BUY"] == "Y"):?>
								<div class="tab-pane hblock<?=(!($iTab++) ? ' active' : '')?>" id="hbuy">
									<div class="title-tab-heading visible-xs"><?=$arParams["TITLE_HOW_BUY"];?></div>
									<div>
									<?$APPLICATION->IncludeFile(SITE_DIR."include/tab_catalog_detail_howbuy.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_HOW_BUY')));?>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'cash' && $arParams["SHOW_PAYMENT"] == "Y"):?>
								<div class="tab-pane pblock<?=(!($iTab++) ? ' active' : '')?>" id="payment">
									<div class="title-tab-heading visible-xs"><?=$arParams["TITLE_PAYMENT"];?></div>
									<div>
									<?$APPLICATION->IncludeFile(SITE_DIR."include/tab_catalog_detail_payment.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_PAYMENT')));?>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'delivery' && $arParams["SHOW_DELIVERY"] == "Y"):?>
								<div class="tab-pane dblock<?=(!($iTab++) ? ' active' : '')?>" id="delivery">
									<div class="title-tab-heading visible-xs"><?=$arParams["TITLE_DELIVERY"];?></div>
									<div>
									<?$APPLICATION->IncludeFile(SITE_DIR."include/tab_catalog_detail_delivery.php", array(), array("MODE" => "html", "NAME" => GetMessage('TITLE_DELIVERY')));?>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'available' && $useStores && ($showCustomOffer || !$templateData["OFFERS"] )):?>
								<div class="tab-pane stores_tab<?=(!($iTab++) ? ' active' : '')?>" id="stores">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_STOCK_NAME"] ? $arParams["TAB_STOCK_NAME"] : GetMessage("STORES_TAB"));?></div>
									<div class="stores_wrapp">
									<?if($templateData["OFFERS"]){?>
										<?foreach($templateData["OFFERS"] as $arOffer){?>
											<div class="sku_stores_<?=$arOffer["ID"]?>" style="display: none;">
												<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", $templateData["STORES"]["TEMPLATE"], array(
														"PER_PAGE" => "10",
														"USE_STORE_PHONE" => $templateData["STORES"]["USE_STORE_PHONE"],
														"SCHEDULE" => $templateData["STORES"]["SCHEDULE"],
														"USE_MIN_AMOUNT" => $templateData["STORES"]["USE_MIN_AMOUNT"],
														"MIN_AMOUNT" => $templateData["STORES"]["MIN_AMOUNT"],
														"ELEMENT_ID" => $arOffer["ID"],
														"STORE_PATH"  =>  $templateData["STORES"]["STORE_PATH"],
														"MAIN_TITLE"  =>  $templateData["STORES"]['MAIN_TITLE'],
														"MAX_AMOUNT"=>$templateData["STORES"]["MAX_AMOUNT"],
														"USE_ONLY_MAX_AMOUNT" => $templateData["STORES"]["USE_ONLY_MAX_AMOUNT"],
														"SHOW_EMPTY_STORE" => $templateData["STORES"]['SHOW_EMPTY_STORE'],
														"SHOW_GENERAL_STORE_INFORMATION" => $templateData["STORES"]['SHOW_GENERAL_STORE_INFORMATION'],
														"USE_ONLY_MAX_AMOUNT" => $templateData["STORES"]["USE_ONLY_MAX_AMOUNT"],
														"USER_FIELDS" => $templateData["STORES"]['USER_FIELDS'],
														"FIELDS" => $templateData["STORES"]['FIELDS'],
														"STORES" => $templateData["STORES"]['STORES'],
														"STORES_PARAMS" => $templateData["STORES"]['STORES_PARAMS'],
														"STORES_PARAMS_PRICE" => $templateData["STORES"]['STORES_PARAMS_PRICE'],
														"PRICE_CODE" => $templateData["STORES"]['PRICE_CODE'],
														"QUANTITY" => $templateData["STORES"]['QUANTITY'],
														"STORES_FILTER_ORDER" => $templateData["STORES"]['STORES_FILTER_ORDER'],
														"STORES_FILTER" => $templateData["STORES"]['STORES_FILTER'],
														"STORES_FILTER_PARAM" => $templateData["STORES"]['STORES_FILTER_PARAM'],
														"BASKET_URL" => $templateData["STORES"]["BASKET_URL"],
														"CACHE_GROUPS" => $templateData["STORES"]["CACHE_GROUPS"],
														"CACHE_TYPE" => $templateData["STORES"]["CACHE_TYPE"],
														"CACHE_TIME" => $templateData["STORES"]["CACHE_TIME"],

														"OFFERS_CART_PROPERTIES" => $templateData["STORES"]["OFFERS_CART_PROPERTIES"],
														"PARTIAL_PRODUCT_PROPERTIES" => $templateData["STORES"]["PARTIAL_PRODUCT_PROPERTIES"],
														"ADD_PROPERTIES_TO_BASKET" => $templateData["STORES"]["ADD_PROPERTIES_TO_BASKET"],
														"PRODUCT_PROPERTIES" => $templateData["STORES"]["PRODUCT_PROPERTIES"],

														"IBLOCK_ID" => $arOffer["IBLOCK_ID"],
														"HAS_OFFERS" => "Y",
														"SHOW_MEASURE_WITH_RATIO" => $templateData["STORES"]["SHOW_MEASURE_WITH_RATIO"],
														"SHOW_DISCOUNT_TIME"=>$templateData["STORES"]["SHOW_DISCOUNT_TIME"],
														"USE_PRICE_COUNT" => $templateData["STORES"]["USE_PRICE_COUNT"],
														"SHOW_PRICE_COUNT" => $templateData["STORES"]["SHOW_PRICE_COUNT"],
														"USE_RATIO_IN_RANGES" => $templateData["STORES"]["USE_RATIO_IN_RANGES"],
														"PRICE_VAT_INCLUDE" => $templateData["STORES"]["PRICE_VAT_INCLUDE"],
														"PRICE_VAT_SHOW_VALUE" => $templateData["STORES"]["PRICE_VAT_SHOW_VALUE"],
														"CONVERT_CURRENCY" => $templateData["STORES"]["CONVERT_CURRENCY"],
														"CURRENCY_ID" => $templateData["STORES"]["CURRENCY_ID"],
														"MAX_AMOUNT" => $templateData["STORES"]["MAX_AMOUNT"],
														"DEFAULT_COUNT" => $templateData["STORES"]["DEFAULT_COUNT"],
														"SHOW_MEASURE" => $templateData["STORES"]["SHOW_MEASURE"],
														"SHOW_DISCOUNT_PERCENT_NUMBER" => $templateData["STORES"]["SHOW_DISCOUNT_PERCENT_NUMBER"],
														"SHOW_DISCOUNT_PERCENT" => $templateData["STORES"]["SHOW_DISCOUNT_PERCENT"],
														"SHOW_OLD_PRICE" => $templateData["STORES"]["SHOW_OLD_PRICE"],

														"SHOW_CHEAPER_FORM" => $templateData["STORES"]["SHOW_CHEAPER_FORM"],
														"CHEAPER_FORM_NAME" => $templateData["STORES"]["CHEAPER_FORM_NAME"],
													),
													false
												);?>
											</div>
										<?}?>
									<?}else{?>
										<div class="checked_block">
										<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "custom", array(
											"PER_PAGE" => "10",
											"USE_STORE_PHONE" => $templateData["STORES"]["USE_STORE_PHONE"],
											"SCHEDULE" => $templateData["STORES"]["SCHEDULE"],
											"USE_MIN_AMOUNT" => $templateData["STORES"]["USE_MIN_AMOUNT"],
											"MIN_AMOUNT" => $templateData["STORES"]["MIN_AMOUNT"],
											"ELEMENT_ID" => $templateData["STORES"]["ELEMENT_ID"],
											"STORE_PATH"  =>  $templateData["STORES"]["STORE_PATH"],
											"MAIN_TITLE"  =>  $templateData["STORES"]["MAIN_TITLE"],
											"MAX_AMOUNT"=>$templateData["STORES"]["MAX_AMOUNT"],
											"USE_ONLY_MAX_AMOUNT" => $templateData["STORES"]["USE_ONLY_MAX_AMOUNT"],
											"SHOW_EMPTY_STORE" => $templateData["STORES"]['SHOW_EMPTY_STORE'],
											"SHOW_GENERAL_STORE_INFORMATION" => $templateData["STORES"]['SHOW_GENERAL_STORE_INFORMATION'],
											"USE_ONLY_MAX_AMOUNT" => $templateData["STORES"]["USE_ONLY_MAX_AMOUNT"],
											"USER_FIELDS" => $templateData["STORES"]['USER_FIELDS'],
											"FIELDS" => $templateData["STORES"]['FIELDS'],
											"STORES" => $arParams["CUSTOM_STORES"],
											"STORES_PARAMS" => $templateData["STORES"]['STORES_PARAMS'],
											"STORES_PARAMS_PRICE" => $templateData["STORES"]['STORES_PARAMS_PRICE'],
											"PRICE_CODE" => $templateData["STORES"]['PRICE_CODE'],
											"QUANTITY" => $templateData["STORES"]['QUANTITY'],
											"STORES_FILTER_ORDER" => $templateData["STORES"]['STORES_FILTER_ORDER'],
											"STORES_FILTER" => $templateData["STORES"]['STORES_FILTER'],
											"STORES_FILTER_PARAM" => $templateData["STORES"]['STORES_FILTER_PARAM'],
											"BASKET_URL" => $templateData["STORES"]["BASKET_URL"],
											"CACHE_GROUPS" => $templateData["STORES"]["CACHE_GROUPS"],
											"CACHE_TYPE" => $templateData["STORES"]["CACHE_TYPE"],
											"CACHE_TIME" => $templateData["STORES"]["CACHE_TIME"],

											"OFFERS_CART_PROPERTIES" => $templateData["STORES"]["OFFERS_CART_PROPERTIES"],
											"PARTIAL_PRODUCT_PROPERTIES" => $templateData["STORES"]["PARTIAL_PRODUCT_PROPERTIES"],
											"ADD_PROPERTIES_TO_BASKET" => $templateData["STORES"]["ADD_PROPERTIES_TO_BASKET"],
											"PRODUCT_PROPERTIES" => $templateData["STORES"]["PRODUCT_PROPERTIES"],

											"IBLOCK_ID" => $templateData["STORES"]["IBLOCK_ID"],
											"SHOW_MEASURE_WITH_RATIO" => $templateData["STORES"]["SHOW_MEASURE_WITH_RATIO"],
											"SHOW_DISCOUNT_TIME"=>$templateData["STORES"]["SHOW_DISCOUNT_TIME"],
											"USE_PRICE_COUNT" => $templateData["STORES"]["USE_PRICE_COUNT"],
											"SHOW_PRICE_COUNT" => $templateData["STORES"]["SHOW_PRICE_COUNT"],
											"USE_RATIO_IN_RANGES" => $templateData["STORES"]["USE_RATIO_IN_RANGES"],
											"PRICE_VAT_INCLUDE" => $templateData["STORES"]["PRICE_VAT_INCLUDE"],
											"PRICE_VAT_SHOW_VALUE" => $templateData["STORES"]["PRICE_VAT_SHOW_VALUE"],
											"CONVERT_CURRENCY" => $templateData["STORES"]["CONVERT_CURRENCY"],
											"CURRENCY_ID" => $templateData["STORES"]["CURRENCY_ID"],
											"MAX_AMOUNT" => $templateData["STORES"]["MAX_AMOUNT"],
											"DEFAULT_COUNT" => $templateData["STORES"]["DEFAULT_COUNT"],
											"SHOW_MEASURE" => $templateData["STORES"]["SHOW_MEASURE"],
											"SHOW_DISCOUNT_PERCENT_NUMBER" => $templateData["STORES"]["SHOW_DISCOUNT_PERCENT_NUMBER"],
											"SHOW_DISCOUNT_PERCENT" => $templateData["STORES"]["SHOW_DISCOUNT_PERCENT"],
											"SHOW_OLD_PRICE" => $templateData["STORES"]["SHOW_OLD_PRICE"],

											"SHOW_CHEAPER_FORM" => $templateData["STORES"]["SHOW_CHEAPER_FORM"],
											"CHEAPER_FORM_NAME" => $templateData["STORES"]["CHEAPER_FORM_NAME"],
										),
										false
									);?>
									</div>
									<?}?>
									</div>
								</div>
							<?endif;?>			
							<?if($value == 'video' && $arVideo):?>
								<div class="tab-pane<?=(!($iTab++) ? ' active' : '')?> " id="video">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_VIDEO_NAME"] ? $arParams["TAB_VIDEO_NAME"] : GetMessage("VIDEO_TAB"));?>
								<?if(count($arVideo) > 1):?>
									<span class="count empty">&nbsp;(<?=count($arVideo)?>)</span>
								<?endif;?></div>
									<div class="video_block">
										<?if(count($arVideo) > 1):?>
											<table class="video_table">
												<tbody>
													<?foreach($arVideo as $v => $value):?>
														<?if(($v + 1) % 2):?>
															<tr>
														<?endif;?>
														<td width="50%"><?=str_replace('src=', 'width="458" height="257" src=', str_replace(array('width', 'height'), array('data-width', 'data-height'), $value));?></td>
														<?if(!(($v + 1) % 2)):?>
															</tr>
														<?endif;?>
													<?endforeach;?>
													<?if(($v + 1) % 2):?>
														</tr>
													<?endif;?>
												</tbody>
											</table>
										<?else:?>
											<?=$arVideo[0]?>
										<?endif;?>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'reviews' && $arParams["USE_REVIEW"] == "Y"):?>
								<div class="tab-pane <?=(!($iTab++) ? 'active' : '')?> wrap_inner_review" id="review">
									<div class="title-tab-heading visible-xs product_reviews_tab "><?=($arParams["TAB_REVIEW_NAME"] ? $arParams["TAB_REVIEW_NAME"] : GetMessage("REVIEW_TAB"))?><span class="count empty"></span></div>
									<?if($arParams["USE_REVIEW"] == "Y"):?>
										<?
										$ymID = $templateData["YM_ELEMENT_ID"];
										if(!$templateData["YM_ELEMENT_ID"] && $arResult["IBLOCK_SECTION_ID"])
										{
											$arTmpSection = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array("ID" => $arResult["IBLOCK_SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "UF_YM_ELEMENT_ID"));
											if($arTmpSection["UF_YM_ELEMENT_ID"])
												$ymID = $arTmpSection["UF_YM_ELEMENT_ID"];
										}
										?>
										<?if($ymID):?>
											<div id="reviews_content">
												<?$APPLICATION->IncludeComponent(
													"aspro:api.yamarket.reviews_model.tires2",
													"main",
													Array(
														"YANDEX_MODEL_ID" => $ymID
													)
												);?>
											</div>
										<?elseif(IsModuleInstalled("forum")):?>
											<div id="reviews_content">
												<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("area");?>
													<?$APPLICATION->IncludeComponent(
														"bitrix:forum.topic.reviews",
														"main",
														Array(
															"CACHE_TYPE" => $arParams["CACHE_TYPE"],
															"CACHE_TIME" => $arParams["CACHE_TIME"],
															"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
															"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
															"FORUM_ID" => $arParams["FORUM_ID"],
															"ELEMENT_ID" => $arResult["ID"],
															"IBLOCK_ID" => $arParams["IBLOCK_ID"],
															"AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
															"SHOW_RATING" => "N",
															"SHOW_MINIMIZED" => "Y",
															"SECTION_REVIEW" => "Y",
															"POST_FIRST_MESSAGE" => "Y",
															"MINIMIZED_MINIMIZE_TEXT" => GetMessage("HIDE_FORM"),
															"MINIMIZED_EXPAND_TEXT" => GetMessage("ADD_REVIEW"),
															"SHOW_AVATAR" => "N",
															"SHOW_LINK_TO_FORUM" => "N",
															"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
														),	false
													);?>
												<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("area", "");?>
											</div>
										<?endif;?>
									<?endif;?>
								</div>
							<?endif;?>
							<?if($value == 'suitable' && $bShowSuitableCars):?>
								<div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="suitable_cars">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_SUITABLE_NAME"] ? $arParams["TAB_SUITABLE_NAME"] : GetMessage("SUITABLE_TAB"))?></div>
									<?$APPLICATION->IncludeComponent(
										"aspro:auto.suitable_item.tires2", 
										".default", 
										array(
											"IBLOCK_ID" => $arParams["IBLOCK_ID"],
											"TYPE_FILTER" => $typeFilter,
											"COMPONENT_TEMPLATE" => ".default",
											"CACHE_TYPE" => $arParams["CACHE_TYPE"],
											"CACHE_TIME" => $arParams["CACHE_TIME"],
											"TYRE_WIDTH" => $filterTWidth,
											"TYRE_PROFILE" => $filterTHeight,
											"TYRE_DIAMETER" => $filterTDia,
											"DISK_WIDTH" => $filterDWidth,
											"DISK_DIAMETER" => $filterDDia,
											"DISK_LZ" => $filterDLZ,
											"DISK_PCD" => $filterDPCD,
											"CAPACITY" => $filterAEmkost,
											"AMPERAGE" => $filterAVoltag,
											"POLARITY" => $filterAPolarnost,
											"TYPE" => $filterAType,
											"AKB_WIDTH" => $filterAWidth,
											"AKB_LENGTH" => $filterALength,
											"AKB_HEIGHT" => $filterAHeight,
											"SITE_ID" => SITE_ID,
										),
										false, array("HIDE_ICONS" => "Y")
									);?>
								</div>
							<?endif;?>
							<?if($value == 'question' && ($arParams["SHOW_ASK_BLOCK"] == "Y") && (intVal($arParams["ASK_FORM_ID"]))):?>
								<div class="tab-pane<?=(!($iTab++) ? ' acive' : '')?>" id="ask">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_FAQ_NAME"] ? $arParams["TAB_FAQ_NAME"] : GetMessage('ASK_TAB'))?></div>
									<div class="row">
										<div class="col-md-3 hidden-sm text_block">
											<?$APPLICATION->IncludeFile(SITE_DIR."include/ask_tab_detail_description.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_ASK_DESCRIPTION')));?>
										</div>
										<div class="col-md-9 form_block">
											<div id="ask_block_content">
												<?$APPLICATION->IncludeComponent(
													"bitrix:form.result.new",
													"inline",
													Array(
														"WEB_FORM_ID" => $arParams["ASK_FORM_ID"],
														"IGNORE_CUSTOM_TEMPLATE" => "N",
														"USE_EXTENDED_ERRORS" => "N",
														"SEF_MODE" => "N",
														"CACHE_TYPE" => "A",
														"CACHE_TIME" => "3600000",
														"LIST_URL" => "",
														"EDIT_URL" => "",
														"SUCCESS_URL" => "?send=ok",
														"CHAIN_ITEM_TEXT" => "",
														"CHAIN_ITEM_LINK" => "",
														"VARIABLE_ALIASES" => Array("WEB_FORM_ID" => "WEB_FORM_ID", "RESULT_ID" => "RESULT_ID"),
														"AJAX_MODE" => "Y",
														"AJAX_OPTION_JUMP" => "N",
														"AJAX_OPTION_STYLE" => "Y",
														"AJAX_OPTION_HISTORY" => "N",
														"SHOW_LICENCE" => CTires2::GetFrontParametrValue('SHOW_LICENCE'),
													)
												);?>
											</div>
										</div>
									</div>
								</div>
							<?endif;?>
							<?if($value == 'dop' && $arParams["SHOW_ADDITIONAL_TAB"] == "Y"):?>
								<div class="tab-pane additional_block<?=(!($iTab++) ? ' active' : '')?>" id="dops">
									<div class="title-tab-heading visible-xs"><?=($arParams["TAB_DOPS_NAME"] ? $arParams["TAB_DOPS_NAME"] : GetMessage("ADDITIONAL_TAB"));?></div>
									<div>
									<?$APPLICATION->IncludeFile(SITE_DIR."include/additional_products_description.php", array(), array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_ADDITIONAL_DESCRIPTION')));?>
									</div>
								</div>
							<?endif;?>
						<?endforeach;?>
					</div>

					<?if($templateData['ADDITIONAL_GALLERY']):?>
						<div class="wraps galerys-block with-padding<?=($templateData['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'] ? ' hidden' : '')?>">
							<h4><?=($arParams["BLOCK_ADDITIONAL_GALLERY_NAME"] ? $arParams["BLOCK_ADDITIONAL_GALLERY_NAME"] : GetMessage("ADDITIONAL_GALLERY_TITLE"))?></h4>
							<?if($arParams['ADDITIONAL_GALLERY_TYPE'] === 'SMALL'):?>
								<div class="small-gallery-block">
									<div class="flexslider unstyled front border small_slider custom_flex top_right color-controls" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "counts": [4, 3, 2, 1]}'>
										<ul class="slides items">
											<?if(!$templateData['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
												<?foreach($templateData['ADDITIONAL_GALLERY'] as $i => $arPhoto):?>
													<li class="col-md-3 item visible">
														<div>
															<img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
														</div>
														<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy dark_block_animate" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>"></a>
													</li>
												<?endforeach;?>
											<?endif;?>
										</ul>
									</div>
								</div>
							<?else:?>
								<div class="gallery-block">
									<div class="gallery-wrapper">
										<div class="inner">
											<?if(count($templateData['ADDITIONAL_GALLERY']) > 1 || ($templateData['OFFERS'] && 'TYPE_1' === $arParams['TYPE_SKU'])):?>
												<div class="small-gallery-wrapper">
													<div class="flexslider unstyled small-gallery center-nav ethumbs" data-plugin-options='{"slideshow": false, "useCSS": true, "animation": "slide", "animationLoop": true, "itemWidth": 60, "itemMargin": 20, "minItems": 1, "maxItems": 9, "slide_counts": 1, "asNavFor": ".gallery-wrapper .bigs"}' id="carousel1">
														<ul class="slides items">
															<?if(!$templateData['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
																<?foreach($templateData['ADDITIONAL_GALLERY'] as $arPhoto):?>
																	<li class="item">
																		<img class="img-responsive inline" border="0" src="<?=$arPhoto['THUMB']['src']?>" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
																	</li>
																<?endforeach;?>
															<?endif;?>
														</ul>
													</div>
												</div>
											<?endif;?>
											<div class="flexslider big_slider dark bigs color-controls" id="slider" data-plugin-options='{"animation": "slide", "useCSS": true, "directionNav": true, "controlNav" :true, "animationLoop": true, "slideshow": false, "sync": "#carousel1"}'>
												<ul class="slides items">
													<?if(!$templateData['OFFERS'] || 'TYPE_1' !== $arParams['TYPE_SKU']):?>
														<?foreach($templateData['ADDITIONAL_GALLERY'] as $i => $arPhoto):?>
															<li class="col-md-12 item">
																<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy" rel="gallery" target="_blank" title="<?=$arPhoto['TITLE']?>">
																	<img src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
																	<span class="zoom"></span>
																</a>
															</li>
														<?endforeach;?>
													<?endif;?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							<?endif;?>
						</div>
					<?endif;?>
				<?endif;?>

				<?if($templateData["PROPERTIES"]["EXPANDABLES"]["VALUE"]):?>
					<div class="wraps hidden_print addon_type">
						<h4><?=($arParams["DETAIL_EXPANDABLES_TITLE"] ? $arParams["DETAIL_EXPANDABLES_TITLE"] : GetMessage("DETAIL_EXPANDABLES_TITLE"))?></h4>
						<div class="bottom_slider specials tab_slider_wrapp custom_type">
						<ul class="slider_navigation top custom_flex border">
							<li class="tabs_slider_navigation access_nav cur" data-code="access"></li>
						</ul>

						<ul class="tabs_content">
							<li class="tab access_wrapp" data-code="access">
								<div class="flexslider loading_state shadow border custom_flex top_right" data-plugin-options='{"animation": "slide", "animationSpeed": 600, "directionNav": true, "controlNav" :false, "animationLoop": true, "slideshow": false, "controlsContainer": ".tabs_slider_navigation.access_nav", "counts": [4,3,3,2,1]}'>
									<ul class="tabs_slider access_slides slides">
										<?$GLOBALS['arrFilterAccess'] = array("ID" => $templateData["PROPERTIES"]["EXPANDABLES"]["VALUE"]);?>
										<?$APPLICATION->IncludeComponent(
											"bitrix:catalog.top",
											"main",
											array(
												"USE_REGION" => ($arRegion ? "Y" : "N"),
												"STORES" => $arParams['STORES'],
												"TITLE_BLOCK" => $arParams["SECTION_TOP_BLOCK_TITLE"],
												"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
												"IBLOCK_ID" => $arParams["IBLOCK_ID"],
												"SALE_STIKER" => $arParams["SALE_STIKER"],
												"STIKERS_PROP" => $arParams["STIKERS_PROP"],
												"SHOW_RATING" => $arParams["SHOW_RATING"],
												"FILTER_NAME" => 'arrFilterAccess',
												"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
												"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
												"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
												"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
												"SECTION_URL" => $templateData["FOLDER"].$templateData["URL_TEMPLATES"]["section"],
												"DETAIL_URL" => $templateData["FOLDER"].$templateData["URL_TEMPLATES"]["element"],
												"BASKET_URL" => $arParams["BASKET_URL"],
												"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
												"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
												"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
												"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
												"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
												"DISPLAY_COMPARE" => ($arParams["DISPLAY_COMPARE"] ? "Y" : "N"),
												"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
												"ELEMENT_COUNT" => $disply_elements,
												"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
												"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
												"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
												"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
												"PRICE_CODE" => $arParams['PRICE_CODE'],
												"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
												"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
												"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
												"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
												"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
												"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
												"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
												"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
												"CACHE_TYPE" => $arParams["CACHE_TYPE"],
												"CACHE_TIME" => $arParams["CACHE_TIME"],
												"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
												"CACHE_FILTER" => $arParams["CACHE_FILTER"],
												"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
												"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
												"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
												"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
												"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
												"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
												"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
												"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
												'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
												'CURRENCY_ID' => $arParams['CURRENCY_ID'],
												'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
												'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
												'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
												'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
												'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
												'LABEL_PROP' => $arParams['LABEL_PROP'],
												'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
												'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

												'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
												'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
												'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
												'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
												'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
												'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
												'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
												'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
												'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
												'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
												'ADD_TO_BASKET_ACTION' => $basketAction,
												'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
												'COMPARE_PATH' => $templateData['FOLDER'].$templateData['URL_TEMPLATES']['compare'],
											),
											false, array("HIDE_ICONS"=>"Y")
										);?>
									</ul>
								</div>
							</li>
						</ul>
					</div>
					</div>
				<?endif;?>

				<?if($templateData["PROPERTIES"]["PODBORKI"] && $templateData["PROPERTIES"]["PODBORKI"]["VALUE"]):?>
					<div class="wraps podborki">
						<?$GLOBALS['arrFilterLanding'] = array("ID" => $templateData["PROPERTIES"]["PODBORKI"]["VALUE"]);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"news-project",
							array(
								"IBLOCK_TYPE" => "aspro_tires2_content",
								"IBLOCK_ID" => $templateData["PROPERTIES"]["PODBORKI"]["LINK_IBLOCK_ID"],
								"NEWS_COUNT" => "20",
								"SORT_BY1" => "SORT",
								"SORT_ORDER1" => "ASC",
								"SORT_BY2" => "ID",
								"SORT_ORDER2" => "DESC",
								"FILTER_NAME" => "arrFilterLanding",
								"FIELD_CODE" => array(
									0 => "NAME",
									1 => "PREVIEW_PICTURE",
									2 => "",
								),
								"PROPERTY_CODE" => array(
									0 => "PERIOD",
									1 => "REDIRECT",
									2 => "",
								),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" => "N",
								"CACHE_TIME" => "36000000",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"PREVIEW_TRUNCATE_LEN" => "",
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"SET_TITLE" => "N",
								"SET_STATUS_404" => "N",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"INCLUDE_SUBSECTIONS" => "Y",
								"PAGER_TEMPLATE" => ".default",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"PAGER_TITLE" => "Новости",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"VIEW_TYPE" => "block",
								"BIG_BLOCK" => "Y",
								"SHOW_MORE" => "N",
								"IMAGE_POSITION" => "left",
								"COUNT_IN_LINE" => "3",
								"TITLE" => ($arParams["BLOCK_LANDINGS_NAME"] == "N" ? GetMessage("BLOCK_LANDINGS_NAME") : $arParams["BLOCK_LANDINGS_NAME"]),
							),
							$component, array("HIDE_ICONS" => "Y")
						);?>
					</div>
				<?endif;?>
				<?/*services*/?>
				<?if((int)$arParams["IBLOCK_SERVICES_ID"]):?>
					<?$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
					$arServices = CTires2Cache::CIBLockElement_GetList(array('CACHE' => array("TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_SERVICES_ID"]), "GROUP" => "ID")), array("IBLOCK_ID" => $arParams["IBLOCK_SERVICES_ID"], "ACTIVE"=>"Y", "ACTIVE_DATE" => "Y", "PROPERTY_LINK_GOODS" => $arResult["ID"]), false, false, $arSelect);
					if($arServices):?>
						<?global $arrSaleFilter; $arrSaleFilter = array("ID" => array_keys($arServices));?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"items-services",
							array(
								"IBLOCK_TYPE" => "aspro_tires2_content",
								"IBLOCK_ID" => $arParams["IBLOCK_SERVICES_ID"],
								"NEWS_COUNT" => "20",
								"SORT_BY1" => "SORT",
								"SORT_ORDER1" => "ASC",
								"SORT_BY2" => "ID",
								"SORT_ORDER2" => "DESC",
								"FILTER_NAME" => "arrSaleFilter",
								"FIELD_CODE" => array(
									0 => "NAME",
									1 => "PREVIEW_TEXT",
									3 => "PREVIEW_PICTURE",
									4 => "",
								),
								"PROPERTY_CODE" => array(
									0 => "PERIOD",
									1 => "REDIRECT",
									2 => "",
								),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" => "N",
								"CACHE_TIME" => "36000000",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"PREVIEW_TRUNCATE_LEN" => "",
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"SET_TITLE" => "N",
								"SET_STATUS_404" => "N",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"INCLUDE_SUBSECTIONS" => "Y",
								"PAGER_TEMPLATE" => ".default",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"PAGER_TITLE" => "Новости",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"VIEW_TYPE" => "list",
								"BIG_BLOCK" => "Y",
								"IMAGE_POSITION" => "left",
								"COUNT_IN_LINE" => "2",
								"TITLE" => ($arParams["BLOCK_SERVICES_NAME"] ? $arParams["BLOCK_SERVICES_NAME"] : GetMessage("SERVICES_TITLE")),
							),
							$component, array("HIDE_ICONS" => "Y")
						);?>
					<?endif;?>
				<?endif;?>
				<?/*articles*/?>
				<?if((int)$arParams["BLOG_IBLOCK_ID"]):?>
					<?$arSelect = array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
					$arFilterBlog = array("IBLOCK_ID" => $arParams["BLOG_IBLOCK_ID"], "ACTIVE"=>"Y", "ACTIVE_DATE" => "Y");

					if($arResult["IBLOCK_SECTION_ID"])
					{
						$arFilterBlog = array(
							'LOGIC' => 'OR',
							array(
								"PROPERTY_LINK_SECTIONS" => $arResult["IBLOCK_SECTION_ID"]
							),
							array(
								"PROPERTY_LINK_GOODS" => $arResult["ID"]
							)
						);
					}
					else
					{
						$arFilterBlog["PROPERTY_LINK_GOODS"] = $arResult["ID"];
					}

					$arArticels = CTires2Cache::CIBLockElement_GetList(array('CACHE' => array("TAG" => CTires2Cache::GetIBlockCacheTag($arParams["BLOG_IBLOCK_ID"]), "GROUP" => "ID")), $arFilterBlog, false, false, $arSelect);
					if($arArticels):?>
						<?global $arrSaleFilter; $arrSaleFilter = array("ID" => array_keys($arArticels));?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"news5",
							array(
								"IBLOCK_TYPE" => "aspro_tires2_content",
								"IBLOCK_ID" => $arParams["BLOG_IBLOCK_ID"],
								"NEWS_COUNT" => "20",
								"SORT_BY1" => "SORT",
								"SORT_ORDER1" => "ASC",
								"SORT_BY2" => "ID",
								"SORT_ORDER2" => "DESC",
								"FILTER_NAME" => "arrSaleFilter",
								"FIELD_CODE" => array(
									0 => "NAME",
									1 => "PREVIEW_TEXT",
									3 => "PREVIEW_PICTURE",
									4 => "",
								),
								"PROPERTY_CODE" => array(
									0 => "PERIOD",
									1 => "REDIRECT",
									2 => "",
								),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" => "N",
								"CACHE_TIME" => "36000000",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"PREVIEW_TRUNCATE_LEN" => "",
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"SET_TITLE" => "N",
								"SET_STATUS_404" => "N",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"INCLUDE_SUBSECTIONS" => "Y",
								"PAGER_TEMPLATE" => ".default",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"PAGER_TITLE" => "Новости",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"VIEW_TYPE" => "list",
								"BIG_BLOCK" => "Y",
								"IMAGE_POSITION" => "left",
								"COUNT_IN_LINE" => "2",
								"TITLE" => ($arParams["BLOCK_BLOG_NAME"] ? $arParams["BLOCK_BLOG_NAME"] : GetMessage("BLOCK_BLOG_NAME")),
							),
							$component, array("HIDE_ICONS" => "Y")
						);?>
					<?endif;?>
				<?endif;?>
			</div>
			<div class="gifts">
				<?if ($templateData['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale"))
				{
					$arProductIBlock = array();
					foreach(\Aspro\Functions\CAsproTires2::getCatalogIBlocks("", true, true) as $id)
						$arProductIBlock["SHOW_PRODUCTS_".$id] = "Y";

					$APPLICATION->IncludeComponent("bitrix:sale.gift.product", "main", array(
							"USE_REGION" => $arParams['USE_REGION'],
							"STORES" => $arParams['STORES'],
							"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
							'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
							'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
							'BUY_URL_TEMPLATE' => $templateData['~BUY_URL_TEMPLATE'],
							'ADD_URL_TEMPLATE' => $templateData['~ADD_URL_TEMPLATE'],
							'SUBSCRIBE_URL_TEMPLATE' => $templateData['~SUBSCRIBE_URL_TEMPLATE'],
							'COMPARE_URL_TEMPLATE' => $templateData['~COMPARE_URL_TEMPLATE'],
							"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],

							"SHOW_DISCOUNT_PERCENT" => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
							"SHOW_OLD_PRICE" => $arParams['GIFTS_SHOW_OLD_PRICE'],
							"PAGE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
							"LINE_ELEMENT_COUNT" => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
							"HIDE_BLOCK_TITLE" => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
							"BLOCK_TITLE" => $arParams['GIFTS_DETAIL_BLOCK_TITLE'],
							"TEXT_LABEL_GIFT" => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
							"SHOW_NAME" => $arParams['GIFTS_SHOW_NAME'],
							"SHOW_IMAGE" => $arParams['GIFTS_SHOW_IMAGE'],
							"MESS_BTN_BUY" => $arParams['GIFTS_MESS_BTN_BUY'],

							/*"SHOW_PRODUCTS_{$arParams['IBLOCK_ID']}" => "Y",
							"SHOW_PRODUCTS_160" => "Y",*/
							"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
							"PRODUCT_SUBSCRIPTION" => $arParams["PRODUCT_SUBSCRIPTION"],
							"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
							"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
							"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ADD_PROPERTIES_TO_BASKET" => $arParams["ADD_PROPERTIES_TO_BASKET"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"PARTIAL_PRODUCT_PROPERTIES" => $arParams["PARTIAL_PRODUCT_PROPERTIES"],
							"USE_PRODUCT_QUANTITY" => 'N',
							"OFFER_TREE_PROPS_{$templateData['OFFERS_IBLOCK']}" => $arParams['OFFER_TREE_PROPS'],
							"CART_PROPERTIES_{$templateData['OFFERS_IBLOCK']}" => $arParams['OFFERS_CART_PROPERTIES'],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
							"SALE_STIKER" => $arParams["SALE_STIKER"],
							"STIKERS_PROP" => $arParams["STIKERS_PROP"],
							"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
							"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
							"DISPLAY_TYPE" => "block",
							"SHOW_RATING" => $arParams["SHOW_RATING"],
							"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
							"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
							"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
							"TYPE_SKU" => "Y",

							"POTENTIAL_PRODUCT_TO_BUY" => array(
								'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
								'MODULE' => isset($templateData['MODULE']) ? $templateData['MODULE'] : 'catalog',
								'PRODUCT_PROVIDER_CLASS' => isset($templateData['PRODUCT_PROVIDER_CLASS']) ? $templateData['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
								'QUANTITY' => isset($templateData['QUANTITY']) ? $templateData['QUANTITY'] : null,
								'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

								'PRIMARY_OFFER_ID' => isset($templateData['OFFERS'][0]['ID']) ? $templateData['OFFERS'][0]['ID'] : null,
								'SECTION' => array(
									'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
									'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
									'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
									'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
								),
							)
						)+$arProductIBlock, $component, array("HIDE_ICONS" => "Y"));
				}
				if ($templateData['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled("sale"))
				{
					$APPLICATION->IncludeComponent(
							"bitrix:sale.gift.main.products",
							"main",
							array(
								"USE_REGION" => $arParams['USE_REGION'],
								"STORES" => $arParams['STORES'],
								"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
								"PAGE_ELEMENT_COUNT" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								"BLOCK_TITLE" => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

								"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
								"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],

								"AJAX_MODE" => $arParams["AJAX_MODE"],
								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],

								"ELEMENT_SORT_FIELD" => 'ID',
								"ELEMENT_SORT_ORDER" => 'DESC',
								//"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
								//"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
								"FILTER_NAME" => 'searchFilter',
								"SECTION_URL" => $arParams["SECTION_URL"],
								"DETAIL_URL" => $arParams["DETAIL_URL"],
								"BASKET_URL" => $arParams["BASKET_URL"],
								"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
								"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
								"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],

								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],

								"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
								"SET_TITLE" => $arParams["SET_TITLE"],
								"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
								"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

								"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
								"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
								"CURRENCY_ID" => $arParams["CURRENCY_ID"],
								"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
								"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"]) ? $arParams["TEMPLATE_THEME"] : ""),

								"ADD_PICT_PROP" => (isset($arParams["ADD_PICT_PROP"]) ? $arParams["ADD_PICT_PROP"] : ""),

								"LABEL_PROP" => (isset($arParams["LABEL_PROP"]) ? $arParams["LABEL_PROP"] : ""),
								"OFFER_ADD_PICT_PROP" => (isset($arParams["OFFER_ADD_PICT_PROP"]) ? $arParams["OFFER_ADD_PICT_PROP"] : ""),
								"OFFER_TREE_PROPS" => (isset($arParams["OFFER_TREE_PROPS"]) ? $arParams["OFFER_TREE_PROPS"] : ""),
								"SHOW_DISCOUNT_PERCENT" => (isset($arParams["SHOW_DISCOUNT_PERCENT"]) ? $arParams["SHOW_DISCOUNT_PERCENT"] : ""),
								"SHOW_OLD_PRICE" => (isset($arParams["SHOW_OLD_PRICE"]) ? $arParams["SHOW_OLD_PRICE"] : ""),
								"MESS_BTN_BUY" => (isset($arParams["MESS_BTN_BUY"]) ? $arParams["MESS_BTN_BUY"] : ""),
								"MESS_BTN_ADD_TO_BASKET" => (isset($arParams["MESS_BTN_ADD_TO_BASKET"]) ? $arParams["MESS_BTN_ADD_TO_BASKET"] : ""),
								"MESS_BTN_DETAIL" => (isset($arParams["MESS_BTN_DETAIL"]) ? $arParams["MESS_BTN_DETAIL"] : ""),
								"MESS_NOT_AVAILABLE" => (isset($arParams["MESS_NOT_AVAILABLE"]) ? $arParams["MESS_NOT_AVAILABLE"] : ""),
								'ADD_TO_BASKET_ACTION' => (isset($arParams["ADD_TO_BASKET_ACTION"]) ? $arParams["ADD_TO_BASKET_ACTION"] : ""),
								'SHOW_CLOSE_POPUP' => (isset($arParams["SHOW_CLOSE_POPUP"]) ? $arParams["SHOW_CLOSE_POPUP"] : ""),
								'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
								'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
								"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
								"SALE_STIKER" => $arParams["SALE_STIKER"],
								"STIKERS_PROP" => $arParams["STIKERS_PROP"],
								"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
								"DISPLAY_TYPE" => "block",
								"SHOW_RATING" => $arParams["SHOW_RATING"],
								"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
								"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
							)
							+ array(
								'OFFER_ID' => empty($templateData['OFFERS'][$templateData['OFFERS_SELECTED']]['ID']) ? $arResult['ID'] : $templateData['OFFERS'][$templateData['OFFERS_SELECTED']]['ID'],
								'SECTION_ID' => $arResult['SECTION']['ID'],
								'ELEMENT_ID' => $arResult['ID'],
							),
							$component,
							array("HIDE_ICONS" => "Y")
					);
				}
				?>
			</div>
			<script type="text/javascript">
				BX.message({
					QUANTITY_AVAILIABLE: '<? echo COption::GetOptionString("aspro.tires2", "EXPRESSION_FOR_EXISTS", GetMessage("EXPRESSION_FOR_EXISTS_DEFAULT"), SITE_ID); ?>',
					QUANTITY_NOT_AVAILIABLE: '<? echo COption::GetOptionString("aspro.tires2", "EXPRESSION_FOR_NOTEXISTS", GetMessage("EXPRESSION_FOR_NOTEXISTS"), SITE_ID); ?>',
					ADD_ERROR_BASKET: '<? echo GetMessage("ADD_ERROR_BASKET"); ?>',
					ADD_ERROR_COMPARE: '<? echo GetMessage("ADD_ERROR_COMPARE"); ?>',
					ONE_CLICK_BUY: '<? echo GetMessage("ONE_CLICK_BUY"); ?>',
					MORE_TEXT_BOTTOM: '<?=\Bitrix\Main\Config\Option::get("aspro.tires2", "EXPRESSION_READ_MORE_OFFERS_DEFAULT", GetMessage("MORE_TEXT_BOTTOM"));?>',
					TYPE_SKU: '<? echo $arParams['TYPE_SKU']; ?>',
					HAS_SKU_PROPS: '<? echo ($arResult['OFFERS_PROP'] ? 'Y' : 'N'); ?>',
					SITE_ID: '<? echo SITE_ID; ?>'
				})
			</script>

			<script type="text/javascript">
				if(!$(".stores_tab").length){
					$('.item-stock .store_view').removeClass('store_view');
				}
				viewItemCounter('<?=$arResult["ID"];?>','<?=current($arParams["PRICE_CODE"]);?>');
			</script>
			<?if($arParams["FILTER_PARAMS"]["SIMILAR_PARAMS"]):?>
				<div class="wraps hidden_print addon_type similar_block tab last_bottom similar">
					<h4><?=($arParams["TITLE_SIMILAR_PARAMS"] ? $arParams["TITLE_SIMILAR_PARAMS"] : GetMessage("SIMILAR_PARAMS_TITLE"))?></h4>
					<div class="bottom_slider specials tab_slider_wrapp custom_type">
					<ul class="slider_navigation top custom_flex border">
						<li class="tabs_slider_navigation similar_nav cur" data-code="similar"></li>
					</ul>
					<ul class="tabs_content">
						<li class="tab accos_wrapp cur" data-code="similar">
							<div class="flexslider loading_state shadow border custom_flex top_right" data-plugin-options='{"animation": "slide", "animationSpeed": 600, "directionNav": true, "controlNav" :false, "animationLoop": true, "slideshow": false, "controlsContainer": ".tabs_slider_navigation.similar_nav", "counts": [4,3,3,2,1]}'>
								<ul class="tabs_slider accos_slides slides">
									<?$GLOBALS['arrFilterAssoc'] = $arParams["FILTER_PARAMS"]["SIMILAR_PARAMS"];?>
									<?$APPLICATION->IncludeComponent(
										"bitrix:catalog.top",
										"main",
										array(
											"USE_REGION" => ($arRegion ? "Y" : "N"),
											"STORES" => $arParams['STORES'],
											"TITLE_BLOCK" => $arParams["SECTION_TOP_BLOCK_TITLE"],
											"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
											"IBLOCK_ID" => $arParams["IBLOCK_ID"],
											"SALE_STIKER" => $arParams["SALE_STIKER"],
											"STIKERS_PROP" => $arParams["STIKERS_PROP"],
											"SHOW_RATING" => $arParams["SHOW_RATING"],
											"FILTER_NAME" => 'arrFilterAssoc',
											"ELEMENT_SORT_FIELD" => $arParams["SORT_LINKED"],
											"ELEMENT_SORT_ORDER" => $arParams["SORT_LINKED_ORDER"],
											"ELEMENT_SORT_FIELD2" => "NAME",
											"ELEMENT_SORT_ORDER2" => "ASC",
											"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
											"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
											"BASKET_URL" => $arParams["BASKET_URL"],
											"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
											"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
											"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
											"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
											"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
											"DISPLAY_COMPARE" => ($arParams["DISPLAY_COMPARE"] ? "Y" : "N"),
											"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
											"ELEMENT_COUNT" => $disply_elements,
											"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
											"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
											"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
											"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
											"PRICE_CODE" => $arParams['PRICE_CODE'],
											"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
											"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
											"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
											"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
											"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
											"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
											"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
											"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
											"CACHE_TYPE" => $arParams["CACHE_TYPE"],
											"CACHE_TIME" => $arParams["CACHE_TIME"],
											"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
											"CACHE_FILTER" => $arParams["CACHE_FILTER"],
											"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
											"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
											"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
											"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
											"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
											"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
											"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
											"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
											'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
											'CURRENCY_ID' => $arParams['CURRENCY_ID'],
											'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
											'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
											'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
											'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
											'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
											'LABEL_PROP' => $arParams['LABEL_PROP'],
											'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
											'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

											'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
											'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
											'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
											'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
											'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
											'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
											'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
											'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
											'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
											'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
											'ADD_TO_BASKET_ACTION' => $basketAction,
											'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
											'COMPARE_PATH' => $templateData['FOLDER'].$templateData['URL_TEMPLATES']['compare'],
										),
										false, array("HIDE_ICONS"=>"Y")
									);?>
								</ul>
							</div>
						</li>
					</ul>
				</div>
				</div>
			<?endif;?>
			<?if($templateData['ASSOCIATED']):?>
				<div class="wraps hidden_print goods-block with-padding block ajax_load catalog">
					<?$GLOBALS['arrFilterAssoc'] = array("ID" => $templateData['ASSOCIATED']);?>
					<?$APPLICATION->IncludeComponent(
						"aspro:catalog.section.tires2",
						"catalog_block_slider",
						array(
							"USE_REGION" => ($arRegion ? "Y" : "N"),
							"STORES" => $arParams['STORES'],
							"TITLE_BLOCK" => $arParams["SECTION_TOP_BLOCK_TITLE"],
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"IBLOCK_IDS" => \Aspro\Functions\CAsproTires2::getCatalogIBlocks("", true, true),
							"SALE_STIKER" => $arParams["SALE_STIKER"],
							"STIKERS_PROP" => $arParams["STIKERS_PROP"],
							"SHOW_RATING" => $arParams["SHOW_RATING"],
							"FILTER_NAME" => 'arrFilterAssoc',
							"ELEMENT_SORT_FIELD" => $arParams["SORT_LINKED"],
							"ELEMENT_SORT_ORDER" => $arParams["SORT_LINKED_ORDER"],
							"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
							"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"DISPLAY_COMPARE" => ($arParams["DISPLAY_COMPARE"] ? "Y" : "N"),
							"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
							"ELEMENT_COUNT" => $disply_elements,
							"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
							"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
							"LINE_ELEMENT_COUNT" => $arParams["TOP_LINE_ELEMENT_COUNT"],
							"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
							"PRICE_CODE" => $arParams['PRICE_CODE'],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
							"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
							"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
							"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
							"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"CACHE_FILTER" => $arParams["CACHE_FILTER"],
							"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
							"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
							"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
							"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
							"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
							'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
							'VIEW_MODE' => (isset($arParams['TOP_VIEW_MODE']) ? $arParams['TOP_VIEW_MODE'] : ''),
							'ROTATE_TIMER' => (isset($arParams['TOP_ROTATE_TIMER']) ? $arParams['TOP_ROTATE_TIMER'] : ''),
							'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
							'LABEL_PROP' => $arParams['LABEL_PROP'],
							'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
							'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

							'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
							'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
							'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
							'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
							'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
							'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
							'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
							'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
							'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
							'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
							'ADD_TO_BASKET_ACTION' => $basketAction,
							'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
							'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
							"TITLE" => ($arParams["DETAIL_EXPANDABLES_TITLE"] ? $arParams["DETAIL_EXPANDABLES_TITLE"] : GetMessage("DETAIL_EXPANDABLES_TITLE")),
							"INCLUDE_SUBSECTIONS" => "Y",
							"SHOW_ALL_WO_SECTION" => "Y",
						),
						false, array("HIDE_ICONS"=>"Y")
					);?>
				</div>
			<?endif;?>
		</div>
		<div class="right_block_wrap col-md-3">
			<div class="right_info_block">
				<?if($templateData['PARENT_SECTION']):?>
					<div class="brand">
						<?if($templateData['PARENT_SECTION']['PICTURE']):?>
							<div class="image"><a href="<?=$templateData['PARENT_SECTION']['SECTION_PAGE_URL'];?>"><img src="<?=$templateData['PARENT_SECTION']['PICTURE']['src'];?>" alt="<?=$templateData['PARENT_SECTION']['NAME'];?>" title="<?=$templateData['PARENT_SECTION']['NAME'];?>" itemprop="image"></a></div>
						<?endif;?>
						<div class="preview">
							<?if($templateData['PARENT_SECTION']['DESCRIPTION'] && $arParams['HIDE_BRAND_DESCRIPTION'] != 'Y'):?>
								<div class="text"><?=$templateData['PARENT_SECTION']['DESCRIPTION'];?></div>
							<?endif;?>
							<?if($templateData['PARENT_SECTION']['SIMILAR_PRODUCTS_URL']):?>
								<div class="link icons_fa"><a href="<?=$templateData['LIST_PAGE_URL'].'?'.$arTheme['PODBOR_ELEMENTS_URL']['VALUE'].'=Y&set_filter=y'.$templateData['PARENT_SECTION']['SIMILAR_PRODUCTS_URL'];?>" target="_blank" class="similar_all_link"><?=GetMessage("SIMILAR_ITEMS")?></a></div>
								<script>
									BX.ajax.loadJSON(
										'<?=$templateData['LIST_PAGE_URL'].'?'.$arTheme['PODBOR_ELEMENTS_URL']['VALUE'].'=Y&ajax=y&set_filter=y'.$templateData['PARENT_SECTION']['SIMILAR_PRODUCTS_URL'];?>',
										function(data){
											if(typeof data == 'object')
											{
												if('SEF_SET_FILTER_URL' in data)
													$('.similar_all_link').attr('href', data.SEF_SET_FILTER_URL);
											}
										}
									)
								</script>
							<?endif;?>
							<?if($templateData['BRAND_ITEM'] && $templateData['SECTION']):?>
								<div class="link icons_fa"><a href="<?=$templateData['SECTION']['SECTION_PAGE_URL']?>filter/brand-is-<?=$templateData['BRAND_ITEM']['CODE']?>/apply/" target="_blank"><?=GetMessage("ITEMS_BY_SECTION")?></a></div>
							<?endif;?>
							<?$allURL = ($templateData['BRAND_ITEM'] ? $templateData['PARENT_SECTION']['SECTION_PAGE_URL'] : $arTheme['CATALOG_SEARCH_PAGE_URL']['VALUE'].'?q='.$templateData['PARENT_SECTION']['NAME']);?>
							<div class="link icons_fa"><a href="<?=$allURL;?>" target="_blank"><?=GetMessage("ITEMS_BY_BRAND", array("#BRAND#" => $templateData['PARENT_SECTION']["NAME"]))?></a></div>
						</div>
					</div>
				<?endif;?>
				<?if((ModuleManager::isModuleInstalled("sale") && (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N'))):?>
					<?include_once($_SERVER["DOCUMENT_ROOT"].$arParams["BIGDATA_PATH_TEMPLATE"]);?>
				<?endif;?>
				<?if($templateData["TIZERS_ITEMS"]){?>
					<div class="tizers_block_detail tizers_block">
						<?$count_t_items=count($templateData["TIZERS_ITEMS"]);?>
						<?foreach($templateData["TIZERS_ITEMS"] as $arItem){?>
							<div class="inner_wrapper item clearfix">
								<?if($arItem["UF_FILE"]){?>
									<div class="img">
										<?if($arItem["UF_LINK"]){?>
											<a class="dark-color" href="<?=$arItem["UF_LINK"];?>" <?=(strpos($arItem["UF_LINK"], "http") !== false ? "target='_blank' rel='nofollow'" : '')?>>
										<?}?>
										<img src="<?=$arItem["PREVIEW_PICTURE"]["src"];?>" alt="<?=$arItem["UF_NAME"];?>" title="<?=$arItem["UF_NAME"];?>">
										<?if($arItem["UF_LINK"]){?>
											</a>
										<?}?>
									</div>
								<?}?>
								<div class="text_block">
									<div class="title">
										<?if($arItem["UF_LINK"]){?>
											<a href="<?=$arItem["UF_LINK"];?>" <?=(strpos($arItem["UF_LINK"], "http") !== false ? "target='_blank' rel='nofollow'" : '')?>>
										<?}?>
										<?=$arItem["UF_NAME"];?>
										<?if($arItem["UF_LINK"]){?>
											</a>
										<?}?>
									</div>
									<?if($arItem['UF_DESCRIPTION']):?>
										<div class="description"><?=$arItem['UF_DESCRIPTION'];?></div>
									<?endif;?>
								</div>
							</div>
						<?}?>
					</div>
				<?}?>
				
				<?CTires2::get_banners_position('CATALOG', 'N', 'Y');?>
			</div>
		</div>		
	</div>
<?endif;?>
<?if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
		<script type="text/javascript">
			BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
		</script>
	<?}
}?>
<script type="text/javascript">
	var viewedCounter = {
		path: '/bitrix/components/bitrix/catalog.element/ajax.php',
		params: {
			AJAX: 'Y',
			SITE_ID: "<?= SITE_ID ?>",
			PRODUCT_ID: "<?= $arResult['ID'] ?>",
			PARENT_ID: "<?= $arResult['ID'] ?>"
		}
	};
	BX.ready(
		BX.defer(function(){
			$('body').addClass('detail_page');
			BX.ajax.post(
				viewedCounter.path,
				viewedCounter.params
			);
			if( $('.stores_tab').length ){
				var arSearch=parseUrlQuery();
				if("oid" in arSearch)
				{
					$('.stores_tab .sku_stores_'+arSearch.oid).show();
				}
				else
				{
					var obSKU = window['<?=$templateData['STR_ID']?>'];
					if(typeof obSKU == "object")
					{
						obSKU.setStoreBlock(obSKU.offers[obSKU.offerNum].ID)
					}
					else
						$('.stores_tab .stores_wrapp > div:first').show();
				}
			}
		})
		
	);
</script>
<?if(isset($_GET["RID"])){?>
	<?if($_GET["RID"]){?>
		<script>
			$(document).ready(function() {
				$("<div class='rid_item' data-rid='<?=htmlspecialcharsbx($_GET["RID"]);?>'></div>").appendTo($('body'));
			});
		</script>
	<?}?>
<?}?>