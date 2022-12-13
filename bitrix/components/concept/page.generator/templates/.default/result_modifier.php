<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? 
global $USER;

$do_array_values_for_ITEMS = false;





foreach($arResult["ITEMS"] as $key=>$arItem)
{
    if(  ( $arItem["PROPERTIES"]["ADMIN_ONLY_VIEW"]["VALUE"] == "Y" && !$USER->isAdmin() ) || ( $arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"] == "Y" && $arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"] == "Y" )  )
    {
        unset( $arResult["ITEMS"][$key] );

        if(!$do_array_values_for_ITEMS)
            $do_array_values_for_ITEMS = true;
    }
}

if($do_array_values_for_ITEMS)
    $arResult["ITEMS"] = array_values($arResult["ITEMS"]);



$arResult["H1_MAIN"] = 0;
if(!empty($arResult["ITEMS"]))
{
    foreach($arResult["ITEMS"] as $key=>$arItem)
    {
        if($arItem["PROPERTIES"]["ADMIN_ONLY_VIEW"]["VALUE"] == "Y" && !$USER->isAdmin())
            unset($arResult["ITEMS"][$key]);
    }

    foreach($arResult["ITEMS"] as $key=>$arItem)
    {
        if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y")
        {
            $arResult["H1_MAIN"] = 1;
            $arResult["ITEMS"][$key]["H1_MAIN"] = 1;
            break;
        }
    }
}
?>


<?
$arResult["SHOW_SOC"] = false;

if((strlen($arResult["SECTION"]["UF_CHAM_SOC_VK"])>0 || strlen($arResult["SECTION"]["UF_CHAM_SOC_FB"])>0 || strlen($arResult["SECTION"]["UF_CHAM_SOC_TW"])>0 || strlen($arResult["SECTION"]["UF_CHAM_SOC_YT"])>0 || strlen($arResult["SECTION"]["UF_CHAM_SOC_IG"])>0))
    $arResult["SHOW_SOC"] = true;
    
    

?>

<?
//phones and emails
$arResult["PHONES_SHOW_DOWN"] = false;
$arShowCount = 0;

if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0)
    $arShowCount++;

if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0)
    $arShowCount++;
    

if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0)
    $arShowCount++;

if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0)
    $arShowCount++;  
    
if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0)
    $arShowCount++;
    
if($arShowCount > 2 || ($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])))
    $arResult["PHONES_SHOW_DOWN"] = true;
    

$main_key = -1;
$main_key_first = -1;

$valID = "";

$video_api = 0;    
    
if(!empty($arResult["ITEMS"]))
{
    $first_block_start_desktop = false;
    $first_block_start_mobile = false;



    foreach($arResult["ITEMS"] as $key=>$arItem)
    {

        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "first_block")
        {
            if($main_key_first < 0)
                $main_key_first = $key;
            
            
            if($arItem["PROPERTIES"]["FB_ADD_PICTURE"]["VALUE"] > 0)
                $arItem["TWO_COLS"] = "Y";
            
            if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "buttons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed")
            {
                $k = 0;
                
                if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"]) > 0)
                    $k++;
                    
                if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"]) > 0)
                    $k++;
                    
                if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"]) > 0)
                    $k++;
                    
                    
                $arItem["BUTTONS_COUNT"] = $k;
                    
            }
            
            if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "icons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed")
            {
                $arItem["ICONS_COUNT"] = 0;
                $arItem["ICONS_DESC_COUNT"] = 0;

                if(!empty($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"]))
                    $arItem["ICONS_COUNT"] = count($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"]);

                if(!empty($arItem["PROPERTIES"]["FB_ICONS_DESC"]["VALUE"]))
                    $arItem["ICONS_DESC_COUNT"] = count($arItem["PROPERTIES"]["FB_ICONS_DESC"]["VALUE"]);

                $arItem["ICONS_MAX"] = max($arItem["ICONS_COUNT"], $arItem["ICONS_DESC_COUNT"]);
            }


            if($arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"] != "Y")
            {

                if(!$first_block_start_desktop)
                {
                    $arResult["ITEMS"][$main_key_first]["START_DESKTOP"] = $arItem;
                    $first_block_start_desktop = true;
                }

                $arResult["ITEMS"][$main_key_first]["ELEMENTS_LG"][] = $arItem;
                
            }

            if($arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"] != "Y")
            {

                if(!$first_block_start_mobile){
                    $arResult["ITEMS"][$main_key_first]["START_MOBILE"] = $arItem;
                    $first_block_start_mobile = true;
                }

                $arResult["ITEMS"][$main_key_first]["ELEMENTS_XS"][] = $arItem;

            }
            
            /*$arResult["ITEMS"][$main_key_first]["ELEMENTS"][] = $arItem;*/
            
            if($main_key_first != $key)
                unset($arResult["ITEMS"][$key]);
            
        }
        
        //tariffs
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "tariff" && ($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "flat"))
        {
            
            $type = $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "flat";
            
            if($valID != $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type)
                $main_key = -1;
        }
        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service")
        {
            
            $type = $arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "flat";
            
            if($valID != $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type)
                $main_key = -1;
                
        }    
        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "blink" && ($arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "link"))
        {

            $type = $arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "link";
            
            if($valID != $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type)
                $main_key = -1;

        }

        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "opinion")
        {
            
            $type = $arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "slider";
            
            if($valID != $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type)
                $main_key = -1;
                
        }

        else
        {
            if($valID != $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"])
                $main_key = -1;
        }
        
        
        
        
        //text
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "text")
        {
            if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE"]["VALUE"] > 0)
            {
                $arResult["ITEMS"][$key]["PADDING_CHANGE"] = true;
                $arResult["ITEMS"][$key]["TITLE_CHANGE"] = true;
                $arResult["ITEMS"][$key]["BUTTON_CHANGE"] = true;
            }

            if(strlen($arItem["PREVIEW_TEXT"]))
            {
                $arResult["ITEMS"][$key]["TEXT"] = str_replace(array("#MAP_START#","#VIDEO_START#"), array('<img class="lazyload img-for-lazyload map-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">','<img class="lazyload img-for-lazyload video-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">'), $arItem["~PREVIEW_TEXT"]);
            }
        }
       
       
        
        //tariffs flat
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "tariff" && ($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "flat"))
        {

            if($main_key < 0)
                $main_key = $key;
        
        
            $arResult["ITEMS"][$main_key]["ELEMENTS"][] = $arItem;
            
            if($main_key != $key)
                unset($arResult["ITEMS"][$key]);

        }
        
        
        //blink links

        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "blink" && ($arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "link"))
        {


            if($main_key < 0)
                $main_key = $key;


            $arResult["ITEMS"][$main_key]["ELEMENTS"][] = $arItem;
            
            if($main_key != $key)
                unset($arResult["ITEMS"][$key]);

        }


        //opinion
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "opinion")
        {
            if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] != "slider")
            {
                $arResult["ITEMS"][$key]["TITLE_CHANGE"] = true;
                $arResult["ITEMS"][$key]["BUTTON_CHANGE"] = true;
            }

            if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "slider")
                {   
                    if($main_key < 0)
                        $main_key = $key;
                
                
                    $arResult["ITEMS"][$main_key]["ELEMENTS"][] = $arItem;
                    
                    if($main_key != $key)
                        unset($arResult["ITEMS"][$key]);
                }

        }

        //advantages
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "advantages")
        {
            

            if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0)
            {
                $arResult["ITEMS"][$key]["PADDING_CHANGE"] = true;
                $arResult["ITEMS"][$key]["TITLE_CHANGE"] = true;
                $arResult["ITEMS"][$key]["BUTTON_CHANGE"] = true;
            }
            if($arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == "slider")
            {
                $arResult["ITEMS"][$key]["PADDING_CHANGE"] = false;
            }
            if(!empty($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"]))
            {

                foreach($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"] as $arValue){
                    if(strlen($arValue) > 0){
                        $arItem["PIC_COUNT"]++;
                    }
                }

            }
            if(!empty($arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"]))
            {
                foreach($arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"] as $arValue){
                    if(strlen($arValue) > 0){
                        $arItem["IC_COUNT"]++;
                    }
                }
            }
            if(!empty($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["VALUE"]))
            {
                foreach($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["DESCRIPTION"] as $arValue){
                    if(strlen($arValue) > 0){
                        $arItem["PIC_NAME_COUNT"]++;
                    }
                }
            }
            if(!empty($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["VALUE"]))
            {
                foreach($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["VALUE"] as $arValue){
                    if(strlen($arValue) > 0){
                        $arItem["PIC_DESC_COUNT"]++;
                    }
                }
            }


            $arResult["ITEMS"][$key]["PIC_COUNT"] = $arItem["PIC_COUNT"];
            $arResult["ITEMS"][$key]["IC_COUNT"] = $arItem["IC_COUNT"];
            $arResult["ITEMS"][$key]["PIC_NAME_COUNT"] = $arItem["PIC_NAME_COUNT"];
            $arResult["ITEMS"][$key]["PIC_DESC_COUNT"] = $arItem["PIC_DESC_COUNT"];
            $arResult["ITEMS"][$key]["PIC_MAX"] = max($arItem["PIC_COUNT"], $arItem["PIC_DESC_COUNT"], $arItem["PIC_NAME_COUNT"], $arItem["IC_COUNT"]);
        }

        
        
        //services
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service")
        {
            if($main_key < 0)
                $main_key = $key; 
        
            $arResult["ITEMS"][$main_key]["ELEMENTS"][] = $arItem;
            
            if($main_key != $key)
                unset($arResult["ITEMS"][$key]);

        }

        //news
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "news")
        {

            $arFilter = Array("ID"=> $arItem["PROPERTIES"]["NEWS_ELEMENTS"]["VALUE"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");

            $res = CIBlockElement::GetList(Array("sort" => "asc"), $arFilter);

            while($ob = $res->GetNextElement())
            {
                $arElement = Array();
                
                $arElement = $ob->GetFields();  
                $arElement["PROPERTIES"] = $ob->GetProperties();

                $arResult["ITEMS"][$key]["ELEMENTS"][] = $arElement;
               
            }

        }

        //catalog


        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "catalog")
        {
            global $DB_cham;
            ChamDB::ChamDBval();
            
                $ar_res_item = Array();
                $arFilter = Array("ID"=>$arItem["PROPERTIES"]["CATALOG"]["VALUE"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                $db_list = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter);

                while($ar_result = $db_list->GetNext())
                {

                    $ar_res_item = array("NAME" => $ar_result["NAME"], "ID" => $ar_result["ID"], "PICTURE" => $ar_result["PICTURE"]);
                    $arResult["ITEMS"][$key]["IBLOCK_ID"] = $ar_result["IBLOCK_ID"]; 
                    $arFilter = Array("IBLOCK_ID"=> $arResult["ITEMS"][$key]["IBLOCK_ID"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",  "SECTION_ID"=>$ar_result["ID"], "INCLUDE_SUBSECTIONS" => "Y");
                    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);

                    $currency = "";

                    if($arItem["PROPERTIES"]["CHAM_CURR_ON"]["VALUE"] == "Y")
                        $currency = $arItem["PROPERTIES"]["CHAM_CURR_VAL"]["VALUE"];

                    while($ob = $res->GetNextElement()){
                      
                        $arElement = Array();
                        $arElement = $ob->GetFields();
                        $arElement["PROPERTIES"] = $ob->GetProperties();


                        if($arItem["PROPERTIES"]["CHAM_CURR_ON"]["VALUE"] != "Y")
                            $currency = $arElement["PROPERTIES"]["CHAM_CURR"]["VALUE"];

                        $arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"] = "<span class='main1'>".$arElement["PROPERTIES"]["PRICE"]["~VALUE"]."</span>";
                   

                        if(strlen($arElement["PROPERTIES"]["BOX_PRICE"]["VALUE"])>0 && strlen($arElement["PROPERTIES"]["PRICE"]["~VALUE"])<=0)
                        {
                           
                            $unit = "";
                                if(in_array($arElement["PROPERTIES"]["CHAM_UNITS"]["VALUE"], $arResult["SECTION"]["UF_CHAM_UNITS"]) && $arResult["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
                                {
                                    $unit = $DB_cham["UNITS"]["ITEMS"][$arElement["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_MAIN"];

                                    if(strlen($DB_cham["UNITS"]["ITEMS"][$arElement["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"])>0)
                                        $unit = $DB_cham["UNITS"]["ITEMS"][$arElement["PROPERTIES"]["CHAM_UNITS"]["VALUE"]]["~SYM_PRICE"];

                                    $unit = "<span class='units-style'> ".$unit."</span>";
                                }

                            $from = "";
                                if($arElement["PROPERTIES"]["PRICE_FROM"]["VALUE"] == "Y")
                                    $from = GetMessage("PAGE_GEN_RESMOD_HAM_LAND_FROM");

                            $arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"] = $from."<span class='main1'>".CHam_format::CurrFormatString($arElement["PROPERTIES"]["BOX_PRICE"]["VALUE"], $currency, $arElement["PROPERTIES"]["CHAM_CURR"]["VALUE"])."</span>".$unit;
                        }

                        if($arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y")
                           $arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"] = "<span class='main1'>".GetMessage("PAGE_GEN_RESMOD_HAM_LAND_REQUEST")."</span>";

                        $arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = $arElement["PROPERTIES"]["OLD_PRICE"]["~VALUE"];

                        if($arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y" && strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])<=0)
                            $arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = "";


                        if(strlen($arElement["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"])>0 && strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])<=0 && $arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y")
                            $arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"] = CHam_format::CurrFormatString($arElement["PROPERTIES"]["BOX_OLD_PRICE"]["VALUE"], $currency, $arElement["PROPERTIES"]["CHAM_CURR"]["VALUE"]);
                        

                        $ar_res_item["SECT_ELEMENTS"][] = $arElement;
                    }

                    $arResult["ITEMS"][$key]["ELEMENTS"][] = $ar_res_item;
                }

        }
        //faq
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "faq")
        {

            $arFilter = Array("ID" => $arItem["PROPERTIES"]["FAQ_ELEMENTS"]["VALUE"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");

            $res = CIBlockElement::GetList(Array("sort" => "asc"), $arFilter);

            while($ob = $res->GetNextElement())
            {
                $arElement = Array();
                
                $arElement = $ob->GetFields();  
                $arElement["PROPERTIES"] = $ob->GetProperties();

                $arResult["ITEMS"][$key]["ELEMENTS"][] = $arElement;
               
            }


            $arResult["ITEMS"][$key]["BUTTON_CHANGE"] = true;

        }

        // component
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "component")
            $arResult["COMPONENTS"][] = $arItem;

        
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "tariff" && ($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "flat"))
        {
            
            $type = $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "flat";
            
            $valID = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type;
        }

        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service")
        {
            
            $type = $arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "flat";
            
            $valID = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type;
        }
        
        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "blink" && ($arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "link"))
        {
            

            $type = $arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "link";

            $valID = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type;
                
        }

        elseif($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "opinion")
        {
            
            $type = $arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"];
            
            if(strlen($type) <= 0)
                $type = "slider";
            
            $valID = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].$type;
        }
        else
        {
            $valID = $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"];
        }

        
    }
}


$menu_count = 0;
$menu_first_sort = 0;
if(!empty($arResult["ITEMS"]))
{
    foreach($arResult["ITEMS"] as $key=>$arItem)
    {

        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "gallery")
        {

            $val=3;
            $arCount = Array();

            for($i=1; $i <=4; $i++)
            {
                if(strlen($arItem["PROPERTIES"]["GALLERY_COUNT_PHOTO_$i"]["VALUE"]) > 0)
                    $val=(int)$arItem["PROPERTIES"]["GALLERY_COUNT_PHOTO_$i"]["VALUE"];

                $arCount[$i] = $val;
            }
            
            
            
            $arCountDesc = false;

            if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "slider")
            {
                if(!empty($arItem["PROPERTIES"]["GALLERY"]["~DESCRIPTION"]))
                {
                    foreach($arItem["PROPERTIES"]["GALLERY"]["~DESCRIPTION"] as $desc)
                    {
                        if(strlen($desc)>0)
                        {
                            $arCountDesc = true;
                            break;
                        }

                    }
                }

            }

            $arResult["ITEMS"][$key]["GALLERY_COUNT"] = $arCount;
            $arResult["ITEMS"][$key]["GALLERY_COUNT_DESC"] = $arCountDesc;
        }

        //menu
        if($arItem["PROPERTIES"]["SHOW_IN_MENU"]["VALUE"] == "Y" )
        {
            $arMenu = Array();

            $arMenu["SORT"] = $arItem["PROPERTIES"]["MENU_SORT"]["VALUE"];
            $arMenu["ID"] = $arItem["ID"];
            $arMenu["HIDE"] = $arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"];
            $arMenu["HIDE_LG"] = $arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"];
            
            $arMenu["MENU_LINK"] = $arItem["PROPERTIES"]["MENU_LINK"]["VALUE"];
            $arMenu["MENU_LINK_OPEN"] = $arItem["PROPERTIES"]["MENU_LINK_OPEN"]["VALUE"];

            if(strlen($arItem["PROPERTIES"]["MENU_TITLE"]["VALUE"]) > 0)
                $arMenu["NAME"] = $arItem["PROPERTIES"]["MENU_TITLE"]["~VALUE"];

            elseif(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
                $arMenu["NAME"] = $arItem["PROPERTIES"]["HEADER"]["~VALUE"];
            
            else
                $arMenu["NAME"] = $arItem["NAME"];


            if(strlen($arItem["PROPERTIES"]["MENU_SORT"]["VALUE"]) > 0)
            {
                $arResult["MENU_FIRST_SORT"][$menu_first_sort] = $arMenu;
                $menu_first_sort++;
            }

            else
            {
                $arResult["MENU_SEC_SORT"][] = $arMenu;
              
            }


            $menu_count++;
            
        }
        
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service" && $arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "flat")
        {
            $picture = 0;
            $name = 0;
            $subname = 0;
            $price = 0;
            if(!empty($arItem["ELEMENTS"]))
            {
                foreach($arItem["ELEMENTS"] as $arService)
                {
                    if($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"] > 0)
                        $picture++;

                    if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0)
                        $name++;
                        
                    if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0)
                        $subname++;
                        
                    if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0)
                        $price++;
                        
                    if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0)
                        $price++;
                }
            }


            $arResult["ITEMS"][$key]["SHOW_PICTURE"] = $picture;  
            $arResult["ITEMS"][$key]["SHOW_NAME"] = $name; 
            $arResult["ITEMS"][$key]["SHOW_SUBNAME"] = $subname; 
            $arResult["ITEMS"][$key]["SHOW_PRICE"] = $price; 

        }


        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "service")
        {
            
            if(!empty($arItem["ELEMENTS"]) && is_array($arItem["ELEMENTS"]))
            {
                $arElements = Array();

                    foreach($arItem["ELEMENTS"] as $arService)
                    {
                        
                        if(!empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"]) || isset($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]["TEXT"]))
                        {
                            if(!empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"]) || strlen($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]["TEXT"]) > 0)
                                $arElements[] = $arService["ID"];
                        }
                    }
              
                
                
                $arResult["ITEMS"][$key]["ID_ALL"] = $arElements;
                
            }
        }

        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "tariff")
        {
            
            
            if(!empty($arItem["ELEMENTS"]) && is_array($arItem["ELEMENTS"]))
            {
                $arElements = Array();
         
                foreach($arItem["ELEMENTS"] as $arTariff)
                {
                    if(!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) || isset($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]["TEXT"]))
                    {
                        if(!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) || strlen($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]["TEXT"]) > 0)
                            $arElements[] = $arTariff["ID"];
                    }
                }
        
                $arResult["ITEMS"][$key]["ID_ALL"] = $arElements;
            }
            

        }


        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "news")
        {
            $subname = 0;
            $arElements = Array();

            if(!empty($arItem["ELEMENTS"]))
            {
                foreach($arItem["ELEMENTS"] as $arNews)
                {
                    if(strlen($arNews["PROPERTIES"]["DATE"]["VALUE"]) > 0)
                        $subname++;

                    if(!empty($arNews["PROPERTIES"]["NEWS_GALLERY"]["VALUE"]) || strlen($arNews["PREVIEW_TEXT"]) > 0){
                        $arElements[] = $arNews["ID"];
                    }
                    
                }
            }
            

            $arResult["ITEMS"][$key]["SHOW_SUBNAME"] = $subname; 

            $arResult["ITEMS"][$key]["ID_ALL"] = $arElements;
        }

        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "catalog")
        {

            $arElements = Array();
            $picture = 0;

            if(!empty($arItem["ELEMENTS"]))
            {
                foreach($arItem["ELEMENTS"] as $arCatalog)
                {
                 
                    if(strlen($arCatalog["PICTURE"]) > 0)              
                        $picture++;

                    if(!empty($arCatalog["SECT_ELEMENTS"]))
                    {
                        foreach($arCatalog["SECT_ELEMENTS"] as $arSectElements)
                        {
                            if(!empty($arSectElements["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) > 0 || !empty($arSectElements["PROPERTIES"]["OTHER_COMPLECT"]["VALUE"]) || strlen($arSectElements["DETAIL_TEXT"]) > 0 || strlen($arSectElements["PREVIEW_TEXT"]) > 0)
                                $arElements[$arCatalog["ID"]][] = $arSectElements["ID"];
                        }
                    }

                } 

            }
              

            $arResult["ITEMS"][$key]["SHOW_CATALOG_PICTURE"] = $picture;
            $arResult["ITEMS"][$key]["ID_ALL"] = $arElements;
            
        }


        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "numbers")
        {
            $string_num = 0;

            if(!empty($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"]))
            {
                foreach($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"] as $arNum)
                {
                    if(strlen(trim($arNum)) > 0)
                        $string_num++;
                }
            }

            $arResult["ITEMS"][$key]["STRING_NUM"] = $string_num; 
        }

    }
} 

$arResult["MENU_COUNT"] = $menu_count;

if(!empty($arResult["MENU_FIRST_SORT"]))
{
    asort($arResult["MENU_FIRST_SORT"]);

    if(!empty($arResult["MENU_SEC_SORT"]))
        $arResult["MENU"] = array_merge($arResult["MENU_FIRST_SORT"], $arResult["MENU_SEC_SORT"]);
    
    else
        $arResult["MENU"] = $arResult["MENU_FIRST_SORT"];
    
   
}
else
    $arResult["MENU"] = $arResult["MENU_SEC_SORT"];




if(!empty($arResult["ITEMS"]))
{
    foreach($arResult["ITEMS"] as $key=>$arItem)
    {
        if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "first_block")
        {
            unset($arResult["ITEMS"][$key]);
            array_unshift($arResult["ITEMS"], $arItem);
        }
    }
}


if(!empty($arResult["SECTION"]["UF_CHAM_AGREEMENTS"]))
{
    foreach($arResult["SECTION"]["UF_CHAM_AGREEMENTS"] as $arAgreement)
    {
        $arSelect = Array("SORT", "ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PROPERTY_*");
        $arFilter = Array("ID"=>IntVal($arAgreement), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement()){ 
        $arFields = $ob->GetFields();  
        $arFields["PROPERTIES"] = $ob->GetProperties();  

        $arResult["SECTION"]["AGREEMENTS"][] = $arFields;
        }
    }
    sort($arResult["SECTION"]["AGREEMENTS"]);
}


if(!empty($arResult["SECTION"]["UF_CH_BOX_ADV"]))
{

    foreach($arResult["SECTION"]["UF_CH_BOX_ADV"] as $arAgreement)
    {

        $arFilter = Array("ID"=>IntVal($arAgreement), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
        while($ob = $res->GetNextElement()){ 
            $arFields = $ob->GetFields();  
            $arFields["PROPERTIES"] = $ob->GetProperties();  

            $arResult["CH_BOX_ADV"][] = $arFields;
        }
    }

}

?>


<?$frame = $this->createFrame()->begin();?>

    <?
        $headServicesJs = "";
        $BodyServicesJs = "";
        $LazyServicesJs = "";
    ?>

    <?//if(strlen($arResult["SECTION"]["UF_CHAM_INHEAD"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_CSS"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_METRIKA"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_GOOGLE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_GTM"]) > 0):?>
      
        <?$this->SetViewTarget("service_head");?>

            <?
                echo "<input type=\"hidden\" class=\"iblock-landing\" value=\"".$arResult["SECTION"]["IBLOCK_ID"]."\">";

           
                $headServicesJs .= $arResult["SECTION"]["~UF_CHAM_METRIKA"];
                $headServicesJs .= $arResult["SECTION"]["~UF_CHAM_GOOGLE"];
                $headServicesJs .= $arResult["SECTION"]["~UF_CHAM_GTM"];


                if(isset($headServicesJs{0}))
                {
                    if($arResult["SECTION"]["UF_LAZY_SERVICE"])
                    {
                        $LazyServicesJs = $headServicesJs;
                        $headServicesJs = "";
                    }
                    else
                        echo str_replace("<script", "<script data-skip-moving='true'", $headServicesJs);

                }

                if(isset($arResult["SECTION"]["UF_CHAM_INHEAD"]{0}))
                    echo str_replace("<script", "<script data-skip-moving='true'", $arResult["SECTION"]["~UF_CHAM_INHEAD"]);

            ?>
     
        <?$this->EndViewTarget(); ?> 
        
    <?//endif;?>

    <?//if(strlen($arResult["SECTION"]["UF_CHAM_INBODY"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_GTM_BODY"]) > 0):?>
      
        <?$this->SetViewTarget("service_body");?>

            <?
                if(isset($arResult["SECTION"]["UF_CHAM_GTM_BODY"]{0}))
                {
                    if($arResult["SECTION"]["UF_LAZY_SERVICE"])
                        $LazyServicesJs .= $arResult["SECTION"]["~UF_CHAM_GTM_BODY"];
                    else
                        echo str_replace("<script", "<script data-skip-moving='true'", $arResult["SECTION"]["~UF_CHAM_GTM_BODY"]);
                }

                if(isset($arResult["SECTION"]["UF_CHAM_INBODY"]{0}))
                    echo str_replace("<script", "<script data-skip-moving='true'", $arResult["SECTION"]["~UF_CHAM_INBODY"]);
            ?>

        <?$this->EndViewTarget(); ?> 
        
    <?//endif;?>

    <?//if(strlen($arResult["SECTION"]["UF_CHAM_INCLOSEBODY"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_SCRIPTS"]) > 0 || isset($arResult["SECTION"]["UF_CHAM_CSS"]{0}) || isset($arResult["SECTION"]["UF_LAZY_JS"]{0})):?>


    <?

        $GOALS_JS = array();


        $GOALS_JS['CALLBACK'] = ChamDB::getGoalsJs(
            array(
                'UF_CHAM_METRIKA'=>$arResult["SECTION"]['UF_CHAM_METRIKA'],
                'UF_CHAM_GOOGLE'=>$arResult["SECTION"]["UF_CHAM_GOOGLE"],
                'UF_CHAM_GTM' => $arResult["SECTION"]["UF_CHAM_GTM"],
                'METRIKA_GOAL' => $arResult["SECTION"]["UF_YA_G_FRM"],
                'GOOGLE_CATEGORY' => $arResult["SECTION"]["UF_GA_CAT_FRM"],
                'GOOGLE_ACTION' => $arResult["SECTION"]["UF_GA_ACT_FRM"],
                'GTM_EVENT' => $arResult["SECTION"]["UF_GTM_EVT_FRM"],
                'GTM_CATEGORY' => $arResult["SECTION"]["UF_GTM_CAT_FRM"],
                'GTM_ACTION' => $arResult["SECTION"]["UF_GTM_ACT_FRM"],
            ));

        $GOALS_JS['ADD2BASKET'] = ChamDB::getGoalsJs(
            array(
                'UF_CHAM_METRIKA'=>$arResult["SECTION"]['UF_CHAM_METRIKA'],
                'UF_CHAM_GOOGLE'=>$arResult["SECTION"]["UF_CHAM_GOOGLE"],
                'UF_CHAM_GTM' => $arResult["SECTION"]["UF_CHAM_GTM"],
                'METRIKA_GOAL' => $arResult["SECTION"]["UF_YA_G_ADD2BSKT"],
                'GOOGLE_CATEGORY' => $arResult["SECTION"]["UF_GA_CAT_ADD2BSKT"],
                'GOOGLE_ACTION' => $arResult["SECTION"]["UF_GA_ACT_ADD2BSKT"],
                'GTM_EVENT' => $arResult["SECTION"]["UF_GTM_EVT_ADD2BSKT"],
                'GTM_CATEGORY' => $arResult["SECTION"]["UF_GTM_CAT_ADD2BSKT"],
                'GTM_ACTION' => $arResult["SECTION"]["UF_GTM_ACT_ADD2BSKT"],
            ));

        /*$GOALS_JS['ORDER'] = ChamDB::getGoalsJs(
            array(
                'UF_CHAM_METRIKA'=>$arResult["SECTION"]['UF_CHAM_METRIKA'],
                'UF_CHAM_GOOGLE'=>$arResult["SECTION"]["UF_CHAM_GOOGLE"],
                'UF_CHAM_GTM' => $arResult["SECTION"]["UF_CHAM_GTM"],
                'METRIKA_GOAL' => $arResult["SECTION"]["UF_YA_G_ORD"],
                'GOOGLE_CATEGORY' => $arResult["SECTION"]["UF_GA_CAT_ORD"],
                'GOOGLE_ACTION' => $arResult["SECTION"]["UF_GA_ACT_ORD"],
                'GTM_EVENT' => $arResult["SECTION"]["UF_GTM_EVT_ORD"],
                'GTM_CATEGORY' => $arResult["SECTION"]["UF_GTM_CAT_ORD"],
                'GTM_ACTION' => $arResult["SECTION"]["UF_GTM_ACT_ORD"],
            ));

        $GOALS_JS['FAST_ORDER'] = ChamDB::getGoalsJs(
            array(
                'UF_CHAM_METRIKA'=>$arResult["SECTION"]['UF_CHAM_METRIKA'],
                'UF_CHAM_GOOGLE'=>$arResult["SECTION"]["UF_CHAM_GOOGLE"],
                'UF_CHAM_GTM' => $arResult["SECTION"]["UF_CHAM_GTM"],
                'METRIKA_GOAL' => $arResult["SECTION"]["UF_YA_G_FORD"],
                'GOOGLE_CATEGORY' => $arResult["SECTION"]["UF_GA_CAT_FORD"],
                'GOOGLE_ACTION' => $arResult["SECTION"]["UF_GA_ACT_FORD"],
                'GTM_EVENT' => $arResult["SECTION"]["UF_GTM_EVT_FORD"],
                'GTM_CATEGORY' => $arResult["SECTION"]["UF_GTM_CAT_FORD"],
                'GTM_ACTION' => $arResult["SECTION"]["UF_GTM_ACT_FORD"],
            ));*/



    ?>

    <?$this->SetViewTarget("service_close_body");?>


        
        <?

            if(isset($arResult["SECTION"]["UF_CHAM_INCLOSEBODY"]))
                echo $arResult["SECTION"]["~UF_CHAM_INCLOSEBODY"];


            if($arResult["SECTION"]["UF_LAZY_SERVICE"] && isset($LazyServicesJs{0}))
            {?>

                <?
                    if(intval($arResult["SECTION"]["UF_LAZY_SERVICE_TIME"])<=0)
                        $arResult["SECTION"]["UF_LAZY_SERVICE_TIME"] = 1;
                ?>
                <script>

                    $(window).on("load", function()
                    {
                        setTimeout(function()
                        {
                            $("body").append('<?=str_replace(array("/","'", "\r\n"), array("\/", '"', ""), $LazyServicesJs)?>');

                        }, <?=$arResult["SECTION"]["UF_LAZY_SERVICE_TIME"]?> * 1000);

                    });

                </script>

            <?}


            if(isset($arResult["SECTION"]["UF_LAZY_JS"]{0}))
            {?>

                <?
                    if(intval($arResult["SECTION"]["UF_LAZY_JS_TIMER"])<=0)
                        $arResult["SECTION"]["UF_LAZY_JS_TIMER"] = 1;
                ?>
                <script>

                    $(window).on("load", function()
                    {
                        setTimeout(function()
                        {
                            $("body").append('<?=str_replace(array("/","'", "\r\n"), array("\/", '"', ""), $arResult["SECTION"]["~UF_LAZY_JS"])?>');

                        }, <?=$arResult["SECTION"]["UF_LAZY_JS_TIMER"]?> * 1000);

                    });

                </script>

            <?}

            if(isset($arResult["SECTION"]["UF_CHAM_SCRIPTS"]{0}))
                echo "<script>".str_replace(array("/","'", "\r\n"), array("\/", '"', ""), $arResult["SECTION"]["~UF_CHAM_SCRIPTS"])."</script>";

            if(isset($arResult["SECTION"]["UF_CHAM_CSS"]{0}))
                echo "<style>".$arResult["SECTION"]["~UF_CHAM_CSS"]."</style>";

        ?>

        <?if($arResult["SECTION"]["UF_USE_RUB"]):?>

            <script>
                $(window).on("load", function()
                {
                    $("body").append("<link href=\"https://fonts.googleapis.com/css?family=PT+Sans+Caption&amp;display=swap&amp;subset=latin-ext\" type=\"text/css\" rel=\"stylesheet\">");
                });
                
            </script>

        <?endif;?>


        <?//if(isset($KRAKEN_TEMPLATE_ARRAY['GOALS_JS']['ADD2BASKET']{0})):?>
            <script>
                var globalGoalsHam = <?=CUtil::PhpToJSObject($GOALS_JS, false, true)?>;
            </script>
        <?//endif;?>
 
    <?$this->EndViewTarget(); ?> 
        
    <?//endif;?>

<?$frame->end();?>

<?
$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "CODE"=>"BLINK_COLS"));
$arResult['ENUM_COLLS_BLINK'] = array();
while($enum_fields = $property_enums->GetNext())
{
    $arResult["SECTION"]['ENUM_COLLS_BLINK'][] = $enum_fields['ID'];
}

    
if($arResult["SECTION"]["UF_CHAM_CHOOSECOPY"] > 0)
{
    $arResult["SECTION"]["UF_CHAM_CHOOSECOPY_ENUM"] = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CHAM_CHOOSECOPY"],
    ))->GetNext();
}



if($arResult["SECTION"]["UF_CHAM_MENU_TYPE"] > 0)
{
    $arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CHAM_MENU_TYPE"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] = "first";

if($arResult["SECTION"]["UF_CHAM_HEADER_CLR"] > 0)
{
    $arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CHAM_HEADER_CLR"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"] = "dark";

if($arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE"] > 0)
{
    $arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"] = "elips";

if(!empty($arResult["SECTION"]["UF_CHAM_SOC_VIEW"]))
{
    $soc = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CHAM_SOC_VIEW"],
    ));
    
    while($arSoc = $soc->GetNext())
        $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"][] = $arSoc["XML_ID"];
}

if($arResult["SECTION"]["UF_CH_MASK"] > 0)
{
    $arResult["SECTION"]["UF_CH_MASK_ENUM"] = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_CH_MASK"],
    ))->GetNext();
}
else
   $arResult["SECTION"]["UF_CH_MASK_ENUM"]["XML_ID"] = "rus";
    
    

if($arResult["SECTION"]["UF_CH_COLOR_HEADER"] > 0)
{
    $arResult["SECTION"]["UF_CH_COLOR_HEADER_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CH_COLOR_HEADER"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CH_COLOR_HEADER_ENUM"]["XML_ID"] = "def";


if($arResult["SECTION"]["UF_CH_COLOR_MENU"] > 0)
{
    $arResult["SECTION"]["UF_CH_COLOR_MENU_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CH_COLOR_MENU"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CH_COLOR_MENU_ENUM"]["XML_ID"] = "def";


if($arResult["SECTION"]["UF_CH_POS_BODY_BG"] > 0)
{
    $arResult["SECTION"]["UF_CH_POS_BODY_BG_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CH_POS_BODY_BG"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CH_POS_BODY_BG_ENUM"]["XML_ID"] = "scroll";



if($arResult["SECTION"]["UF_CH_BODY_REPEAT_BG"] > 0)
{
    $arResult["SECTION"]["UF_CH_BODY_REPEAT_BG_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_CH_BODY_REPEAT_BG"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_CH_BODY_REPEAT_BG_ENUM"]["XML_ID"] = "no-repeat";



if(strlen($arResult["SECTION"]["UF_CH_BODY_BG_CLR"]) <= 0)
    $arResult["SECTION"]["UF_CH_BODY_BG_CLR"] = "transparent";


if($arResult["SECTION"]["UF_VIEW_SCRLL_MENU"] > 0)
{
    $arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"] = CUserFieldEnum::GetList(array(), array(
        "ID" => $arResult["SECTION"]["UF_VIEW_SCRLL_MENU"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"] = "menu-scroll-hide";





if($arResult["SECTION"]["UF_MAIN_COLOR_BTN"] > 0)
{
    $arResult["SECTION"]["UF_MAIN_COLOR_BTN_ENUM"] = CUserFieldEnum::GetList(array(), array(
    "ID" => $arResult["SECTION"]["UF_MAIN_COLOR_BTN"],
    ))->GetNext();
}
else
    $arResult["SECTION"]["UF_MAIN_COLOR_BTN_ENUM"]["XML_ID"] = "light";


//phones and emails
$arResult["PHONES_SHOW_DOWN"] = false;
$arShowCount = 0;

if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0)
    $arShowCount++;

if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0)
    $arShowCount++;
    

if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0)
    $arShowCount++;

if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0)
    $arShowCount++;  
    
if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0)
    $arShowCount++;
    
if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0)
    $arShowCount++;
    
if($arShowCount > 2 || ($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])))
    $arResult["PHONES_SHOW_DOWN"] = true;
    

$protocol = 'http://';

if ((isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https') || (isset($_SERVER['HTTPS']) && ToLower($_SERVER['HTTPS']) == 'on'))
    $protocol = 'https://';
    
$host = explode(":", $_SERVER["HTTP_HOST"]);
$uri = explode("?", $_SERVER["REQUEST_URI"]); 

$url_name = $protocol.$host[0].$uri[0];    
$serv = $protocol.$host[0];   


$seo_url = $url_name;
    
if(strlen($arResult["SECTION"]["UF_CHAM_OG_URL"]) > 0)
    $seo_url = $arResult["SECTION"]["UF_CHAM_OG_URL"];


$arResult["SEO"]["seo_url"] = $seo_url;


$seo_type = "website";
    
if(strlen($arResult["SECTION"]["UF_CHAM_OG_TYPE"]) > 0)
    $seo_type = $arResult["SECTION"]["UF_CHAM_OG_TYPE"];

$arResult["SEO"]["seo_type"] = $seo_type;



$seo_title = $arResult["SECTION"]["NAME"];
                                                            
if(strlen($arResult["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
    $seo_title = $arResult["IPROPERTY_VALUES"]["SECTION_META_TITLE"];
    
if(strlen($arResult["SECTION"]["UF_CHAM_OG_TITLE"]) > 0)
    $seo_title = $arResult["SECTION"]["UF_CHAM_OG_TITLE"];

$arResult["SEO"]["seo_title"] = Chameleon::prepareText($seo_title);





$seo_desc = "";
                                                            
if(strlen($arResult["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) > 0)
    $seo_desc = $arResult["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"];
    
if(strlen($arResult["SECTION"]["UF_CHAM_OG_DESC"]) > 0)
    $seo_desc = $arResult["SECTION"]["UF_CHAM_OG_DESC"];


$arResult["SEO"]["seo_desc"] = str_replace(array("\r\n", "\r", "\n", "<br>", "<br/>"), array(" ", " ", " "," "," "), Chameleon::prepareText($seo_desc));


$seo_img = $serv.CFile::GetPath($arResult["SECTION"]["PICTURE"]);
    
if($arResult["SECTION"]["UF_CHAM_OG_IMAGE"] > 0)
    $seo_img = $serv.CFile::GetPath($arResult["SECTION"]["UF_CHAM_OG_IMAGE"]);

$arResult["SEO"]["seo_img"] = $seo_img;



/*errors*/


if($arResult["SECTION"]["UF_CHAM_CALLBACK"] == 1 && $arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"] <= 0)
    $arResult["ERRORS"]["CALLBACK"] = "Y";

foreach($arResult["ITEMS"] as $key=>$arItem)
{
    if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "catalog" && $arResult["SECTION"]["UF_CHAM_CATALOG_FRM"] <= 0)
        $arResult["ERRORS"]["CATALOG_FORM"] = "Y";
    
    if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "catalog" && $arResult["SECTION"]["UF_CH_BOX_ON"] == 1 && ($arResult["SECTION"]["UF_CH_BOX_ORDER_FORM"] <= 0 && $arResult["SECTION"]["UF_CH_BOX_ONE_CLICK"] <= 0)) 
        $arResult["ERRORS"]["CATALOG_CART_FORM"] = "Y";
}


$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array("CH_BOX_ADV", "CACHED_TPL", "COMPONENTS", 'SEO', 'IPROPERTY_TEMPLATES', 'H1_MAIN', "ERRORS"));
?>

