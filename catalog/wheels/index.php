<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("PODBOR_TITLE", "Подбор дисков");
$APPLICATION->SetTitle("Диски");
?> 

<?$APPLICATION->IncludeComponent(
	"aspro:catalog.tires2", 
	"main_with_types", 
	array(
		"IBLOCK_TYPE" => "aspro_tires2_catalog",
		"IBLOCK_ID" => "19",
		"HIDE_NOT_AVAILABLE" => "N",
		"BASKET_URL" => "/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/catalog/wheels/",
		"SEF_FOLDER_CATALOG" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "arTires2Filter",
		"VISIBLE_LIST_PROP_COUNT" => 5,
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "BASE",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"USE_REVIEW" => "Y",
		"FILTER_URL" => $arTheme["CATALOG_DISK_PAGE_URL"]["VALUE"],
		"TYPE" => "wheels",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "N",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"POST_FIRST_MESSAGE" => "N",
		"USE_COMPARE" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CONVERT_CURRENCY" => "N",
		"QUANTITY_FLOAT" => "N",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "CML2_LINK",
			1 => "PROP_1",
		),
		"SHOW_TOP_ELEMENTS" => "N",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "2",
		"SECTION_PAGE_ELEMENT" => "32",
		"PAGE_ELEMENT_COUNT" => "24",
		"LINE_ELEMENT_COUNT" => "4",
		"ELEMENT_SORT_FIELD" => "PRICE",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array(
			0 => "HIT",
			1 => "SHIRINA_DISKA",
			2 => "POSADOCHNYY_DIAMETR_DISKA",
			3 => "MEZHBOLTOVOE_RASSTOYANIE",
			4 => "CML2_ARTICLE",
			5 => "BRAND",
			6 => "NOVINKA",
			7 => "AKTSIYA",
			8 => "KHIT_PRODAZH",
			9 => "REST",
			10 => "VYSOTA_PROFILYA",
			11 => "DESCRIPTION",
			12 => "POSADOCHNYY_DIAMETR",
			13 => "SEZONNOST",
			14 => "SHIRINA_PROFILYA",
			15 => "SHIPY",
			16 => "NEW",
			17 => "SPIKES",
			18 => "FILES",
			19 => "CML2_ARTICLE",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_LIMIT" => "5",
		"LIST_DISPLAY_POPUP_IMAGE" => "Y",
		"LIST_DEFAULT_CATALOG_TEMPLATE" => "LIST",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "SHIRINA_DISKA",
			1 => "POSADOCHNYY_DIAMETR_DISKA",
			2 => "COUNT_OTVERSTIY",
			3 => "MEZHBOLTOVOE_RASSTOYANIE",
			4 => "VYLET_DISKA",
			5 => "DIAMETR_STUPITSY",
			6 => "CML2_ARTICLE",
			7 => "MODEL_DISKA",
			8 => "WHEEL_TYPE",
			9 => "DISK_COLOR",
			10 => "BRAND",
			11 => "EMKOST",
			12 => "KLEMMY",
			13 => "POLARNOST",
			14 => "VIDEO_YOUTUBE",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "CML2_LINK",
			1 => "PROP_1",
			2 => "",
		),
		"SKU_DISPLAY_LOCATION" => "RIGHT",
		"LINK_IBLOCK_TYPE" => "#IBLOCK_CATALOG_TYPE#",
		"LINK_IBLOCK_ID" => "20",
		"LINK_PROPERTY_SID" => "RELATED_ITEMS",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "Y",
		"ALSO_BUY_ELEMENT_COUNT" => "5",
		"ALSO_BUY_MIN_BUYES" => "2",
		"USE_STORE" => "Y",
		"USE_STORE_PHONE" => "Y",
		"USE_STORE_SCHEDULE" => "Y",
		"USE_MIN_AMOUNT" => "Y",
		"MIN_AMOUNT" => "4",
		"STORE_PATH" => "/contacts/stores/#store_id#/",
		"MAIN_TITLE" => "Наличие на складах",
		"MAIN_TITLE_LIST" => "Наличие",
		"MAX_AMOUNT" => "8",
		"USE_ONLY_MAX_AMOUNT" => "Y",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"MAX_COUNT" => "0",
		"DEFAULT_COUNT" => "1",
		"USE_RATING" => "Y",
		"PROIZVODITEL" => "PROIZVODITEL",
		"EMKOST" => "EMKOST",
		"POLARNOST" => "POLARNOST",
		"KLEMMY" => "KLEMMY",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "main_with_types",
		"SECTIONS_TYPE_VIEW" => "sections_1",
		"SECTION_ELEMENTS_TYPE_VIEW" => "list_elements_1",
		"ELEMENT_TYPE_VIEW" => "FROM_MODULE",
		"BIGDATA_EXT" => "bigdata_1",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"SHOW_MEASURE_WITH_RATIO" => "N",
		"SHOW_DISCOUNT_PERCENT_NUMBER" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"ALT_TITLE_GET" => "NORMAL",
		"SHOW_DISCOUNT_TIME" => "Y",
		"SHOW_COUNTER_LIST" => "Y",
		"SHOW_DISCOUNT_TIME_EACH_SKU" => "N",
		"SHOW_RATING" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"DETAIL_DOCS_PROP" => "FILES",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"DETAIL_STRICT_SECTION_CHECK" => "N",
		"SET_LAST_MODIFIED" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"SHOW_HOW_BUY" => "Y",
		"TITLE_HOW_BUY" => "Как купить",
		"SHOW_DELIVERY" => "N",
		"TITLE_DELIVERY" => "Доставка",
		"SHOW_PAYMENT" => "N",
		"TITLE_PAYMENT" => "Оплата",
		"SHOW_GARANTY" => "Y",
		"TITLE_GARANTY" => "Условия гарантии",
		"IBLOCK_STOCK_ID" => "133",
		"SHOW_MEASURE" => "N",
		"SHOW_UNABLE_SKU_PROPS" => "Y",
		"SHOW_ARTICLE_SKU" => "N",
		"DISPLAY_WISH_BUTTONS" => "Y",
		"STIKERS_PROP" => "HIT",
		"SALE_STIKER" => "SALE_TEXT",
		"SHOW_HINTS" => "Y",
		"AJAX_FILTER_CATALOG" => "Y",
		"USE_FILTER_PRICE" => "N",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"RESTART" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"NO_WORD_LOGIC" => "Y",
		"SECTION_TOP_BLOCK_TITLE" => "Лучшие предложения",
		"SECTIONS_LIST_PREVIEW_PROPERTY" => "DESCRIPTION",
		"SECTIONS_LIST_PREVIEW_DESCRIPTION" => "Y",
		"SHOW_SECTION_LIST_PICTURES" => "Y",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"SORT_BUTTONS" => array(
			0 => "POPULARITY",
			1 => "NAME",
			2 => "PRICE",
			3 => "QUANTITY"
		),
		"SORT_PRICES" => "REGION_PRICE",
		"SORT_REGION_PRICE" => "BASE",
		"DEFAULT_LIST_TEMPLATE" => "block",
		"SECTION_DISPLAY_PROPERTY" => "",
		"SECTION_PREVIEW_PROPERTY" => "DESCRIPTION",
		"SHOW_SECTION_PICTURES" => "Y",
		"SHOW_SECTION_DESC" => "Y",
		"LANDING_TITLE" => "Популярные категории",
		"LANDING_SECTION_COUNT" => "7",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"SHOW_DEACTIVATED" => "N",
		"DISPLAY_ELEMENT_SLIDER" => "32",
		"TITLE_SLIDER" => "Рекомендуем",
		"VIEW_BLOCK_TYPE" => "N",
		"PROPERTIES_DISPLAY_LOCATION" => "TAB",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "Y",
		"ADD_SECTION_DETAIL_TO_SLIDER" => "N",
		"SHOW_BRAND_PICTURE" => "Y",
		"SHOW_CHEAPER_FORM" => "Y",
		"SHOW_SEND_GIFT" => "Y",
		"SEND_GIFT_FORM_NAME" => "",
		"CHEAPER_FORM_NAME" => "",
		"SHOW_ASK_BLOCK" => "Y",
		"ASK_FORM_ID" => "2",
		"DETAIL_OFFERS_LIMIT" => "0",
		"DETAIL_EXPANDABLES_TITLE" => "Аксессуары",
		"DETAIL_ASSOCIATED_TITLE" => "Похожие товары",
		"SHOW_ADDITIONAL_TAB" => "Y",
		"PROPERTIES_DISPLAY_TYPE" => "TABLE",
		"LIST_PRODUCT_BLOCKS_TAB_ORDER" => "desc,char,reviews,suitable,buy,question,offers,cash,delivery,video",
		"SHOW_KIT_PARTS" => "N",
		"SHOW_KIT_PARTS_PRICES" => "N",
		"SHOW_ONE_CLICK_BUY" => "Y",
		"USE_SHARE" => "Y",
		"SKU_DETAIL_ID" => "oid",
		"USE_ADDITIONAL_GALLERY" => "Y",
		"ADDITIONAL_GALLERY_PROPERTY_CODE" => "PHOTO_GALLERY",
		"ADDITIONAL_GALLERY_TYPE" => "SMALL",
		"TAB_OFFERS_NAME" => "",
		"TAB_DESCR_NAME" => "",
		"TAB_CHAR_NAME" => "",
		"TAB_VIDEO_NAME" => "",
		"TAB_REVIEW_NAME" => "",
		"TAB_FAQ_NAME" => "",
		"TAB_STOCK_NAME" => "",
		"TAB_DOPS_NAME" => "",
		"BLOCK_SERVICES_NAME" => "",
		"BLOCK_LANDINGS_NAME" => "",
		"BLOCK_DOCS_NAME" => "",
		"IBLOCK_SERVICES_ID" => "134",
		"BLOG_IBLOCK_ID" => "157",
		"BLOCK_BLOG_NAME" => "",
		"RECOMEND_COUNT" => "5",
		"VISIBLE_PROP_COUNT" => "5",
		"BUNDLE_ITEMS_COUNT" => "3",
		"USE_GIFTS_DETAIL" => "Y",
		"USE_GIFTS_SECTION" => "Y",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
		"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
		"STORES" => array(
			0 => "1",
			1 => "5",
		),
		"USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"STORES_FILTER" => "TITLE",
		"STORES_FILTER_ORDER" => "SORT_ASC",
		"USE_BIG_DATA" => "Y",
		"BIG_DATA_RCM_TYPE" => "bestsell",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"COMPATIBLE_MODE" => "Y",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"PROP_TYRE_SHIRINA_PROFILYA" => "0",
		"PROP_TYRE_VYSOTA_PROFILYA" => "0",
		"PROP_TYRE_POSADOCHNYY_DIAMETR" => "0",
		"PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA" => "POSADOCHNYY_DIAMETR_DISKA",
		"PROP_DISK_SHIRINA_DISKA" => "SHIRINA_DISKA",
		"PROP_DISK_MEZHBOLTOVOE_RASSTOYANIE" => "MEZHBOLTOVOE_RASSTOYANIE",
		"PROP_DISK_COUNT_OTVERSTIY" => "COUNT_OTVERSTIY",
		"PROP_DISK_VYLET_DISKA" => "VYLET_DISKA",
		"PROP_DISK_DIAMETR_STUPITSY" => "DIAMETR_STUPITSY",
		"PROP_AKB_LENGTH" => "0",
		"PROP_AKB_WIDTH" => "0",
		"PROP_AKB_HEIGHT" => "0",
		"PROP_AKB_EMKOST" => "0",
		"PROP_AKB_POLARNOST" => "0",
		"PROP_AKB_TYPE" => "0",
		"PROP_AKB_VOLTAG" => "0",
		"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
		"COMPARE_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"COMPARE_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"COMPARE_ELEMENT_SORT_FIELD" => "sort",
		"COMPARE_ELEMENT_SORT_ORDER" => "asc",
		"DISPLAY_ELEMENT_SELECT_BOX" => "N",
		"USE_SIMILAR_PARAMS" => "Y",
		"TITLE_SIMILAR_PARAMS" => "",
		"LIST_SIMILAR_PARAMS" => array(
			0 => "SHIRINA_DISKA",
			1 => "POSADOCHNYY_DIAMETR_DISKA",
			2 => "COUNT_OTVERSTIY",
			3 => "MEZHBOLTOVOE_RASSTOYANIE",
		),
		"SORT_TAB_BUTTONS" => "PRICE",
		"SORT_TAB_BUTTONS_ORDER" => "asc",
		"SORT_TAB_PRICES" => "REGION_PRICE",
		"SORT_TAB_REGION_PRICE" => "BASE",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"USE_SUITABLE_CAR" => "Y",
		"TAB_SUITABLE_NAME" => "",
		"BLOCK_TITLE_TIRES" => "",
		"BLOCK_TITLE_TIRES_MOTO" => "",
		"BLOCK_TITLE_TIRES_TRUCK" => "",
		"SHOW_SUBSECTION_PREVIEW_PROPERTY" => "UF_SECTION_DESCR",
		"SHOW_SUBSECTION_DESC" => "Y",
		"SECTION_LINE_ELEMENT" => "4",
		"STORES_FILTER_PARAM" => array(
			0 => "STORE",
		),
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"element" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "search/#SMART_FILTER_PATH#/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>