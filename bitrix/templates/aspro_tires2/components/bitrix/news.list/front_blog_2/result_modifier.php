<?if(!defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED !== true) die();?>
<?
if($arResult['ITEMS'])
{
	$arWideItem = $arGoodsSections = $arGoodsSectionsIDs = array();
	$bWideBlock = false;
	foreach($arResult["ITEMS"] as $key => $arItem)
	{
		/*if($key > 4)
			unset($arResult["ITEMS"][$key]);
		else
		{*/
			if($arItem['IBLOCK_SECTION_ID'])
			{
				$resGroups = CIBlockElement::GetElementGroups($arItem['ID'], true, array('ID'));
				while($arGroup = $resGroups->Fetch())
				{
					$arResult['ITEMS'][$key]['SECTIONS'][$arGroup['ID']] = $arGroup['ID'];
					$arGoodsSectionsIDs[$arGroup['ID']] = $arGroup['ID'];
				}
			}
			$arResult["ITEMS"][$key]["DETAIL_PAGE_URL"] = CTires2::FormatNewsUrl($arItem);

			if($arItem['PROPERTIES']['BIG_BLOCK']['VALUE'] == 'Y' && !$bWideBlock)
			{
				$bWideBlock = true;
				$arWideItem = $arResult["ITEMS"][$key];
				unset($arResult["ITEMS"][$key]);
			}
		//}
	}
	if($bWideBlock)
		array_unshift($arResult["ITEMS"], $arWideItem);

	if($arGoodsSectionsIDs)
	{
		$arGoodsSections = CTires2Cache::CIBLockSection_GetList(array('CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N', 'RESULT' => array('NAME'))), array('ID' => $arGoodsSectionsIDs), false, array('ID', 'NAME'));
		foreach($arResult['ITEMS'] as $key => $arItem)
		{
			if($arItem['IBLOCK_SECTION_ID'])
			{
				foreach($arItem['SECTIONS'] as $id => $name)
					$arResult['ITEMS'][$key]['SECTIONS'][$id] = $arGoodsSections[$id];
			}
		}
	}
}
?>