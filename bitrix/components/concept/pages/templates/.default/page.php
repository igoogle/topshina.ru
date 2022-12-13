<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?
$host = ChamHost::getHost($_SERVER, "N");
$ar_result["ID"] = -1;


$arSelect0 = Array("ID", "SECTION_PAGE_URL", "UF_CHAM_FULL_URL", "UF_CHAM_URL");
$arFilter0 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "=CODE"=>$arResult["VARIABLES"]["SECTION_CODE"]);
$db_list0 = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter0, false, $arSelect0);
$ar_result0 = $db_list0->GetNext();

if(isset($ar_result0["UF_CHAM_URL"]{0}) && $ar_result0["UF_CHAM_URL"] != $host)
{
	if(intval($ar_result0["UF_CHAM_FULL_URL"])>0)
		LocalRedirect("http://".$ar_result0["UF_CHAM_URL"]."/".$ar_result0["CODE"]."/", true, "301 Moved permanently");
	else
    	LocalRedirect("http://".$ar_result0["UF_CHAM_URL"], true, "301 Moved permanently");
}

if(!isset($ar_result0["UF_CHAM_URL"]{0}))
{
	$arSelect1 = Array("ID", "SECTION_PAGE_URL", "CODE", "UF_CHAM_URL", "UF_CHAM_FULL_URL");
	$arFilter1 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "=UF_CHAM_FULL_URL"=>"0", "=UF_CHAM_URL" => $host);
	$db_list1 = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter1, false, $arSelect1);
	
	if($ar_result1 = $db_list1->GetNext())
		LocalRedirect("http://".$ar_result1["UF_CHAM_URL"], true, "301 Moved permanently");

}

$arFilter2 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y");
$db_list2 = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter2, false);
$ar_result2 = $db_list2->GetNext();    


if($ar_result0["ID"] == $ar_result2["ID"])
{
	if(intval($ar_result0["UF_CHAM_FULL_URL"])<=0)
		LocalRedirect(SITE_DIR, true, "301 Moved permanently");
}




if($ar_result0["ID"] > 0)
{
	$GLOBALS["CURRENT_SECTION_ID"] = $APPLICATION->IncludeComponent(
		"concept:page.generator", 
		"", 
		array(
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CHECK_DATES" => $arParams["CHECK_DATES"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"PARENT_SECTION" => $ar_result0["ID"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"COMPONENT_TEMPLATE" => ""
		),
		$component
	);
}
?>

