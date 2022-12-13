<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?\Bitrix\Main\Loader::includeModule('aspro.tires2');?>

<?
$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();
$arPost = $request->getPostList()->toArray();
?>

<?if($request->isPost() && $arPost["ELEMENT_ID"]){
	if($arPost["OFFERS_ID"]){
		foreach($arPost["OFFERS_ID"] as $id){?>
			<div class="sku_stores_<?=$id?>" style="display: none;">
				<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", $arPost["TEMPLATE"], array(
						"PER_PAGE" => "10",
						"USE_STORE_PHONE" => $arPost["USE_STORE_PHONE"],
						"SCHEDULE" => $arPost["SCHEDULE"],
						"USE_MIN_AMOUNT" => $arPost["USE_MIN_AMOUNT"],
						"MIN_AMOUNT" => $arPost["MIN_AMOUNT"],
						"ELEMENT_ID" => $id,
						"STORE_PATH"  =>  $arPost["STORE_PATH"],
						"MAIN_TITLE"  =>  $arPost['MAIN_TITLE'],
						"MAX_AMOUNT"=>$arPost["MAX_AMOUNT"],
						"USE_ONLY_MAX_AMOUNT" => $arPost["USE_ONLY_MAX_AMOUNT"],
						"SHOW_EMPTY_STORE" => $arPost['SHOW_EMPTY_STORE'],
						"SHOW_GENERAL_STORE_INFORMATION" => $arPost['SHOW_GENERAL_STORE_INFORMATION'],
						"USE_ONLY_MAX_AMOUNT" => $arPost["USE_ONLY_MAX_AMOUNT"],
						"USER_FIELDS" => $arPost['USER_FIELDS'],
						"FIELDS" => $arPost['FIELDS'],
						"STORES" => $arPost['STORES'],
						"STORES_PARAMS" => $arPost['STORES_PARAMS'],
						"STORES_PARAMS_PRICE" => $arPost['STORES_PARAMS_PRICE'],
						"PRICE_CODE" => $arPost['PRICE_CODE'],
						"QUANTITY" => $arPost['QUANTITY'],
						"STORES_FILTER_ORDER" => $arPost['STORES_FILTER_ORDER'],
						"STORES_FILTER" => $arPost['STORES_FILTER'],
						"STORES_FILTER_PARAM" => $arPost['STORES_FILTER_PARAM'],
						"BASKET_URL" => $arPost["BASKET_URL"],
						"CACHE_GROUPS" => $arPost["CACHE_GROUPS"],
						"CACHE_TYPE" => $arPost["CACHE_TYPE"],
						"CACHE_TIME" => $arPost["CACHE_TIME"],

						"IBLOCK_ID" => $arPost["IBLOCK_ID"],
						"SHOW_MEASURE_WITH_RATIO" => $arPost["SHOW_MEASURE_WITH_RATIO"],
						"SHOW_DISCOUNT_TIME"=>$arPost["SHOW_DISCOUNT_TIME"],
						"USE_PRICE_COUNT" => $arPost["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arPost["SHOW_PRICE_COUNT"],
						"USE_RATIO_IN_RANGES" => $arPost["USE_RATIO_IN_RANGES"],
						"PRICE_VAT_INCLUDE" => $arPost["PRICE_VAT_INCLUDE"],
						"PRICE_VAT_SHOW_VALUE" => $arPost["PRICE_VAT_SHOW_VALUE"],
						"CONVERT_CURRENCY" => $arPost["CONVERT_CURRENCY"],
						"CURRENCY_ID" => $arPost["CURRENCY_ID"],
						"MAX_AMOUNT" => $arPost["MAX_AMOUNT"],
						"DEFAULT_COUNT" => $arPost["DEFAULT_COUNT"],
						"SHOW_MEASURE" => $arPost["SHOW_MEASURE"],
						"SHOW_DISCOUNT_PERCENT_NUMBER" => $arPost["SHOW_DISCOUNT_PERCENT_NUMBER"],
						"SHOW_DISCOUNT_PERCENT" => $arPost["SHOW_DISCOUNT_PERCENT"],
						"SHOW_OLD_PRICE" => $arPost["SHOW_OLD_PRICE"],
					),
					false
				);?>
			</div>
		<?}
	}else{?>
		<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", $arPost["TEMPLATE"], array(
				"PER_PAGE" => "10",
				"USE_STORE_PHONE" => $arPost["USE_STORE_PHONE"],
				"SCHEDULE" => $arPost["SCHEDULE"],
				"USE_MIN_AMOUNT" => $arPost["USE_MIN_AMOUNT"],
				"MIN_AMOUNT" => $arPost["MIN_AMOUNT"],
				"ELEMENT_ID" => $arPost["ELEMENT_ID"],
				"STORE_PATH"  =>  $arPost["STORE_PATH"],
				"MAIN_TITLE"  =>  $arPost["MAIN_TITLE"],
				"MAX_AMOUNT"=>$arPost["MAX_AMOUNT"],
				"USE_ONLY_MAX_AMOUNT" => $arPost["USE_ONLY_MAX_AMOUNT"],
				"SHOW_EMPTY_STORE" => $arPost['SHOW_EMPTY_STORE'],
				"SHOW_GENERAL_STORE_INFORMATION" => $arPost['SHOW_GENERAL_STORE_INFORMATION'],
				"USE_ONLY_MAX_AMOUNT" => $arPost["USE_ONLY_MAX_AMOUNT"],
				"USER_FIELDS" => $arPost['USER_FIELDS'],
				"FIELDS" => $arPost['FIELDS'],
				"STORES" => $arPost['STORES'],
				"STORES_PARAMS" => $arPost['STORES_PARAMS'],
				"STORES_PARAMS_PRICE" => $arPost['STORES_PARAMS_PRICE'],
				"PRICE_CODE" => $arPost['PRICE_CODE'],
				"QUANTITY" => $arPost['QUANTITY'],
				"STORES_FILTER_ORDER" => $arPost['STORES_FILTER_ORDER'],
				"STORES_FILTER" => $arPost['STORES_FILTER'],
				"STORES_FILTER_PARAM" => $arPost['STORES_FILTER_PARAM'],
				"BASKET_URL" => $arPost["BASKET_URL"],
				"CACHE_GROUPS" => $arPost["CACHE_GROUPS"],
				"CACHE_TYPE" => $arPost["CACHE_TYPE"],
				"CACHE_TIME" => $arPost["CACHE_TIME"],

				"IBLOCK_ID" => $arPost["IBLOCK_ID"],
				"SHOW_MEASURE_WITH_RATIO" => $arPost["SHOW_MEASURE_WITH_RATIO"],
				"SHOW_DISCOUNT_TIME"=>$arPost["SHOW_DISCOUNT_TIME"],
				"USE_PRICE_COUNT" => $arPost["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arPost["SHOW_PRICE_COUNT"],
				"USE_RATIO_IN_RANGES" => $arPost["USE_RATIO_IN_RANGES"],
				"PRICE_VAT_INCLUDE" => $arPost["PRICE_VAT_INCLUDE"],
				"PRICE_VAT_SHOW_VALUE" => $arPost["PRICE_VAT_SHOW_VALUE"],
				"CONVERT_CURRENCY" => $arPost["CONVERT_CURRENCY"],
				"CURRENCY_ID" => $arPost["CURRENCY_ID"],
				"MAX_AMOUNT" => $arPost["MAX_AMOUNT"],
				"DEFAULT_COUNT" => $arPost["DEFAULT_COUNT"],
				"SHOW_MEASURE" => $arPost["SHOW_MEASURE"],
				"SHOW_DISCOUNT_PERCENT_NUMBER" => $arPost["SHOW_DISCOUNT_PERCENT_NUMBER"],
				"SHOW_DISCOUNT_PERCENT" => $arPost["SHOW_DISCOUNT_PERCENT"],
				"SHOW_OLD_PRICE" => $arPost["SHOW_OLD_PRICE"],
			),
			false
		);?>
	<?}
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>