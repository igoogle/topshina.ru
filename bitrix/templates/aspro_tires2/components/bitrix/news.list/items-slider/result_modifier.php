<?
if($arResult['ITEMS'])
{
	$arSectionsIDs = array();
	foreach($arResult['ITEMS'] as $key => $arItem)
	{
		$arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = CTires2::FormatNewsUrl($arItem);
		CTires2::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
		if($SID = $arItem['IBLOCK_SECTION_ID'])
		{
			$arSectionsIDs[] = $SID;
		}
		if($arItem['PROPERTIES'])
		{
			foreach($arItem['PROPERTIES'] as $key2 => $arProp)
			{
				if(($key2 == 'EMAIL' || $key2 == 'PHONE') && $arProp['VALUE'])
					$arResult['ITEMS'][$key]['MIDDLE_PROPS'][] = $arProp;
				if(strpos($key2, 'SOCIAL') !== false && $arProp['VALUE'])
					$arResult['ITEMS'][$key]['SOCIAL_PROPS'][] = $arProp;
			}
		}
	}
	if($arSectionsIDs){
		$arResult['SECTIONS'] = CTires2Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
	}
}
?>