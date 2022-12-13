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
    $bs = new CIBlockSection;

    $ID = intval(trim($_POST["section_id"]));

    $arFields = Array();

    $arFields["UF_CHAM_NOINDEX"] = trim($_POST["hameleon_seo_noindex"]);

    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = trim(strip_tags($_POST["hameleon_seo_title"]));
    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_KEYWORDS"] = trim(strip_tags($_POST["hameleon_seo_keywords"]));
    $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_DESCRIPTION"] = trim(strip_tags($_POST["hameleon_seo_description"]));

    $arFields["UF_CHAM_OG_URL"] = $_POST["hameleon_seo_og_url"];
    $arFields["UF_CHAM_OG_TYPE"] = $_POST["hameleon_seo_og_type"];
    $arFields["UF_CHAM_OG_TITLE"] = trim(strip_tags($_POST["hameleon_seo_og_title"]));
    $arFields["UF_CHAM_OG_DESC"] = trim(strip_tags($_POST["hameleon_seo_og_description"]));


    $arFields["UF_CHAM_META_TAGS"] = $_POST["hameleon_other_meta"];

    if(SITE_CHARSET == "windows-1251")
    {
        foreach($arFields as $key => $value)
        {
            if(is_array($value))
            {
                foreach($value as $k=>$val)
                    $value[$k] = utf8win1251($val);
                    
            }
            else
            {
                $arFields[$key] = utf8win1251($value);
            }
            
            
        }
            
            
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_TITLE"] = utf8win1251(trim(strip_tags($_POST["hameleon_seo_title"])));
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_KEYWORDS"] = utf8win1251(trim(strip_tags($_POST["hameleon_seo_keywords"])));
        $arFields["IPROPERTY_TEMPLATES"]["SECTION_META_DESCRIPTION"] = utf8win1251(trim(strip_tags($_POST["hameleon_seo_description"])));
    }



    if(strlen($_FILES["hameleon_seo_og_image"]["name"]))
    {
        $arFile = $_FILES["hameleon_seo_og_image"];
        $arFile["MODULE_ID"] = "iblock";
        
        $arFields["UF_CHAM_OG_IMAGE"] = $arFile;
    }
    elseif($_POST["hameleon_seo_og_image_del"] == 'Y' && strlen($_FILES["hameleon_seo_og_image"]["name"]) <= 0)
    {
        CFile::Delete($_POST['imageogimage']);
        
        $arFile = CFile::MakeFileArray();
        $arFile["MODULE_ID"] = "iblock";
        $arFile["del"] = "Y";
        
        $arFields["UF_CHAM_OG_IMAGE"] = $arFile;
    }


    $res = CIBlockSection::GetByID($ID);
    $ar_res = $res->GetNext();


    if($bs->Update($ID, $arFields))
    {
        $arResult["OK"] = "Y";
        
        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($ar_res["IBLOCK_ID"], $ID);
        $ipropValues->clearValues();
    }


}
$arResult = json_encode($arResult);
echo $arResult;  
    
?>


<?//require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');?>