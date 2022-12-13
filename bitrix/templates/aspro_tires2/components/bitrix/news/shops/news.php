<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$arFilterValues = array(); //filter for item_type prop

$arItemsFilter = CTires2::GetIBlockAllElementsFilter($arParams);

$arProp = CIBlockProperty::GetList(array("id" => "asc"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "CODE" => "ITEM_TYPE"))->Fetch();
if($arProp && $arProp["PROPERTY_TYPE"] == "L"):
	$rsPropEnum = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE" => "ITEM_TYPE"));
	$arEnums = array();

	$arFilterValues = array(
		"LOGIC" => "OR",
	);

	while($arEnum = $rsPropEnum->Fetch())
	{
		$arEnums[$arEnum["ID"]] = array(
			"VALUE" => $arEnum["VALUE"],
			"XML_ID" => $arEnum["XML_ID"],
		);

		$arFilterValues[] = array(
			"PROPERTY_ITEM_TYPE" => $arEnum["ID"]
		);
	}
	$arAllItems = CTires2Cache::CIBlockElement_GetList(array('CACHE' => array("MULTI" =>"Y", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemsFilter, false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ITEM_TYPE"));

	if($arAllItems)
	{
		$arTmpProps = array();
		foreach($arAllItems as $arTmpItem)
		{
			if($arTmpItem['PROPERTY_ITEM_TYPE_ENUM_ID'])
			{
				if(is_array($arTmpItem['PROPERTY_ITEM_TYPE_ENUM_ID']))
				{
					foreach($arTmpItem['PROPERTY_ITEM_TYPE_ENUM_ID'] as $id)
					{
						$arTmpProps[$id] = $id;
					}
				}
				else
					$arTmpProps[$arTmpItem['PROPERTY_ITEM_TYPE_ENUM_ID']] = $arTmpItem['PROPERTY_ITEM_TYPE_ENUM_ID'];
			}
		}
		if($arTmpProps)
		{
			foreach($arEnums as $key => $arValueEnum)
			{
				if(!$arTmpProps[$key])
					unset($arEnums[$key]);
			}
		}
		else
		{
			$arEnums = array();
		}
	}
	else
	{
		$arEnums = array();
	}

	if($arEnums):?>
		<?$bHideFilter = (isset($_COOKIE['HIDE_FILTER_SHOPS']) && $_COOKIE['HIDE_FILTER_SHOPS'] == 'Y' ? true : false);?>
		<div class="wrapper_inner">
			<div class="top_filter_block type_item swipeignore<?=($bHideFilter ? ' closed' : '');?>"<?=($bHideFilter ? ' style="width:50px;"' : '');?>>
				<form<?=($bHideFilter ? ' style="display:none;"' : '')?>>
					<div class="bx_filter bx_filter_vertical">
						<div class="bx_filter_block">
							<?foreach($arEnums as $key => $arValue):?>
								<div class="bx_filter_parameters_box_container <?=$arValue["XML_ID"]?>">
									<input type="checkbox" value="<?=$key?>" checked="checked" name="item_type[<?=$arValue["XML_ID"];?>]" id="type_<?=$key?>">
									<label data-role="type_<?=$key?>" class="bx_filter_param_label" for="type_<?=$key?>">
										<span class="bx_filter_input_checkbox">
											<span class="bx_filter_param_text"><?=$arValue["VALUE"]?></span>
										</span>
									</label>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</form>
				<div class="filter_close">
					<svg class="close_icon" width="10" height="10.031" viewBox="0 0 10 10.031">
					<defs>
						<style>
						  .ccls-2 {
							fill-rule: evenodd;
							opacity: 0.5;
						  }
						</style>
					  </defs>
					  <path class="ccls-2" d="M1587.48,261l3.2,3.2a1.045,1.045,0,0,1-1.48,1.477l-3.2-3.2-3.23,3.233a1.046,1.046,0,0,1-1.48-1.478l3.23-3.233-3.23-3.232a1.046,1.046,0,0,1,1.48-1.479l3.23,3.234,3.2-3.2a1.045,1.045,0,0,1,1.48,1.477Z" transform="translate(-1581 -256)"/>
					</svg>
					<svg class="show_icon" width="20" height="20" viewBox="0 0 20 20">
					  <defs>
						<style>
						  .mcls-1 {
							fill: #666;
						  }

						  .mcls-1, .mcls-2 {
							fill-rule: evenodd;
						  }

						  .mcls-2 {
							fill: none;
							stroke: #666;
							stroke-linecap: round;
							stroke-linejoin: round;
							stroke-width: 2px;
						  }
						</style>
					  </defs>
					  <path id="Tune" class="mcls-1" d="M17,15.859V17a1,1,0,0,1-2,0V15.859a3.981,3.981,0,0,1,0-7.717V3a1,1,0,0,1,2,0V8.141A3.981,3.981,0,0,1,17,15.859ZM16,10a2,2,0,1,0,2,2A2,2,0,0,0,16,10Z"/>
					  <path id="Location_pin" data-name="Location pin" class="mcls-2" d="M10.216,13.964L7,17,2.51,12.758a6.47,6.47,0,0,1-1.5-3.928A5.909,5.909,0,0,1,7,3.006a6.007,6.007,0,0,1,5.391,3.282"/>
					  <path id="Location_pin-2" data-name="Location pin" class="mcls-1" d="M7,11.992A2.993,2.993,0,1,1,9.994,9,2.993,2.993,0,0,1,7,11.992ZM7,8.015A0.985,0.985,0,1,0,7.986,9,0.985,0.985,0,0,0,7,8.015Z"/>
					</svg>
				</div>
			</div>
		</div>
	<?endif;?>
<?endif;?>

<?$bPostRequset = ($request->isPost());

if(!($bMap = in_array('MAP', $arParams['LIST_PROPERTY_CODE'])))
{
	$itemsCnt = CTires2Cache::CIBlockElement_GetList(array('CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']))), $arItemsFilter, array());
}
else
{
	// get items & coordinates
	$arItems = CTires2Cache::CIBlockElement_GetList(array('CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'URL_TEMPLATE' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['detail'])), $arItemsFilter, false, false, array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_TEXT', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_EMAIL', 'PROPERTY_SCHEDULE', 'PROPERTY_METRO', 'PROPERTY_MAP', 'PROPERTY_ITEM_TYPE'));

	$itemsCnt = count($arItems);
}
?>

<div class="js_wrapper">
	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y')){
		$APPLICATION->RestartBuffer();?>
	<?}?>
<?
$arItemsID = array();
		
if($bPostRequset && $arItems){
	foreach($arItems as $key => $arItem){
		$bItemTypeInRequest = false;
		if($arItem['PROPERTY_ITEM_TYPE_VALUE']){
			if(is_array($arItem['PROPERTY_ITEM_TYPE_VALUE'])){
				foreach($arItem['PROPERTY_ITEM_TYPE_ENUM_ID'] as $enumID){
					if($request["item_type"] && in_array($enumID, $request["item_type"])){
						$bItemTypeInRequest = true;
						$arItemsID[] = $arItem['ID'];
						break;
					}
				}
			}
			else{
				if($request["item_type"] && in_array($arItem['PROPERTY_ITEM_TYPE_ENUM_ID'], $request["item_type"])){
					$bItemTypeInRequest = true;
					$arItemsID[] = $arItem['ID'];
				}
			}
			
			if(!$bItemTypeInRequest){
				unset($arItems[$key]);
				$itemsCnt--;
			}
		}
		else{
			$arItemsID[] = $arItem['ID'];
		}
	}
}
?>	
	<?if($bMap && $itemsCnt){
			foreach($arItems as $arItem){
				// element coordinates
				$arItem['GPS_S'] = $arItem['GPS_N'] = false;
				if($arStoreMap = explode(',', $arItem['PROPERTY_MAP_VALUE'])){
					$arItem['GPS_S'] = $arStoreMap[0];
					$arItem['GPS_N'] = $arStoreMap[1];
				}

				// use detail link?
				$bDetailLink = $arParams['SHOW_DETAIL_LINK'] !== 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

				$html = '';
				// element name
				if(in_array('NAME', $arParams['LIST_FIELD_CODE']) && strlen($arItem['NAME'])){
					$html .= '<div class="title">';
						if($bDetailLink){
							$html .= '<a class="dark-color" href="'.$arItem['DETAIL_PAGE_URL'].'">';
						}
						$html .= $arItem['NAME'];
						
						$bAddress = in_array('ADDRESS', $arParams['LIST_PROPERTY_CODE']) && ($arItem['PROPERTY_ADDRESS_VALUE'] || (!is_array($arItem['PROPERTY_ADDRESS_VALUE']) && strlen($arItem['PROPERTY_ADDRESS_VALUE'])));
						if($bAddress){
								$value = (is_array($arItem['PROPERTY_ADDRESS_VALUE']) ? implode('<br />', $arItem['PROPERTY_ADDRESS_VALUE']) : (strlen($arItem['PROPERTY_ADDRESS_VALUE']) ? $arItem['PROPERTY_ADDRESS_VALUE'] : ''));
								if($value){
									$html .= ((strlen($arItem['NAME']) && strlen($value)) ? ', ' : '').$value;
								}
							}

						if($bDetailLink){
							$html .= '</a>';
						}
					$html .= '</div>';
				}

				$html .= '<div class="info-content">';
					// element metro				
					$bMetro = in_array('METRO', $arParams['LIST_PROPERTY_CODE']) && ($arItem['PROPERTY_METRO_VALUE'] || (!is_array($arItem['PROPERTY_METRO_VALUE']) && strlen($arItem['PROPERTY_METRO_VALUE'])));
					if($bMetro){
						if($bMetro){
							$value = (is_array($arItem['PROPERTY_METRO_VALUE']) ? implode(', ', $arItem['PROPERTY_METRO_VALUE']) : (strlen($arItem['PROPERTY_METRO_VALUE']) ? $arItem['PROPERTY_METRO_VALUE'] : ''));
							if($value){
								$html .= '<div class="metro"><i></i>'.$value.'</div>';
							}
						}
					}

					// element schedule
					if(in_array('SCHEDULE', $arParams['LIST_PROPERTY_CODE']) && ($arItem['PROPERTY_SCHEDULE_VALUE'] || strlen($arItem['PROPERTY_SCHEDULE_VALUE']))){
						$html .= '<div class="schedule">'.$arItem['~PROPERTY_SCHEDULE_VALUE']['TEXT'].'</div>';
					}

					// element phone
					if(in_array('PHONE', $arParams['LIST_PROPERTY_CODE']) && ($arItem['PROPERTY_PHONE_VALUE'] || (!is_array($arItem['PROPERTY_PHONE_VALUE']) && strlen($arItem['PROPERTY_PHONE_VALUE'])))){
						if(is_array($arItem['PROPERTY_PHONE_VALUE'])){
							$values = array();
							foreach($arItem['PROPERTY_PHONE_VALUE'] as $value){
								$values[] = '<a href="tel:'.str_replace(array(' ', ',', '-', '(', ')'), '', $value).'">'.$value.'</a>';
							}
							$html .= '<div class="phone">'.implode('<br>', $values).'</div>';
						}
						elseif(strlen($arItem['PROPERTY_PHONE_VALUE'])){
							$html .= '<div class="phone"><a href="tel:'.str_replace(array(' ', ',', '-', '(', ')'), '', $arItem['PROPERTY_PHONE_VALUE']).'">'.$arItem['PROPERTY_PHONE_VALUE'].'</a></div>';
						}
					}

					// element email
					if(in_array('EMAIL', $arParams['LIST_PROPERTY_CODE']) && ($arItem['PROPERTY_EMAIL_VALUE'] || (!is_array($arItem['PROPERTY_EMAIL_VALUE']) && strlen($arItem['PROPERTY_EMAIL_VALUE'])))){
						if(is_array($arItem['PROPERTY_EMAIL_VALUE'])){
							$values = array();
							foreach($arItem['PROPERTY_EMAIL_VALUE'] as $value){
								$values[] = '<a class="dark-color" href="mailto:'.$value.'">'.$value.'</a>';
							}
							$html .= '<div class="email">'.implode(', ', $values).'</div>';
						}
						elseif(strlen($arItem['PROPERTY_EMAIL_VALUE'])){
							$html .= '<div class="email"><a class="dark-color" href="mailto:'.$arItem['PROPERTY_EMAIL_VALUE'].'">'.$arItem['PROPERTY_EMAIL_VALUE'].'</a></div>';
						}
					}
					
					// element type
					if($arItem['PROPERTY_ITEM_TYPE_VALUE']){
						$html .= '<div class="item_type">';
							if(is_array($arItem['PROPERTY_ITEM_TYPE_VALUE'])){
								$html .= implode(', ', $arItem['PROPERTY_ITEM_TYPE_VALUE']);
							}
							else{
								$html .= $arItem['PROPERTY_ITEM_TYPE_VALUE'];
							}
						$html .= '</div>';
					}
				$html .= '</div>';

				
				// add placemark to map
				if($arItem['GPS_S'] && $arItem['GPS_N']){
					$mapLAT += $arItem['GPS_S'];
					$mapLON += $arItem['GPS_N'];
					$arPlacemarks[] = array(
						"ID" => $arItem["ID"],
						"LAT" => $arItem['GPS_S'],
						"LON" => $arItem['GPS_N'],
						"TEXT" => $html,
					);
				}
			}
		}?>
		<?if($bMap):?>
			<div class="contacts_map">
				<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('shops-map-block');?>
					<?if($arParams["MAP_TYPE"] != "0"):?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:map.google.view",
							"map",
							array(
								"INIT_MAP_TYPE" => "ROADMAP",
								"MAP_DATA" => serialize(array("google_lat" => $mapLAT, "google_lon" => $mapLON, "google_scale" => 16, "PLACEMARKS" => $arPlacemarks)),
								"MAP_WIDTH" => "100%",
								"MAP_HEIGHT" => "400",
								"CONTROLS" => array(
								),
								"OPTIONS" => array(
									0 => "ENABLE_DBLCLICK_ZOOM",
									1 => "ENABLE_DRAGGING",
								),
								"MAP_ID" => "",
								"ZOOM_BLOCK" => array(
									"POSITION" => "right center",
								),
								"API_KEY" => $arParams["API_KEY"],
								"COMPONENT_TEMPLATE" => "map",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO"
							),
							false,
							array(
								"HIDE_ICONS" => "Y"
							)
						);?>
					<?else:?>
						<?
						if($arItems){
							$mapLAT = floatval($mapLAT / count($arItems));
							$mapLON = floatval($mapLON / count($arItems));
						}
						?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:map.yandex.view",
							"map",
							array(
								"INIT_MAP_TYPE" => "ROADMAP",
								"MAP_DATA" => serialize(array("yandex_lat" => $mapLAT, "yandex_lon" => $mapLON, "yandex_scale" => 17, "PLACEMARKS" => $arPlacemarks)),
								"MAP_WIDTH" => "100%",
								"MAP_HEIGHT" => "400",
								"CONTROLS" => array(
									0 => "ZOOM",
									1 => "SMALLZOOM",
									3 => "TYPECONTROL",
									4 => "SCALELINE",
								),
								"OPTIONS" => array(
									0 => "ENABLE_DBLCLICK_ZOOM",
									1 => "ENABLE_DRAGGING",
								),
								"MAP_ID" => "",
								"ZOOM_BLOCK" => array(
									"POSITION" => "right center",
								),
								"COMPONENT_TEMPLATE" => "map",
								"API_KEY" => $arParams["API_KEY"],
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO"
							),
							false, array("HIDE_ICONS" =>"Y")
						);?>
					<?endif;?>
				<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('shops-map-block', '');?>
			</div>		
	<?endif;?>
	<?if($itemsCnt):?>
		<?
		if($arItemsID){
			$GLOBALS[$arParams["FILTER_NAME"]]['ID'] = $arItemsID;
		}
		?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"shops",
			Array(
				"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
				"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
				"SORT_BY1"	=>	$arParams["SORT_BY1"],
				"SORT_ORDER1"	=>	$arParams["SORT_ORDER1"],
				"SORT_BY2"	=>	$arParams["SORT_BY2"],
				"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
				"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
				"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
				"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
				"SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"IBLOCK_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
				"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
				"SET_TITLE"	=>	"N",
				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
				"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
				"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
				"ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
				"CACHE_TYPE"	=>	'A', // for map!
				"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
				"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
				"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
				"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
				"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
				"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
				"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
				"DISPLAY_NAME"	=>	"Y",
				"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
				"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
				"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
				"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
				"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
				"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
				"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
				"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
				"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
			),
			$component
		);?>
	<?else:?>
		<div class="wrapper_inner">
			<div class="alert alert-warning"><?=GetMessage("NOT_FOUND_ITEMS")?></div>
		</div>
	<?endif;?>
	<?CTires2::checkRestartBuffer();?>
</div>