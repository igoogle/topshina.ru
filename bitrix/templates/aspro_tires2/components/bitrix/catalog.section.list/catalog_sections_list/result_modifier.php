<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Type\Collection,
	Bitrix\Main\Localization\Loc;

if (!empty($arResult['SECTIONS']))
{

	if ('Y' == $arParams['CONVERT_CURRENCY'])
	{
		if (!CModule::IncludeModule('currency'))
		{
			$arParams['CONVERT_CURRENCY'] = 'N';
			$arParams['CURRENCY_ID'] = '';
		}
	}
	
	$arNewItemsList = array();
	$arResult["SUMM_RATING"] = 0;

	global $arTheme, $arRegion;

	$propSezon = $propSpike = "";

	$propSezonName = "PROP_TYRE_SEASON";
	$propSpikeName = "PROP_TYRE_SPIKES";

	$propTyreSezonnost = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName, "SEZONNOST");
	$propTyreSpikes = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSpikeName, "SHIPY");
	$tyreIBlockID = \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_tires"][0]);
	$propMotoTyreSezonnost = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName."_MOTO", "SEZONNOST");
	$propMotoTyreSpikes = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSpikeName."_MOTO", "SHIPY");
	$mototyreIBlockID = \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_MOTO_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_moto_tires"][0]);
	$propTruckTyreSezonnost = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName."_TRUCK", "SEZONNOST");
	$propTruckTyreSpikes = \Bitrix\Main\Config\Option::get("aspro.tires2", $propSpikeName."_TRUCK", "SHIPY");
	$trucktyreIBlockID = \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TRUCK_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_truck_tires"][0]);

	$wheelsIBlockID = \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0]);
	$akbIBlockID = \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0]);

	$arResult["TITLES"] = array(
		"TOP" => Loc::getMessage("SECTIONS_MODEL_ITEM"),
		"ALL" => Loc::getMessage("SECTIONS_ALL_ITEM")
	);

	if($arParams["IBLOCK_ID"] == $tyreIBlockID)
	{
		$propSezon = $propTyreSezonnost;
		$propSpike = $propTyreSpikes;
	}
	elseif($arParams["IBLOCK_ID"] == $mototyreIBlockID)
	{
		$propSezon = $propMotoTyreSezonnost;
		$propSpike = $propMotoTyreSpikes;
		$propSezonName .= "_MOTO";
		$propSpikeName .= "_MOTO";
	}
	elseif($arParams["IBLOCK_ID"] == $trucktyreIBlockID)
	{
		$propSezon = $propTruckTyreSezonnost;
		$propSpike = $propTruckTyreSpikes;
		$propSezonName .= "_TRUCK";
		$propSpikeName .= "_TRUCK";
	}
	elseif($arParams["IBLOCK_ID"] == $wheelsIBlockID)
	{

		$arResult["TITLES"] = array(
			"TOP" => Loc::getMessage("SECTIONS_MODELD_ITEM"),
			"ALL" => Loc::getMessage("SECTIONS_ALLD_ITEM")
		);
	}
	elseif($arParams["IBLOCK_ID"] == $akbIBlockID)
	{

		$arResult["TITLES"] = array(
			"TOP" => Loc::getMessage("SECTIONS_MODELA_ITEM"),
			"ALL" => Loc::getMessage("SECTIONS_ALLA_ITEM")
		);
	}
	
	$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");
	$arSections = $arTmpStickers = $arResult["SECTION_STICKERS"] = array();

	\Bitrix\Main\Type\Collection::sortByColumn($arResult["SECTIONS"], array("SORT" => SORT_ASC, "NAME" => array(SORT_NATURAL | SORT_FLAG_CASE, SORT_ASC)));

	foreach($arResult["SECTIONS"] as $key => $arSection)
		$arSections[$arSection["ID"]] = $arSection;

	$arResult["SECTIONS"] = $arSections;
	unset($arSections);

	if($arParams["AJAX_FILTER_ITEM"] != "N")
	{

		$arResult["COUNTS_ALL_SECTIONS"] = count($arResult["SECTIONS"]);
		if($arResult["COUNTS_ALL_SECTIONS"] > 1)
		{
			$arResult["SECTIONS"] = array_values($arResult["SECTIONS"]); //reset keys
			$arSection=array();

			$arParams["PAGE"] = ($arParams["PAGE"]!='' ? $arParams["PAGE"] : 1);
			$page = (int)abs($arParams["PAGE"]);
			$count=ceil($arResult["COUNTS_ALL_SECTIONS"]/$arParams["SECTION_PAGE_ELEMENT"]);
			$page = ($page > $count ? 1 : $page);
			$limit = $arResult["COUNTS_ALL_SECTIONS"] < $page * $arParams["SECTION_PAGE_ELEMENT"] ? $arResult["COUNTS_ALL_SECTIONS"] : $page * $arParams["SECTION_PAGE_ELEMENT"];
			$arResult["PAGE"] = $page;

			for($i = ($page - 1) * $arParams["SECTION_PAGE_ELEMENT"]; $i < $limit; $i++)
				$arSection[] = $arResult["SECTIONS"][$i];

			$arResult["SECTIONS"] = array();
			foreach($arSection as $arValue)
			{
				$arResult["SECTIONS"][$arValue["ID"]] = $arValue;
			}
		}
	}

	$arSezonProps = array();
	$arFilter = array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "SECTION_ID" => array_keys($arResult["SECTIONS"]), "INCLUDE_SUBSECTIONS" => "Y");

	if ($arParams["HIDE_NOT_AVAILABLE"] == "Y") {
		if ($arRegion) {
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
			if ($arTmpFilter) {
				$arFilter[] = $arTmpFilter;
			}
		} else {
			$arFilter['CATALOG_AVAILABLE'] = 'Y';
		}
	}

	/* get items */
	$arItems = CTires2Cache::CIBLockElement_GetList(array("CACHE" => array("MULTI" =>"Y", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arFilter, false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "PROPERTY_".$prop, "PROPERTY_".$propSezon, "PROPERTY_".$propSpike, "PROPERTY_vote_count", "PROPERTY_vote_sum"));

	if($arItems)
	{
		foreach($arItems as $arItem)
		{
			/* get item price */
			$arPriceList = \Aspro\Functions\CAsproTires2::getPriceList($arItem["ID"], $arParams["PRICE_CODE"], 1, true);
			$arPricesID = array();
			if($arPriceList)
			{
				foreach($arPriceList as $arPriceTmp)
					$arPricesID[] = $arPriceTmp["CATALOG_GROUP_ID"];
			}
			if($arPricesID)
			{
				global $USER;
				$arPrice = CCatalogProduct::GetOptimalPrice($arItem["ID"], 1, $USER->GetUserGroupArray(), 'N', $arPriceList);
				if($arPrice["RESULT_PRICE"])
				{
					$price = $arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"];
					$arFormatPrice = $arPrice["RESULT_PRICE"];
					if($arParams["CONVERT_CURRENCY"] != "Y" && $arPrice["RESULT_PRICE"]["CURRENCY"] != $arPrice["PRICE"]["CURRENCY"])
					{
						$price = roundEx(CCurrencyRates::ConvertCurrency($arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"], $arPrice["RESULT_PRICE"]["CURRENCY"], $arPrice["PRICE"]["CURRENCY"]),CATALOG_VALUE_PRECISION);
						$arFormatPrice = $arPrice["PRICE"];
						$arFormatPrice["DISCOUNT_PRICE"] = $price;
					}

					if (!$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["MIN_PRICE"] && $arFormatPrice["BASE_PRICE"] > 0) {
						$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["MIN_PRICE"] = $arFormatPrice;
					} else {
						$comparePrice = $price;
						if ($arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["MIN_PRICE"]["DISCOUNT_PRICE"] > $comparePrice && $comparePrice > 0) {
							// $minPrice = $comparePrice;
							$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["MIN_PRICE"] = $arFormatPrice;
						}
					}
				}
			}
			/**/

			/* quantity */
			if(!$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["TOTAL_QUANTITY_COUNT"])
				$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["TOTAL_QUANTITY_COUNT"] = 0;
			if($arParams["STORES"])
			{
				if(class_exists("\Bitrix\Catalog\StoreProductTable") && method_exists("\Bitrix\Catalog\StoreProductTable", "getList"))
				{
					$rsStoreProducts = \Bitrix\Catalog\StoreProductTable::getList(
						array(
							"filter" => array(
								"STORE_ID" => $arParams["STORES"],
								"PRODUCT_ID" => $arItem["ID"],
							),
							"select" => array("AMOUNT")
						)
					);
				}
				else
				{
					$rsStoreProducts = CCatalogStoreProduct::GetList(
						array(),
						array(
							"PRODUCT_ID" => $arItem["ID"],
							"STORE_ID" => $arParams["STORES"]
						),
						false,
						false,
						array("AMOUNT")
					);
				}
				while($arStoreProduct = $rsStoreProducts->fetch())
					$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["TOTAL_QUANTITY_COUNT"] += $arStoreProduct["AMOUNT"];
			}
			else
			{
				$arProduct = \Bitrix\Catalog\ProductTable::getList(array(
					"filter" => array(
						"=ID" => $arItem["ID"]
					),
					"select" => array("QUANTITY")
				))->fetch();
				$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["TOTAL_QUANTITY_COUNT"] += $arProduct["QUANTITY"];
			}
			/**/

			/* rating */
			if ((int)$arItem['PROPERTY_VOTE_COUNT_VALUE']) {
				$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SUMM_RATING"] += ($arItem['PROPERTY_VOTE_SUM_VALUE'] / $arItem['PROPERTY_VOTE_COUNT_VALUE']);
				++$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["ITEMS_COUNT"];
			}
			/**/

			/* hit prop */
			if($arItem["PROPERTY_".$prop."_VALUE"])
			{
				if(is_array($arItem["PROPERTY_".$prop."_VALUE"]))
				{
					sort($arItem["PROPERTY_".$prop."_VALUE"] );
					foreach($arItem["PROPERTY_".$prop."_VALUE"] as $value)
					{
						$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["STICKERS"][$value] =array(
							"CLASS" => 'sticker_'.CUtil::translit($value, 'ru'),
							"VALUE" => $value,
						);
					}
				}
				else
				{
					$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["STICKERS"][$arItem["PROPERTY_".$prop."_VALUE"]] =array(
						"CLASS" => 'sticker_'.CUtil::translit($arItem["PROPERTY_".$prop."_VALUE"], 'ru'),
						"VALUE" => $arItem["PROPERTY_".$prop."_VALUE"],
					);
				}
			}
			/**/

			/* spike prop*/
			if($arItem["PROPERTY_".$propSpike."_VALUE"])
			{
				switch($arItem["PROPERTY_".$propSpike."_VALUE"])
				{
					case \Bitrix\Main\Config\Option::get("aspro.tires2", $propSpikeName."_Y", Loc::getMessage("PROP_TYRE_SPIKES_Y_VALUE")):
						$class = "icon-spikes";
						break;
					case \Bitrix\Main\Config\Option::get("aspro.tires2", $propSpikeName."_N", Loc::getMessage("PROP_TYRE_SPIKES_N_VALUE")):
						$class = "icon-wthspikes";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SEZON_PROPS"]["SPIKES"][$arItem["PROPERTY_".$propSpike."_VALUE"]] = array(
					"ID" => $arItem["PROPERTY_".$propSpike."_VALUE"],
					"VALUE" => $arItem["PROPERTY_".$propSpike."_VALUE"],
				);
				$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SEZON_PROPS"]["SPIKES"][$arItem["PROPERTY_".$propSpike."_VALUE"]] = array(
					"ID" => $arItem["PROPERTY_".$propSpike."_VALUE"],
					"CLASS" => $class,
					"VALUE" => $arItem["PROPERTY_".$propSpike."_VALUE"]
				);
			}
			/**/

			/* sezon prop */
			if($arItem["PROPERTY_".$propSezon."_VALUE"])
			{
				$arResult["SEZON_PROPS"]["SEZON"][$arItem["PROPERTY_".$propSezon."_VALUE"]] = array(
					"ID" => $arItem["PROPERTY_".$propSezon."_VALUE"],
					"VALUE" => $arItem["PROPERTY_".$propSezon."_VALUE"],
				);
				switch($arItem["PROPERTY_".$propSezon."_VALUE"])
				{
					case \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName."_SUMMER", Loc::getMessage("PROP_TYRE_SEASON_SUMMER_VALUE")):
						$class = "icon-summer";
						break;
					case \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName."_WINTER", Loc::getMessage("PROP_TYRE_SEASON_WINTER_VALUE")):
						$class = "icon-winter";
						break;
					case \Bitrix\Main\Config\Option::get("aspro.tires2", $propSezonName."_ALL", Loc::getMessage("PROP_TYRE_SEASON_ALL_VALUE")):
						$class = "icon-allseason";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SEZON_PROPS"]["SEZON"][$arItem["PROPERTY_".$propSezon."_VALUE"]] = array(
					"ID" => $arItem["PROPERTY_".$propSezon."_VALUE"],
					"CLASS" => $class,
					"VALUE" => $arItem["PROPERTY_".$propSezon."_VALUE"]
				);
			}
			/**/
			$arResult["SECTIONS"][$arItem["IBLOCK_SECTION_ID"]]["SHOW_DATA_CONDITION"] = false;
		}
	}
	unset($arItems);
	/**/

	$arParams["FILTER_PROP"] = $GLOBALS["APPLICATION"]->ConvertCharset($arParams["FILTER_PROP"], 'UTF-8', SITE_CHARSET);
	if($arParams["FILTER_PROP"] && $arParams["TYPE_FILTER"] && $arResult["SEZON_PROPS"])
	{
		foreach($arResult["SECTIONS"] as $key => $arSection)
		{
			if(!$arSection["SEZON_PROPS"] || !$arSection["SEZON_PROPS"][$arParams["TYPE_FILTER"]] || ($arSection["SEZON_PROPS"][$arParams["TYPE_FILTER"]] && !$arSection["SEZON_PROPS"][$arParams["TYPE_FILTER"]][$arParams["FILTER_PROP"]]))
				unset($arResult["SECTIONS"][$key]);
		}
	}

	if($arParams["AJAX_FILTER_ITEM"] != "Y")
	{
		foreach($arResult["SECTIONS"] as $key => $arSection)
		{
			$arTmpValues = array();
			if($arSection["SEZON_PROPS"])
			{
				foreach($arSection["SEZON_PROPS"] as $arGroup)
				{
					foreach($arGroup as $arValue)
						$arTmpValues[$arValue["ID"]] = $arValue["ID"];
				}
			}
			if($arTmpValues)
				$arResult["SECTIONS"][$key]["SHOW_DATA_CONDITION"] = implode(" ", $arTmpValues);
		}
	}

}?>