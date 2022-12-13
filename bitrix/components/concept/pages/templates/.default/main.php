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


$arFilter2 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "=UF_CHAM_URL" => $host, "=UF_CHAM_FULL_URL" => "0");
$db_list2 = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter2, false);

if($db_list2->SelectedRowsCount()>0)
{
    $ar_result2 = $db_list2->GetNext();
    $ar_result["ID"] = $ar_result2["ID"];
}
else
{
    $arSelect = Array("ID", "SECTION_PAGE_URL", "CODE", "UF_CHAM_URL", "UF_CHAM_FULL_URL");
    $arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y");
    $db_list = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter, false, $arSelect);
    $ar_result = $db_list->GetNext();
       
    if(strlen($ar_result["UF_CHAM_URL"]) > 0 )
    {
        if(intval($ar_result["UF_CHAM_FULL_URL"])>0)
            LocalRedirect("http://".$ar_result["UF_CHAM_URL"]."/".$ar_result["CODE"]."/", true, "301 Moved permanently");
        else
        {
            if($ar_result["UF_CHAM_URL"] != $host)
                LocalRedirect("http://".$ar_result["UF_CHAM_URL"], true, "301 Moved permanently");
        }
           
    }
}
?>

<?if($ar_result["ID"] > 0):?>

    <?$GLOBALS["CURRENT_SECTION_ID"] = $APPLICATION->IncludeComponent(
        "concept:page.generator", 
        "", 
        array(
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CHECK_DATES" => $arParams["CHECK_DATES"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "PARENT_SECTION" => $ar_result["ID"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
            "MESSAGE_404" => $arParams["MESSAGE_404"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "SHOW_404" => $arParams["SHOW_404"],
            "FILE_404" => $arParams["FILE_404"],
            "COMPONENT_TEMPLATE" => ""
        ),
        $component
    );?>
    


<?endif;?>
