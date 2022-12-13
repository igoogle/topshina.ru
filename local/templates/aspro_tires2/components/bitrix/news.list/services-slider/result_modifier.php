<?
foreach($arResult['ITEMS'] as $key => $arItem){
	CTires2::getFieldImageData($arResult['ITEMS'][$key], array('PREVIEW_PICTURE'));
}
?>