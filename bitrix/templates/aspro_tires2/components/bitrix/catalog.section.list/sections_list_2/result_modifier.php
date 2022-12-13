<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>
<?
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Type\Collection,
	Bitrix\Main\Localization\Loc;

if (!empty($arResult['SECTIONS']))
{
	\Bitrix\Main\Type\Collection::sortByColumn($arResult["SECTIONS"], array("SORT" => SORT_ASC, "NAME" => array(SORT_NATURAL | SORT_FLAG_CASE, SORT_ASC)));
	$arResult["SECTIONS"] = array_values($arResult["SECTIONS"]); //reset keys

	$arResult["COUNTS_ALL_SECTIONS"] = count($arResult["SECTIONS"]);

	if($arResult["COUNTS_ALL_SECTIONS"] > 1)
	{
		$arSection=array();

		$arParams["PAGE"] = ($arParams["PAGE"]!='' ? $arParams["PAGE"] : 1);
		$page = (int)abs($arParams["PAGE"]);
		$count=ceil($arResult["COUNTS_ALL_SECTIONS"]/$arParams["SECTION_PAGE_ELEMENT"]);
		$page = ($page > $count ? 1 : $page);
		$limit = $arResult["COUNTS_ALL_SECTIONS"] < $page * $arParams["SECTION_PAGE_ELEMENT"] ? $arResult["COUNTS_ALL_SECTIONS"] : $page * $arParams["SECTION_PAGE_ELEMENT"];
		$arResult["PAGE"] = $page;

		for($i = ($page - 1) * $arParams["SECTION_PAGE_ELEMENT"]; $i < $limit; $i++)
			$arSection[] = $arResult["SECTIONS"][$i];

		$arResult["SECTIONS"] = $arSection;
	}

}?>