<?$APPLICATION->IncludeComponent("bitrix:search.title", (isset($arTheme["TYPE_SEARCH"]["VALUE"]) ? $arTheme["TYPE_SEARCH"]["VALUE"] : $arTheme["TYPE_SEARCH"]), array(
	"NUM_CATEGORIES" => "1",
	"TOP_COUNT" => "10",
	"ORDER" => "date",
	"USE_LANGUAGE_GUESS" => "Y",
	"CHECK_DATES" => "Y",
	"SHOW_OTHERS" => "Y",
	"PAGE" => CTires2::GetFrontParametrValue("CATALOG_SEARCH_PAGE_URL"),
	"CATEGORY_OTHERS_TITLE" => "OTHER",
	"CATEGORY_0_TITLE" => "ALL",
	"CATEGORY_0_iblock_aspro_tires2_catalog" => array("all"),
	"CATEGORY_0_iblock_aspro_tires2_content" => array("all"),
	"SHOW_INPUT" => "Y",
	"INPUT_ID" => "title-search-input",
	"CONTAINER_ID" => "title-search",
	"PREVIEW_TRUNCATE_LEN" => "",
	"SHOW_PREVIEW" => "Y",
	"PRICE_CODE" => array("BASE", "OPT"),
	"CONVERT_CURRENCY" => "Y",
	"CURRENCY_ID" => "RUB",
	"PREVIEW_WIDTH" => "25",
	"PREVIEW_HEIGHT" => "25"
	),
	false, array("HIDE_ICONS" => "Y")
);?>