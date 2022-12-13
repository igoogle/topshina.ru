<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?global $arTheme;?>
<div class="filters_wrap">
	<div class="row flexbox">
		<div class="col-md-6 col-sm-6 item item_tires">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter", 
				"front", 
				array(
					"IBLOCK_TYPE" => "aspro_tires2_catalog",
					"IBLOCK_ID" => $arTheme["CATALOG_TIRES_IBLOCK_ID"]["VALUE"],
					"FILTER_URL" => $arTheme["CATALOG_TIRES_PAGE_URL"]["VALUE"],
					"SECTION_ID" => "",
					"FILTER_NAME" => "arTires2Filter",
					"PRICE_CODE" => array(),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "86400",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "N",
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					"SHOW_HINTS" => "N",
					"CONVERT_CURRENCY" => "N",
					"CURRENCY_ID" => "",
					"DISPLAY_ELEMENT_COUNT" => "N",
					"INSTANT_RELOAD" => "Y",
					"VIEW_MODE" => "",
					"SEF_MODE" => "N",
					"SEF_RULE" => "",
					"SMART_FILTER_PATH" => "",
					"HIDE_NOT_AVAILABLE" => "N",
					"COMPONENT_TEMPLATE" => "front",
					"SECTION_CODE" => "",
					"PAGER_PARAMS_NAME" => "arrPager",
					"BLOCK_TITLE_TIRES" => "шин",
					"BLOCK_TITLE_TIRES_MOTO" => "мотошин",
					"BLOCK_TITLE_TIRES_TRUCK" => "грузовых шин",
					'TYPE' => 'tires',
					'ALL_LINK_TITLE' => 'Все шины',
				),
				false
			);?>
		</div>
		<div class="col-md-6 col-sm-6 item">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter", 
				"front", 
				array(
					"IBLOCK_TYPE" => "aspro_tires2_catalog",
					"IBLOCK_ID" => $arTheme["CATALOG_WHEELS_IBLOCK_ID"]["VALUE"],
					"FILTER_URL" => $arTheme["CATALOG_DISK_PAGE_URL"]["VALUE"],
					"SECTION_ID" => "",
					"FILTER_NAME" => "arTires2Filter",
					"PRICE_CODE" => array(),
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "86400",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "N",
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					"SHOW_HINTS" => "N",
					"CONVERT_CURRENCY" => "N",
					"CURRENCY_ID" => "",
					"DISPLAY_ELEMENT_COUNT" => "N",
					"INSTANT_RELOAD" => "Y",
					"VIEW_MODE" => "",
					"SEF_MODE" => "N",
					"SEF_RULE" => "",
					"SMART_FILTER_PATH" => "",
					"HIDE_NOT_AVAILABLE" => "N",
					"COMPONENT_TEMPLATE" => "front",
					"SECTION_CODE" => "",
					"PAGER_PARAMS_NAME" => "arrPager",
					"BLOCK_TITLE_WHEELS" => "дисков",
					'TYPE' => 'wheels',
					'ALL_LINK_TITLE' => 'Все диски',
				),
				false
			);?>
		</div>
	</div>

	<div id="filter_result" class="clearfix">
		<div class="title pull-left">Результаты</div>
		<div class="block_all_results">
			<div class="tyres_result"></div>
			<div class="wheels_result"></div>
		</div>
	</div>	
</div>