<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();
$arPost = $request->getPostList()->toArray();

if($request->isPost() && (isset($arPost['ELEMENT_ID']) && $arPost['ELEMENT_ID']))
{		
	global $APPLICATION;
	$arPost = $APPLICATION->ConvertCharsetArray($arPost, 'UTF-8', LANG_CHARSET);
	
	\Bitrix\Main\Loader::includeModule('sale');
	\Bitrix\Main\Loader::includeModule('currency');
	\Bitrix\Main\Loader::includeModule('catalog');?>

	<?$ElementID = $APPLICATION->IncludeComponent(
		"bitrix:catalog.element",
		"ajax",
		Array(
			"USE_REGION" => $arPost["USE_REGION"],
			"SHOW_MEASURE_WITH_RATIO" => $arPost["SHOW_MEASURE_WITH_RATIO"],
			"SHOW_DISCOUNT_TIME"=>$arPost["SHOW_DISCOUNT_TIME"],
			
			"IBLOCK_TYPE" => $arPost["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arPost["IBLOCK_ID"],
			
			"CACHE_TYPE" => $arPost["CACHE_TYPE"],
			"CACHE_TIME" => $arPost["CACHE_TIME"],
			"CACHE_GROUPS" => $arPost["CACHE_GROUPS"],
			
			"PRICE_CODE" => $arPost["PRICES"][$request["REGION_ID"]][$request["STORE_ID"]],
			"PRICE_CODE_IDS" => $arPost["PRICES_ID"][$request["REGION_ID"]][$request["STORE_ID"]],

			"USE_PRICE_COUNT" => $arPost["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arPost["SHOW_PRICE_COUNT"],
			"USE_RATIO_IN_RANGES" => $arPost["USE_RATIO_IN_RANGES"],
			"PRICE_VAT_INCLUDE" => $arPost["PRICE_VAT_INCLUDE"],
			"PRICE_VAT_SHOW_VALUE" => $arPost["PRICE_VAT_SHOW_VALUE"],

			"SHOW_CHEAPER_FORM" => $arPost["SHOW_CHEAPER_FORM"],
			"CHEAPER_FORM_NAME" => $arPost["CHEAPER_FORM_NAME"],
			
			"ELEMENT_ID" => $arPost["ELEMENT_ID"],
			"ELEMENT_CODE" => "",
			"STORES" => array($request["STORE_ID"]),
			
			"CONVERT_CURRENCY" => $arPost["CONVERT_CURRENCY"],
			"CURRENCY_ID" => $arPost["CURRENCY_ID"],
			"BASKET_URL" => $arPost["BASKET_URL"],
			'HIDE_NOT_AVAILABLE' => "N",
			'HIDE_NOT_AVAILABLE_OFFERS' => "N",
			'SHOW_DEACTIVATED' => 'Y',
			"USE_ELEMENT_COUNTER" => '',

			"MAX_AMOUNT" => $arPost["MAX_AMOUNT"],
			"DEFAULT_COUNT" => $arPost["DEFAULT_COUNT"],
			"SHOW_MEASURE" => $arPost["SHOW_MEASURE"],
			"SHOW_DISCOUNT_PERCENT_NUMBER" => $arPost["SHOW_DISCOUNT_PERCENT_NUMBER"],
			"SHOW_DISCOUNT_PERCENT" => $arPost["SHOW_DISCOUNT_PERCENT"],
			"SHOW_OLD_PRICE" => $arPost["SHOW_OLD_PRICE"],
			"USE_MAIN_ELEMENT_SECTION" => "N",

			"OFFERS_CART_PROPERTIES" => $arPost["OFFERS_CART_PROPERTIES"],
			"PARTIAL_PRODUCT_PROPERTIES" => $arPost["PARTIAL_PRODUCT_PROPERTIES"],
			"ADD_PROPERTIES_TO_BASKET" => $arPost["ADD_PROPERTIES_TO_BASKET"],
			"PRODUCT_PROPERTIES" => $arPost["PRODUCT_PROPERTIES"],

			"OFFERS_LIMIT" => 1,

			'DISABLE_INIT_JS_IN_COMPONENT' => '',
			'COMPATIBLE_MODE' => '',
			'SET_VIEWED_IN_COMPONENT' => '',

			"USE_GIFTS_DETAIL" => '',
			"USE_GIFTS_MAIN_PR_SECTION_LIST" => '',
		),
		false
	);?>
	
<?}?>