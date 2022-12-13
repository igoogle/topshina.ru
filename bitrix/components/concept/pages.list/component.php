<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);



$arParams["TOP_DEPTH"] = intval($arParams["TOP_DEPTH"]);
if($arParams["TOP_DEPTH"] <= 0)
	$arParams["TOP_DEPTH"] = 2;
    

$arResult["SECTIONS"]=array();

/*************************************************************************
			Work with cache
*************************************************************************/
//if($this->startResultCache())
//{
	if(!Loader::includeModule("iblock") || !Loader::includeModule("concept.hameleon"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}

	global $HAMELEON_TEMPLATE_ARRAY;

	$arResult = array();

	if($arParams['PANEL'] == "edit-sets"){
		ChamDB::getIblockIDs(array("CODES"=> array("concept_hameleon_site", "concept_hameleon_forms", "concept_hameleon_agreements", "concept_hameleon_site_modal", "concept_hameleon_advantag")));

		

		$arResult["SECTION"]=array();

        $arFilter = Array('IBLOCK_ID' => $HAMELEON_TEMPLATE_ARRAY['CONSTRUCTOR']["IBLOCK_ID"], "ID"=>$arParams["CURRENT_SECTION_ID"]);
        $dbResSect = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, false, array("UF_*"));
        
       	$arResult["SECTION"] = $dbResSect->GetNext();
	}


	if($arParams['PANEL'] == "addpage")
	{

		ChamDB::getIblockIDs(array("CODES"=>array(
			"concept_hameleon_site"
		)));

		$arResult["SECTIONS"]=array();

        $arFilter = Array('IBLOCK_ID' => $HAMELEON_TEMPLATE_ARRAY['CONSTRUCTOR']["IBLOCK_ID"]);
        $dbResSect = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, false, array("ID", "ACTIVE", "SECTION_PAGE_URL", "NAME", "SORT", "UF_CHAM_URL", "UF_CHAM_FULL_URL"));
        
        while($sectRes = $dbResSect->GetNext())
            $arResult["SECTIONS"][] = $sectRes;

      
	}

	if($arParams['PANEL'] == "newpage")
	{
		ChamDB::getIblockIDs(array("CODES"=>array(
			"concept_hameleon_site"
		)));
	}

		

	if($arParams['PANEL'] == "forms")
	{
		ChamDB::getIblockIDs(array("CODES"=> array("concept_hameleon_forms")));


		$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_SECTION_ID");
		$arFilter = Array("IBLOCK_ID"=> $HAMELEON_TEMPLATE_ARRAY['FORMS']["IBLOCK_ID"]);
		$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, $arSelect);

		while($ob = $res->GetNextElement())
		{

			$arFields = $ob->GetFields();



			$arResult["FORMS_ELEMENTS"][] = $arFields;

			if(strlen($arFields["IBLOCK_SECTION_ID"])<=0)
				$arResult["FORMS_ELEMENTS_NO_SECTION"][] = $arFields;

		}

		$arSelect = Array("SORT", "ID", "NAME");
		$dbResSect = CIBlockSection::GetList(
		   Array("SORT"=>"ASC"),
		   Array("IBLOCK_ID"=> $HAMELEON_TEMPLATE_ARRAY['FORMS']["IBLOCK_ID"]),
		   false,
		   $arSelect
		);


		while($sectRes = $dbResSect->GetNext())
		{
			$arSections[] = $sectRes;
		}


	    if(!empty($arSections))
	    {
	        foreach($arSections as $arSection){  
			
	    		foreach($arResult["FORMS_ELEMENTS"] as $key=>$arItem){
	    			
	    			 if($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']){
	    				$arSection['ELEMENTS'][] =  $arItem;
	    			 }
	    		}

	    		if(!empty($arSection['ELEMENTS']))
	    		{
	    			asort($arSection['ELEMENTS']);
	    		
	    			$arElementGroups[] = $arSection;
	    		}
	    		
	    	}
	  
	    	$arResult["FORMS_IN_SECTION"] = $arElementGroups;
	    }

	}

	if($arParams['PANEL'] == "modals")
	{
		ChamDB::getIblockIDs(array("CODES"=> array("concept_hameleon_site_modal")));



		$arSelect = Array("SORT", "ID", "NAME", "IBLOCK_SECTION_ID");
		$arFilterModal = Array("IBLOCK_ID"=> $HAMELEON_TEMPLATE_ARRAY['POPUP']["IBLOCK_ID"]);
		$resModal = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilterModal, false, false, $arSelect);
		while($obModal = $resModal->GetNextElement())
		{

			$arFieldsModal = $obModal->GetFields();

			$arResult["MODALS_ELEMENTS"][] = $arFieldsModal;

			if(strlen($arFieldsModal["IBLOCK_SECTION_ID"]) <= 0)
				$arResult["MODALS_ELEMENTS_NO_SECTION"][] = $arFieldsModal;

		}




		$arSelect = Array("SORT", "ID", "NAME");
		$dbResSectModal = CIBlockSection::GetList(
		   Array("SORT"=>"ASC"),
		   Array("IBLOCK_ID"=> $HAMELEON_TEMPLATE_ARRAY['POPUP']["IBLOCK_ID"]),
		   false,
		   $arSelect
		);


		while($sectResModal = $dbResSectModal->GetNext())
		{
			$arSectionsModal[] = $sectResModal;
		}



		if(!empty($arSectionsModal) && is_array($arSectionsModal))
		{


			foreach($arSectionsModal as $arSectionModal){  

				if(!empty($arResult["MODALS_ELEMENTS"]) && is_array($arResult["MODALS_ELEMENTS"]))
				{
					foreach($arResult["MODALS_ELEMENTS"] as $key=>$arItem){
					
					 if($arItem['IBLOCK_SECTION_ID'] == $arSectionModal['ID']){
							$arSectionModal['ELEMENTS'][] =  $arItem;
						 }
					}

				}

				if(!empty($arSectionModal['ELEMENTS']))
				{
					asort($arSectionModal['ELEMENTS']);
					$arElementGroupsModal[] = $arSectionModal;
				}

				
			}

		}

		$arResult["MODALS_IN_SECTION"] = $arElementGroupsModal;
	}

	

	



	

	$this->includeComponentTemplate();
//}

?>