<? /*
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$aMenuLinksExt = array();
if($arMenuParametrs = CTires2::GetDirMenuParametrs(__DIR__))
	{
	if($arMenuParametrs['MENU_SHOW_SECTIONS'] == 'Y')
	{
		$arSections = CTires2Cache::CIBlockSection_GetList(array('SORT' => 'ASC', 'ID' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag(CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_content']['aspro_tires2_services'][0]), 'MULTI' => 'Y')), array('IBLOCK_ID' => CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_content']['aspro_tires2_services'][0], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'));
		$arSectionsByParentSectionID = CTires2Cache::GroupArrayBy($arSections, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
	}

	if($arMenuParametrs['MENU_SHOW_ELEMENTS'] == 'Y')
	{ */
		/*filter by region*/
		/*global $arRegion;
		$arFilterItem = array('IBLOCK_ID' => CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_content']['aspro_tires2_services'][0], 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y', 'INCLUDE_SUBSECTIONS' => 'Y');
		$arSelect = array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'ACTIVE', 'SORT', 'DETAIL_PAGE_URL');

		$arItems = CTires2Cache::CIBlockElement_GetList(array('SORT' => 'ASC', 'ID' => 'DESC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag(CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_content']['aspro_tires2_services'][0]), 'MULTI' => 'Y')), $arFilterItem, false, false, $arSelect);
		if($arMenuParametrs['MENU_SHOW_SECTIONS'] == 'Y')
		{
			$arItemsBySectionID = CTires2Cache::GroupArrayBy($arItems, array('MULTI' => 'Y', 'GROUP' => array('IBLOCK_SECTION_ID')));
		}
		else
		{
			unset($arFilterItem['SECTION_GLOBAL_ACTIVE']);
			unset($arFilterItem['INCLUDE_SUBSECTIONS']);
			$arFilterItem['SECTION_ID'] = 0;*/

			/*$arItemsRoot = CTires2Cache::CIBlockElement_GetList(array('SORT' => 'ASC', 'ID' => 'DESC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag(CTires2Cache::$arIBlocks[SITE_ID]['aspro_tires2_content']['aspro_tires2_services'][0]), 'MULTI' => 'Y')), $arFilterItem, false, false, $arSelect);
			$arItems = array_merge((array)$arItems, (array)$arItemsRoot);*/
		/*}
		if($arItems)
		{
			foreach($arItems as $key => $arItem)
			{
				$arTmpProp = array();
				$rsPropRegion = CIBlockElement::GetProperty($arItem['IBLOCK_ID'], $arItem['ID'], array('sort' => 'asc'), Array('CODE'=>'LINK_REGION'));
				while($arPropRegion = $rsPropRegion->Fetch())
				{
					if($arPropRegion['VALUE'])
						$arTmpProp[] = $arPropRegion['VALUE'];
				}
				$arItems[$key]['LINK_REGION'] = $arTmpProp;
			}
		}
	}
	if($arSections)
	{
		CTires2::getSectionChilds(false, $arSections, $arSectionsByParentSectionID, $arItemsBySectionID, $aMenuLinksExt);
	}

	if($arItems && $arMenuParametrs['MENU_SHOW_SECTIONS'] != 'Y')
	{
		foreach($arItems as $arItem)
		{
			$arExtParam = array('FROM_IBLOCK' => 1, 'DEPTH_LEVEL' => 1);
			if(isset($arItem['LINK_REGION']))
				$arExtParam['LINK_REGION'] = $arItem['LINK_REGION'];
			$aMenuLinksExt[] = array($arItem['NAME'], $arItem['DETAIL_PAGE_URL'], array(), $arExtParam);
		}
	}
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
*/?>
