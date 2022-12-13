<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		/*"AUTO_MARK" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_MANUFACTURER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),*/
		"CACHE_TIME" => Array(
			"DEFAULT" => "604800",
		),
		"TYPE_FILTER" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER"),
			"TYPE" => "LIST",
			"VALUES" => array(
				"tires" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_TIRES"),
				"wheels" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_WHEELS"),
				"akb" => GetMessage("AUTO_LIST_PARAMS_TYPE_FILTER_AKB")
			),
			"DEFAULT" => "tires",
			"REFRESH" => "Y",
		),
	),
);

if($arCurrentValues['TYPE_FILTER'] == 'tires')
{
	$arComponentParameters["PARAMETERS"]["TYRE_WIDTH"] = Array(
		"NAME" => GetMessage("T_TYRE_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["TYRE_PROFILE"] = Array(
		"NAME" => GetMessage("T_TYRE_PROFILE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["TYRE_DIAMETER"] = Array(
		"NAME" => GetMessage("T_TYRE_DIAMETER"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
}

if($arCurrentValues['TYPE_FILTER'] == 'wheels')
{
	$arComponentParameters["PARAMETERS"]["DISK_WIDTH"] = Array(
		"NAME" => GetMessage("T_DISK_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["DISK_DIAMETER"] = Array(
		"NAME" => GetMessage("T_DISK_DIAMETER"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["DISK_LZ"] = Array(
		"NAME" => GetMessage("T_DISK_LZ"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["DISK_PCD"] = Array(
		"NAME" => GetMessage("T_DISK_PCD"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
}

if($arCurrentValues['TYPE_FILTER'] == 'akb')
{
	$arComponentParameters["PARAMETERS"]["AKB_WIDTH"] = Array(
		"NAME" => GetMessage("T_AKB_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["AKB_LENGTH"] = Array(
		"NAME" => GetMessage("T_AKB_LENGTH"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["AKB_HEIGHT"] = Array(
		"NAME" => GetMessage("T_AKB_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["POLARITY"] = Array(
		"NAME" => GetMessage("T_POLARITY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["TYPE"] = Array(
		"NAME" => GetMessage("T_TYPE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["AMPERAGE"] = Array(
		"NAME" => GetMessage("T_AMPERAGE"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
	$arComponentParameters["PARAMETERS"]["CAPACITY"] = Array(
		"NAME" => GetMessage("T_CAPACITY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"PARENT" => "",
	);
}

?>
