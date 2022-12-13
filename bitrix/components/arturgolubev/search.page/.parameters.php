<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("search"))
	return;

$arComponentParameters = array(
	"GROUPS" => array(
		"PAGER_SETTINGS" => array(
			"NAME" => GetMessage("SEARCH_PAGER_SETTINGS"),
		),
	),
	"PARAMETERS" => array(
		// "AJAX_MODE" => array(),
		"CHECK_DATES" => array(
			"NAME" => GetMessage("SEARCH_CHECK_DATES"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"DEFAULT_SORT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_SP_DEFAULT_SORT"),
			"TYPE" => "LIST",
			"MULTIPLE" => "N",
			"DEFAULT" => "rank",
			"VALUES" => array(
				"rank" => GetMessage("CP_SP_DEFAULT_SORT_RANK"),
				"date" => GetMessage("CP_SP_DEFAULT_SORT_DATE"),
			),
		),
		
		"USE_LANGUAGE_GUESS" => Array(
			"NAME" => GetMessage("CP_BSP_USE_LANGUAGE_GUESS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "BASE",
		),
		
		// VISUAL
		
		"FILTER_NAME" => array(
			// "PARENT" => "BASE",
			"NAME" => GetMessage("CP_BSP_FILTER_NAME"),
			"TYPE" => "STRING",
		),
		"SHOW_WHERE" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("SEARCH_SHOW_DROPDOWN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"REFRESH" => "Y",
		),
		"arrWHERE" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("SEARCH_WHERE_DROPDOWN"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => CSearchParameters::GetFilterDropDown(),
		),
		"SHOW_WHEN" => array(
			"PARENT" => "VISUAL",
			"NAME" => GetMessage("CP_BSP_SHOW_WHEN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N"
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
		
		
		"PAGE_RESULT_COUNT" => array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("SEARCH_PAGE_RESULT_COUNT"),
			"TYPE" => "STRING",
			"DEFAULT" => "50",
		),
		"DISPLAY_TOP_PAGER" => Array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("CP_BSP_DISPLAY_TOP_PAGER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"DISPLAY_BOTTOM_PAGER" => Array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("CP_BSP_DISPLAY_BOTTOM_PAGER"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PAGER_TITLE" => array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("SEARCH_PAGER_TITLE"),
			"TYPE" => "STRING",
			"DEFAULT" => GetMessage("SEARCH_RESULTS"),
		),
		"PAGER_SHOW_ALWAYS" => array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("SEARCH_PAGER_SHOW_ALWAYS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"PAGER_TEMPLATE" => array(
			"PARENT" => "PAGER_SETTINGS",
			"NAME" => GetMessage("SEARCH_PAGER_TEMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
	),
);

if($arCurrentValues["SHOW_WHERE"] == "N")
	unset($arComponentParameters["PARAMETERS"]["arrWHERE"]);

CSearchParameters::AddFilterParams($arComponentParameters, $arCurrentValues, "arrFILTER", "BASE");
?>
