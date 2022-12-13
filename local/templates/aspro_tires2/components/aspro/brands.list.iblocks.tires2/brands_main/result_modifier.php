<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arResult)
{
	$arResult["ITEMS"] = array();
	foreach($arResult as $key => $arIBlock)
	{
		if($arIBlock["ITEMS"])
			$arResult["ITEMS"] = array_merge($arResult["ITEMS"], $arIBlock["ITEMS"]);
	}
	$sort1 = (strtoupper($arParams["SORT_ORDER1"]) == "DESC" ? SORT_DESC : SORT_ASC);
	$sort2 = (strtoupper($arParams["SORT_ORDER2"]) == "DESC" ? SORT_DESC : SORT_ASC);
	if($arResult["ITEMS"])
		\Bitrix\Main\Type\Collection::sortByColumn($arResult["ITEMS"], array($arParams["SORT_BY1"] => $sort1, $arParams["SORT_BY2"] => $sort2));
}
?>