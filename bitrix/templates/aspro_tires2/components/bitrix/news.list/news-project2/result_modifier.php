<?
foreach($arResult['ITEMS'] as $key => $arItem){
	if($SID = $arItem['IBLOCK_SECTION_ID']){
		$arSectionsIDs[] = $SID;
	}
	CTires2::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}

?>