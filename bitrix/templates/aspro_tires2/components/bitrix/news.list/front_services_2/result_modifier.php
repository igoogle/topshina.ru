<?
// get all subsections of PARENT_SECTION or root sections
$arSectionsFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y');
$arParams['DEPTH_LEVEL'] = 1;
$start_level = ($arResult['SECTION']['PATH'][0]['DEPTH_LEVEL'] ? $arResult['SECTION']['PATH'][0]['DEPTH_LEVEL'] : 1);
$end_level = $arParams['DEPTH_LEVEL'];

if($arParams['PARENT_SECTION'])
{
	$arParentSection = CTires2Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'N')), array('ID' => $arParams['PARENT_SECTION']), false, array('ID', 'IBLOCK_ID', 'LEFT_MARGIN', 'RIGHT_MARGIN'));

	$arSectionsFilter = array_merge($arSectionsFilter, array(/*'SECTION_ID' => $arParams['PARENT_SECTION'],*/'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'], '>DEPTH_LEVEL' => '1'));

	$arSectionsFilter['INCLUDE_SUBSECTIONS'] = 'Y';
	$arSectionsFilter['<=DEPTH_LEVEL'] = $end_level;

}
else
{
	$arSectionsFilter['<=DEPTH_LEVEL'] = $end_level;
}
$arResult['SECTIONS'] = CTires2Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), $arSectionsFilter, false, array('ID', 'NAME', 'IBLOCK_ID', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', 'SECTION_PAGE_URL', 'PICTURE', 'DESCRIPTION'), array('nPageSize' => $arParams['NEWS_COUNT']));
?>