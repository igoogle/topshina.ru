<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TYPE_SKU' => 'N',
	'OFFER_TREE_PROPS' => array('-'),
);

$arParams = array_merge($arDefaultParams, $arParams);

if ('TYPE_2' != $arParams['TYPE_SKU'] )
	$arParams['TYPE_SKU'] = 'N';

if ('TYPE_2' == $arParams['TYPE_SKU'] && $arParams['DISPLAY_TYPE'] !='table' ){
	if (!is_array($arParams['OFFER_TREE_PROPS']))
		$arParams['OFFER_TREE_PROPS'] = array($arParams['OFFER_TREE_PROPS']);
	foreach ($arParams['OFFER_TREE_PROPS'] as $key => $value)
	{
		$value = (string)$value;
		if ('' == $value || '-' == $value)
			unset($arParams['OFFER_TREE_PROPS'][$key]);
	}
	if (empty($arParams['OFFER_TREE_PROPS']) && isset($arParams['OFFERS_CART_PROPERTIES']) && is_array($arParams['OFFERS_CART_PROPERTIES']))
	{
		$arParams['OFFER_TREE_PROPS'] = $arParams['OFFERS_CART_PROPERTIES'];
		foreach ($arParams['OFFER_TREE_PROPS'] as $key => $value)
		{
			$value = (string)$value;
			if ('' == $value || '-' == $value)
				unset($arParams['OFFER_TREE_PROPS'][$key]);
		}
	}
}else{
	$arParams['OFFER_TREE_PROPS'] = array();
}


if (!empty($arResult['ITEMS'])){
	$arConvertParams = array();
	if ('Y' == $arParams['CONVERT_CURRENCY'])
	{
		if (!CModule::IncludeModule('currency'))
		{
			$arParams['CONVERT_CURRENCY'] = 'N';
			$arParams['CURRENCY_ID'] = '';
		}
		else
		{
			$arResultModules['currency'] = true;
			if($arResult['CURRENCY_ID'])
			{
				$arConvertParams['CURRENCY_ID'] = $arResult['CURRENCY_ID'];
			}
			else
			{
				$arCurrencyInfo = CCurrency::GetByID($arParams['CURRENCY_ID']);
				if (!(is_array($arCurrencyInfo) && !empty($arCurrencyInfo)))
				{
					$arParams['CONVERT_CURRENCY'] = 'N';
					$arParams['CURRENCY_ID'] = '';
				}
				else
				{
					$arParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
					$arConvertParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
				}
			}
		}
	}

	$arEmptyPreview = false;
	$strEmptyPreview = $this->GetFolder().'/images/no_photo.png';
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview))
	{
		$arSizes = getimagesize($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview);
		if (!empty($arSizes))
		{
			$arEmptyPreview = array(
				'SRC' => $strEmptyPreview,
				'WIDTH' => intval($arSizes[0]),
				'HEIGHT' => intval($arSizes[1])
			);
		}
		unset($arSizes);
	}
	unset($strEmptyPreview);

	$arSKUPropList = array();
	$arSKUPropIDs = array();
	$arSKUPropKeys = array();
	$boolSKU = false;
	$strBaseCurrency = '';
	$boolConvert = isset($arResult['CONVERT_CURRENCY']['CURRENCY_ID']);
	if (!$boolConvert)
		$strBaseCurrency = CCurrency::GetBaseCurrency();


	$arNewItemsList = array();
	$arResult["SUMM_RATING"] = 0;

	global $arTheme;

	$prop = ($arParams["STIKERS_PROP"] ? $arParams["STIKERS_PROP"] : "HIT");
	$arTmpStickers = $arResult["SECTION_STICKERS"] = array();

	$arFormatProps = \Aspro\Functions\CAsproTires2::getFormatedProps();

	foreach ($arResult['ITEMS'] as $key => $arItem)
	{

		$arTmpStickers[] = CTires2::GetItemStickers($arItem["PROPERTIES"][$prop]);

		/* remove .000 from value */
		foreach($arFormatProps as $codeProp)
		{
			if($arItem["PROPERTIES"][$codeProp]["VALUE"])
			{
				if(!ctype_digit($arItem["PROPERTIES"][$codeProp]["VALUE"])){
					$arItem["PROPERTIES"][$codeProp]["VALUE"] = rtrim(rtrim($arItem["PROPERTIES"][$codeProp]["VALUE"], '0'), '.');
				}
			}
		}
		/**/

		$arItem['CHECK_QUANTITY'] = false;
		if (!isset($arItem['CATALOG_MEASURE_RATIO']))
			$arItem['CATALOG_MEASURE_RATIO'] = 1;
		if (!isset($arItem['CATALOG_QUANTITY']))
			$arItem['CATALOG_QUANTITY'] = 0;
		$arItem['CATALOG_QUANTITY'] = (
			0 < $arItem['CATALOG_QUANTITY'] && is_float($arItem['CATALOG_MEASURE_RATIO'])
			? floatval($arItem['CATALOG_QUANTITY'])
			: intval($arItem['CATALOG_QUANTITY'])
		);
		$arItem['CATALOG'] = false;
		if (!isset($arItem['CATALOG_SUBSCRIPTION']) || 'Y' != $arItem['CATALOG_SUBSCRIPTION'])
			$arItem['CATALOG_SUBSCRIPTION'] = 'N';

		if ($arResult['MODULES']['catalog'])
		{
			$arItem['CATALOG'] = true;
			if (!isset($arItem['CATALOG_TYPE']))
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_PRODUCT;
			if (
				(CCatalogProduct::TYPE_PRODUCT == $arItem['CATALOG_TYPE'] || CCatalogProduct::TYPE_SKU == $arItem['CATALOG_TYPE'])
				&& !empty($arItem['OFFERS'])
			)
			{
				$arItem['CATALOG_TYPE'] = CCatalogProduct::TYPE_SKU;
			}
			switch ($arItem['CATALOG_TYPE'])
			{
				case CCatalogProduct::TYPE_SET:
					$arItem['OFFERS'] = array();
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
				case CCatalogProduct::TYPE_SKU:
					break;
				case CCatalogProduct::TYPE_PRODUCT:
				default:
					$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
					break;
			}
		}
		else
		{
			$arItem['CATALOG_TYPE'] = 0;
			$arItem['OFFERS'] = array();
		}

		if ($arItem['CATALOG'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			//set min price when USE_PRICE_COUNT
			if($arParams['USE_PRICE_COUNT'] == 'Y')
			{
				foreach($arItem['OFFERS'] as $keyOffer => $arOffer)
				{
					//format prices when USE_PRICE_COUNT
					if(function_exists('CatalogGetPriceTableEx') && (isset($arOffer['PRICE_MATRIX'])) && !$arOffer['PRICE_MATRIX'])
					{
						$arPriceTypeID = array();
						if($arOffer['PRICES'])
						{
							foreach($arOffer['PRICES'] as $priceKey => $arOfferPrice)
							{
								if($arOffer['CATALOG_GROUP_NAME_'.$arOfferPrice['PRICE_ID']])
								{
									$arPriceTypeID[] = $arOfferPrice['PRICE_ID'];
									$arOffer['PRICES'][$priceKey]['GROUP_NAME'] = $arOffer['CATALOG_GROUP_NAME_'.$arOfferPrice['PRICE_ID']];
								}
							}
						}
						$arOffer["PRICE_MATRIX"] = CatalogGetPriceTableEx($arOffer["ID"], 0, $arPriceTypeID, 'Y', $arConvertParams);
						if(count($arOffer['PRICE_MATRIX']['ROWS']) <= 1)
						{
							$arOffer['PRICE_MATRIX'] = '';
						}
					}
					$arItem['OFFERS'][$keyOffer] = array_merge($arOffer, CTires2::formatPriceMatrix($arOffer));
				}
			}

			$arItem['MIN_PRICE'] = CTires2::getMinPriceFromOffersExt(
				$arItem['OFFERS'],
				$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency
			);
		}
		if (
			$arResult['MODULES']['catalog']
			&& $arItem['CATALOG']
			&&
				($arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_PRODUCT
				|| $arItem['CATALOG_TYPE'] == CCatalogProduct::TYPE_SET)
		)
		{
			CIBlockPriceTools::setRatioMinPrice($arItem, false);
			$arItem['MIN_BASIS_PRICE'] = $arItem['MIN_PRICE'];
		}

		if (!empty($arItem['DISPLAY_PROPERTIES']))
		{
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp)
			{
				if ('F' == $arDispProp['PROPERTY_TYPE'])
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
			}
		}

		//set min price when USE_PRICE_COUNT
		if($arParams['USE_PRICE_COUNT'] == 'Y' && !$arItem['OFFERS'])
		{
			$arItem["FIX_PRICE_MATRIX"] = CTires2::checkPriceRangeExt($arItem);
		}

		//format prices when USE_PRICE_COUNT
		$arItem = array_merge($arItem, CTires2::formatPriceMatrix($arItem));

		$propGroup = '';
		if($arItem["IBLOCK_ID"] == $arTheme["CATALOG_TIRES_IBLOCK_ID"]["VALUE"])
		{
			$propGroup = ($arTheme["PROP_TYRE_POSADOCHNYY_DIAMETR"]["VALUE"] && isset($arItem["PROPERTIES"][$arTheme["PROP_TYRE_POSADOCHNYY_DIAMETR"]["VALUE"]]) ? $arTheme["PROP_TYRE_POSADOCHNYY_DIAMETR"]["VALUE"] : "");
			$arItem["SIZE"] = $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SHIRINA_PROFILYA"]["VALUE"]]["VALUE"]."/".$arItem["PROPERTIES"][$arTheme["PROP_TYRE_VYSOTA_PROFILYA"]["VALUE"]]["VALUE"]." R".$arItem["PROPERTIES"][$propGroup]["VALUE"];

			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SEASON_SUMMER"]["VALUE"]:
						$class = "icon-summer";
						break;
					case $arTheme["PROP_TYRE_SEASON_WINTER"]["VALUE"]:
						$class = "icon-winter";
						break;
					case $arTheme["PROP_TYRE_SEASON_ALL"]["VALUE"]:
						$class = "icon-allseason";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON"]["VALUE"]]["VALUE"]
					);
			}
			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SPIKES_Y"]["VALUE"]:
						$class = "icon-spikes";
						break;
					case $arTheme["PROP_TYRE_SPIKES_N"]["VALUE"]:
						$class = "icon-wthspikes";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES"]["VALUE"]]["VALUE"]
					);
			}
		}
		elseif($arItem["IBLOCK_ID"] == $arTheme["CATALOG_WHEELS_IBLOCK_ID"]["VALUE"])
		{
			$propGroup = ($arTheme["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"]["VALUE"] && isset($arItem["PROPERTIES"][$arTheme["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"]["VALUE"]])? $arTheme["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"]["VALUE"] : "");
			$arItem["SIZE"] = $arItem["PROPERTIES"][$arTheme["PROP_DISK_SHIRINA_DISKA"]["VALUE"]]["VALUE"]."x".$arItem["PROPERTIES"][$propGroup]["VALUE"]." ".$arItem["PROPERTIES"][$arTheme["PROP_DISK_COUNT_OTVERSTIY"]["VALUE"]]["VALUE"]."x".$arItem["PROPERTIES"][$arTheme["PROP_DISK_MEZHBOLTOVOE_RASSTOYANIE"]["VALUE"]]["VALUE"];
		}
		elseif($arItem["IBLOCK_ID"] == $arTheme["CATALOG_MOTO_TIRES_IBLOCK_ID"]["VALUE"])
		{
			$propGroup = ($arTheme["PROP_TYRE_POSADOCHNYY_MOTO_DIAMETR"]["VALUE"] && isset($arItem["PROPERTIES"][$arTheme["PROP_TYRE_POSADOCHNYY_MOTO_DIAMETR"]["VALUE"]])? $arTheme["PROP_TYRE_POSADOCHNYY_MOTO_DIAMETR"]["VALUE"] : "");
			$arItem["SIZE"] = $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SHIRINA_MOTO_PROFILYA"]["VALUE"]]["VALUE"]."/".$arItem["PROPERTIES"][$arTheme["PROP_TYRE_VYSOTA_MOTO_PROFILYA"]["VALUE"]]["VALUE"]." R".$arItem["PROPERTIES"][$propGroup]["VALUE"];

			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_MOTO"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_MOTO"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SEASON_MOTO_SUMMER"]["VALUE"]:
						$class = "icon-summer";
						break;
					case $arTheme["PROP_TYRE_SEASON_MOTO_WINTER"]["VALUE"]:
						$class = "icon-winter";
						break;
					case $arTheme["PROP_TYRE_SEASON_MOTO_ALL"]["VALUE"]:
						$class = "icon-allseason";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_MOTO"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_MOTO"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_MOTO"]["VALUE"]]["VALUE"]
					);
			}
			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_MOTO"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_MOTO"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SPIKES_MOTO_Y"]["VALUE"]:
						$class = "icon-spikes";
						break;
					case $arTheme["PROP_TYRE_SPIKES_MOTO_N"]["VALUE"]:
						$class = "icon-wthspikes";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_MOTO"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_MOTO"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_MOTO"]["VALUE"]]["VALUE"]
					);
			}
		}
		elseif($arItem["IBLOCK_ID"] == $arTheme["CATALOG_TRUCK_TIRES_IBLOCK_ID"]["VALUE"])
		{
			$propGroup = ($arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"] && isset($arItem["PROPERTIES"][$arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"]])? $arTheme["PROP_TYRE_POSADOCHNYY_TRUCK_DIAMETR"]["VALUE"] : "");
			$arItem["SIZE"] = $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SHIRINA_TRUCK_PROFILYA"]["VALUE"]]["VALUE"]."/".$arItem["PROPERTIES"][$arTheme["PROP_TYRE_VYSOTA_TRUCK_PROFILYA"]["VALUE"]]["VALUE"]." R".$arItem["PROPERTIES"][$propGroup]["VALUE"];

			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_TRUCK"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_TRUCK"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SEASON_TRUCK_SUMMER"]["VALUE"]:
						$class = "icon-summer";
						break;
					case $arTheme["PROP_TYRE_SEASON_TRUCK_WINTER"]["VALUE"]:
						$class = "icon-winter";
						break;
					case $arTheme["PROP_TYRE_SEASON_TRUCK_ALL"]["VALUE"]:
						$class = "icon-allseason";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_TRUCK"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_TRUCK"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SEASON_TRUCK"]["VALUE"]]["VALUE"]
					);
			}
			if($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_TRUCK"]["VALUE"]]["VALUE"])
			{
				switch($arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_TRUCK"]["VALUE"]]["VALUE"])
				{
					case $arTheme["PROP_TYRE_SPIKES_TRUCK_Y"]["VALUE"]:
						$class = "icon-spikes";
						break;
					case $arTheme["PROP_TYRE_SPIKES_TRUCK_N"]["VALUE"]:
						$class = "icon-wthspikes";
						break;
					default:
						$class = "";
						break;
				}
				$arResult["SECTION_PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_TRUCK"]["VALUE"]]["NAME"]]["PROPS"][$arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_TRUCK"]["VALUE"]]["VALUE"]] = array(
						"CLASS" => $class,
						"VALUE" => $arItem["PROPERTIES"][$arTheme["PROP_TYRE_SPIKES_TRUCK"]["VALUE"]]["VALUE"]
					);
			}
		}

		$arItem['LAST_ELEMENT'] = 'N';
		$arNewItemsList[$key] = $arItem;

		if ((int)$arItem['PROPERTIES']['vote_count']['VALUE']) {
			$arResult["SUMM_RATING"] += ($arItem['PROPERTIES']['vote_sum']['VALUE'] / $arItem['PROPERTIES']['vote_count']['VALUE']);
			++$arResult["ITEMS_COUNT"];
		}
	}

	$arNewItemsList[$key]['LAST_ELEMENT'] = 'Y';
	$arResult['ITEMS'] = $arNewItemsList;
	$arResult['SKU_PROPS'] = $arSKUPropList;
	$arResult['DEFAULT_PICTURE'] = $arEmptyPreview;


	$arFilterItemsGroups = array('IBLOCK_ID' => $arParams["IBLOCK_ID"], "SECTION_ID" => $arParams["SECTION_ID"], 'ACTIVE' => 'Y', 'SECTION_GLOBAL_ACTIVE' => 'Y');
	if ($GLOBALS[$arParams['FILTER_NAME']]) {
		$arrFilter = $GLOBALS[$arParams['FILTER_NAME']];
		$arFilterItemsGroups += $arrFilter;
	}

	$resItemsGroups = CIBlockElement::GetList(array(), $arFilterItemsGroups, array('PROPERTY_'.$propGroup));
	while ($groupItem = $resItemsGroups->Fetch()) {
		$groupItems[] = $groupItem;
	}
	foreach ($groupItems as $group) {
		$arResult['ITEMS_GROUPS'][$group['PROPERTY_'.$propGroup.'_VALUE']] = $group['PROPERTY_'.$propGroup.'_VALUE'];
	}


	$arResult["USE_GROUPS"] =  $propGroup;
	if ($propGroup) {
		foreach ($arResult['ITEMS'] as $arItem) {
			$arResult['GROUPS'][round($arItem['PROPERTIES'][$propGroup]['VALUE'], 1)]['ITEMS'][] = $arItem;
		}

		ksort($arResult['GROUPS']);

		foreach ($arResult['GROUPS'] as $key => $arGroup) {
			\Bitrix\Main\Type\Collection::sortByColumn($arResult['GROUPS'][$key]['ITEMS'], array('NAME' => SORT_ASC, 'ID' => SORT_ASC));
		}
	} else {
		$arResult['GROUPS'][0]['ITEMS'] = $arResult['ITEMS'];
	}

	$strFromText = \Bitrix\Main\Localization\Loc::getMessage("PRICES_FROM");

	if ($arResult['NAV_RESULT']->NavPageCount > 1) {
		/* get items */
		$arItems = CTires2Cache::CIBLockElement_GetList(array("CACHE" => array("MULTI" =>"Y", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "SECTION_ID" => $arResult["ID"], "INCLUDE_SUBSECTIONS" => "Y"), false, false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID"));
		if ($arItems) {
			$arDoubles = $arPriceResult = array();
			foreach ($arItems as $arItem) {
				/* get item price */
				$arPriceList = \Aspro\Functions\CAsproTires2::getPriceList($arItem["ID"], $arParams["PRICE_CODE"], 1, true);
				$arPricesID = array();
				if ($arPriceList) {
					foreach ($arPriceList as $arPriceTmp) {
						$arPricesID[] = $arPriceTmp["CATALOG_GROUP_ID"];
					}
				}
				if ($arPricesID) {
					global $USER;
					$arPrice = CCatalogProduct::GetOptimalPrice($arItem["ID"], 1, $USER->GetUserGroupArray(), 'N', $arPriceList);
					if ($arPrice["RESULT_PRICE"]) {
						$price = $arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"];
						$arFormatPrice = $arPrice["RESULT_PRICE"];
						if (
							$arParams["CONVERT_CURRENCY"] != "Y"
							&& $arPrice["RESULT_PRICE"]["CURRENCY"] != $arPrice["PRICE"]["CURRENCY"]
						) {
							$price = roundEx(
								CCurrencyRates::ConvertCurrency(
									$arPrice["RESULT_PRICE"]["DISCOUNT_PRICE"],
									$arPrice["RESULT_PRICE"]["CURRENCY"],
									$arPrice["PRICE"]["CURRENCY"]
								),
								CATALOG_VALUE_PRECISION);
							$arFormatPrice = $arPrice["PRICE"];
							$arFormatPrice["DISCOUNT_PRICE"] = $price;
						}

						if (!$arPriceResult["MIN_PRICE"] && $arFormatPrice["BASE_PRICE"] > 0) {
							$arPriceResult["MIN_PRICE"] = $arFormatPrice;
						} else {
							$comparePrice = $price;

							if ($arPriceResult["MIN_PRICE"]["DISCOUNT_PRICE"] > $comparePrice && $comparePrice > 0) {
								$arPriceResult["MIN_PRICE"] = $arFormatPrice;
							}
						}
					}
				}
				/**/
			}
		}
		if ($arPriceResult) {
			$nSectionPrice = \Aspro\Functions\CAsproItem::getCurrentPrice(
				$arPriceResult["MIN_PRICE"]["DISCOUNT_PRICE"],
				$arPriceResult["MIN_PRICE"],
				false
			);
			$arResult["SECTION_PRICE"] = $strFromText.' '.$nSectionPrice;
		}
	} else {
		$arResult["SECTION_PRICE"] = \Aspro\Functions\CAsproTires2::getMinPriceFromItems(
			$arResult["ITEMS"],
			$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency,
			$strFromText
		);
	}

	if ($arTmpStickers) {
		foreach ($arTmpStickers as $arAllStickers) {
			foreach ($arAllStickers as $arStickers) {
				$arResult["SECTION_STICKERS"][$arStickers["CLASS"]]=  $arStickers;
			}
		}
	}

	unset($arResult['ITEMS']);

	$arResult['CURRENCIES'] = array();
	if ($arResult['MODULES']['currency'])
	{
		if ($boolConvert)
		{
			$currencyFormat = CCurrencyLang::GetFormatDescription($arResult['CONVERT_CURRENCY']['CURRENCY_ID']);
			$arResult['CURRENCIES'] = array(
				array(
					'CURRENCY' => $arResult['CONVERT_CURRENCY']['CURRENCY_ID'],
					'FORMAT' => array(
						'FORMAT_STRING' => $currencyFormat['FORMAT_STRING'],
						'DEC_POINT' => $currencyFormat['DEC_POINT'],
						'THOUSANDS_SEP' => $currencyFormat['THOUSANDS_SEP'],
						'DECIMALS' => $currencyFormat['DECIMALS'],
						'THOUSANDS_VARIANT' => $currencyFormat['THOUSANDS_VARIANT'],
						'HIDE_ZERO' => $currencyFormat['HIDE_ZERO']
					)
				)
			);
			unset($currencyFormat);
		}
		else
		{
			$currencyIterator = CurrencyTable::getList(array(
				'select' => array('CURRENCY')
			));
			while ($currency = $currencyIterator->fetch())
			{
				$currencyFormat = CCurrencyLang::GetFormatDescription($currency['CURRENCY']);
				$arResult['CURRENCIES'][] = array(
					'CURRENCY' => $currency['CURRENCY'],
					'FORMAT' => array(
						'FORMAT_STRING' => $currencyFormat['FORMAT_STRING'],
						'DEC_POINT' => $currencyFormat['DEC_POINT'],
						'THOUSANDS_SEP' => $currencyFormat['THOUSANDS_SEP'],
						'DECIMALS' => $currencyFormat['DECIMALS'],
						'THOUSANDS_VARIANT' => $currencyFormat['THOUSANDS_VARIANT'],
						'HIDE_ZERO' => $currencyFormat['HIDE_ZERO']
					)
				);
			}
			unset($currencyFormat, $currency, $currencyIterator);
		}
	}
}?>