<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$arFilterValues = array(); //filter for item_type prop

$arProp = CUserTypeEntity::GetList(array($by=>$order), array("ENTITY_ID" => "CAT_STORE", "FIELD_NAME" => "UF_ITEM_TYPE"))->Fetch();
if($arProp && $arProp["USER_TYPE_ID"] == "enumeration"):
	$rsPropEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $arProp["ID"]));
	$arEnums = array();

	$arFilterValues = array(
		"LOGIC" => "OR",
	);

	while($arEnum = $rsPropEnum->Fetch())
	{
		$arEnums[$arEnum["ID"]] = array(
			"VALUE" => $arEnum["VALUE"],
			"XML_ID" => $arEnum["XML_ID"]
		);

		$arFilterValues[] = array(
			"UF_ITEM_TYPE" => $arEnum["ID"]
		);
	}
	
	$arItemsFilter = CTires2::GetIBlockAllElementsFilter($arParams);
	$arItems = $arItemsID = array();

	$dbRes = CCatalogStore::GetList(array('ID' => 'ASC'), $arItemsFilter, false, false, array("ID", "SORT", "UF_ITEM_TYPE"));
	while($arRes = $dbRes->Fetch()){
		$arRes['UF_ITEM_TYPE'] = unserialize($arRes['UF_ITEM_TYPE']);
		$arItems[] = $arRes;
	}

	if($arItems)
	{
		$arTmpProps = array();
		foreach($arItems as $key => $arItem)
		{
			if($arItem['UF_ITEM_TYPE'])
			{
				if(is_array($arItem['UF_ITEM_TYPE']))
				{
					foreach($arItem['UF_ITEM_TYPE'] as $enumID)
					{
						$arTmpProps[$enumID] = $enumID;
					}
					
				}
				else
				{
					$arTmpProps[$arItem['UF_ITEM_TYPE']] = $arItem['UF_ITEM_TYPE'];
				}
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
		<?
		$bHideFilter = (isset($_COOKIE['HIDE_FILTER_SHOPS']) && $_COOKIE['HIDE_FILTER_SHOPS'] == 'Y' ? true : false);
		?>
	
		<div class="wrapper_inner">
			<div class="top_filter_block type_item swipeignore<?=($bHideFilter ? ' closed' : '');?>"<?=($bHideFilter ? ' style="width:50px;"' : '');?>>
				<form<?=($bHideFilter ? ' style="display:none;"' : '')?>>
					<div class="bx_filter bx_filter_vertical">
						<div class="bx_filter_block">
							<?foreach($arEnums as $key => $arValue):?>
								<div class="bx_filter_parameters_box_container <?=$arValue["XML_ID"]?>">
									<input type="checkbox" value="<?=$key?>" checked="checked" name="item_type[]" id="type_<?=$key?>">
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

/*if($bPostRequset)
{*/
	if($request["item_type"])
	{
		$arFilterValues = array(
			"LOGIC" => "OR",
		);
		foreach($request["item_type"] as $value)
		{
			$arFilterValues[] = array(
				"UF_ITEM_TYPE" => $value
			);
		}
	}
//}?>

<?
if($arFilterValues)
	$GLOBALS[$arParams["FILTER_NAME"]][] = $arFilterValues;?>
<?
$itemsCnt = 1;
/*if($bPostRequset && !$request["item_type"])
	$itemsCnt = 0;*/
?>
<div class="js_wrapper">
	<?if((isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") || (strtolower($_REQUEST['ajax']) == 'y')){
		$APPLICATION->RestartBuffer();?>
	<?}?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.store.list",
		"main",
		Array(
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"PHONE" => $arParams["PHONE"],
			"SCHEDULE" => $arParams["SCHEDULE"],
			"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
			"TITLE" => $arParams["TITLE"],
			"FILTER_NAME" => $arParams['FILTER_NAME'],
			"SET_TITLE" => "N",
			"PATH_TO_ELEMENT" => $arResult["PATH_TO_ELEMENT"],
			"PATH_TO_LISTSTORES" => $arResult["PATH_TO_LISTSTORES"],
			"MAP_TYPE" => $arParams["MAP_TYPE"],
			"GOOGLE_API_KEY" => $arParams["GOOGLE_API_KEY"],
		),
		$component
	);?>
	<?CTires2::checkRestartBuffer();?>
</div>