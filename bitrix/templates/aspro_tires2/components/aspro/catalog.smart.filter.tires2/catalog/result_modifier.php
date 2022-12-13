<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $arPropType, $arRegion;
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";
$arPropType = \Aspro\Functions\CAsproTires2::getParametersPropType();

$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

if($request["reset_form"] == "Y")
	$arResult["RESET_FORM"] = "Y";

if($arParams["INSTANT_RELOAD"] == "Y")
	$arResult["JS_FILTER_PARAMS"]["AJAX_FILTER"] = "Y";

include_once("functions.php");

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
	$arPropType["PROP_PROIZVODITEL"]["VALUE"],
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
	//$arPropType["PROP_TYRE_RNF"]["VALUE"],
);

$arFormatProps = \Aspro\Functions\CAsproTires2::getFormatedProps();

$bShowAllProps = (isset($arParams["ALL_PROPS"]) && $arParams["ALL_PROPS"] == "Y");
$arResult["TOP_PROPS"] = $arResult["OTHER_PROPS"] = array();
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if(!in_array($arItem["CODE"], $arShowProps))
	{
		if($bShowAllProps)
			$arResult["OTHER_PROPS"][$key] = $arItem;
		else
			unset($arResult["ITEMS"][$key]);
	}
	else
	{
		$arResult["TOP_PROPS"][$key] = $arItem;
	}
}

$arResult["ITEMS"] = formatFilterProps($arResult["ITEMS"], $arPropType, $arFormatProps);

if($arResult["TOP_PROPS"])
	$arResult["TOP_PROPS"] = formatFilterProps($arResult["TOP_PROPS"], $arPropType, $arFormatProps);

if($arResult["OTHER_PROPS"])
	$arResult["OTHER_PROPS"] = formatFilterProps($arResult["OTHER_PROPS"], $arPropType, $arFormatProps);

/* resort values */
foreach($arResult["ITEMS"] as $key => $arItem)
{
	if($arItem["VALUES"])
	{
		if($arFormatProps[$arItem["CODE"]])
			\Bitrix\Main\Type\Collection::sortByColumn($arResult["ITEMS"][$key]["VALUES"], array("VALUE" => array(SORT_NUMERIC, SORT_ASC)));
	}
}

if($arResult["TOP_PROPS"])
{
	foreach($arResult["TOP_PROPS"] as $key => $arItem)
	{
		if($arItem["VALUES"])
		{
			if($arFormatProps[$arItem["CODE"]])
				\Bitrix\Main\Type\Collection::sortByColumn($arResult["TOP_PROPS"][$key]["VALUES"], array("VALUE" => array(SORT_NUMERIC, SORT_ASC)));
		}
	}
}

if($arResult["OTHER_PROPS"])
{
	foreach($arResult["OTHER_PROPS"] as $key => $arItem)
	{
		if($arItem["VALUES"])
		{
			if($arFormatProps[$arItem["CODE"]])
				\Bitrix\Main\Type\Collection::sortByColumn($arResult["OTHER_PROPS"][$key]["VALUES"], array("VALUE" => array(SORT_NUMERIC, SORT_ASC)));
		}
	}
}
/**/
?>