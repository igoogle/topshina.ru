<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

use \Bitrix\Main\Loader;
use \Redsign\MegaMart\IblockElementExt;

$component = $this->getComponent();

$component->arParams['SHOW_SLIDER'] = 'N';

$arResult['MODULES']['redsign.megamart'] = Loader::includeModule('redsign.megamart');

if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
{
	foreach ($arResult['ITEMS'] as $iItemKey => $arItem)
	{
		$haveOffers = !empty($arItem['OFFERS']);

		if ($arParams['FILL_ITEM_ALL_PRICES'])
		{
			if ($haveOffers)
			{
				$bOfferCnt = 0;
				foreach ($arItem['OFFERS'] as $arOffer)
				{
					if (!is_array($arOffer['PRICES']) || count($arOffer['PRICES']) < 2)
					{
						$bOfferCnt++;
					}
				}
				if (is_array($arOffer['PRICES']) && $bOfferCnt == count($arOffer['PRICES']))
				{
					$component->arParams['FILL_ITEM_ALL_PRICES'] = false;
				}
				unset($arOffer, $bOfferCnt);

				// #bitrixwtf
				if ($arResult['MODULES']['redsign.megamart'])
				{
					foreach ($arItem['OFFERS'] as $iOfferKey => $jsOffer)
					{
						IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$iItemKey]['OFFERS'][$iOfferKey]);
						$arResult['ITEMS'][$iItemKey]['JS_OFFERS'][$iOfferKey]['ITEM_ALL_PRICES'] = $arResult['ITEMS'][$iItemKey]['OFFERS'][$iOfferKey]['ITEM_ALL_PRICES'];
					}
				}

			}
			else
			{
				if (
					(!is_array($arItem['PRICES']) || count($arItem['PRICES']) < 2)
					&& (
						!is_array($arItem['ITEM_ALL_PRICES'][$arItem['ITEM_PRICE_SELECTED']]['PRICES'])
						|| count($arItem['ITEM_ALL_PRICES'][$arItem['ITEM_PRICE_SELECTED']]['PRICES']) < 2
					)
				) {
					$component->arParams['FILL_ITEM_ALL_PRICES'] = false;
				}

				// #bitrixwtf
				if ($arResult['MODULES']['redsign.megamart'])
				{
					IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$iItemKey]);
				}
			}
		}
	}
}

$arParams = $component->applyTemplateModifications();

$component->arParams['ADD_TO_BASKET_ACTION'] = $arParams['~ADD_TO_BASKET_ACTION'];
$arParams['ADD_TO_BASKET_ACTION'] = $arParams['~ADD_TO_BASKET_ACTION'];

if (Loader::includeModule('redsign.devfunc'))
{
	\Redsign\DevFunc\Sale\Location\Region::editCatalogResult($arResult);
	if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
	{
		foreach ($arResult['ITEMS'] as $iItemKey => $arItem)
		{
			\Redsign\DevFunc\Sale\Location\Region::editCatalogItem($arResult['ITEMS'][$iItemKey]);
		}
		unset($iItemKey, $arItem);
	}
}

if (!is_array($arResult['CATALOG']) && $arResult['MODULES']['redsign.megamart'])
{
	$params = array(
	  'PROP_PRICE' => $arParams['PRICE_PROP'],
	  'PROP_DISCOUNT' => $arParams['DISCOUNT_PROP'],
	  'PROP_CURRENCY' => $arParams['CURRENCY_PROP'],
	  'PRICE_DECIMALS' => $arParams['PRICE_DECIMALS'],
	);

	IblockElementExt::addPrices($arResult['ITEMS'], $params);
}
