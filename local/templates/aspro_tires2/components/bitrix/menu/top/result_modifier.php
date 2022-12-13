<?
if($arResult)
{
	global $APPLICATION;
	/*$cur_page = $GLOBALS['APPLICATION']->GetCurPage(true);
	$cur_page_no_index = $GLOBALS['APPLICATION']->GetCurPage(false);

	foreach($arResult as $key=>$arItem)
	{
		if(!$arItem['SELECTED'])
			$arResult[$key]['SELECTED'] = CMenu::IsItemSelected($arItem['LINK'], $cur_page, $cur_page_no_index);
	}*/
	
	$arResult = CTires2::getChilds($arResult);
	global $arRegion, $arTheme;

	foreach($arResult as $key=>$arItem)
	{

		if(isset($arItem['CHILD']))
		{
			foreach($arItem['CHILD'] as $key2=>$arItemChild)
			{
				if(isset($arItemChild['PARAMS']) && $arRegion && $arTheme['USE_REGIONALITY']['VALUE'] === 'Y' && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_FILTER_ITEM']['VALUE'] === 'Y')
				{
					// filter items by region
					if(isset($arItemChild['PARAMS']['LINK_REGION']))
					{
						if($arItemChild['PARAMS']['LINK_REGION'])
						{
							if(!in_array($arRegion['ID'], $arItemChild['PARAMS']['LINK_REGION']))
								unset($arResult[$key]['CHILD'][$key2]);
						}
						else
							unset($arResult[$key]['CHILD'][$key2]);
					}
				}
			}
		}
	}
	if($arTheme["CATALOG_DROPDOWN_MENU"]["VALUE"] == "1" && $arResult)
	{
		$iblockID = CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_megamenu"][0];

		$arTmpSections = $arSections = array();

		foreach($arResult as $key => $arMenu)
		{
			if($arMenu['PARAMS']['CATALOG_CODE'])
			{
				//get catalog codes
				$arTmpSections[$arMenu['PARAMS']['CATALOG_CODE']] = $key;
			}
		}

		if($arTmpSections)
		{
			//get root sections
			$arSections = CTires2Cache::CIBlockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($iblockID), 'MULTI' => 'N', 'GROUP' => 'CODE')), array('IBLOCK_ID' => $iblockID, 'ACTIVE' => 'Y', 'CODE' => array_keys($arTmpSections)), false, array('ID', 'CODE'));

			if($arSections)
			{
				$arSubSections = $arItems = array();

				//get subsections
				foreach($arSections as $key => $arSection)
				{
					$arSection['ITEMS'] = CTires2Cache::CIBlockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($iblockID), 'MULTI' => 'N', 'GROUP' => 'ID')), array('IBLOCK_ID' => $iblockID, 'ACTIVE' => 'Y', 'SECTION_ID' => $arSection['ID']), false, array('ID', 'NAME'));
					$arSections[$key]['ITEMS'] = $arSection['ITEMS'];
					$arSubSections = array_merge($arSubSections, array_keys($arSection['ITEMS']));
				}

				if($arSubSections)
				{
					//get items
					$arFilterItem = array('SECTION_ID' => $arSubSections, 'ACTIVE' => 'Y');
					$arSelect = array('ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'PROPERTY_URL');
					$arItems = CTires2Cache::CIBlockElement_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('MULTI' => 'Y', 'GROUP' => 'IBLOCK_SECTION_ID')), $arFilterItem, false, false, $arSelect);

					if($arItems)
					{
						foreach($arSections as $key => $arSection)
						{
							if($arSection['ITEMS'])
							{
								foreach($arSection['ITEMS'] as $key2 => $arSubSection)
								{
									if($arItems[$key2])
										$arSections[$key]['ITEMS'][$key2]['ITEMS'] = $arItems[$key2];
									else
										unset($arSections[$key]['ITEMS'][$key2]);
								}
							}
						}

						//merge menu childs
						foreach($arTmpSections as $key => $value)
						{
							if($arResult[$value]['CHILD'])
							{
								$arResult[$value]['CHILD2'] = $arResult[$value]['CHILD'];
								$arResult[$value]['CHILD'] = $arSections[$key];
							}
						}
					}
				}
			}
		}
	}
}
?>