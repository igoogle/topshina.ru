<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$aMenuLinksExt = $arSections = array();
if($arMenuParametrs = CTires2::GetDirMenuParametrs(__DIR__))
{
	if($arMenuParametrs['MENU_SHOW_SECTIONS'] == 'Y')
	{
		$catalog_id = \Bitrix\Main\Config\Option::get('aspro.tires2', 'CATALOG_WHEELS_IBLOCK_ID', CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_catalog']['aspro_tires2_catalog_wheels'][0]);
		$arSections = CTires2Cache::CIBlockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($catalog_id), 'MULTI' => 'Y')), array('IBLOCK_ID' => $catalog_id, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', '<DEPTH_LEVEL' => \Bitrix\Main\Config\Option::get("aspro.tires2", "MAX_DEPTH_MENU", 2)));
		$arSectionsByParentSectionID = CTires2Cache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
	}
	if($arSections)
	{
		CTires2::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);
		// $aMenuLinksExt[] = array('MENU_CATALOG_ID', '', array(), array('MENU_CATALOG_ID' => $catalog_id));
	}
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>