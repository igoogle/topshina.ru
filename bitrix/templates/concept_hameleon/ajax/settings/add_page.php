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
  $iblock_id = $_POST["iblock_id"];
  $name = trim($_POST["newpage_name"]);
  $code = trim($_POST["newpage_id"]);

  if(trim(SITE_CHARSET) == "windows-1251")
  {
      $name = utf8win1251($name);
      $code = utf8win1251($code);
  }

  $bs = new CIBlockSection;

  $arFields = Array(
    "ACTIVE" => "Y",
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID" => $iblock_id,
    "NAME" => $name,
    "CODE" => $code
  );

  if($ID = $bs->Add($arFields))
  {
  
        $arResult["OK"] = "Y";
          
        $rsData = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID"=>"IBLOCK_".$iblock_id."_SECTION"));
        
        $arFields = Array();
        
        
        while($arRes = $rsData->Fetch())
        {
            
            if($arRes["USER_TYPE_ID"] == "string")
                $arFields[$arRes["FIELD_NAME"]] = $arRes["SETTINGS"]["DEFAULT_VALUE"];
                
            if($arRes["USER_TYPE_ID"] == "CHamTextarea")
                $arFields[$arRes["FIELD_NAME"]] = $arRes["SETTINGS"]["DEFAULT_VALUE"]; 
        
            
            if($arRes["USER_TYPE_ID"] == "boolean")
                $arFields[$arRes["FIELD_NAME"]] = $arRes["SETTINGS"]["DEFAULT_VALUE"];
            
            
            if($arRes["USER_TYPE_ID"] == "enumeration")
            {        
                $rsValue = CUserFieldEnum::GetList(array(), array(
                    "USER_FIELD_ID" => $arRes["ID"],
                ));
                
                while($arValue = $rsValue->GetNext())
                {
                    if($arValue["DEF"] == "Y")
                        $arFields[$arRes["FIELD_NAME"]] = $arValue["ID"];
                }
        
            }
            
            
        }
        
        $bs = new CIBlockSection;
        $bs->Update($ID, $arFields);
          
          
          $arSection = GetIBlockSection($ID);
          $arResult["HREF"] = $arSection["SECTION_PAGE_URL"];
          
        }
}

$arResult = json_encode($arResult);
echo $arResult;
?>