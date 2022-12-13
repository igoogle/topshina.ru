<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

use \Bitrix\Main\Loader;

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);


$allowOrder = true;
if (Loader::includeModule('redsign.megamart'))
{
	$isUseOrderMinPrice = \Redsign\Megamart\OrderUtils::isUseMinPrice();
	
	if ($isUseOrderMinPrice && !isset($arResult['ACCOUNT_NUMBER']))
	{
		$allowOrder = \Redsign\Megamart\OrderUtils::checkMinPrice($arResult['ORDER_PRICE']);
	}

	if (!$allowOrder)
	{
		$sErrorMessage = \Bitrix\Main\Config\Option::get(
			'redsign.megamart',
			'sale_order_min_price_error_text',
			''
		);

		$nMinPrice = \Redsign\MegaMart\OrderUtils::getMinPrice();

		$arSearch = ['#MIN_PRICE#', '#PRICE#', '#DIFF_PRICE#'];
		$arReplacements = [
			$nMinPrice,
			$arResult['ORDER_PRICE'],
			abs($arResult['ORDER_PRICE'] - $nMinPrice)
		];

		$sErrorMessage = str_replace($arSearch, $arReplacements, $sErrorMessage);

		$arResult['ALLOW_ORDER_ERROR_MESSAGE'] = $sErrorMessage;
	}
}

$arResult['ALLOW_ORDER'] = $allowOrder;
unset($allowOrder);
