<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$aMenuLinksExt = array();

$catalog_id = \Bitrix\Main\Config\Option::get('aspro.tires2', 'CATALOG_IBLOCK_ID', CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_catalog']['aspro_tires2_catalog'][0]);
$arSections = CTires2Cache::CIBlockSection_GetList(array('SORT' => 'ASC', 'ID' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($catalog_id), 'MULTI' => 'Y')), array('IBLOCK_ID' => $catalog_id, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', '<DEPTH_LEVEL' => \Bitrix\Main\Config\Option::get("aspro.tires2", "MAX_DEPTH_MENU", 2)));
$arSectionsByParentSectionID = CTires2Cache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));

if($arSections)
	CTires2::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>