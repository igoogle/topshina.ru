<?
$APPLICATION->SetDirProperty('HIDE_LEFT_BLOCK', 'Y');
if($arParams['USE_FILTER'] == 'Y'){
$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	'catalog',
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"AJAX_FILTER_FLAG" => $isAjaxFilter,
		"SECTION_ID" => (isset($arSection["ID"]) ? $arSection["ID"] : ''),
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"FILTER_URL" => $arParams['FILTER_URL'],
		"PRICE_CODE" => ($arParams["USE_FILTER_PRICE"] == 'Y' ? $arParams["FILTER_PRICE_CODE"] : $arParams["PRICE_CODE"]),
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SAVE_IN_SESSION" => "N",
		"XML_EXPORT" => "Y",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"SHOW_HINTS" => $arParams["SHOW_HINTS"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'DISPLAY_ELEMENT_COUNT' => $arParams['DISPLAY_ELEMENT_COUNT'],
		"INSTANT_RELOAD" => "N",
		"VIEW_MODE" => strtolower($arTheme["FILTER_VIEW"]["VALUE"]),
		"SEF_MODE" => 'N',
		"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
		"SMART_FILTER_PATH" => '',//$arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"BLOCK_TITLE_TIRES" => $arParams['BLOCK_TITLE_TIRES'],
		"BLOCK_TITLE_TIRES_MOTO" => $arParams['BLOCK_TITLE_TIRES_MOTO'],
		"BLOCK_TITLE_TIRES_TRUCK" => $arParams['BLOCK_TITLE_TIRES_TRUCK'],
		'TYPE' => $arParams['TYPE'],
	),
	$component);
}
?>

<?$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();?>

<?$isAjax="N";?>
<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && ($request["ajax_get"] == "Y" || $request["ajax_basket"]=="Y" || $_POST["AJAX_POST"] == "Y"))
	$isAjax="Y";?>

<?if($isAjax=="Y"):?>
	<?$APPLICATION->RestartBuffer();?>
<?endif;?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"sections_list_2",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => 1,
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
		"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
		"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
		"SECTIONS_LIST_PREVIEW_DESCRIPTION" => $arParams["SECTIONS_LIST_PREVIEW_DESCRIPTION"],
		"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
		"SECTION_PAGE_ELEMENT" => ($arParams["SECTIONS_PAGE_ELEMENT"] ? $arParams["SECTIONS_PAGE_ELEMENT"] : 30),
		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"IS_AJAX" => $isAjax,
		"PAGE" => $request["PAGEN_2"],
	),
	$component
);?>

<?if($isAjax=="Y"):?>
	<?die();?>
<?endif;?>