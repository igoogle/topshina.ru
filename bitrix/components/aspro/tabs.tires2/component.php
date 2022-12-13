<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?\Bitrix\Main\Loader::includeModule('iblock');
$arTabs = $arShowProp = array();
global $USER;

$arResult["SHOW_SLIDER_PROP"] = false;
if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
{
	$arrFilter = array();
}
else
{
	$arrFilter = $GLOBALS[$arParams["FILTER_NAME"]];
	if(!is_array($arrFilter))
		$arrFilter = array();
}

$arParams['IBLOCK_IDS'] = $arIBlocks = array(
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_tires"][0]),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0]),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0]),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_EXPENDABLES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_expandables"][0]),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_MOTO_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_moto_tires"][0]),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TRUCK_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_truck_tires"][0]),
);

$arFilter = array("ACTIVE" => "Y", "ACTIVE_DATE" => "Y", "IBLOCK_ID" => $arIBlocks, "IBLOCK_ACTIVE" => "Y", "SECTION_GLOBAL_ACTIVE" => "Y");
if($arParams["SECTION_ID"])
	$arFilter[]=array("SECTION_ID" => $arParams["SECTION_ID"], "INCLUDE_SUBSECTIONS" => "Y");
elseif($arParams["SECTION_CODE"])
	$arFilter[]=array("SECTION_CODE" => $arParams["SECTION_CODE"], "INCLUDE_SUBSECTIONS" => "Y");

global $arTheme, $isShowCatalogElements;
$bCatalogIndex = $isShowCatalogElements;

$arParams["USE_PERMISSIONS"] = $arParams["USE_PERMISSIONS"]=="Y";
if(!is_array($arParams["GROUP_PERMISSIONS"]))
	$arParams["GROUP_PERMISSIONS"] = array(1);

$bUSER_HAVE_ACCESS = !$arParams["USE_PERMISSIONS"];
if($arParams["USE_PERMISSIONS"] && isset($GLOBALS["USER"]) && is_object($GLOBALS["USER"]))
{
	$arUserGroupArray = $USER->GetUserGroupArray();
	foreach($arParams["GROUP_PERMISSIONS"] as $PERM)
	{
		if(in_array($PERM, $arUserGroupArray))
		{
			$bUSER_HAVE_ACCESS = true;
			break;
		}
	}
}

if($bCatalogIndex)
{
	$arShowProp = CTires2Cache::CIBlockPropertyEnum_GetList(Array("sort" => "asc", "id" => "desc", "CACHE" => array("TAG" => CTires2Cache::GetPropertyCacheTag($arParams["TABS_CODE"]))), Array("ACTIVE" => "Y", "IBLOCK_ID" => $arIBlocks, "CODE" => $arParams["TABS_CODE"]));

	if($arShowProp)
	{
		if($arParams['STORES'])
		{
			foreach($arParams['STORES'] as $key => $store)
			{
				if(!$store)
					unset($arParams['STORES'][$key]);
			}
		}
		global $arRegion;
		$arFilterStores = array();
		if ($arRegion) {
			$arParams['USE_REGION'] = 'Y';
			if ($arRegion['LIST_PRICES']) {
				if (reset($arRegion['LIST_PRICES']) != 'component') {
					$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
					$arParams['~PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
				}
			}
			if ($arRegion['LIST_STORES']) {
				if (reset($arRegion['LIST_STORES']) != 'component') {
					$arParams['STORES'] = $arRegion['LIST_STORES'];
					$arParams['~STORES'] = $arRegion['LIST_STORES'];
				}

				if ($arParams["HIDE_NOT_AVAILABLE"] == "Y") {
					if (CTires2::checkVersionModule('18.6.200', 'iblock')) {
						$arTmpFilter[]['STORE_NUMBER'] = $arParams['STORES'];
						$arTmpFilter[]['>STORE_AMOUNT'] = 0;
					} else {
						$arTmpFilter["LOGIC"] = "OR";
						foreach($arParams['STORES'] as $storeID)
						{
							$arTmpFilter[] = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
						}
					}
					$arFilterStores[] = $arTmpFilter;
				}
			}
		} else {
			if ($arParams["HIDE_NOT_AVAILABLE"] == "Y") {
				if (CTires2::checkVersionModule('18.6.200', 'iblock')) {
					$arFilterStores["=AVAILABLE"] = "Y";
				} else {
					$arFilterStores["CATALOG_AVAILABLE"] = "Y";
				}
			}
		}
		
		foreach($arShowProp as $key => $prop)
		{
			$arItems = array();
			$arFilterProp = array("PROPERTY_".$arParams["TABS_CODE"]."_VALUE" => array($prop));

			$arItems = CTires2Cache::CIBLockElement_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => CTires2Cache::GetIBlockCacheTag($arIBlocks))), array_merge($arFilter, $arrFilter, $arFilterProp, $arFilterStores), false, array("nTopCount" => 1), array("ID", "IBLOCK_ID"));
			if($arItems)
			{
				$arTabs[$key] = array(
					"TITLE" => $prop,
					"FILTER" => array_merge($arFilterProp, $arFilter, $arrFilter, $arFilterStores)
				);
				$arResult["SHOW_SLIDER_PROP"] = true;
			}
		}
	}
	else
	{
		return;
	}
	$arParams["PROP_CODE"] = $arParams["TABS_CODE"];
	$arResult["TABS"] = $arTabs;

	$this->IncludeComponentTemplate();
}
else
	return;?>