<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$arResult = array('ERROR' => '', 'ITEMS' => array());

if(!CModule::IncludeModule('aspro.tires2')){
	$arResult['ERROR'] = GetMessage('TIRES2_T_ERROR_MODULE_NOT_INCLUDED_NOTE');
}
else{
	global $arTheme, $STARTTIME;

	$localKey = 'TIRES2_VIEWED_ITEMS_'.SITE_ID;
	$arItemsACTIVE_FROMByID = array();
	$arViewed = (isset($_COOKIE[$localKey]) && strlen($_COOKIE[$localKey])) ? json_decode($_COOKIE[$localKey], true) : array();

	if($arViewed && is_array($arViewed)){
		$viewedDays = \Bitrix\Main\Config\Option::get("sale", "viewed_time", "5");
		$viewedCntMax = \Bitrix\Main\Config\Option::get("sale", "viewed_count", "10");
		$arResult['DIETIME'] = $DIETIME = $STARTTIME - $viewedDays * 86400000;

		foreach($arViewed as $PRODUCT_ID => $arItem){
			// delete old items
			if($arItem[0] < $DIETIME){
				unset($arViewed[$PRODUCT_ID]);
				continue;
			}

			// make array $PRODUCT_ID => ACTIVE_FROM for DESC sort
			$arItemsACTIVE_FROMByID[$PRODUCT_ID] = $arItem[0];

			// get image
			$arImage = array();
			if($PICTURE_ID = isset($arItem['1']) ? $arItem['1'] : false){
				$arImage = CFile::ResizeImageGet($PICTURE_ID, array('width' => 110, 'height' => 110), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			}

			// make item array
			$arViewed[$PRODUCT_ID] = array(
				'PRODUCT_ID' => $PRODUCT_ID,
				'IBLOCK_ID' => (isset($arItem['2']) ? $arItem['2'] : $PRODUCT_ID),
				'ACTIVE_FROM' => $arItem[0],
				'PICTURE' => array(
					'ID' => $PICTURE_ID,
					'SRC' => $arImage ? $arImage['src'] : \Aspro\Functions\CAsproTires2::showNoImage((isset($arItem['2']) ? $arItem['2'] : $PRODUCT_ID)),
					'ALT' => $arImage ? (strlen($arImage['DESCRIPTION']) ? $arImage['DESCRIPTION'] : (strlen($arImage['ALT']) ? $arImage['ALT'] : false)) : false,
					'TITLE' => $arImage ? (strlen($arImage['DESCRIPTION']) ? $arImage['DESCRIPTION'] : (strlen($arImage['TITLE']) ? $arImage['TITLE'] : false)) : false,
				),
			);
		}

		// sort by ACTIVE_FROM
		arsort($arItemsACTIVE_FROMByID);

		// make RESULT items
		foreach($arItemsACTIVE_FROMByID as $PRODUCT_ID => $ACTIVE_FROM){
			// only $viewedCntMax items
			if(count($arResult['ITEMS']) < $viewedCntMax){
				$arResult['ITEMS'][] = $arViewed[$PRODUCT_ID];
			}
			else{
				break;
			}
		}
	}

	// time of last viewed product
	$arResult['LAST_ACTIVE_FROM'] = $arResult['ITEMS'] ? $arResult['ITEMS'][count($arResult['ITEMS']) - 1]['ACTIVE_FROM'] : $STARTTIME;
}
global $arTheme;
$path = (isset($arTheme['VIEWED_TEMPLATE']['VALUE']) ? strtolower($arTheme['VIEWED_TEMPLATE']['VALUE']) : 'horizontal');
$this->IncludeComponentTemplate('', $componentPath.'/templates/main_'.$path.'/');
?>