<?
foreach($arResult['ITEMS'] as $key => $arItem){
	if($SID = $arItem['IBLOCK_SECTION_ID']){
		$arSectionsIDs[] = $SID;
	}
	$arResult['ITEMS'][$key]['DETAIL_PAGE_URL'] = CTires2::FormatNewsUrl($arItem);
	$arResult["ITEMS"][$key]["PROPS_FORMAT"] = \Aspro\Functions\CAsproTires2::prepareItemProps($arItem['DISPLAY_PROPERTIES']);
	
	if(strlen($arItem['DISPLAY_PROPERTIES']['REDIRECT']['VALUE']))
		unset($arResult['ITEMS'][$key]['DISPLAY_PROPERTIES']['REDIRECT']);
	CTires2::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}

if($arSectionsIDs){
	$arResult['SECTIONS'] = CTires2Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
}
?>