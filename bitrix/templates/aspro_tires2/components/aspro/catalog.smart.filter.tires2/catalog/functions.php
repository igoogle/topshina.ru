<?
use \Bitrix\Main\Localization\Loc;
function showFilterProps($arItems, $arPropType, $numVisiblePropValues){
	$i == 0;
	foreach($arItems as $key=>$arItem)
	{
		if(
			empty($arItem["VALUES"])
			|| isset($arItem["PRICE"])
		)
			continue;

		if (
			$arItem["DISPLAY_TYPE"] == "A"
			&& (
				$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
			)
		)
			continue;
		$class="";
		/*if($arItem["OPENED"]){
			if($arItem["OPENED"]=="Y"){
				$class="active";
			}
		}else*/if($arItem["DISPLAY_EXPANDED"]=="Y"){
			$class="active";
		}
		$typeTI = "";
		if($arPropType["PROP_TYRE_SHIRINA_PROFILYA"]["VALUE"] == $arItem["CODE"])
			$typeTI = "twidth";
		if($arPropType["PROP_TYRE_VYSOTA_PROFILYA"]["VALUE"] == $arItem["CODE"])
			$typeTI = "theight";
		if($arPropType["PROP_TYRE_POSADOCHNYY_DIAMETR"]["VALUE"] == $arItem["CODE"])
			$typeTI = "tdia";
		if($arPropType["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"]["VALUE"] == $arItem["CODE"])
			$typeTI = "ddia";
		if($arPropType["PROP_DISK_SHIRINA_DISKA"]["VALUE"] == $arItem["CODE"])
			$typeTI = "dwidth";
		if($arPropType["PROP_DISK_MEZHBOLTOVOE_RASSTOYANIE"]["VALUE"] == $arItem["CODE"])
			$typeTI = "dmbr";
		if($arPropType["PROP_DISK_COUNT_OTVERSTIY"]["VALUE"] == $arItem["CODE"])
			$typeTI = "dco";
		if($arPropType["PROP_DISK_VYLET_DISKA"]["VALUE"] == $arItem["CODE"])
			$typeTI = "dvd";
		if($arPropType["PROP_DISK_DIAMETR_STUPITSY"]["VALUE"] == $arItem["CODE"])
			$typeTI = "dds";

		if($arPropType["PROP_AKB_LENGTH"]["VALUE"] == $arItem["CODE"])
			$typeTI = "alen";
		if($arPropType["PROP_AKB_WIDTH"]["VALUE"] == $arItem["CODE"])
			$typeTI = "awidth";
		if($arPropType["PROP_AKB_HEIGHT"]["VALUE"] == $arItem["CODE"])
			$typeTI = "aheight";
		if($arPropType["PROP_AKB_EMKOST"]["VALUE"] == $arItem["CODE"])
			$typeTI = "acapacity";
		if($arPropType["PROP_AKB_POLARNOST"]["VALUE"] == $arItem["CODE"])
			$typeTI = "apolarity";
		if($arPropType["PROP_AKB_TYPE"]["VALUE"] == $arItem["CODE"])
			$typeTI = "atype";
		if($arPropType["PROP_AKB_VOLTAG"]["VALUE"] == $arItem["CODE"])
			$typeTI = "avolume";

		$isFilter=true;
		?>
		<div class="bx_filter_parameters_box type_<?=$arItem["DISPLAY_TYPE"];?> <?=$class;?>" data-tyreindex="<?=$typeTI;?>" data-expanded="<?=($arItem["DISPLAY_EXPANDED"] ? $arItem["DISPLAY_EXPANDED"] : "N");?>" data-prop_code=<?=strtolower($arItem["CODE"]);?> data-property_id="<?=$arItem["ID"]?>">
			<span class="bx_filter_container_modef"></span>
			<?if($arItem["CODE"]!="IN_STOCK" && $arItem["CODE"] != $arPropType["PROP_TYRE_RNF"]["VALUE"] && $arItem["DISPLAY_TYPE"] != 'F'){?>
				<div class="bx_filter_parameters_box_title icons_fa" >
					<div>
						<?=( $arItem["CODE"] == "MINIMUM_PRICE" ? Loc::getMessage("PRICE") : $arItem["NAME"] );?>
						<div class="char_name">
							<div class="props_list">
								<?if($arParams["SHOW_HINTS"]){
									if(!$arItem["FILTER_HINT"]){
										$prop = CIBlockProperty::GetByID($arItem["ID"], $arParams["IBLOCK_ID"])->GetNext();
										$arItem["FILTER_HINT"]=$prop["HINT"];
									}?>
									<?if( $arItem["FILTER_HINT"] && strpos( $arItem["FILTER_HINT"],'line')===false){?>
										<div class="hint"><span class="icon"><i>?</i></span><div class="tooltip" style="display: none;"><?=$arItem["FILTER_HINT"]?></div></div>
									<?}?>
								<?}?>
							</div>
						</div>
					</div>
				</div>
			<?}?>
			<?$style="";
			if($arItem["CODE"]=="IN_STOCK" || $arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"]){
				$style="style='display:block;'";
			}elseif($arItem["DISPLAY_EXPANDED"]!= "Y"){
				$style="style='display:none;'";
			}?>
			<div class="bx_filter_block <?=($arItem["PROPERTY_TYPE"]!="N" && ($arItem["DISPLAY_TYPE"] != "P" && $arItem["DISPLAY_TYPE"] != "R") ? "limited_block" : "");?>">
				<div class="bx_filter_parameters_box_container <?=($arItem["DISPLAY_TYPE"]=="G" ? "pict_block" : "");?>">
				<?
				$arCur = current($arItem["VALUES"]);
				switch ($arItem["DISPLAY_TYPE"]){
					case "A"://NUMBERS_WITH_SLIDER
						?>
						<div class="wrapp_all_inputs wrap_md">
							<?$isConvert=false;
							if($arItem["CODE"] == "MINIMUM_PRICE" && $arParams["CONVERT_CURRENCY"]=="Y"){
								$isConvert=true;
							}
							$value1 = $arItem["VALUES"]["MIN"]["VALUE"];
							$value2 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/4);
							$value3 = $arItem["VALUES"]["MIN"]["VALUE"] + round(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])/2);
							$value4 = $arItem["VALUES"]["MIN"]["VALUE"] + round((($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"])*3)/4);
							$value5 = $arItem["VALUES"]["MAX"]["VALUE"];
							if($isConvert){
								$value1 =SaleFormatCurrency($value1, $arParams["CURRENCY_ID"], true);
								$value2 =SaleFormatCurrency($value2, $arParams["CURRENCY_ID"], true);
								$value3 =SaleFormatCurrency($value3, $arParams["CURRENCY_ID"], true);
								$value4 =SaleFormatCurrency($value4, $arParams["CURRENCY_ID"], true);
								$value5 =SaleFormatCurrency($value5, $arParams["CURRENCY_ID"], true);
							}?>
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
											placeholder="<?echo $value1;?>"
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
											placeholder="<?echo $value5;?>"
											onkeyup="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(this)"
										/>
									</div>
								</div>
								<span class="divider"></span>
								<div style="clear: both;"></div>
							</div>
							<div class="wrapp_slider iblock">
								<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">

									<div class="bx_ui_slider_part first p1"><span><?=$value1?></span></div>
									<div class="bx_ui_slider_part p2"><span><?=$value2?></span></div>
									<div class="bx_ui_slider_part p3"><span><?=$value3?></span></div>
									<div class="bx_ui_slider_part p4"><span><?=$value4?></span></div>
									<div class="bx_ui_slider_part last p5"><span><?=$value5?></span></div>

									<div class="bx_ui_slider_pricebar_VD" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
									<div class="bx_ui_slider_pricebar_VN" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
									<div class="bx_ui_slider_pricebar_V"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
									<div class="bx_ui_slider_range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
										<a class="bx_ui_slider_handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
										<a class="bx_ui_slider_handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
									</div>
								</div>
								<?
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
									"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
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
							</div>
						</div>
						<?
						break;
					case "B"://NUMBERS
						?>
						<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container form-control bg">
							<input
								class="min-price"
								type="text"
								name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
								id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
								value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
								placeholder="<?echo $arItem["VALUES"]["MIN"]["VALUE"];?>"
								size="5"
								onkeyup="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(this)"
								/>
						</div></div>
						<div class="bx_filter_parameters_box_container_block"><div class="bx_filter_input_container form-control bg">
							<input
								class="max-price"
								type="text"
								name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
								id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
								value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
								placeholder="<?echo $arItem["VALUES"]["MAX"]["VALUE"];?>"
								size="5"
								onkeyup="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(this)"
								/>
						</div></div>
						<?
						break;
					case "G"://CHECKBOXES_WITH_PICTURES
						?>
						<?$j=1;
						$isHidden = false;?>
						<?foreach ($arItem["VALUES"] as $val => $ar):?>
							<?if($ar["VALUE"]){?>
								<?if($j > $numVisiblePropValues && !$isHidden):
									$isHidden = true;?>
									<div class="hidden_values">
								<?endif;?>
								<div class="pict">
									<input
										style="display: none"
										type="checkbox"
										name="<?=$ar["CONTROL_NAME"]?>"
										id="<?=$ar["CONTROL_ID"]?>"
										value="<?=$ar["HTML_VALUE"]?>"
										<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
										<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
									/>
									<?
									$class = "";
									if ($ar["CHECKED"])
										$class.= " active";
									if ($ar["DISABLED"])
										$class.= " disabled";
									?>
									<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label nab dib<?=$class?>" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
										<?/*<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">*/?>
											<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
											<span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
											<?endif?>
										<?/*</span>*/?>
									</label>
								</div>
								<?$j++;?>
							<?}?>
						<?endforeach?>
						<?if($isHidden):?>
							</div>
							<div class="inner_expand_text"><span class="expand_block"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
						<?endif;?>
						<?
						break;
					case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
						?>
						<?$j=1;
						$isHidden = false;?>
						<?foreach ($arItem["VALUES"] as $val => $ar):?>
							<?if($ar["VALUE"]){?>
								<?if($j > $numVisiblePropValues && !$isHidden):
									$isHidden = true;?>
									<div class="hidden_values">
								<?endif;?>
								<input
									style="display: none"
									type="checkbox"
									name="<?=$ar["CONTROL_NAME"]?>"
									id="<?=$ar["CONTROL_ID"]?>"
									value="<?=$ar["HTML_VALUE"]?>"
									<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
									<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
								/>
								<?
								$class = "";
								if ($ar["CHECKED"])
									$class.= " active";
								if ($ar["DISABLED"])
									$class.= " disabled";
								?>
								<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?> pal nab" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'active');">
									<?/*<span class="bx_filter_param_btn bx_color_sl" title="<?=$ar["VALUE"]?>">*/?>
										<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
											<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
										<?endif?>
									<?/*</span>*/?>
									<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
									if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
										?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
									endif;?></span>
								</label>
								<?$j++;?>
							<?}?>
						<?endforeach?>
						<?if($isHidden):?>
							</div>
							<div class="inner_expand_text"><span class="expand_block"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
						<?endif;?>
						<?
						break;
					case "P"://DROPDOWN
						$checkedItemExist = false;
						?>
						<?if($arItem["CODE"] == $arPropType['PROP_TYRE_VYSOTA_PROFILYA']['VALUE']):?>
							<span class="separator vysota_prof">/</span>
						<?endif;?>
						<?if($arItem["CODE"] == $arPropType['PROP_TYRE_POSADOCHNYY_DIAMETR']['VALUE']):?>
							<span class="separator diametr">R</span>
						<?endif;?>
						<?if($arItem["CODE"] == $arPropType['PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA']['VALUE'] || $arItem["CODE"] == $arPropType['PROP_DISK_MEZHBOLTOVOE_RASSTOYANIE']['VALUE']):?>
							<span class="separator cross"><?=\Aspro\Functions\CAsproTires2::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/cross.svg');?></span>
						<?endif;?>
						<div class="bx_filter_select_container">
							<div class="bx_filter_select_block" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
								<div class="bx_filter_select_text" data-role="currentOption">
									<?
									foreach ($arItem["VALUES"] as $val => $ar)
									{
										if ($ar["CHECKED"])
										{
											echo $ar["VALUE"];
											$checkedItemExist = true;
										}
									}
									if (!$checkedItemExist)
									{
										echo Loc::getMessage("CT_BCSF_FILTER_ALL");
									}
									?>
								</div>
								<div class="bx_filter_select_arrow"></div>
								<input
									style="display: none"
									type="radio"
									name="<?=$arCur["CONTROL_NAME_ALT"]?>"
									id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
									value=""
								/>
								<?foreach ($arItem["VALUES"] as $val => $ar):?>
									<input
										style="display: none"
										type="radio"
										name="<?=$ar["CONTROL_NAME_ALT"]?>"
										id="<?=$ar["CONTROL_ID"]?>"
										value="<? echo $ar["HTML_VALUE_ALT"] ?>"
										<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
										<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
									/>
								<?endforeach?>
								<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none;">
									<ul>
										<li>
											<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_all_<?=$arCur["CONTROL_ID"]?>" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
												<? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?>
											</label>
										</li>
									<?
									foreach ($arItem["VALUES"] as $val => $ar):
										$class = "";
										if ($ar["CHECKED"])
											$class.= " selected";
										if ($ar["DISABLED"])
											$class.= " disabled";
									?>
										<li>
											<label for="<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?> <?=($ar["EXT_CLASS"] ? $ar["EXT_CLASS"] : "");?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
										</li>
									<?endforeach?>
									</ul>
								</div>
							</div>
						</div>
						<?
						break;
					case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
						?>
						<div class="bx_filter_select_container">
							<div class="bx_filter_select_block" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
								<div class="bx_filter_select_text" data-role="currentOption">
									<?
									$checkedItemExist = false;
									foreach ($arItem["VALUES"] as $val => $ar):
										if ($ar["CHECKED"])
										{
										?>
											<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
												<span class="bx_filter_btn_color_icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
											<?endif?>
											<span class="bx_filter_param_text">
												<?=$ar["VALUE"]?>
											</span>
										<?
											$checkedItemExist = true;
										}
									endforeach;
									if (!$checkedItemExist){?>
										<?echo Loc::getMessage("CT_BCSF_FILTER_ALL");
									}
									?>
								</div>
								<div class="bx_filter_select_arrow"></div>
								<input
									style="display: none"
									type="radio"
									name="<?=$arCur["CONTROL_NAME_ALT"]?>"
									id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
									value=""
								/>
								<?foreach ($arItem["VALUES"] as $val => $ar):?>
									<input
										style="display: none"
										type="radio"
										name="<?=$ar["CONTROL_NAME_ALT"]?>"
										id="<?=$ar["CONTROL_ID"]?>"
										value="<?=$ar["HTML_VALUE_ALT"]?>"
										<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
										<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
									/>
								<?endforeach?>
								<div class="bx_filter_select_popup" data-role="dropdownContent" style="display: none">
									<ul>
										<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
											<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" data-role="label_<?=$arCur["CONTROL_ID"]?>" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
												<? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?>
											</label>
										</li>
									<?
									foreach ($arItem["VALUES"] as $val => $ar):
										$class = "";
										if ($ar["CHECKED"])
											$class.= " selected";
										if ($ar["DISABLED"])
											$class.= " disabled";
									?>
										<li>
											<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label<?=$class?>" onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
												<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
													<span class="bx_filter_btn_color_icon" title="<?=$ar["VALUE"]?>" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
												<?endif?>
												<span class="bx_filter_param_text">
													<?=$ar["VALUE"]?>
												</span>
											</label>
										</li>
									<?endforeach?>
									</ul>
								</div>
							</div>
						</div>
						<?
						break;
					case "K"://RADIO_BUTTONS
						?>
						<div class="filter label_block radio">
							<input
								type="radio"
								value=""
								name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
								id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
								onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.click(this)"
							/>
						<label data-role="label_<?=$arCur["CONTROL_ID"]?>" class="bx_filter_param_label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
							<span class="bx_filter_input_checkbox"><span><? echo Loc::getMessage("CT_BCSF_FILTER_ALL"); ?></span></span>
						</label>
						</div>
						<?$j=1;
						$isHidden = false;?>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
							<?if($j > $numVisiblePropValues && !$isHidden):
								$isHidden = true;?>
								<div class="hidden_values">
							<?endif;?>
							<div class="filter label_block radio">
								<input
											type="radio"
											value="<? echo $ar["HTML_VALUE_ALT"] ?>"
											name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
											id="<? echo $ar["CONTROL_ID"] ?>"
											<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
											<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
											onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.click(this)"
										/>
								<?$class = "";
								if ($ar["CHECKED"])
									$class.= " selected";
								if ($ar["DISABLED"])
									$class.= " disabled";?>
								<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label <?=($ar["EXT_CLASS"] ? $ar["EXT_CLASS"] : "");?> <?=$class;?>" for="<? echo $ar["CONTROL_ID"] ?>">
									<span class="bx_filter_input_checkbox">

										<span class="bx_filter_param_text1" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
										if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
											?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
										endif;?></span>
									</span>
								</label>
							</div>
							<?$j++;?>
						<?endforeach;?>
						<?if($isHidden):?>
							</div>
							<div class="inner_expand_text"><span class="expand_block"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
						<?endif;?>
						<?
						break;
					case "U"://CALENDAR
						?>
						<div class="bx_filter_parameters_box_container_block">
							<div class="bx_filter_input_container bx_filter_calendar_container">
								<?$APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
									array(
										'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
										'SHOW_INPUT' => 'Y',
										'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter'.$arParams["IBLOCK_ID"].'.keyup(this)" onchange="smartFilter'.$arParams["IBLOCK_ID"].'.keyup(this)"',
										'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
										'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
										'SHOW_TIME' => 'N',
										'HIDE_TIMEBAR' => 'Y',
									),
									null,
									array('HIDE_ICONS' => 'Y')
								);?>
							</div>
						</div>
						<div class="bx_filter_parameters_box_container_block">
							<div class="bx_filter_input_container bx_filter_calendar_container">
								<?$APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
									array(
										'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
										'SHOW_INPUT' => 'Y',
										'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter'.$arParams["IBLOCK_ID"].'.keyup(this)" onchange="smartFilter'.$arParams["IBLOCK_ID"].'.keyup(this)"',
										'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
										'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
										'SHOW_TIME' => 'N',
										'HIDE_TIMEBAR' => 'Y',
									),
									null,
									array('HIDE_ICONS' => 'Y')
								);?>
							</div>
						</div>
						<?
						break;
					default://CHECKBOXES
						$count=count($arItem["VALUES"]);
						$i=1;
						if(!$arItem["FILTER_HINT"]){
							$prop = CIBlockProperty::GetByID($arItem["ID"], $arItem["IBLOCK_ID"])->GetNext();
							$arItem["FILTER_HINT"]=$prop["HINT"];
						}
						if($arItem["IBLOCK_ID"]!=$arParams["IBLOCK_ID"] && strpos($arItem["FILTER_HINT"],'line')!==false){
							$isSize=true;
						}else{
							$isSize=false;
						}?>
						<?$j=1;
						$isHidden = false;?>
						<?foreach($arItem["VALUES"] as $val => $ar):?>
							<?if($j > $numVisiblePropValues && !$isHidden):
								$isHidden = true;?>
								<div class="hidden_values">
							<?endif;?>
							<input
								type="checkbox"
								value="<? echo $ar["HTML_VALUE"] ?>"
								name="<? echo $ar["CONTROL_NAME"] ?>"
								id="<? echo $ar["CONTROL_ID"] ?>"
								<? echo $ar["DISABLED"] ? 'disabled class="disabled"': '' ?>
								<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
								onclick="smartFilter<?=$arParams["IBLOCK_ID"]?>.click(this)"
							/>
							<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx_filter_param_label <?=($isSize ? "nab sku" : "");?> <?=($ar["EXT_CLASS"] ? $ar["EXT_CLASS"] : "");?> <?=($i==$count ? "last" : "");?> <? echo $ar["DISABLED"] ? 'disabled': '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
								<span class="bx_filter_input_checkbox">

									<span class="bx_filter_param_text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
									if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"]) && !$isSize):
										?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
									endif;?></span>
								</span>
							</label>
							<?$i++;?>
							<?$j++;?>
						<?endforeach;?>
						<?if($isHidden):?>
							</div>
							<div class="inner_expand_text"><span class="expand_block"><?=Loc::getMessage("FILTER_EXPAND_VALUES");?></span></div>
						<?endif;?>
				<?}?>
				</div>
				<div class="clb"></div>
			</div>
		</div>
	<?}?>
<?}?>

<?
function formatFilterProps($arItems, $arPropType, $arFormatProps){
	foreach($arItems as $key => $arItem)
	{
		if($arItem["VALUES"])
		{
			//price
			if(isset($arItem["PRICE"]))
			{
				if(($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0) || (!$arItem["VALUES"]["MAX"]["VALUE"] && !$arItem["VALUES"]["MIN"]["VALUE"]))
					unset($arItems[$key]);
			}
			else
			{
				if(count($arItem["VALUES"]) == 1)
				{
					if($arItem["CODE"] != "IN_STOCK" && $arItem["CODE"] != $arPropType["PROP_TYRE_RNF"]["VALUE"])
						unset($arItems[$key]);
				}
				else
				{

					if($arItem["VALUES"]["MAX"] && $arItem["VALUES"]["MIN"])
					{
						if(isset($arItem["VALUES"]["MIN"]["VALUE"]) && isset($arItem["VALUES"]["MAX"]["VALUE"]))
						{
							if($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
								unset($arItems[$key]);
						}
						else
							unset($arItems[$key]);
					}
					else
					{
						foreach($arItem["VALUES"] as $key2 => $arValue)
						{
							if($arFormatProps[$arItem["CODE"]]){
								if(preg_match('/^[-]*\d+[.]\d*$/', $arValue["VALUE"])){
									$arItems[$key]["VALUES"][$key2]['VALUE'] = (float)$arValue["VALUE"];
								}

								if($arValue["HTML_VALUE_ALT"] != ($tmpValue = crc32($arItems[$key]["VALUES"][$key2]['VALUE']))){
									$arItems[$key]["VALUES"][$key2]["CONTROL_ID"] = str_replace($arValue["HTML_VALUE_ALT"], $tmpValue, $arValue["CONTROL_ID"]);
								}
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_SPIKES"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_SPIKES_Y"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-spikes";
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_SPIKES"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_SPIKES_N"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-spikes-no";
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_SEASON"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_SUMMER"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-summer";
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_WINTER"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-winter";
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_ALL"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-allseason";
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_L"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_L_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_MC"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_MC_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_GR"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_GR_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_VND"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_VND_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_UN"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_UN_TITLE");
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_1"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_1_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_2"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_2_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_3"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_3_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_4"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_4_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_5"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_5_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_6"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_6_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_7"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_7_TITLE");
							}

							if($arItem["CODE"] == $arPropType["PROP_TYRE_ACHE_TYPE"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_1"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_1_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_2"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_2_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_3"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_3_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_4"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_4_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_5"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_5_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_6"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_6_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_7"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_7_TITLE");
							}

							if($arItem["CODE"] == $arPropType["PROP_DISK_TYPE"]["VALUE"])
							{
								if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_1"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_1_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_2"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_2_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_3"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_3_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_4"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_4_TITLE");
								if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_5"]["VALUE"])
									$arItems[$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_5_TITLE");
							}
						}
					}
				}
			}
		}
		else
			unset($arItems[$key]);

		if($arItem["CODE"]=="IN_STOCK" || $arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"])
		{
			if($arItems[$key]["VALUES"])
			{
				sort($arItems[$key]["VALUES"]);
				$arItems[$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];

				if($arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"])
				{
					$arItems[$key]["VALUES"][0]["EXT_CLASS"] = "icon-rnf";
				}
			}
		}
	}
	return $arItems;
}
?>