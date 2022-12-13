<?
if($arResult){
	$arResult = CTires2::getChilds($arResult);

	$cur_page = $GLOBALS['APPLICATION']->GetCurPage(true);
	$cur_page_no_index = $GLOBALS['APPLICATION']->GetCurPage(false);

	foreach($arResult as $key=>$arItem)
	{
		if($arItem["PARAMS"]["PICTURE"])
		{
			$img=CFile::ResizeImageGet($arItem["PARAMS"]["PICTURE"], Array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$arResult[$key]["IMAGES"]=$img;
		}

		if(isset($arItem["PARAMS"]["NOT_SHOW"]) && $arItem["PARAMS"]["NOT_SHOW"]=="Y")
			unset($arResult[$key]);

		if(!$arItem['SELECTED'])
			$arResult[$key]['SELECTED'] = CMenu::IsItemSelected($arItem['LINK'], $cur_page, $cur_page_no_index);

		if($arItem["CHILD"])
		{
			foreach($arItem["CHILD"] as $key2=>$arChild)
			{
				if(isset($arChild["PARAMS"]["NOT_SHOW"]) && $arChild["PARAMS"]["NOT_SHOW"]=="Y")
					unset($arResult[$key]["CHILD"][$key2]);
				if($arChild["PARAMS"]["PICTURE"])
				{
					$img=CFile::ResizeImageGet($arChild["PARAMS"]["PICTURE"], Array('width'=>50, 'height'=>50), BX_RESIZE_IMAGE_PROPORTIONAL, true);
					$arResult[$key]["CHILD"][$key2]["IMAGES"]=$img;
				}
				if(!$arChild['SELECTED'])
					$arResult[$key]["CHILD"][$key2]['SELECTED'] = CMenu::IsItemSelected($arChild['LINK'], $cur_page, $cur_page_no_index);
			}
		}
	}
}?>