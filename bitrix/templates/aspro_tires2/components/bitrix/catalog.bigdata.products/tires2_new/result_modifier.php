<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
if (!isset($arParams['LINE_ELEMENT_COUNT']))
	$arParams['LINE_ELEMENT_COUNT'] = 3;
$arParams['LINE_ELEMENT_COUNT'] = intval($arParams['LINE_ELEMENT_COUNT']);
if (2 > $arParams['LINE_ELEMENT_COUNT'] || 5 < $arParams['LINE_ELEMENT_COUNT'])
	$arParams['LINE_ELEMENT_COUNT'] = 3;

\Bitrix\Main\Loader::includeModule("aspro.tires2");

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$arParams['TEMPLATE_THEME'] = COption::GetOptionString('main', 'wizard_eshop_adapt_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';

/* hide compare link from module options */
if(CTires2::GetFrontParametrValue('CATALOG_COMPARE') == 'N')
	$arParams["DISPLAY_COMPARE"] = 'N';
/**/

/* hide delay link from module options */
if(CTires2::GetFrontParametrValue('CATALOG_DELAY') == 'N')
	$arParams["DISPLAY_WISH_BUTTONS"] = 'N';
/**/

if (!empty($arResult['ITEMS']))
{
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
	$strEmptyPreview = SITE_TEMPLATE_PATH . '/images/no_photo_medium.png';
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . $strEmptyPreview))
	{
		$arSizes = getimagesize($_SERVER['DOCUMENT_ROOT'] . $strEmptyPreview);
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

	//
	$skuPropList = array(); // array("id_catalog" => array(...))
	$skuPropIds = array(); // array("id_catalog" => array(...))
	$skuPropKeys = array(); // array("id_catalog" => array(...))

	if (!$boolConvert)
		$strBaseCurrency = CCurrency::GetBaseCurrency();

	$catalogs = array();


	$arNewItemsList = $arIBlocksID = $arSectionsID = $arSections = array();

	foreach($arResult['ITEMS'] as $key => $arItem)
	{
		if($arItem['IBLOCK_SECTION_ID'] && !in_array($arItem['IBLOCK_SECTION_ID'], $arSectionsID))
		{
			$arSectionsID[] = $arItem['IBLOCK_SECTION_ID'];
		
			if(!in_array($arItem['IBLOCK_ID'], $arIBlocksID))
			{
				$arIBlocksID[] = $arItem['IBLOCK_ID'];
			}
		}
	}
	
	if($arSectionsID)
	{
		$arSections = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arIBlocksID), 'GROUP' => 'ID')), array("IBLOCK_ID" => $arIBlocksID, 'ID' => $arSectionsID), false, array('ID', 'PICTURE'));
		
		foreach($arSections as $key => $arSection)
		{
			if($arSection['PICTURE'])
			{
				$arSections[$key]['PICTURE'] = CFile::ResizeImageGet($arSection['PICTURE'], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );
			}
		}
	}

	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$arItem['CATALOG_QUANTITY'] = (
		0 < $arItem['CATALOG_QUANTITY'] && is_float($arItem['CATALOG_MEASURE_RATIO'])
			? floatval($arItem['CATALOG_QUANTITY'])
			: intval($arItem['CATALOG_QUANTITY'])
		);
		$arItem['CATALOG'] = false;
		$arItem['LABEL'] = false;
		if (!isset($arItem['CATALOG_SUBSCRIPTION']) || 'Y' != $arItem['CATALOG_SUBSCRIPTION'])
			$arItem['CATALOG_SUBSCRIPTION'] = 'N';

		if(!$arItem['PREVIEW_PICTURE'] && !$arItem['DETAIL_PICTURE']){
			if($arSections[$arItem['IBLOCK_SECTION_ID']]['PICTURE']){
				$arItem['NO_IMAGE_PATH'] = $arSections[$arItem['IBLOCK_SECTION_ID']]['PICTURE']['src'];
			}
			else{
				$arItem['NO_IMAGE_PATH'] = \Aspro\Functions\CAsproTires2::showNoImage($arItem["IBLOCK_ID"], $arParams['SITE_ID']);
			}
		}
		$arPropsHint = \Aspro\Functions\CAsproTires2::getPropsHint($arParams, $arItem);

		$arItem["TIRES_PROP"] = \Aspro\Functions\CAsproTires2::getPropsHintValue($arItem, $arPropsHint);

		// Item Label Properties
		$itemIblockId = $arItem['IBLOCK_ID'];
		$propertyName = isset($arParams['LABEL_PROP'][$itemIblockId]) ? $arParams['LABEL_PROP'][$itemIblockId] : false;

		if ($propertyName && isset($arItem['PROPERTIES'][$propertyName]))
		{
			$property = $arItem['PROPERTIES'][$propertyName];

			if (!empty($property['VALUE']))
			{
				if ('N' == $property['MULTIPLE'] && 'L' == $property['PROPERTY_TYPE'] && 'C' == $property['LIST_TYPE'])
				{
					$arItem['LABEL_VALUE'] = $property['NAME'];
				}
				else
				{
					$arItem['LABEL_VALUE'] = (is_array($property['VALUE'])
						? implode(' / ', $property['VALUE'])
						: $property['VALUE']
					);
				}
				$arItem['LABEL'] = true;

				if (isset($arItem['DISPLAY_PROPERTIES'][$propertyName]))
					unset($arItem['DISPLAY_PROPERTIES'][$propertyName]);
			}
			unset($property);
		}

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
				$arItem['CATALOG_MEASURE_RATIO'] = 1;
				$arItem['CATALOG_QUANTITY'] = 0;
				$arItem['CHECK_QUANTITY'] = false;
				break;
			case CCatalogProduct::TYPE_SKU:
				break;
			case CCatalogProduct::TYPE_PRODUCT:
			default:
				$arItem['CHECK_QUANTITY'] = ('Y' == $arItem['CATALOG_QUANTITY_TRACE'] && 'N' == $arItem['CATALOG_CAN_BUY_ZERO']);
				break;
		}

		// Offers
		if ($arItem['CATALOG'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS']))
		{
			$arSKUPropIDs = isset($skuPropIds[$arItem['IBLOCK_ID']]) ? $skuPropIds[$arItem['IBLOCK_ID']] : array();
			$arSKUPropList = isset($skuPropList[$arItem['IBLOCK_ID']]) ? $skuPropList[$arItem['IBLOCK_ID']] : array();
			$arSKUPropKeys = isset($skuPropKeys[$arItem['IBLOCK_ID']]) ? $skuPropKeys[$arItem['IBLOCK_ID']] : array();

			$arMatrixFields = $arSKUPropKeys;
			$arMatrix = array();

			$arNewOffers = array();
			$boolSKUDisplayProperties = false;
			$arItem['OFFERS_PROP'] = false;

			//set min price when USE_PRICE_COUNT
			if($arParams['USE_PRICE_COUNT'] == 'Y')
			{
				$arPriceTypeID = array();
				foreach($arItem['OFFERS'] as $keyOffer => $arOffer)
				{
					//format prices when USE_PRICE_COUNT
					if(function_exists('CatalogGetPriceTableEx') && (isset($arOffer['PRICE_MATRIX'])) && !$arOffer['PRICE_MATRIX'])
					{
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
					}
					$arItem['OFFERS'][$keyOffer] = array_merge($arOffer, CTires2::formatPriceMatrix($arOffer));
				}
			}
			
			$arItem['MIN_PRICE'] = CTires2::getMinPriceFromOffersExt(
				$arItem['OFFERS'],
				$boolConvert ? $arResult['CONVERT_CURRENCY']['CURRENCY_ID'] : $strBaseCurrency
			);
		}

		if ($arItem['CATALOG'] && CCatalogProduct::TYPE_PRODUCT == $arItem['CATALOG_TYPE'])
		{
			CIBlockPriceTools::setRatioMinPrice($arItem, true);
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
		$arItem['LAST_ELEMENT'] = 'N';
		$arNewItemsList[$key] = $arItem;
	}

	$arNewItemsList[$key]['LAST_ELEMENT'] = 'Y';
	$arResult['ITEMS'] = $arNewItemsList;
	$arResult['SKU_PROPS'] = $skuPropList;
	$arResult['DEFAULT_PICTURE'] = $arEmptyPreview;
}
?>