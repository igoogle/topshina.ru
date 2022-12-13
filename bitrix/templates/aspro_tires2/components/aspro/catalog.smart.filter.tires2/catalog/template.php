<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;
if($arResult["ITEMS"]){?>
	<?$arShowTyreIndex = array(
		\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_tires"][0]),
		\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0]),
		\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0]),
		\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_MOTO_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_moto_tires"][0]),
		\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TRUCK_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_truck_tires"][0]),
	);

	$bTiresIBlock = ((in_array($arParams["IBLOCK_ID"], $arShowTyreIndex) && $arParams['HIDE_AVTOLIST'] != 'Y') ? true : false);
	$arTiresIblock = array($arShowTyreIndex[0], $arShowTyreIndex[3], $arShowTyreIndex[4]);
	$countTyres = count($arTiresIblock);

	$bCalcType = ($arParams['TYPE_CALC'] == 'Y');

	$title = '';
	switch($arParams['IBLOCK_ID']){
		case $arShowTyreIndex[0]:
			$title = strtolower(strip_tags($arParams['BLOCK_TITLE_TIRES']));
			if($bCalcType)
				$arParams['TYPE'] = 'tires';
			break;
		case $arShowTyreIndex[1]:
			$title = strtolower(strip_tags($arParams['BLOCK_TITLE_WHEELS']));
			if($bCalcType)
				$arParams['TYPE'] = 'wheels';
			break;
		case $arShowTyreIndex[2]:
			$title = strtolower(strip_tags($arParams['BLOCK_TITLE_AKB']));
				if($bCalcType)
				$arParams['TYPE'] = 'akb';
			break;
		case $arShowTyreIndex[3]:
			$title = strtolower(strip_tags($arParams['BLOCK_TITLE_TIRES_MOTO']));
			if($bCalcType)
				$arParams['TYPE'] = 'moto tires';
			break;
		case $arShowTyreIndex[4]:
			$title = strtolower(strip_tags($arParams['BLOCK_TITLE_TIRES_TRUCK']));
			if($bCalcType)
				$arParams['TYPE'] = 'truck tires';
			break;
	}
	?>
	<?include_once("functions.php")?>
	<?global $arPropType;?>

	<?$arResult["FORM_ACTION"] = ($arParams["FILTER_URL"] ? $arParams["FILTER_URL"] : $arResult["FORM_ACTION"]);?>
	<div class="front_filter_wrap catalog_filter <?=($arParams['TYPE'] ? $arParams['TYPE'] : '');?>" data-params='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arParams, false))?>' data-template="<?=$this->__component->__template->__name?>">
		<?//if($arParams['IBLOCK_ID'] == $arShowTyreIndex[0] || $arParams['IBLOCK_ID'] == $arShowTyreIndex[1] || $arParams['IBLOCK_ID'] == $arShowTyreIndex[2]):?>
			<div class="title_block clearfix<?=($arParams['IBLOCK_ID'] == $arShowTyreIndex[3] || $arParams['IBLOCK_ID'] == $arShowTyreIndex[4] || $arParams['HIDE_AVTOLIST'] == 'Y' ? ' not_visible' : '');?>">
				<?if(($arParams['IBLOCK_ID'] == $arShowTyreIndex[0] || $arParams['IBLOCK_ID'] == $arShowTyreIndex[1] || $arParams['IBLOCK_ID'] == $arShowTyreIndex[2]) && $arParams['HIDE_AVTOLIST'] != 'Y'):?>
					<span class="link_item pull-left active" data-filter="params"><?=Loc::getMessage("FILTER_TITLE");?></span>
					<span class="link_item pull-left" data-filter="avto"><?=Loc::getMessage("FILTER_AUTO_TITLE");?></span>
				<?endif;?>
				<div class="clearfix"></div>
			</div>
		<?//endif;?>
		<div class="bx_filter bx_filter_vertical front_filter">
			<div class="bx_filter_section">
				<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?=$arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
					<input type="hidden" <?=($arPropType["PODBOR_ELEMENTS_URL"]["VALUE"] ? 'name="'.$arPropType["PODBOR_ELEMENTS_URL"]["VALUE"].'"' : '');?> id="<?=$arPropType["PODBOR_ELEMENTS_URL"]["VALUE"];?>" value="Y">
					<?if($bTiresIBlock):?>
						<input type="hidden" data-id="filter_name" value="<?=$arParams["FILTER_NAME"];?>">
						<div class="bx_filter_parameters_box tyresind">
							<?$APPLICATION->IncludeComponent(
								"aspro:auto.list.tires2",
								"catalog",
								Array(
									"AUTO_COMPLECT" => "",
									"AUTO_MARK" => "",
									"AUTO_MODEL" => "",
									"AUTO_YEAR" => "",
									"INSTANT_RELOAD" => "Y",
									"TYPE_FILTER" => ($arParams["IBLOCK_ID"] == \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0]) ? "wheels" : ($arParams["IBLOCK_ID"] == \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0]) ? "akb" : "tires"))
								)
							);?>
						</div>
					<?endif;?>
					<div class="tyres_params active">
						<input type="hidden" name="del_url" value="<?echo str_replace('/filter/clear/apply/','/',$arResult["SEF_DEL_FILTER_URL"]);?>" />

						<?foreach($arResult["HIDDEN"] as $arItem):?>
							<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
						<?endforeach;

						$isFilter=false;
						$numVisiblePropValues = 5;
						?>

						<?//prices?>
						<?if($arResult["OTHER_PROPS"]):?>
							<div class="other_props">
								<?foreach($arResult["OTHER_PROPS"] as $key=>$arItem)
								{
									$key = $arItem["ENCODED_ID"];
									if(isset($arItem["PRICE"])):
										if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
											continue;
										?>
										<div class="bx_filter_parameters_box type_WIDE">
											<span class="bx_filter_container_modef"></span>
											<div class="bx_filter_parameters_box_title" ><?=(count($arParams['PRICE_CODE']) > 1 ? $arItem["NAME"] : Loc::getMessage("PRICE"));?></div>
											<div class="bx_filter_block">
												<div class="bx_filter_parameters_box_container numbers">
													<div class="wrapp_all_inputs wrap_md">
														<?
														$isConvert=false;
														if($arParams["CONVERT_CURRENCY"]=="Y"){
															$isConvert=true;
														}
														$price1 = $arItem["VALUES"]["MIN"]["VALUE"];
														$price2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
														$price3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
														$price4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
														$price5 = $arItem["VALUES"]["MAX"]["VALUE"];

														if($isConvert){
															$price1 =SaleFormatCurrency($price1, $arParams["CURRENCY_ID"], true);
															$price2 =SaleFormatCurrency($price2, $arParams["CURRENCY_ID"], true);
															$price3 =SaleFormatCurrency($price3, $arParams["CURRENCY_ID"], true);
															$price4 =SaleFormatCurrency($price4, $arParams["CURRENCY_ID"], true);
															$price5 =SaleFormatCurrency($price5, $arParams["CURRENCY_ID"], true);
														}
														?>
														<div class="wrapp_change_inputs iblock">
															<div class="bx_filter_parameters_box_container_block">
																<div class="bx_filter_input_container form-control bg">
																	<input
																		class="min-price"
																		type="text"
																		name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																		id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																		value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																		size="5"
																		placeholder="<?echo $price1;?>"
																		onkeyup="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(this)"
																	/>
																</div>
															</div>
															<div class="bx_filter_parameters_box_container_block">
																<div class="bx_filter_input_container form-control bg">
																	<input
																		class="max-price"
																		type="text"
																		name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																		id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																		value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																		size="5"
																		placeholder="<?echo $price5;?>"
																		onkeyup="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(this)"
																	/>
																</div>
															</div>
															<span class="divider"></span>
															<div style="clear: both;"></div>
														</div>
														<div class="wrapp_slider iblock">
															<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
																<div class="bx_ui_slider_part first p1"><span><?=$price1?></span></div>
																<div class="bx_ui_slider_part p2"><span><?=$price2?></span></div>
																<div class="bx_ui_slider_part p3"><span><?=$price3?></span></div>
																<div class="bx_ui_slider_part p4"><span><?=$price4?></span></div>
																<div class="bx_ui_slider_part last p5"><span><?=$price5?></span></div>

																<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
																<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
																<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
																<div class="bx_ui_slider_range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
																	<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
																	<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
																</div>
															</div>
															<div style="opacity: 0;height: 1px;"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?
										$isFilter=true;
										$precision = 2;
										if (Bitrix\Main\Loader::includeModule("currency"))
										{
											$res = CCurrencyLang::GetFormatDescription($arItem["VALUES"]["MIN"]["CURRENCY"]);
											$precision = $res['DECIMALS'];
										}
										$arJsParams = array(
											"leftSlider" => 'left_slider_'.$key,
											"rightSlider" => 'right_slider_'.$key,
											"tracker" => "drag_tracker_".$key,
											"trackerWrap" => "drag_track_".$key,
											"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
											"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
											"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
											"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
											"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
											"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
											"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
											"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
											"precision" => $precision,
											"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
											"colorAvailableActive" => 'colorAvailableActive_'.$key,
											"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
										);
										?>
										<script type="text/javascript">
											BX.ready(function(){
												if(typeof window['trackBarOptions'] === 'undefined'){
													window['trackBarOptions'] = {}
												}
												window['trackBarOptions']['<?=$key?>'] = <?=CUtil::PhpToJSObject($arJsParams)?>;
												window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(window['trackBarOptions']['<?=$key?>']);
											});
										</script>
									<?endif;
								}?>
							</div>
						<?endif;?>

						<?//not prices?>
						<?if($arResult["TOP_PROPS"]):?>
							<?=showFilterProps($arResult["TOP_PROPS"], $arPropType, $numVisiblePropValues);?>
						<?endif;?>

						<?//prices?>
						<?if($arResult["OTHER_PROPS"]):?>
							<div class="other_props">
								<?=showFilterProps($arResult["OTHER_PROPS"], $arPropType, $numVisiblePropValues);?>
							</div>
						<?endif;?>
					</div>

					<?if($arResult["ITEMS"])
						$isFilter = true;?>

					<?if($isFilter){?>
						<div class="clb"></div>
						<div class="bx_filter_button_box active">
							<div class="bx_filter_block">
								<div class="bx_filter_parameters_box_container">
									<div class="bx_filter_popup_result right" data-id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
										<?echo Loc::getMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
										<a rel="nofollow" href="<?echo str_replace('/filter/clear/apply/', '/', $arResult["FILTER_URL"]);?>" class="btn btn-default white white-bg"><?echo Loc::getMessage("CT_BCSF_FILTER_SHOW")?></a>
									</div>
									<input class="bx_filter_search_button btn btn-default <?=($arParams["INSTANT_RELOAD"] != "Y" ? "" : "hidden");?>" onclick="return sendQueryTires<?=$arParams["IBLOCK_ID"]?>(this)" type="submit" name="set_filter" data-href="" value="<?=Loc::getMessage("CT_BCSF_SET_FILTER")?>" />
									<?if($arParams["INSTANT_RELOAD"] == "Y"):?>
										<span class="btn btn-default white" data-href="" id="del_filter">
									<?else:?>
										<span class="bx_filter_search_reset_main btn btn-default white" data-href="">
									<?endif;?>
										<?=Loc::getMessage("CT_BCSF_DEL_FILTER")?>
									</span>
									<?if($arParams['IBLOCK_ID'] != $arShowTyreIndex[2]):?>
										<div class="all_hint">
											<span class="icon"><i>?</i></span><span class="text" data-event="jqm" data-name="all_hint" data-param-form_id="filter_all_hint" data-param-type="<?=($arParams['IBLOCK_ID'] == $arShowTyreIndex[1] ? 'WHEELS' : 'TIRES');?>"><?=Loc::getMessage('ALL_HINT');?></span>
										</div>
									<?endif;?>
								</div>
							</div>
						</div>
					<?}?>
				</form>
				<div style="clear: both;"></div>
			</div>
		</div>
</div>
	<div id="filter_result" class="catalog_result clearfix">
		<div class="title pull-left"><?=Loc::getMessage('RESULT_TITLE');?></div>
		<div class="block_all_results">
			<div class="tyres_result"></div>
			<div class="wheels_result"></div>
			<div class="akb_result"></div>
		</div>
	</div>

	<script>
		var sendQueryTires<?=$arParams["IBLOCK_ID"]?> = function(e){
			var form = $(e).closest("form");
			smartFilter.click(form.find("input").first()[0], true, form.find('[name=set_filter]')[0])
			return false;
		}
		var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=$arParams["VIEW_MODE"];?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
	</script>
<?}?>