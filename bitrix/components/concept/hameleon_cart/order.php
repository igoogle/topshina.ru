<?
$site_id = trim($_REQUEST["site_id"]);
define("SITE_ID", $site_id);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/concept/hameleon_cart/core.php");



    use Bitrix\CHamOrders;
    use Bitrix\CHamOrdersItems;
    
$arRes = array();
$arRes["OK"] = "N";
   
$host = ChamHost::getHost($_SERVER);


$arSection = Array();
$arIBlockElement = Array();

$element_id = intval(trim($_POST["element"]));
$section_id = intval(trim($_POST["section"]));
$section_iblock_id = intval(trim($_POST["section_iblock_id"]));
$go = true;


if(isset($_POST["name"]{0}) || isset($_POST["phone"]{0}) || isset($_POST["email"]{0}) || $_POST["send"] != "Y" || $element_id<=0 || $section_id<=0)
        $go = false;

if($section_id>0 && $section_iblock_id>0)
{
    CModule::IncludeModule('iblock');

    $rsResult = CIBlockSection::GetList(array("SORT"=>"ASC"), array("IBLOCK_ID"=>$section_iblock_id, "ID" => $section_id), false, array("UF_*")); 

    $arSection = $rsResult->GetNext();

    if($arSection["UF_CAPTCHA"])
    {

        if( isset($arSection["UF_CAPTCHA_SEC_KEY"]{0}) && isset($_POST['captchaToken']{0}))
        {
              $Response = CHameleonFunc::getContentFromUrl("https://www.google.com/recaptcha/api/siteverify?secret=".$arSection["UF_CAPTCHA_SEC_KEY"]."&response={$_POST['captchaToken']}");
              $Return = json_decode($Response);

              if(!($Return->success == true && $Return->score >= 0.7))
                    $go = false;
        }
        else
            $go = false;

    }
}



if($go)
{
    $element_block = trim($_REQUEST["element_block"]);
    $element_type = trim($_REQUEST["element_type"]);
    $tmpl_path = trim($_REQUEST["tmpl_path"]);


    $arFilt = Array("ID"=> $element_id, "ACTIVE"=>"Y");
    $r = CIBlockElement::GetList($arSort, $arFilt);

    while($ob = $r->GetNextElement())
    {
        $arIBlockElement = $ob->GetFields();  
        $arIBlockElement["PROPERTIES"] = $ob->GetProperties();
    }

    if($element_block>0){
    	$arFilt2 = Array("ID"=> $element_block, "ACTIVE"=>"Y");
        $r2 = CIBlockElement::GetList($arSort, $arFilt);

        while($ob2 = $r2->GetNextElement())
        {
            $arOtherElement = $ob2->GetFields();  
            $arOtherElement["PROPERTIES"] = $ob2->GetProperties();
        }
    }

    $form_admin = $arIBlockElement["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"];

    if(strlen($form_admin)<=0)
        $form_admin = "light";
        

    $rsSites = CSite::GetByID(SITE_ID);
    $arSite = $rsSites->Fetch();




            
    $header = trim($_REQUEST["header"]);
    $url = trim($_REQUEST["url"]);

    if(trim(SITE_CHARSET) == "windows-1251")
    {
        $header = utf8win1251(trim($_REQUEST["header"]));
        $url = utf8win1251(trim($_REQUEST["url"]));
    }

    $url = urldecode($url);

    $message = '';
    $arFiles = array();

    $resTestReq = true;


    if($form_admin == 'light')
    {
        $phone = trim($_REQUEST["bx-phone"]);
        $email = trim($_REQUEST["bx-email"]);
        $date = trim($_REQUEST["date"]);
        $count = trim($_REQUEST["count"]);
        $checkbox = $_REQUEST["checkbox".$element_id];
        
        $name = trim($_REQUEST["bx-name"]);
        $text = trim($_REQUEST["text"]);
        $address = trim($_REQUEST["address"]);
        $radiobutton = trim($_REQUEST["radiobutton".$element_id]);

        
        $check_value = '';
        

        if(trim(SITE_CHARSET) == "windows-1251")
        {
            $name = utf8win1251(trim($_REQUEST["bx-name"]));
            $text = utf8win1251(trim($_REQUEST["text"]));
            $address = utf8win1251(trim($_REQUEST["address"]));
            $radiobutton = utf8win1251(trim($_REQUEST["radiobutton".$element_id]));


            if(is_array($checkbox) && !empty($checkbox))
            {
                foreach($checkbox as $k => $value)
                {
                    $checkbox[$k] = utf8win1251(trim($value));
                }
            }
                            
        }


        if(in_array("name", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($name{0}))
              $resTestReq = false;

        if(in_array("phone", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($phone{0}))
              $resTestReq = false;

        if(in_array("email", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($email{0}))
              $resTestReq = false;

        if(in_array("date", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($date{0}))
              $resTestReq = false;

        if(in_array("count", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($count{0}))
              $resTestReq = false;

        if(in_array("address", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($address{0}))
              $resTestReq = false;

        if(in_array("textarea", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && !isset($text{0}))
              $resTestReq = false;

        if(in_array("file", $arIBlockElement["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"]) && empty($_FILES["userfile"]["name"]))
              $resTestReq = false;


        if(!empty($_FILES["userfile"]["name"]))
        {
            foreach ($_FILES["userfile"]["name"] as $key => $name)
            {

                if($_FILES["userfile"]["error"][$key] == 0)
                {

                    if($form_admin == 'light')
                    {
                        if(trim(SITE_CHARSET) == "windows-1251")
                            $filename = utf8win1251($name);
                        else
                            $filename = $name;

                        $arParams = array("safe_chars"=>".", "max_len" => 1000);
                        $filename = Cutil::translit($filename,"ru",$arParams);
                        
                        $filename = basename($filename);
                
                        $newname = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/hameleon_tmp_file/'.$filename;
                        if (!file_exists($newname)) 
                        {
                            move_uploaded_file($_FILES["userfile"]["tmp_name"][$key], $newname);
                        }

                        $arFiles[] = $newname;
                    }
                }
            }
        }
        
        
        if(strlen($radiobutton) > 0)
        {
            $check_value = $radiobutton;
        }

        if(is_array($checkbox) && !empty($checkbox))
        {
            $check_value = implode(', ' , $checkbox);
        }
        
        
        if(strlen($comment) > 0)
            $message .= $comment;

        if(strlen($name) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_NAME")."</b>".$name."<br/>";
        

        if(strlen($phone) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_PHONE")."</b>".$phone."<br/>";
        
        if(strlen($email) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_EMAIL")."</b>".$email."<br/>"; 
            
        if(strlen($count) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_COUNT")."</b>".$count."<br/>";

        if(strlen($date) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_DATE")."</b>".$date."<br/>";
        

        if(strlen($address) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_ADDRESS")."</b>".$address."<br/>";
        

        if(strlen($check_value) > 0)
            $message .= "<b>".GetMessage("HAM_CART_ORDER_CHECK_VALUE")."</b>".$check_value."<br/>";

        if(strlen($text) > 0)
            $message .= "<br/><b>".GetMessage("HAM_CART_ORDER_TEXAREA")."</b>".$text."<br/>";
            
          
        
    }
    elseif($form_admin == 'professional')
    {
        
        $email = "";
        $phone = "";
        $name = "";
        
        $countName = 0;
        $countPhone = 0;
        $countEmail = 0;

        if(strlen($comment) > 0)
            $message .= $comment;
        
        if( !empty($arIBlockElement["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"]) )
        {
            foreach($arIBlockElement["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"] as $k => $arVal)
            {
                
                $type = $arIBlockElement["PROPERTIES"]["FORM_PROP_INPUTS"]["DESCRIPTION"][$k];


                                                                        
                $type = explode(";", ToLower($type));

                if( !empty($type) )
                {
                    foreach($type as $k1=>$val)
                        $type[$k1] = trim($val);
                }

                
                if($type[0] == "radio" || $type[0] == "checkbox" || $type[0] == "select")
                {

                    if($type[1] == "y" && !isset($_POST["input_".$element_id."_$k"]) )
                        $resTestReq = false;

                    $list = explode(";", htmlspecialcharsBack($arVal));                                                    
                    $first = $list[0];
                    
                    if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                    {
                        $tit = str_replace(array("<", ">"), array("", ""), $first);
                        unset($list[0]);
                        
                        if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]) || strlen(trim($_REQUEST["input_".$element_id."_$k"])) > 0)
                            $message .= '<b>'.$tit.': </b> ';
                    }
                      
                    if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]))
                    {
                        
                        $check_array = $_REQUEST["input_".$element_id."_$k"];
                        
                        if(trim(SITE_CHARSET) == "windows-1251")
                        {
                            if( !empty($check_array) )
                            {
                                foreach($check_array as $c=>$check)
                                    $check_array[$c] = utf8win1251(trim($check));
                            }
                            
                        }
                        
                        $message .= implode(", ", $check_array).'<br/>';

                    }
                    else
                    {

                        if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
                        {
                            $check = trim($_REQUEST["input_".$element_id."_$k"]);
                            
                            if(trim(SITE_CHARSET) == "windows-1251")
                                $check = utf8win1251($check);

                            $message .= $check.'<br/>';
                        }
                        
                    }

                    
                    
                    
                }
                else
                {
                                                
                    if($type[1] == "y" && !isset($_POST["input_".$element_id."_$k"]) )
                        $resTestReq = false;
                    
                    if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
                    {
                        $desc = trim($_REQUEST["input_".$element_id."_$k"]);

                        if(trim(SITE_CHARSET) == "windows-1251")
                            $desc = utf8win1251(trim($_REQUEST["input_".$element_id."_$k"]));

                        $message .= '<b>'.$arVal.': </b>'.$desc.'<br/>';
                        
                        if($type[0] == "name")
                        {
                            if($countName <= 0)
                                $name = $desc;

                            $countName++;
                        }
                        
                        if($type[0] == "phone")
                        {
                            if($countPhone <= 0)
                                $phone = $desc;

                            $countPhone++;
                        }
                        
                        if($type[0] == "email")
                        {
                            if($countEmail <= 0)
                                $email = $desc;

                            $countEmail++;
                        }
                    }
                }


                


                if($type[0] == "file")
                {
                    if($type[1] == "y" && empty($_FILES["input_".$element_id."_$k"]["name"]) )
                        $resTestReq = false;

                    if(!empty($_FILES["input_".$element_id."_$k"]["name"]))
                    {
                        $arFile = array();

                        foreach ($_FILES["input_".$element_id."_$k"]["name"] as $key => $name)
                        {
                            if($_FILES["input_".$element_id."_$k"]["error"][$key] == 0)
                            {

                                if(trim(SITE_CHARSET) == "windows-1251")
                                    $filename = utf8win1251($name);
                                else
                                    $filename = $name;

                                $arParams = array("safe_chars"=>".", "max_len" => 1000);
                                $filename = Cutil::translit($filename,"ru",$arParams);
                                
                                $filename = basename($filename);
                        
                                $newname = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/hameleon_tmp_file/'.$filename;
                                if (!file_exists($newname)) 
                                {
                                    move_uploaded_file($_FILES["input_".$element_id."_$k"]["tmp_name"][$key], $newname);
                                }

                                $arFile[] = $newname;
                            }
                        }

                        $arFiles = array_merge($arFiles, $arFile);
                    }
                }
            }

        }

    }

    if(!$resTestReq)
    {
        $arRes = json_encode($arRes);
        echo $arRes;

        return false;
    }

    $mesParams = "";

    for ($i=1; $i <=10 ; $i++)
    { 
        if(strlen($_POST["custom-input-".$i]))
        {

            if(trim(SITE_CHARSET) == "windows-1251")
                $_POST["custom-input-".$i] = utf8win1251(trim($_POST["custom-input-".$i]));

            $mesParams .= "<div>"."<b>".GetMessage("HAMELEON_MESS_CUSTOM_PARAM_".$i)."</b>".$_POST["custom-input-".$i]."</div>";
            
        }
    }

    if(strlen($mesParams))
        $message .= "<br/><br/>".$mesParams;


    $toAdminFile = false;

    if(!empty($arFiles))
        $toAdminFile = true;



    $arFilesId = Array();

    if(!empty($arFiles))
    {
        foreach ($arFiles as $value)
        {

            $file_chars = CFile::MakeFileArray($value);

            $arIMAGE = $file_chars;
            $arIMAGE["MODULE_ID"] = "concept.hameleon";
            if(trim(SITE_CHARSET) == "windows-1251")
                $arIMAGE = utf8win1251($arIMAGE);

            $fid = CFile::SaveFile($arIMAGE, "hameleon_db_files");
            $arFilesId[] = intval($fid);
        }
    }



    $arFilesId = implode(",", $arFilesId);

    $form_info = $message;

    global $DB_cham;
    ChamDB::ChamDBval();
    $cart_info = "";
    $pay_name = $DB_cham["PAYMENT"]["ITEMS"][$_REQUEST["cham_pay"]]["NAME_ON_SITE"];
    $deliv_name = $DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["NAME_ON_SITE"];
    $pay_name_adm = $DB_cham["PAYMENT"]["ITEMS"][$_REQUEST["cham_pay"]]["NAME"];
    $deliv_name_adm = $DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["NAME"];

    $deliv_text = trim($_REQUEST["deliv_text_".$_REQUEST["cham_deliv"]]);

    if(trim(SITE_CHARSET) == "windows-1251")
        $deliv_text = utf8win1251($deliv_text);

    if(strlen($pay_name)>0 && $pay_name != NULL)
    {
        $message .= "<b>".GetMessage("HAM_CART_ORDER_PAYMENT")."</b>".$pay_name."<br/>";
        $cart_info .= "<b>".GetMessage("HAM_CART_ORDER_PAYMENT")."</b>".$pay_name."<br/>";
    }
    if(strlen($deliv_name)>0 && $deliv_name != NULL)
    {
        $message .= "<b>".GetMessage("HAM_CART_ORDER_DELIVERY")."</b>".$deliv_name."<br/>";
        $cart_info .= "<b>".GetMessage("HAM_CART_ORDER_DELIVERY")."</b>".$deliv_name."<br/>";
    }
    if(strlen($deliv_text)>0 && $deliv_text != NULL)
    {
        $deliv_text_title = "<b>".GetMessage("HAM_CART_ORDER_DELIVERY_TITLE")."/<b>";
        if(strlen($DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["ADD_FIELD_NAME"])>0 && $DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["ADD_FIELD_NAME"] != NULL)
            $deliv_text_title = "<b>".$DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["ADD_FIELD_NAME"]."</b>: ";

        $message .= "<b>".$deliv_text_title."</b>".$deliv_text."<br/>";
        $cart_info .= "<b>".$deliv_text_title."</b>".$deliv_text."<br/>";
    }


    $crm_table = "";

    if(!empty($arResult["ITEMS"]))
    {
        foreach ($arResult["ITEMS"] as $key => $arItem){
            $crm_table .= "<b>".($key+1).". </b>".strip_tags($arItem["~NAME"]).", "."<b>".GetMessage("HAM_CART_ORDER_ELEM_PRICE").": </b>".strip_tags($arItem["PROPERTIES"]["BOX_PRICE_FORMAT"]["VALUE"]).", "."<b>".GetMessage("HAM_CART_ORDER_ELEM_COUNT").": </b>".$arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"].strip_tags($unit).", "."<b>".GetMessage("HAM_CART_ORDER_ELEM_SUM").": </b>".$arItem["PROPERTIES"]["BOX_PRICE_COUNT_FORMAT"]["VALUE"].";<br/>";
            
        }
    }


    $table .= $list."</table>";



    $deliv_price = strip_tags($DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["PRICE"]);
    $deliv_price = CHam_format::convertCurr($deliv_price, $DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["CURRENCY"], $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);
    $deliv_price_format = CHam_format::CurrFormatString($deliv_price, $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);


    $total_price_order = $arResult["TOTAL_NEW_NUM"] + $deliv_price;
    $total_price_order_format = CHam_format::CurrFormatString($total_price_order, $arResult["BAS_CURENCIES"]["UF_CH_BAS_CURENCIES"]);


    if($arResult["REQUEST_PRICE"])
    {
        $total_price_format = $arResult["REQUEST_PRICE_REQ"];
        $total_price_order_format = $arResult["REQUEST_PRICE_REQ"];
    }


    $sale = $arResult["TOTAL_SALE"];
    $sum = $arResult["TOTAL_NEW"];
    $total_sum = $total_price_order_format;


    $total_info = "";
    $crm_total_info = "";

    if($sum)
        $total_info .= "<div><b>".GetMessage("HAM_CART_ORDER_LIST_PRICE")."</b> ".$sum."</div>";

    if($sale)
        $total_info .= "<div><b>".GetMessage("HAM_CART_ORDER_LIST_SALE")."</b> ".$sale."</div>";

    if($deliv_price_format)
    {
        $total_info .= "<div><b>".GetMessage("HAM_CART_ORDER_LIST_DELIVERY_PRICE")."</b> ".$deliv_price_format."</div>";
        $crm_total_info .= "<b>".GetMessage("HAM_CART_ORDER_LIST_DELIVERY_PRICE")."</b>".$deliv_price_format."<br/>";
    }

    if($total_sum)
    {
        $total_info .= "<div><b>".GetMessage("HAM_CART_ORDER_LIST_TOTAL")."</b> ".$total_sum."</div>";
        $crm_total_info .= "<b>".GetMessage("HAM_CART_ORDER_LIST_TOTAL")."</b>".$total_sum."<br/>";
    }




    $f_sts = array_shift($DB_cham["STATUS"]["ITEMS"]);

    $arOrder = array(
        'LAND_ID' => htmlspecialcharsEx($arSection["ID"]),
        'SUM' => htmlspecialcharsEx($arResult["TOTAL_NEW_NUM"]),
        'CURRENCY' => htmlspecialcharsEx($arSection["UF_CH_BAS_CURENCIES"]),
        'STATUS' => htmlspecialcharsEx($f_sts["ID"]),
        'PROPERTIES' => htmlspecialcharsEx($form_info),
        'PAYED' => htmlspecialcharsEx("N"),
        'FILES' => htmlspecialcharsEx($arFilesId),
        'DELIVERY' => htmlspecialcharsEx($DB_cham["DELIVERY"]["ITEMS"][$_REQUEST["cham_deliv"]]["ID"]),
        'DELIVERY_SUM' => htmlspecialcharsEx($deliv_price),
        'PAYMENT' => htmlspecialcharsEx($DB_cham["PAYMENT"]["ITEMS"][$_REQUEST["cham_pay"]]["ID"]),
        'NAME' => htmlspecialcharsEx($name),
        'EMAIL' => htmlspecialcharsEx($email),
        'PHONE' => htmlspecialcharsEx($phone),
        'DELIVERY_COMMENT' => htmlspecialcharsEx($deliv_text_title.$deliv_text)
    );



    $result = CHamOrders\CHamOrdersTable::add($arOrder);
    $id_order = $result->getId();
    $arPaymentParams = CHamOrder::GetPaymentSystemParams($id_order);
    $result = "";


    if(!empty($arResult["ITEMS"]))
    {
        foreach($arResult["ITEMS"] as $key => $arItem){
            $arOrderItems = array(
                'NAME' => htmlspecialcharsEx(strip_tags($arItem["~NAME"])),
                'ITEM_ID' => $arItem["ID"],
                'OFFER_ID' => htmlspecialcharsEx($arItem["OTHER_COMPLECT"]["ID"]),
                'PRICE' => htmlspecialcharsEx($arItem["PROPERTIES"]["BOX_PRICE_NUM"]["VALUE"]),
                'OLD_PRICE' => htmlspecialcharsEx($arItem["PROPERTIES"]["BOX_OLD_PRICE_NUM"]["VALUE"]),
                'CURRENCY' => htmlspecialcharsEx($arSection["UF_CH_BAS_CURENCIES"]),
                'QUANTITY' => htmlspecialcharsEx($arItem["PROPERTIES"]["BOX_PRICE_STEP_"]["VALUE"]),
                'ORDER_ID' => htmlspecialcharsEx($id_order),
                'REQUEST' => htmlspecialcharsEx($arItem["PROPERTIES"]["REQUEST_PRICE"]["VALUE"]),

            );
            
            $result = CHamOrdersItems\CHamOrdersItemsTable::add($arOrderItems);
        }
    }

    $arRes["PAYMENT_REDIRECT"] = "";

    $result = "";

    $url_order = $host."/bitrix/admin/cham_shop_orders_view.php?ID=".$id_order;



    $payment_link = "";
    $payment_button = "";

    if(!empty($arPaymentParams))
    {
    	$payment_link = $host."/bitrix/tools/hameleon/payments/init.php?ORDER_ID=".$id_order;
    	$payment_button = "<a href='".$payment_link."' target='_blank' style='padding: 13px 30px;
        display: inline-block;
        background-color: #5cba86;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;'>".GetMessage("HAM_CART_ORDER_PAYMENT_BUTTON_NAME")."</a>";
    }


    $theme_admin = GetMessage("HAM_CART_ORDER_THEME_DEFAULT_ADMIN");
    $theme_user = GetMessage("HAM_CART_ORDER_THEME_DEFAULT_USER");

    if(strlen($arSection["~UF_CHAM_THEME_ADMIN"])>0)
        $theme_admin = $arSection["~UF_CHAM_THEME_ADMIN"];

    if(strlen($arSection["~UF_CHAM_THEME_USER"])>0)
        $theme_user = $arSection["~UF_CHAM_THEME_USER"];


    $id_order_mes = "<div><b>".GetMessage("HAM_CART_ORDER_ORDER_ID")."</b> ".$id_order."</div>";
    $alert_admin = "<br/><br/>".GetMessage("HAM_CART_ORDER_ALERT_ADMIN_PART_1")." <a target='_blank' href='".$host."/bitrix/admin/cham_shop_orders_view.php?ID=".$id_order."'>".GetMessage("HAM_CART_ORDER_ALERT_ADMIN_PART_2")."</a>";

    if(strlen($arSection["~UF_CHAM_CART_ADMIN"])<=0)
    {
        $cart_message_admin = GetMessage("HAM_CART_ORDER_DEFAULT_ADMIN");

        if(!empty($arPaymentParams))
        {
            $cart_message_admin .= "<br/><br/>".$payment_button."<br/>";
        }
    }

    if(strlen($arSection["~UF_CHAM_CART_USER"])<=0)
    {
        $intro = GetMessage("HAM_CART_ORDER_INTRO_USER")."<br/><br/>";
        $alert_user = "<br/><br/>".GetMessage("HAM_CART_ORDER_ALERT_USER");
        $cart_message_user = GetMessage("HAM_CART_ORDER_DEFAULT_USER");

        if(!empty($arPaymentParams))
        {
        	$cart_message_user .= "<br/><br/>".$payment_button."<br/>";
        }

        $cart_message_user .= $alert_user;
    }

    if(strlen($arSection["~UF_CHAM_CART_ADMIN"])>0)
        $cart_message_admin = $arSection["~UF_CHAM_CART_ADMIN"];

    if(strlen($arSection["~UF_CHAM_CART_USER"])>0)
        $cart_message_user = $arSection["~UF_CHAM_CART_USER"];

    $theme_admin = CHamOrder::MakeMessage($id_order, $theme_admin);
    $theme_user = CHamOrder::MakeMessage($id_order, $theme_user);
    $cart_message_admin = CHamOrder::MakeMessage($id_order, $cart_message_admin);
    $cart_message_user = CHamOrder::MakeMessage($id_order, $cart_message_user);



    if(strlen($arSection["~UF_CHAM_EMAIL_FROM"]) > 0)
        $email_from = $arSection["~UF_CHAM_EMAIL_FROM"];
    else
        $email_from = htmlspecialcharsBack($arSite['EMAIL']);


    if(strlen($arSection["~UF_CHAM_EMAIL_TO"]) > 0)
        $email_to = $arSection["~UF_CHAM_EMAIL_TO"];
    else
        $email_to = htmlspecialcharsBack($arSite['EMAIL']);



    $arMailtoAdmin = array();

    if(isset($email_to{0}))
        $arMailtoAdmin = explode(",", $email_to);

    $email_to_form = array();

    if(strlen($arIBlockElement["PROPERTIES"]["EMAIL_TO"]["VALUE"])>0)
    {
        $email_to_form = explode(",", $arIBlockElement["PROPERTIES"]["EMAIL_TO"]["VALUE"]);

        if($arIBlockElement["PROPERTIES"]["DUBLICATE"]["VALUE"] == "Y")
        {
            if(!empty($email_to_form))
                $arMailtoAdmin = array_merge($arMailtoAdmin, $email_to_form);
        }
        else
            $arMailtoAdmin = $email_to_form;
    }


    $replyTo = $email_from;

    $arMailUserto = array();

    if(isset($email{0}))
    {
        $arMailUserto = explode(",", $email);
        $replyTo = $arMailUserto[0];
    }

    $utmFields = "";

    if(isset($_COOKIE["hameleon_UTM_SOURCE_".$site_id]) || isset($_COOKIE["hameleon_UTM_MEDIUM_".$site_id]) || isset($_COOKIE["hameleon_UTM_CAMPAIGN_".$site_id]) || isset($_COOKIE["hameleon_UTM_CONTENT_".$site_id]) || isset($_COOKIE["hameleon_UTM_TERM_".$site_id]))
    {

        $utmFields .= "<br/><br/>".GetMessage("HAMELEON_MESS_SEND_UTM_TITLE")."<br/>";

        if(isset($_COOKIE["hameleon_UTM_SOURCE_".$site_id]))
            $utmFields .= "utm_source: ".$_COOKIE["hameleon_UTM_SOURCE_".$site_id]."<br/>";

        if(isset($_COOKIE["hameleon_UTM_MEDIUM_".$site_id]))
            $utmFields .= "utm_medium: ".$_COOKIE["hameleon_UTM_MEDIUM_".$site_id]."<br/>";

        if(isset($_COOKIE["hameleon_UTM_CAMPAIGN_".$site_id]))
            $utmFields .= "utm_campaign: ".$_COOKIE["hameleon_UTM_CAMPAIGN_".$site_id]."<br/>";

        if(isset($_COOKIE["hameleon_UTM_CONTENT_".$site_id]))
            $utmFields .= "utm_content: ".$_COOKIE["hameleon_UTM_CONTENT_".$site_id]."<br/>";

        if(isset($_COOKIE["hameleon_UTM_TERM_".$site_id]))
            $utmFields .= "utm_term: ".$_COOKIE["hameleon_UTM_TERM_".$site_id]."<br/>";
    }



    $arEventFields = array(
        "MESSAGE" => "<div style='width: 100%; max-width: 800px;'>".$cart_message_admin.$alert_admin.$utmFields."</div>",
        "EMAIL_FROM" => $email_from,
        "EMAIL" => $replyTo,
        "PAGE_NAME" => $arSection["NAME"],
        "THEME" => $theme_admin
    );



    if(!empty($arMailtoAdmin))
    {
        foreach ($arMailtoAdmin as $email_to_val)
        {
            $arEventFields["EMAIL_TO"] = $email_to_val;
            
            if($toAdminFile)
            {
                if(CEvent::Send("HAMELEON_CART_ADMIN", SITE_ID, $arEventFields, "Y", "", $arFiles))
                    $arRes["OK"] = "Y";
            }

            else
            {
                if(CEvent::Send("HAMELEON_CART_ADMIN", SITE_ID, $arEventFields, "Y", ""))
                    $arRes["OK"] = "Y";
            }
        }
    }

    if (file_exists($_SERVER["DOCUMENT_ROOT"].$tmpl_path.'/hameleon_tmp_file/'))
        foreach (glob($_SERVER["DOCUMENT_ROOT"].$tmpl_path.'/hameleon_tmp_file/*') as $file)
            unlink($file);




    $arEventFields2 = array(
        "EMAIL_FROM" => $email_from,
        "EMAIL" => $email_from,
        "MESSAGE" => "<div style='width: 100%; max-width: 800px;'>".$cart_message_user."</div>",
        "THEME" => $theme_user,
    );


    if(!empty($arMailUserto))
    {
        foreach ($arMailUserto as $email_to_val)
        {
            $arEventFields2["EMAIL_TO"] = $email_to_val;
            if(CEvent::Send("HAMELEON_CART_USER", SITE_ID, $arEventFields2))
                $arRes["OK"] = "Y";
        }

        if(!empty($arIBlockElement["PROPERTIES"]['FORM_TEXT']["~VALUE"]) || !empty($arIBlockElement['PROPERTIES']['FORM_FILES']['VALUE']) || strlen($arIBlockElement["PROPERTIES"]['FORM_THEME']["VALUE"]) > 0)
        {

            $arEventFields3 = array(
                "EMAIL_FROM" => $email_from,
                "EMAIL" => $email_from,
                "MESSAGE" => $arIBlockElement["PROPERTIES"]['FORM_TEXT']["~VALUE"]["TEXT"],
                "THEME" => $arIBlockElement["PROPERTIES"]['FORM_THEME']["~VALUE"]
            );

            $files = $arIBlockElement['PROPERTIES']['FORM_FILES']['VALUE'];

            foreach ($arMailUserto as $email_to_val)
            {
                $arEventFields3["EMAIL_TO"] = $email_to_val;
                
                if(!empty($files))
                {
                    if(CEvent::Send("HAMELEON_CART_USER", SITE_ID, $arEventFields3, "Y", "", $files))
                        $arRes["OK"] = "Y";
                }

                else
                {
                    if(CEvent::Send("HAMELEON_CART_USER", SITE_ID, $arEventFields3, "Y", ""))
                        $arRes["OK"] = "Y";
                }
            }
        }

    }



    $arRes["SCRIPTS"] = '';

    $yaGoal = $arIBlockElement['PROPERTIES']['YANDEX_GOAL']['VALUE'];

    $gogCat = $arIBlockElement['PROPERTIES']['GOOGLE_GOAL_CATEGORY']['VALUE'];
    $gogAct = $arIBlockElement['PROPERTIES']['GOOGLE_GOAL_ACTION']['VALUE'];

    $gtmEvn = $arIBlockElement['PROPERTIES']['GTM_EVENT']['VALUE'];
    $gtmCat = $arIBlockElement['PROPERTIES']['GTM_GOAL_CATEGORY']['VALUE'];
    $gtmAct = $arIBlockElement['PROPERTIES']['GTM_GOAL_ACTION']['VALUE'];


    $arYaGoalsYM = $arYaGoals = Array();

    if(strlen($arSection["UF_CHAM_METRIKA"])>0)
    {
        $input_line = "";
        $pattern = "";
        $search = "";
        $replace = "";

        $input_line = $arSection["UF_CHAM_METRIKA"]; 
        $pattern = "/id:[0-9]*,/"; 

        if(preg_match_all($pattern, $input_line, $output_array))
        {
            $search = array("id:",",");
            $replace   = array("", "");
            $arYaGoals = str_replace($search, $replace, $output_array[0]);
        }

        $patternFlagYM = "/ym\([0-9]*,/";

        if(preg_match_all($patternFlagYM, $input_line, $out))
            $arYaGoalsYM = str_replace(array("ym(",","), array("",""), $out[0]);

    }


    if(strlen($arSection["UF_CHAM_GOOGLE"])>0)
    {   

        $patternFlagGa = "/ga\(/";
        $patternFlagGtag = "/gtag\(/"; 
        $googleFlagGa = preg_match($patternFlagGa, $arSection["UF_CHAM_GOOGLE"]);
        $googleFlagGtag = preg_match($patternFlagGtag, $arSection["UF_CHAM_GOOGLE"]);
        
    }

    $idGtm = "";

    if(strlen($arSection["UF_CHAM_GTM"])>0)
    {
        $input_line = "";
        $pattern = "";
        $search = "";
        $replace = "";


        $input_line = $arSection["UF_CHAM_GTM"]; 
        $pattern = "/'GTM-.*'/";

        preg_match($pattern, $input_line, $output_array);

        $search = array("'");
        $replace   = array("");
        $idGtm = str_replace($search, $replace, $output_array[0]);
    }


   

    if(!empty($arYaGoals) > 0 && strlen($yaGoal) > 0)
    {
        foreach($arYaGoals as $idVal)
        {
            $arRes["SCRIPTS"] .= 'yaCounter'.trim($idVal).'.reachGoal("'.trim($yaGoal).'"); ';
        }
    }
    if(!empty($arYaGoalsYM) > 0 && strlen($yaGoal) > 0)
    {

        foreach($arYaGoalsYM as $idVal)
        {
            $arRes["SCRIPTS"] .= 'ym('.htmlspecialcharsbx(trim($idVal)).', "reachGoal", "'.htmlspecialcharsbx(trim($yaGoal)).'");';
        }
    }

    if(strlen($arSection["UF_CHAM_GOOGLE"]) && strlen($gogCat) > 0 && strlen($gogAct) > 0)
    {
        if($googleFlagGa)
            $arRes["SCRIPTS"] .= 'ga("send", "event", "'.htmlspecialcharsbx(trim($gogCat)).'", "'.htmlspecialcharsbx(trim($gogAct)).'"); ';

        if($googleFlagGtag)
            $arRes["SCRIPTS"] .= 'gtag("event","'.htmlspecialcharsbx(trim($gogAct)).'",{"event_category":"'.htmlspecialcharsbx(trim($gogCat)).'"}); ';
    }

    if(strlen($idGtm) > 0 && strlen($gtmEvn) > 0)
    {
        $arRes["SCRIPTS"] .= 'dataLayer.push({"event": "'.trim($gtmEvn).'", "eventCategory": "'.trim($gtmCat).'", "eventAction": "'.trim($gtmAct).'"}); ';
    }

    

    if(isset($arIBlockElement['PROPERTIES']['FORM_JS_AFTER_SEND']['VALUE']["TEXT"]))
        $arRes["SCRIPTS"] .= $arIBlockElement['PROPERTIES']['FORM_JS_AFTER_SEND']['~VALUE']["TEXT"];

    if(!empty($arPaymentParams))
        $arRes["PAYMENT_REDIRECT"] = "/bitrix/tools/hameleon/payments/init.php?ORDER_ID=".$id_order;

    require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/concept.hameleon/crm.php'); 


    $arRes["OK"] = "Y";
    
    $arRes = json_encode($arRes);
    echo $arRes;



    $crm_mes = $form_info."<br/><br/>"."<b>".GetMessage("HAM_CART_ORDER_ORDER_ID")."</b>".$id_order."<br/><br/>"."<b>".GetMessage("HAM_CART_ORDER_ORDER_LIST")."</b><br/>".$crm_table."<br/>".GetMessage("HAM_CART_ORDER_TEXT6")."<br/>".$cart_info.$crm_total_info;



    //bitrix24
    if(
        $arSection["UF_CHAM_B24"] && strlen($arSection["UF_CHAM_B24_URL"]) > 0 
        && 
            (strlen($arSection["UF_CHAM_B24_LOGIN"]) > 0 && strlen($arSection["UF_CHAM_B24_PASSWORD"]) > 0)
        ||  (strlen($arSection["UF_BX_ID"]) > 0 && strlen($arSection["UF_BX_WEB_HOOK"]) > 0)

        )
    {
        

        $crmUrl = "https://".trim($arSection["UF_CHAM_B24_URL"])."/";
        $login = trim($arSection["UF_CHAM_B24_LOGIN"]);
        $password = trim($arSection["UF_CHAM_B24_PASSWORD"]);
        
        
        $title = GetMessage("HAM_CART_ORDER_B24_TITLE").$arSection["NAME"];
        
        $mess = "";
        
        $mess .= "<b>".GetMessage("HAM_CART_ORDER_TEXT2")."</b>".$arSection["NAME"]."<br/>";
        $mess .= "<b>".GetMessage("HAM_CART_ORDER_TEXT3")."</b>".GetMessage("HAM_CART_ORDER_TEXT3_1")."<br/>";
        $mess .= "<b>".GetMessage("HAM_CART_ORDER_TEXT4")."</b>".$url."<br/><br/>";
        
        $mess .= $crm_mes;
        
        

        $namebx = $name;
        $phonebx = $phone;
        $emailbx = $email;
        
        if(trim(SITE_CHARSET) == "windows-1251")
        {
            $title = iconv('windows-1251', 'utf-8', $title);
            $namebx = iconv('windows-1251', 'utf-8', $namebx);
            $phonebx = iconv('windows-1251', 'utf-8', $phonebx);
            $emailbx = iconv('windows-1251', 'utf-8', $emailbx);
            $mess = iconv('windows-1251', 'utf-8', $mess);
        }
        
        
        $arParams = array(
            'LOGIN' => $login, 
            'PASSWORD' => $password, 
            'TITLE' => $title
        );
         
        if(strlen($namebx) > 0)
            $arParams['NAME'] = $namebx;

        if(strlen($phonebx) > 0)
        {
            $arParams['PHONE_WORK'] = $phonebx;

            $arParams["PHONE"][] = Array(
                "VALUE" => $phonebx, 
                "VALUE_TYPE" => "WORK"
            );
        }
            
        if(strlen($email) > 0)
        {
            $arParams['EMAIL_WORK'] = $email;

            $arParams["EMAIL"][] = Array(
                "VALUE" => $email, 
                "VALUE_TYPE" => "WORK"
            );
        }
            
        if(strlen($mess) > 0)
            $arParams['COMMENTS'] = $mess;

        if(strlen($arSection["UF_BX_ASSIGNED_BY_ID"]) > 0)
            $arParams['ASSIGNED_BY_ID'] = $arSection["UF_BX_ASSIGNED_BY_ID"];

        if(isset($_COOKIE["hameleon_UTM_SOURCE_".$site_id]))
            $arParams['UTM_SOURCE'] = $_COOKIE["hameleon_UTM_SOURCE_".$site_id];

        if(isset($_COOKIE["hameleon_UTM_MEDIUM_".$site_id]))
            $arParams['UTM_MEDIUM'] = $_COOKIE["hameleon_UTM_MEDIUM_".$site_id];

        if(isset($_COOKIE["hameleon_UTM_CAMPAIGN_".$site_id]))
            $arParams['UTM_CAMPAIGN'] = $_COOKIE["hameleon_UTM_CAMPAIGN_".$site_id];

        if(isset($_COOKIE["hameleon_UTM_CONTENT_".$site_id]))
            $arParams['UTM_CONTENT'] = $_COOKIE["hameleon_UTM_CONTENT_".$site_id];

        if(isset($_COOKIE["hameleon_UTM_TERM_".$site_id]))
            $arParams['UTM_TERM'] = $_COOKIE["hameleon_UTM_TERM_".$site_id];
            
        
        $arParams['SOURCE_ID'] = "WEB";

        
        if(strlen($arSection["UF_BX_ID"]) > 0 && strlen($arSection["UF_BX_WEB_HOOK"]) > 0)
        {
            $queryData = http_build_query(array(
                'fields' => $arParams,
                'params' => array("REGISTER_SONET_EVENT" => "Y"),
            ));

            $rest = 'crm.lead.add.json';
            $queryUrl = $crmUrl.'rest/'.$arSection["UF_BX_ID"].'/'.$arSection["UF_BX_WEB_HOOK"].'/'.$rest;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $queryUrl,
                CURLOPT_POSTFIELDS => $queryData,
            ));
            $result = curl_exec($curl);
            curl_close($curl);
        }
        elseif (strlen($arSection["UF_CHAM_B24_LOGIN"]) > 0 && strlen($arSection["UF_CHAM_B24_PASSWORD"]) > 0)
        {

            $obHttp = new CHTTP();
            $obHttp->Post($crmUrl.'crm/configs/import/lead.php', $arParams);
            //$result = json_decode(str_replace('\'', '"', $result), true);
            //$arRes["ER"] = '['.$result['error'].'] '.$result['error_message'];
            
        }

    }



    //amocrm
    if($arSection["UF_CHAM_AMO"] && strlen($arSection["UF_CHAM_AMO_URL"]) > 0 && strlen($arSection["UF_CHAM_AMO_LOGIN"]) > 0 && strlen($arSection["UF_CHAM_AMO_HASH"]) > 0)
    {
        
        
        
        $crmUrl = "https://".trim($arSection["UF_CHAM_AMO_URL"])."/"; 
        $login = trim($arSection["UF_CHAM_AMO_LOGIN"]);
        $hash = trim($arSection["UF_CHAM_AMO_HASH"]);
        
        $title = GetMessage("HAM_CART_ORDER_B24_TITLE").$arSection["NAME"];
        
        $mess = "";
        
        $mess .= GetMessage("HAM_CART_ORDER_TEXT2").$arSection["NAME"]."\r\n";
        $mess .= GetMessage("HAM_CART_ORDER_TEXT3").GetMessage("HAM_CART_ORDER_TEXT3_1")."\r\n";
        $mess .= GetMessage("HAM_CART_ORDER_TEXT4").$url."\r\n\r\n";
        
        $mess .= $crm_mes;
        
        $nameamo = $name;
        $phoneamo = $phone;
        $emailamo = $email;
        
        if(trim(SITE_CHARSET) == "windows-1251")
        {
            $title = iconv('windows-1251', 'utf-8', $title);
            $nameamo = iconv('windows-1251', 'utf-8', $nameamo);
            $phoneamo = iconv('windows-1251', 'utf-8', $phoneamo);
            $emailamo = iconv('windows-1251', 'utf-8', $emailamo);
            $mess = iconv('windows-1251', 'utf-8', $mess);
        }
        
        $mess = str_replace(Array("<b>","</b>","<br>","<br/>","<div>","</div>"), Array("", "", "\r\n", "\r\n", "", "\r\n"), $mess);
        $mess = html_entity_decode(strip_tags($mess));
        
        require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/concept.hameleon/amocrm/add.php');
        
    }
}
else
{
    $arRes = json_encode($arRes);
    echo $arRes;
}
?>