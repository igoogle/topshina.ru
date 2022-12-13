<?  if(strlen($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0)
        $arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"] = "form";
    
    if(strlen($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"]) <= 0)
        $arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"] = "form";


    $block_name = $arItem['~NAME'];

    if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
        $block_name .= " (".$arItem["PROPERTIES"]["HEADER"]["~VALUE"].")";

    $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

    $class_button = "";
    $class_button2 = "";

    if(strlen($arItem["PROPERTIES"]["BUTTON_NAME"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"]) > 0)
        $class_button = "left-on";
    
    if(strlen($arItem["PROPERTIES"]["BUTTON_NAME_2"]["VALUE"]) > 0 && strlen($arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"]) > 0)
        $class_button2 = "right-on";
?>


<div class="clearfix"></div>
<div class="main-button-wrap <?if($center):?>center<?endif;?> <?=$class_button?> <?=$class_button2?>">

    <?if(strlen($class_button) > 0):?>

        <a 

        <?

            if(strlen($arItem["PROPERTIES"]["BUTTON_ONCLICK"]["VALUE"])>0) 
            {
                $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BUTTON_ONCLICK"]["VALUE"]);

                echo "onclick='".$str_onclick."'";

                $str_onclick = "";
            }

            $b_left_options = array(
                "MAIN_COLOR" => "primary",
                "STYLE" => ""
            );

            if(strlen($arItem["PROPERTIES"]["BUTTON_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["BUTTON_VIEW"]["VALUE_XML_ID"] != "empty")
            {

                $b_left_options = array(
                    "MAIN_COLOR" => "btn-bgcolor-custom",
                    "STYLE" => "background-color: ".$arItem["PROPERTIES"]["BUTTON_BG_COLOR"]["VALUE"].";"
                );

            }

        ?> 



            class="big button-def left 
                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                <?=hamButtonEditClass(
                    $arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"],
                    $arItem["PROPERTIES"]["BUTTON_FORM"]["VALUE"],
                    $arItem["PROPERTIES"]["BUTTON_MODAL"]["VALUE"])?>

                <?if($arItem["PROPERTIES"]["BUTTON_VIEW"]["VALUE_XML_ID"] == "empty"):?> 
                    secondary 
                <?elseif($arItem["PROPERTIES"]["BUTTON_VIEW"]["VALUE_XML_ID"] == "shine"):?> 
                    shine <?=$b_left_options["MAIN_COLOR"]?> 
                <?else:?> 
                    <?=$b_left_options["MAIN_COLOR"]?>  
                <?endif;?>" 

                <?if(strlen($b_left_options["STYLE"])):?>
                    style = "<?=$b_left_options["STYLE"]?>"
                <?endif;?>

                <?=hamButtonEditAttr(
                    $arItem["PROPERTIES"]["BUTTON_TYPE"]["VALUE_XML_ID"],
                    $arItem["PROPERTIES"]["BUTTON_FORM"]["VALUE"],
                    $arItem["PROPERTIES"]["BUTTON_MODAL"]["VALUE"],
                    $arItem["PROPERTIES"]["BUTTON_LINK"]["VALUE"],
                    $arItem["PROPERTIES"]["BUTTON_BLANK"]["VALUE_XML_ID"],
                    $block_name,
                    $arItem["PROPERTIES"]["BUTTON_QUIZ"]["VALUE"])?>>

                <?=$arItem["PROPERTIES"]["BUTTON_NAME"]["~VALUE"]?>
                    
        </a>

    <?endif;?>

    <?if(strlen($class_button2) > 0):?>

        <a 
        <?

            if(strlen($arItem["PROPERTIES"]["BUTTON_2_ONCLICK"]["VALUE"])>0) 
            {
                $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BUTTON_2_ONCLICK"]["VALUE"]);

                echo "onclick='".$str_onclick."'";

                $str_onclick = "";
            }

            $b_right_options = array(
                "MAIN_COLOR" => "primary",
                "STYLE" => ""
            );

            if(strlen($arItem["PROPERTIES"]["BUTTON_2_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["BUTTON_VIEW_2"]["VALUE_XML_ID"] != "empty")
            {

                $b_right_options = array(
                    "MAIN_COLOR" => "btn-bgcolor-custom",
                    "STYLE" => "background-color: ".$arItem["PROPERTIES"]["BUTTON_2_BG_COLOR"]["VALUE"].";"
                );

            }

        ?> 


        class="big 
            button-def
            right
            <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
            <?=hamButtonEditClass(
                $arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"],
                $arItem["PROPERTIES"]["BUTTON_FORM_2"]["VALUE"],
                $arItem["PROPERTIES"]["BUTTON_MODAL_2"]["VALUE"])?>

            <?if($arItem["PROPERTIES"]["BUTTON_VIEW_2"]["VALUE_XML_ID"] == "empty"):?>
                secondary
            <?elseif($arItem["PROPERTIES"]["BUTTON_VIEW_2"]["VALUE_XML_ID"] == "shine"):?>
                shine <?=$b_right_options["MAIN_COLOR"]?>
            <?else:?>
                <?=$b_right_options["MAIN_COLOR"]?>
            <?endif;?>"

            <?if(strlen($b_right_options["STYLE"])):?>
                style = "<?=$b_right_options["STYLE"]?>"
            <?endif;?>

            <?=hamButtonEditAttr(
                $arItem["PROPERTIES"]["BUTTON_TYPE_2"]["VALUE_XML_ID"],
                $arItem["PROPERTIES"]["BUTTON_FORM_2"]["VALUE"],
                $arItem["PROPERTIES"]["BUTTON_MODAL_2"]["VALUE"],
                $arItem["PROPERTIES"]["BUTTON_LINK_2"]["VALUE"],
                $arItem["PROPERTIES"]["BUTTON_BLANK_2"]["VALUE_XML_ID"],
                $block_name,
                $arItem["PROPERTIES"]["BUTTON_QUIZ_2"]["VALUE"])?>>

            <?=$arItem["PROPERTIES"]["BUTTON_NAME_2"]["~VALUE"]?>
                    
        </a>

    <?endif;?>
    
</div>