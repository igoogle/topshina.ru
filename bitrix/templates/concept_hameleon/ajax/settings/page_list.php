<?
$site_id = trim($_POST["site_id"]);
if(strlen($site_id) > 0)
    define("SITE_ID", htmlspecialchars($site_id));
else
    die();

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');?>


<?
CModule::IncludeModule("concept.hameleon");

if(!Chameleon::getRights())
    die();


CModule::IncludeModule("iblock");
$arResult["OK"] = "N";

if($_POST["send"] == "Y")
{
	$arFilter = Array('IBLOCK_CODE'=>"concept_hameleon_site", 'GLOBAL_ACTIVE'=>'', "ACTIVE"=>"");
	$arSelect = Array("ID");
	$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, false, $arSelect);

	while($ar_result = $db_list->GetNext())
	{
	    $bs = new CIBlockSection;
	    
	    $arFields = Array();
	    
	    $arFields["ACTIVE"] = trim($_POST["page_active".$ar_result["ID"]]);
	    $arFields["SORT"] = trim($_POST["sort_".$ar_result["ID"]]);
	    
	    
	    
	    $bs->Update($ar_result["ID"], $arFields);
	}


	$arResult["OK"] = "Y";
}
$arResult = json_encode($arResult);
echo $arResult;
?>