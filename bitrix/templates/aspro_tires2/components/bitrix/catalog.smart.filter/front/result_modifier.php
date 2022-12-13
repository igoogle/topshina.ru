<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $arPropType, $arRegion;
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
$arPropType = \Aspro\Functions\CAsproTires2::getParametersPropType();

$arShowProps = array(
	$arPropType["PROP_TYRE_SHIRINA_PROFILYA"]["VALUE"],
	$arPropType["PROP_TYRE_VYSOTA_PROFILYA"]["VALUE"],
	$arPropType["PROP_TYRE_POSADOCHNYY_DIAMETR"]["VALUE"],
	$arPropType["PROP_TYRE_SHIRINA_MOTO_PROFILYA"]["VALUE"],
	$arPropType["PROP_TYRE_VYSOTA_MOTO_PROFILYA"]["VALUE"],
	$arPropType["PROP_TYRE_POSADOCHNYY_MOTO_DIAMETR"]["VALUE"],
	$arPropType["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"]["VALUE"],
	$arPropType["PROP_DISK_SHIRINA_DISKA"]["VALUE"],
	$arPropType["PROP_DISK_MEZHBOLTOVOE_RASSTOYANIE"]["VALUE"],
	$arPropType["PROP_DISK_COUNT_OTVERSTIY"]["VALUE"],
	$arPropType["PROP_DISK_VYLET_DISKA"]["VALUE"],
	$arPropType["PROP_DISK_DIAMETR_STUPITSY"]["VALUE"],
	$arPropType["PROP_AKB_LENGTH"]["VALUE"],
	$arPropType["PROP_AKB_WIDTH"]["VALUE"],
	$arPropType["PROP_AKB_HEIGHT"]["VALUE"],
	$arPropType["PROP_AKB_EMKOST"]["VALUE"],
	$arPropType["PROP_AKB_POLARNOST"]["VALUE"],
	$arPropType["PROP_AKB_TYPE"]["VALUE"],
	$arPropType["PROP_AKB_VOLTAG"]["VALUE"],
	$arPropType["PROP_TYRE_SEASON"]["VALUE"],
	$arPropType["PROP_TYRE_SPIKES"]["VALUE"],
	$arPropType["PROP_TYRE_SEASON_MOTO"]["VALUE"],
	$arPropType["PROP_TYRE_SPIKES_MOTO"]["VALUE"],
	$arPropType["PROP_TYRE_SEASON_TRUCK"]["VALUE"],
	$arPropType["PROP_TYRE_SPIKES_TRUCK"]["VALUE"],
	$arPropType["PROP_TYRE_MOTO_AXLE"]["VALUE"],
	$arPropType["PROP_TYRE_RNF"]["VALUE"],
);

$arFormatProps = \Aspro\Functions\CAsproTires2::getFormatedProps();

$arRNF = array();

foreach($arResult["ITEMS"] as $key => $arItem)
{
	if(!in_array($arItem["CODE"], $arShowProps))
	{
		unset($arResult["ITEMS"][$key]);
	}
}
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["VALUES"])
	{
		if(count($arItem["VALUES"]) == 1)
		{
			if($arItem["CODE"] != "IN_STOCK" && $arItem["CODE"] != $arPropType["PROP_TYRE_RNF"]["VALUE"])
				unset($arResult["ITEMS"][$key]);
		}
		else
		{
			foreach($arItem["VALUES"] as $key2 => $arValue)
			{
				if($arFormatProps[$arItem["CODE"]]){
					if(preg_match('/^[-]*\d+[.]\d*$/', $arValue["VALUE"])){
						$arResult["ITEMS"][$key]["VALUES"][$key2]['VALUE'] = (float)$arValue["VALUE"];
					}

					if($arValue["HTML_VALUE_ALT"] != ($tmpValue = crc32($arResult["ITEMS"][$key]["VALUES"][$key2]['VALUE']))){
						$arResult["ITEMS"][$key]["VALUES"][$key2]["CONTROL_ID"] = str_replace($arValue["HTML_VALUE_ALT"], $tmpValue, $arValue["CONTROL_ID"]);
					}
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_SPIKES"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_SPIKES_Y"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-spikes";
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_SPIKES"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_SPIKES_N"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-spikes-no";
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_SEASON"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_SUMMER"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-summer";
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_WINTER"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-winter";
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_SEASON_ALL"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-allseason";
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"] && $arPropType["PROP_TYRE_RNF_ONE"]["VALUE"] != "N")
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_RNF_Y"]["VALUE"]) {
						$arResult["ITEMS"][$key]["VALUES"][$key2]["EXT_CLASS"] = "icon-rnf";
					} else {
						unset($arResult["ITEMS"][$key]["VALUES"][$key2]);
					}
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_L"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_L_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_MC"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_MC_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_GR"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_GR_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_VND"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_VND_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_VEHICLE_TYPE_UN"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_VEHICLE_TYPE_UN_TITLE");
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_1"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_1_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_2"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_2_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_3"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_3_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_4"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_4_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_5"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_5_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_6"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_6_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_APPLICATION_TYPE_7"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_APPLICATION_TYPE_7_TITLE");
				}

				if($arItem["CODE"] == $arPropType["PROP_TYRE_ACHE_TYPE"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_1"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_1_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_2"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_2_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_3"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_3_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_4"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_4_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_5"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_5_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_6"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_6_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_TYRE_ACHE_TYPE_7"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_TYRE_ACHE_TYPE_7_TITLE");
				}

				if($arItem["CODE"] == $arPropType["PROP_DISK_TYPE"]["VALUE"])
				{
					if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_1"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_1_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_2"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_2_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_3"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_3_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_4"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_4_TITLE");
					if($arValue["VALUE"] == $arPropType["PROP_DISK_TYPE_5"]["VALUE"])
						$arResult["ITEMS"][$key]["VALUES"][$key2]["VALUE"] = GetMessage("PROP_DISK_TYPE_5_TITLE");
				}
			}
		}
	}
	if($arItem["CODE"]=="IN_STOCK" || $arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"])
	{
		if($arResult["ITEMS"][$key]["VALUES"]){
			sort($arResult["ITEMS"][$key]["VALUES"]);
			$arResult["ITEMS"][$key]["VALUES"][0]["VALUE"]=$arItem["NAME"];

			if($arItem["CODE"] == $arPropType["PROP_TYRE_RNF"]["VALUE"]/* && $arPropType["PROP_TYRE_RNF_ONE"]["VALUE"] != "Y"*/)
			{
				$arResult["ITEMS"][$key]["VALUES"][0]["EXT_CLASS"] = "icon-rnf";
				$arRNF = $arResult["ITEMS"][$key];
				unset($arResult["ITEMS"][$key]);
			}
		}

	}
}
/* resort values */
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["VALUES"])
	{
		if($arFormatProps[$arItem["CODE"]])
			\Bitrix\Main\Type\Collection::sortByColumn($arResult["ITEMS"][$key]["VALUES"], array("VALUE" => array(SORT_NUMERIC, SORT_ASC)));
	}
}
/**/

if($arRNF)
{
	$arResult["ITEMS"][$arRNF["ID"]] = $arRNF;
}
?>