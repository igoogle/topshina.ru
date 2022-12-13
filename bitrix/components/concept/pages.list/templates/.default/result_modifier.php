<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?

$host = $_SERVER["HTTP_HOST"];

if(strlen($_SERVER["HTTP_HOST"])<=0)
    $host = $_SERVER["SERVER_NAME"];

$host = explode(":", $host);



if(strlen(SITE_SERVER_NAME) > 0 && $host[0] != SITE_SERVER_NAME)
    $host = SITE_SERVER_NAME;
    
else
    $host = $host[0];

$host = ChamHost::convertFromPunycode($host);
$url_name = "http://".$host;

$arResult["SERVER_URL2"] = $host;
$arResult["SERVER_URL"] = $url_name;





if($arParams['PANEL'] == "edit-sets")
{
    if($arResult["SECTION"]["PICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["PICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["LOGO_NAME"] = $arFile["ORIGINAL_NAME"];
    }

    if($arResult["SECTION"]["DETAIL_PICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["DETAIL_PICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["FAVICON_NAME"] = $arFile["ORIGINAL_NAME"];
    }

    if($arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CHAM_HEADER_IMG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["HEADER_IMG_NAME"] = $arFile["ORIGINAL_NAME"];
    }

    if($arResult["SECTION"]["UF_CHAM_COPYPICTURE"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CHAM_COPYPICTURE"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["COPYRIGHT"] = $arFile["ORIGINAL_NAME"];
    }



    if($arResult["SECTION"]["UF_CH_BOX_BG_HEAD"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CH_BOX_BG_HEAD"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["CART_BG_HEAD"] = $arFile["ORIGINAL_NAME"];
    }

    if($arResult["SECTION"]["UF_CH_BODY_BG"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CH_BODY_BG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["BODY_BG"] = $arFile["ORIGINAL_NAME"];
    }

    if($arResult["SECTION"]["UF_CH_FTR_BG"] > 0)
    {
        $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CH_FTR_BG"]);
        $arFile = $rsFile->Fetch();
        
        $arResult["SECTION"]["FTR_BG"] = $arFile["ORIGINAL_NAME"];
    }



    $arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"]["XML_ID"] = "lato";

    if(strlen($arResult["SECTION"]["UF_CHAM_TITLE_FONT"]) > 0 )
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arResult["SECTION"]["UF_CHAM_TITLE_FONT"],
        ));

        $arResult["SECTION"]["UF_CHAM_TITLE_FONT_VAL"] = $font->GetNext();

    }

    $arResult["SECTION"]["UF_CH_MASK_VAL"]["XML_ID"] = "lato";

    if(strlen($arResult["SECTION"]["UF_CH_MASK"]) > 0 )
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arResult["SECTION"]["UF_CH_MASK"],
        ));

        $arResult["SECTION"]["UF_CH_MASK_VAL"] = $font->GetNext();

    }


    $arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"]["XML_ID"] = "lato";

    if(strlen($arResult["SECTION"]["UF_CHAM_TEXT_FONT"]) > 0)
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arResult["SECTION"]["UF_CHAM_TEXT_FONT"],
        ));

        $arResult["SECTION"]["UF_CHAM_TEXT_FONT_VAL"] = $font->GetNext();
    }


    $arResult["SECTION"]["UF_CHAM_MAIN_COLOR_VAL"]["XML_ID"] = "light-blue";

    if(strlen($arResult["SECTION"]["UF_CHAM_MAIN_COLOR"]) > 0)
    {
        $font = CUserFieldEnum::GetList(array(), array(
            "ID" => $arResult["SECTION"]["UF_CHAM_MAIN_COLOR"],
        ));

        $arResult["SECTION"]["UF_CHAM_MAIN_COLOR_VAL"] = $font->GetNext();
    }

    if(strlen($arResult["SECTION"]["UF_CHAM_MENU_TYPE"]) > 0)
    {
        $menu = CUserFieldEnum::GetList(array(), array(
            "ID" => $arResult["SECTION"]["UF_CHAM_MENU_TYPE"],
        ));

        $arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"] = $menu->GetNext();
    }



    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_TITLE_FONT")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["TITLE_FONTS"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_TEXT_FONT")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["TEXT_FONTS"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_MAIN_COLOR")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["MAIN_COLOR"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_MENU_TYPE")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["MENU_TYPE"][] = $arEnum;
        
    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_HEADER_CLR")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["COLOR_SCHEME"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_BUTTONS_TYPE")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["BUTTONS_VIEW"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_SOC_VIEW")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["SOCIALS_POSITION"][] = $arEnum;   
     
    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CHAM_CHOOSECOPY")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["CHOOSECOPY"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_POS_BODY_BG")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["POS_BODY_BG"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_BODY_REPEAT_BG")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["BODY_REPEAT_BG"][] = $arEnum;


    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_COLOR_HEADER")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["COLOR_HEADER"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_VIEW_SCRLL_MENU")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["VIEW_SCRLL_MENU"][] = $arEnum;

    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_CH_MASK")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["MASKS"][] = $arEnum;


    $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_NAME"=>"UF_MAIN_COLOR_BTN")); 
    while($arEnum = $rsEnum->GetNext())
        $arResult["MAIN_COLOR_BTN"][] = $arEnum;

    global $HAMELEON_TEMPLATE_ARRAY;


    if($HAMELEON_TEMPLATE_ARRAY['AGREEMENTS']["IBLOCK_ID"])
    {
        $arFilter = Array("IBLOCK_ID"=>$HAMELEON_TEMPLATE_ARRAY['AGREEMENTS']["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

        while($ob = $res->GetNextElement())
            $arResult["AGREEMENTS"][] = $ob->GetFields();
    }


    if($HAMELEON_TEMPLATE_ARRAY['FORMS']["IBLOCK_ID"])
    {
        $arFilter = Array("IBLOCK_ID"=>$HAMELEON_TEMPLATE_ARRAY['FORMS']["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

        while($ob = $res->GetNextElement())
            $arResult["FORMS"][] = $ob->GetFields();
    }


    if($HAMELEON_TEMPLATE_ARRAY['ADVS']["IBLOCK_ID"])
    {
        $arFilter = Array("IBLOCK_ID"=>$HAMELEON_TEMPLATE_ARRAY['ADVS']["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);

        while($ob = $res->GetNextElement())
            $arResult["CART_ADV"][] = $ob->GetFields();
    }
}

