<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

use \Bitrix\Main\Loader;
use \Redsign\MegaMart\IblockElementExt;
use \Redsign\MegaMart\ParametersUtils;
use \Redsign\MegaMart\ElementListUtils;

$component = $this->getComponent();

$component->arParams['SHOW_SLIDER'] = 'N';

$arResult['MODULES']['redsign.megamart'] = Loader::includeModule('redsign.megamart');

if (isset($component->arParams['~SLIDER_RESPONSIVE_SETTINGS']))
{
	$component->arParams['SLIDER_RESPONSIVE_SETTINGS'] = CUtil::JsObjectToPhp($component->arParams['~SLIDER_RESPONSIVE_SETTINGS']);
}
else
{
	$component->arParams['SLIDER_RESPONSIVE_SETTINGS'] = null;
}

if (empty($component->arParams['RS_LAZY_IMAGES_USE']) || $arParams['RS_LAZY_IMAGES_USE'] == 'FROM_MODULE')
{
	$component->arParams['RS_LAZY_IMAGES_USE'] = \Bitrix\Main\Config\Option::get('redsign.megamart', 'global_lazyload_images');
}


if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
{
	foreach ($arResult['ITEMS'] as $key => $item)
	{
		$haveOffers = !empty($item['OFFERS']);

		if ($haveOffers)
		{
			if ($arParams['FILL_ITEM_ALL_PRICES'])
			{
				$bOfferCnt = 0;
				foreach ($item['OFFERS'] as $arOffer)
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
					foreach ($item['OFFERS'] as $offerKey => $offer)
					{
						IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$key]['OFFERS'][$offerKey]);
						$arResult['ITEMS'][$key]['JS_OFFERS'][$offerKey]['ITEM_ALL_PRICES'] = $arResult['ITEMS'][$key]['OFFERS'][$offerKey]['ITEM_ALL_PRICES'];
					}
					unset($offerKey, $offer);
				}
			}

			// need to get offers PREVIEW_PICTURES
			$component->arParams['PRODUCT_DISPLAY_MODE'] = 'Y';
		}
		else
		{
			if ($arParams['FILL_ITEM_ALL_PRICES'])
			{
				if (
					(!is_array($item['PRICES']) || count($item['PRICES']) < 2)
					&& (
						!is_array($item['ITEM_ALL_PRICES'][$item['ITEM_PRICE_SELECTED']]['PRICES'])
						|| count($item['ITEM_ALL_PRICES'][$item['ITEM_PRICE_SELECTED']]['PRICES']) < 2
					)
				) {
					$component->arParams['FILL_ITEM_ALL_PRICES'] = false;
				}

				// #bitrixwtf
				if ($arResult['MODULES']['redsign.megamart'])
				{
					IblockElementExt::fixCatalogItemFillAllPrices($arResult['ITEMS'][$key]);
				}
			}
		}
	}
	unset($key, $item);
}

if (!is_array($arParams['ADD_TO_BASKET_ACTION']))
{
	$arResult['ORIGINAL_PARAMETERS']['ADD_TO_BASKET_ACTION'] = $arParams['ADD_TO_BASKET_ACTION'] = array($arParams['ADD_TO_BASKET_ACTION']);
}

$arParams = $component->applyTemplateModifications();

$elementListUtils = ElementListUtils::getInstance($component);
$elementListUtils->applyTemplateModifications();
$arResult['ITEM_ROWS'] = $elementListUtils->getItemRows();

$arParams['ADD_TO_BASKET_ACTION'] = $arResult['ORIGINAL_PARAMETERS']['ADD_TO_BASKET_ACTION'];

if (Loader::includeModule('redsign.devfunc'))
{
	\Redsign\DevFunc\Sale\Location\Region::editCatalogResult($arResult);
	if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
	{
		foreach ($arResult['ITEMS'] as $key => $item)
		{
			\Redsign\DevFunc\Sale\Location\Region::editCatalogItem($arResult['ITEMS'][$key]);
		}
		unset($key, $item);
	}
}


if (is_array($arResult['ITEMS']) && count($arResult['ITEMS']) > 0)
{
	foreach ($arResult['ITEMS'] as $key => $item)
	{
		if (!empty($item['PREVIEW_PICTURE']))
		{
			$arResult['ITEMS'][$key]['PREVIEW_PICTURE']['RESIZE'] = CFile::ResizeImageGet(
				$item['PREVIEW_PICTURE']['ID'],
				array('width' => 100, 'height' => 100),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);
		}
	}
	unset($key, $item);
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

if ($arParams['SHOW_PARENT_DESCR'] == 'Y' && $arResult['ID'] == 0)
{
    $arOrder = array();
    $arFilter = array(
        'TYPE' => $arParams['IBLOCK_TYPE'],
        'ID' => $arParams['IBLOCK_ID'],
    );
    $bIncCnt = false;

    $dbIblock = CIBlock::getList($arOrder, $arFilter, $bIncCnt);

    if ($arIblock = $dbIblock->getNext())
	{
        $arResult['NAME'] = $arIblock['NAME'];
        $arResult['DESCRIPTION'] = $arIblock['DESCRIPTION'];
    }
    unset($arOrder, $arFilter, $bIncCnt);
}
