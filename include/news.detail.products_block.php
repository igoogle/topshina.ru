<?global $arRegion;
if($arRegion)
{
	if($arRegion['LIST_PRICES'])
	{
		if(reset($arRegion['LIST_PRICES']) != 'component')
			$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
	}
	if($arRegion['LIST_STORES'])
	{
		if(reset($arRegion['LIST_STORES']) != 'component')
			$arParams['STORES'] = $arRegion['LIST_STORES'];
	}
}
?>
<?$APPLICATION->IncludeComponent(
	"aspro:catalog.section.tires2",
	"catalog_block",
	array(
		"IBLOCK_TYPE" => "aspro_tires2_catalog",
		"IBLOCK_ID" => \Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", 135),
		"IBLOCK_IDS" => \Aspro\Functions\CAsproTires2::getCatalogIBlocks("", true, true),
		"ELEMENT_SORT_FIELD" => $arParams["SORT_BUTTONS"],
		"ELEMENT_SORT_ORDER" => $arParams["SORT_BUTTONS_ORDER"],
		"ELEMENT_COUNT" => ($arParams["LINKED_ELEMENST_PAGE_COUNT"] ? $arParams["LINKED_ELEMENST_PAGE_COUNT"] : 20),
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"PAGER_TEMPLATE" => "main",
		"DISPLAY_TYPE" => "block",
		"TYPE_SKU" => "TYPE_1",
		"LINKED_ITEMS" => false,
		"AJAX_REQUEST" => $arParams["FROM_AJAX"],
		"LINE_ELEMENT_COUNT" => "4",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "10",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => SITE_DIR."basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_GROUPS" => "N",
		"CACHE_FILTER" => "Y",
		"DISPLAY_COMPARE" => "Y",
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"STORES" => $arParams["STORES"],
		"USE_REGION" => ($arRegion ? "Y" : "N"),
		"USE_PRICE_COUNT" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"CONVERT_CURRENCY" => "N",
		"FILTER_NAME" => "arrProductsFilter",
		"SHOW_BUY_BUTTONS" => $arParams["SHOW_BUY_BUTTONS"],
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "catalog_block",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"SEF_MODE" => "N",
		"CACHE_FILTER" => "Y",
		"SHOW_MEASURE" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"COMPARE_PATH" => "",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_RATING" => "Y",
		"SHOW_EMPTY_SECTION" => "N",
		"STIKERS_PROP" => $arParams["STIKERS_PROP"],
		"SALE_STIKER" => $arParams["SALE_STIKER"],
		"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
		"TITLE" => $arParams["TITLE"],
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
	),
	false, array("HIDE_ICONS" => "Y")
);?>