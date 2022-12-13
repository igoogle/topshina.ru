<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(\Bitrix\Main\Loader::includeModule('aspro.tires2'))
	CTires2::clearBasketCounters();

$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"compare_fly",
	Array(
		"IBLOCK_TYPE" => "aspro_next_catalog",
		"IBLOCK_ID" => "0",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_ID#/",
		"COMPARE_URL" => CTires2::GetFrontParametrValue("COMPARE_PAGE_URL"),
		"NAME" => "CATALOG_COMPARE_LIST",
		"AJAX_OPTION_ADDITIONAL" => ""
	)
);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>