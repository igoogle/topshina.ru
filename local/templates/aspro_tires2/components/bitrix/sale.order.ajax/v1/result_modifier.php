<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

/* replace picture */
if ($arResult['JS_DATA']['GRID']['ROWS']) {
	foreach ($arResult['JS_DATA']['GRID']['ROWS'] as $key => $arItem) {
		if (!$arItem['data']['DETAIL_PICTURE']) {
			$arElement = \Bitrix\Iblock\ElementTable::getList(array(
					'select' => array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'IBLOCK_ID'),
					'filter' => array('ID' => $arItem['data']['PRODUCT_ID'])
				)
			)->Fetch();

			$imageID = 0;
			$imageSRC = '';

			if ($arElement && $arElement['IBLOCK_SECTION_ID']) {
				$arSection = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arElement['IBLOCK_ID']))), array("IBLOCK_ID" => $arElement['IBLOCK_ID'], 'ID' => $arElement['IBLOCK_SECTION_ID']), false, array('ID', 'PICTURE'));
				if ($arSection['PICTURE']) {
					$imageID = $arSection['PICTURE'];
					$imgOrig = CFile::ResizeImageGet($arSection['PICTURE'], array( "width" => 2000, "height" => 2000 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );
					$imageSRC = $imgOrig['src'];

					$img = CFile::ResizeImageGet($arSection['PICTURE'], array( "width" => 160, "height" => 160 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );
					$image = $img['src'];

					$img = CFile::ResizeImageGet($arSection['PICTURE'], array( "width" => 320, "height" => 320 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );
					$image2x = $img['src'];
				} else {
					$image = $imageSRC = $image2x = \Aspro\Functions\CAsproTires2::showNoImage($arElement["IBLOCK_ID"]);
				}
			} else {
				$image = $imageSRC = $image2x = \Aspro\Functions\CAsproTires2::showNoImage("");
			}
			$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['DETAIL_PICTURE'] = $imageID;
			$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['DETAIL_PICTURE_SRC_ORIGINAL'] = $imageSRC;
			$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['DETAIL_PICTURE_SRC'] = $image;
			$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['DETAIL_PICTURE_SRC_2X'] = $image2x;

			if (!$arItem['data']['PREVIEW_PICTURE']) {
				$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['PREVIEW_PICTURE'] = $imageID;
				$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['PREVIEW_PICTURE_SRC_ORIGINAL'] = $imageSRC;
				$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['PREVIEW_PICTURE_SRC'] = $image;
				$arResult['JS_DATA']['GRID']['ROWS'][$key]['data']['PREVIEW_PICTURE_SRC_2X'] = $image2x;
			}
		}
	}
}
/**/