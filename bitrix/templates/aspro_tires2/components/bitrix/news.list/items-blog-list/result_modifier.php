<?
if($arResult['ITEMS'])
{
	foreach($arResult['ITEMS'] as $i => $arItem){
		CTires2::getFieldImageData($arResult['ITEMS'][$i], array('PREVIEW_PICTURE'));
	}
}
?>