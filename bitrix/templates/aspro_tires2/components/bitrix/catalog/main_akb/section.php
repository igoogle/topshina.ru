<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?

use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\ModuleManager;


Loader::includeModule("iblock");?>
<?if(strpos($arResult["VARIABLES"]["SECTION_CODE_PATH"], \Bitrix\Main\Config\Option::get("aspro.tires2", "PODBOR_ELEMENTS_URL", "search")) !== false && $arResult['URL_TEMPLATES']['smart_filter'] && !$arResult['VARIABLES']['SMART_FILTER_PATH']):?>
	<?
	$bPodborPage = true;
	$arResult['VARIABLES']['SMART_FILTER_PATH'] = str_replace(array('filter/', '/apply'), '', $arResult['VARIABLES']['SECTION_CODE_PATH']);
	$arResult['VARIABLES']['SECTION_CODE_PATH'] = '';
	?>
	<?include 'sections.php';?>
<?else:?>
	<?global $arTheme, $NextSectionID, $arRegion;
	$arPageParams = $arSection = $section = array();

	// $arResult['VARIABLES']['SMART_FILTER_PATH'] = $arParams['SEF_URL_TEMPLATES_FILTER'];
	// $arResult["URL_TEMPLATES"]["smart_filter"] = $arParams['SEF_URL_TEMPLATES_FILTER'];

	// get current section ID
	if($arResult["VARIABLES"]["SECTION_ID"] > 0){
		$section=CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $arResult["VARIABLES"]["SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "UF_SECTION_DESCR", "UF_OFFERS_TYPE", $arParams["SECTION_DISPLAY_PROPERTY"], "IBLOCK_SECTION_ID", "DEPTH_LEVEL", "LEFT_MARGIN", "RIGHT_MARGIN"));
	}
	elseif(strlen(trim($arResult["VARIABLES"]["SECTION_CODE"])) > 0){

		$section=CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "=CODE" => $arResult["VARIABLES"]["SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "DESCRIPTION", "UF_SECTION_DESCR", "UF_OFFERS_TYPE", $arParams["SECTION_DISPLAY_PROPERTY"], "IBLOCK_SECTION_ID", "DEPTH_LEVEL", "LEFT_MARGIN", "RIGHT_MARGIN"));
	}

	$typeSKU = '';
	if($section){
		$arSection["ID"] = $section["ID"];
		$arSection["NAME"] = $section["NAME"];
		$arSection["IBLOCK_SECTION_ID"] = $section["IBLOCK_SECTION_ID"];
		if($section[$arParams["SECTION_DISPLAY_PROPERTY"]]){
			$arDisplayRes = CUserFieldEnum::GetList(array(), array("ID" => $section[$arParams["SECTION_DISPLAY_PROPERTY"]]));
			if($arDisplay = $arDisplayRes->GetNext()){
				$arSection["DISPLAY"] = $arDisplay["XML_ID"];
			}
		}
		if(strlen($section["DESCRIPTION"]))
			$arSection["DESCRIPTION"] = $section["DESCRIPTION"];
		if(strlen($section["UF_SECTION_DESCR"]))
			$arSection["UF_SECTION_DESCR"] = $section["UF_SECTION_DESCR"];
		$posSectionDescr = COption::GetOptionString("aspro.tires2", "SHOW_SECTION_DESCRIPTION", "BOTTOM", SITE_ID);

		$iSectionsCount = CTires2Cache::CIBlockSection_GetCount(array('CACHE' => array("TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array("SECTION_ID" => $arSection["ID"], "ACTIVE" => "Y", "GLOBAL_ACTIVE" => "Y"));

		$catalog_available = $arParams['HIDE_NOT_AVAILABLE'];
		if (!isset($arParams['HIDE_NOT_AVAILABLE']))
			$catalog_available = 'N';
		if ($arParams['HIDE_NOT_AVAILABLE'] != 'Y' && $arParams['HIDE_NOT_AVAILABLE'] != 'L')
			$catalog_available = 'N';
		if($arParams['HIDE_NOT_AVAILABLE'] == 'Y')
			$catalog_available = 'Y';
		$arElementFilter = array("SECTION_ID" => $arSection["ID"], "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]);
		if($arParams["INCLUDE_SUBSECTIONS"] == "A")
		{
			$arElementFilter["INCLUDE_SUBSECTIONS"] = "Y";
			$arElementFilter["SECTION_GLOBAL_ACTIVE"] = "Y";
			$arElementFilter["SECTION_ACTIVE "] = "Y";
		}
		if($arParams['HIDE_NOT_AVAILABLE'] == 'Y')
			$arElementFilter["CATALOG_AVAILABLE"] = $catalog_available;

		$itemsCnt = CTires2Cache::CIBlockElement_GetList(array("CACHE" => array("TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arElementFilter, array());

		//set offer view type
		$typeTmpSKU = 0;
		if($section['UF_OFFERS_TYPE'])
			$typeTmpSKU = $section['UF_OFFERS_TYPE'];
		else
		{
			if($section["DEPTH_LEVEL"] > 2)
			{
				$sectionParent = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $section["IBLOCK_SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "UF_OFFERS_TYPE"));
				if($sectionParent['UF_OFFERS_TYPE'] && !$typeTmpSKU)
					$typeTmpSKU = $sectionParent['UF_OFFERS_TYPE'];

				if(!$typeTmpSKU)
				{
					$sectionRoot = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $section["LEFT_MARGIN"], ">=RIGHT_BORDER" => $section["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "UF_OFFERS_TYPE"));
					if($sectionRoot['UF_OFFERS_TYPE'] && !$typeTmpSKU)
						$typeTmpSKU = $sectionRoot['UF_OFFERS_TYPE'];
				}
			}
			else
			{
				$sectionRoot = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $section["LEFT_MARGIN"], ">=RIGHT_BORDER" => $section["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "NAME", "UF_OFFERS_TYPE"));
				if($sectionRoot['UF_OFFERS_TYPE'] && !$typeTmpSKU)
					$typeTmpSKU = $sectionRoot['UF_OFFERS_TYPE'];
			}
		}
		if($typeTmpSKU)
		{
			$rsTypes = CUserFieldEnum::GetList(array(), array("ID" => $typeTmpSKU));
			if($arType = $rsTypes->GetNext())
			{
				$typeSKU = $arType['XML_ID'];
				$arTheme["TYPE_SKU"]["VALUE"] = $typeSKU;
			}

		}
	}

	if($arParams['STORES'])
	{
		foreach($arParams['STORES'] as $key => $store)
		{
			if(!$store)
				unset($arParams['STORES'][$key]);
		}
	}
	if($arRegion)
	{
		if($arRegion['LIST_PRICES'])
		{
			if(reset($arRegion['LIST_PRICES']) != 'component')
				$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
		}
		if($arRegion['LIST_STORES'])
		{
			if(reset($arRegion['LIST_STORES']) != 'component')
				$arParams['STORES'] = $arRegion['LIST_STORES'];
		}
	}

	$NextSectionID = $arSection["ID"];?>

	<?
	//seo
	$arSeoItems = CTires2Cache::CIBLockElement_GetList(array('CACHE' => array("MULTI" =>"Y", "TAG" => CTires2Cache::GetIBlockCacheTag(CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_info"][0]))), array("IBLOCK_ID" => CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_info"][0], "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION", "PROPERTY_FORM_QUESTION", "PROPERTY_SECTION_SERVICES", "PROPERTY_TIZERS", "PROPERTY_SECTION", "DETAIL_TEXT", "ElementValues"));
	$arSeoItem = $arTmpRegionsLanding = array();
	if($arSeoItems)
	{
		$iLandingItemID = 0;
		$current_url =  $APPLICATION->GetCurDir();
		$url = urldecode(str_replace(' ', '+', $current_url));
		foreach($arSeoItems as $arItem)
		{
			if(urldecode($arItem["PROPERTY_FILTER_URL_VALUE"]) == $url)
			{
				$arSeoItem = $arItem;
				$iLandingItemID = $arSeoItem['ID'];
				break;
			}
		}
		if($arRegion)
		{
			if($arSeoItem)
			{
				if($arSeoItem['PROPERTY_LINK_REGION_VALUE'])
				{
					if(!is_array($arSeoItem['PROPERTY_LINK_REGION_VALUE']))
						$arSeoItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arSeoItem['PROPERTY_LINK_REGION_VALUE'];
					if(!in_array($arRegion['ID'], $arSeoItem['PROPERTY_LINK_REGION_VALUE']))
						$arSeoItem = array();
				}
			}
			else
			{
				foreach($arSeoItems as $arItem)
				{
					if($arItem['PROPERTY_LINK_REGION_VALUE'])
					{
						if(!is_array($arItem['PROPERTY_LINK_REGION_VALUE']))
							$arItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arItem['PROPERTY_LINK_REGION_VALUE'];
						if(!in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE']))
							$arTmpRegionsLanding[] = $arItem['ID'];
					}
				}
			}
		}
	}
	if($arRegion)
	{
		if($arRegion["LIST_STORES"] && $arParams["HIDE_NOT_AVAILABLE"] == "Y")
		{
			$arTmpFilter["LOGIC"] = "OR";
			foreach($arParams['STORES'] as $storeID)
			{
				$arTmpFilter[] = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
			}
			$GLOBALS[$arParams["FILTER_NAME"]][] = $arTmpFilter;
		}
	}
	?>
	<?if(!in_array("DETAIL_PAGE_URL", (array)$arParams["LIST_OFFERS_FIELD_CODE"]))
		$arParams["LIST_OFFERS_FIELD_CODE"][] = "DETAIL_PAGE_URL";?>
	<?// section elements?>
	<?@include_once('page_blocks/'.$arParams["SECTION_ELEMENTS_TYPE_VIEW"].'.php');?>

	<?CTires2::checkBreadcrumbsChain($arParams, $arSection);?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>

	<?if(\Bitrix\Main\Loader::includeModule("sotbit.seometa")):?>
		<?$APPLICATION->IncludeComponent(
			"sotbit:seo.meta",
			".default",
			array(
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"SECTION_ID" => $arSection['ID'],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
			)
		);?>
	<?endif;?>
<?endif;?>