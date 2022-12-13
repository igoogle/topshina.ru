<?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?> 

<div class="banners-menu big-parent-colls <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">

<?if($admin_active && $show_setting):?>
    <div class='change-colls-info'><?=GetMessage("PAGE_GEN_BLINK_INFO_SAVE")?></div>
<?endif;?>

<div class="">

    <div class="frame-wrap clearfix">

        <?foreach($arItem["ELEMENTS"] as $k=>$arLink):?>

            <?
                $b_options = array(
                    "MAIN_COLOR" => "primary",
                    "STYLE" => ""
                );

                if(strlen($arLink["PROPERTIES"]["BLINK_BUTTON_BG_COLOR"]["VALUE"]))
                {

                    $b_options = array(
                        "MAIN_COLOR" => "btn-bgcolor-custom",
                        "STYLE" => "background-color: ".$arLink["PROPERTIES"]["BLINK_BUTTON_BG_COLOR"]["VALUE"].";"
                    );

                }
            ?>
        
            <?$size = array("width" => 280, "height" => 280);?>
            <?$cols = 'col-md-3 col-sm-6 col-xs-12 small';?>

            <?if($arLink["PROPERTIES"]['BLINK_COLS']['VALUE_XML_ID'] == 'middle'):?>
                <?$size = array("width" => 580, "height" => 280);?>
                <?$cols = 'col-sm-6 col-xs-12 middle';?>
            <?endif;?>
                
                
            <?$size2 = array("width" => 400, "height" => 280);?>
            <?$size3 = array("width" => 400, "height" => 400);?>

            <div class="<?=$cols?> parent-change-cools<?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?> child-animate opacity-zero<?endif;?>">

                <input type="hidden" class='colls_code' value="BLINK_COLS">
                <input type="hidden" class='colls_middle' value="<?=$arSection['ENUM_COLLS_BLINK'][0]?>">
                <input type="hidden" class='colls_small' value="<?=$arSection['ENUM_COLLS_BLINK'][1]?>">

                <div class="frame <?=$arLink["PROPERTIES"]['BLINK_TEXT_COLOR']['VALUE_XML_ID']?>">
                    
                    <?if($arLink["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y' && strlen($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>
                    
                        <a 

                        <?

                            if(strlen($arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                            {
                                $str_onclick = str_replace("'", "\"", $arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                echo "onclick='".$str_onclick."'";

                                $str_onclick = "";
                            }

                        ?> 


                        class="
                            wrap-link
                            <?=hamButtonEditClass(
                                $arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                            <?=hamButtonEditAttr(
                                $arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                $arLink["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                $arLink["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                $block_name,
                                $arLink["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>></a>
                    
                    
                    <?endif;?>
                    
                   
                    <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size, BX_RESIZE_IMAGE_EXACT, true);?>  
                    <img class="img hidden-xs hidden-sm lazyload" data-src="<?=$img["src"]?>" alt=""/>
                    
                    
                    <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size2, BX_RESIZE_IMAGE_EXACT, true);?>  
                    <img class="img visible-sm lazyload" data-src="<?=$img["src"]?>" alt=""/>
                    
                    
                    <?$img = CFile::ResizeImageGet($arLink["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], $size3, BX_RESIZE_IMAGE_EXACT, true);?>  
                    <img class="img visible-xs lazyload" data-src="<?=$img["src"]?>" alt=""/>

                                  
                
                            
                    <div class="small-shadow"></div>
                    <div class="frameshadow"></div>
                    
                    <div class="text">
                    
                        <div class="cont">
                            <div class="name bold"><?=$arLink["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                            <div class="comment"><?=$arLink["PROPERTIES"]['BLINK_TEXT']['~VALUE']["TEXT"]?></div>
                        </div>

                        <?if(strlen($arLink["PROPERTIES"]['BLINK_NAME']['VALUE'])>0 && strlen($arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>

                            <div class="button">
                                 
                                <?if($arLink["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y'):?>
                                    
                                    <a 
                                    class="
                                        medium
                                        button-def
                                        <?=$b_options["MAIN_COLOR"]?>
                                        <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>"

                                        <?if(strlen($b_options["STYLE"])):?>
                                            style = "<?=$b_options["STYLE"]?>"
                                        <?endif;?>

                                    >
                                        
                                        <?=$arLink["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                        
                                    </a>
                                
                                <?else:?>                                                           
                                
                                    <a 

                                        <?
                                            if(strlen($arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                                            {
                                                $str_onclick = str_replace("'", "\"", $arLink["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                                echo "onclick='".$str_onclick."'";

                                                $str_onclick = "";
                                            }
                                        ?> 

                                        class="
                                            button-def
                                            <?=$b_options["MAIN_COLOR"]?>
                                            medium
                                            <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                            <?=hamButtonEditClass(
                                                $arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                                        <?if(strlen($b_options["STYLE"])):?>
                                            style = "<?=$b_options["STYLE"]?>"
                                        <?endif;?>

                                        <?=hamButtonEditAttr(
                                            $arLink["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                            $arLink["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                            $arLink["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                            $arLink["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                            $arLink["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                            $block_name,
                                            $arLink["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>

                                        <?=$arLink["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                        
                                    </a>
                                
                                <?endif;?>
                                
                            </div>
                        <?endif;?>

                    </div>

                    <?admin_setting($arLink)?>



                    <?if($admin_active && $show_setting):?>

                        <span class='change-colls' data-type='element' data-element-id='<?=$arLink['ID']?>'></span>

                    <?endif;?>
                    
                </div>
            </div>

            <?if(($k+1) % 2 == 0 ):?><div class="clearfix visible-sm"></div><?endif;?>

        <?endforeach;?>
    </div>


</div>


</div>

<?endif;?>

<?if($arItem["PROPERTIES"]["BLINK_VIEW"]["VALUE_XML_ID"] == "banner"):?>
<?
    $b_options = array(
        "MAIN_COLOR" => "primary",
        "STYLE" => ""
    );

    if(strlen($arItem["PROPERTIES"]["BLINK_BUTTON_BG_COLOR"]["VALUE"]))
    {

        $b_options = array(
            "MAIN_COLOR" => "btn-bgcolor-custom",
            "STYLE" => "background-color: ".$arItem["PROPERTIES"]["BLINK_BUTTON_BG_COLOR"]["VALUE"].";"
        );

    }
?>
<div class="banner clearfix">

    <div class="col-xs-12">

    <?
        $bg = '';

        if(strlen($arItem["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'])>0)
            $bg = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_BACKGROUND']['VALUE'], array('width'=>900, 'height'=>900), BX_RESIZE_IMAGE_PROPORTIONAL, false);
    ?>

    <div class="element lazyload" data-src="<?=$bg["src"]?>">
        <div class="row">

            <?
                $view = '1';
                $col_img = 'col-lg-3 col-md-3';
                $col_btn = 'col-lg-3 col-md-3';
                $col_text = 'col-lg-6 col-md-6';

                $text_ini = false;
                $img_ini = false;
                $btn_ini = false;

                if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0 ||strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0)
                    $text_ini = true;

                if(strlen($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0 && strlen($arItem["PROPERTIES"]['BLINK_NAME']['VALUE'])>0)
                    $btn_ini = true;

                if(strlen($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'])>0)
                    $img_ini = true;
                

                if(!$btn_ini)
                {
                    $col_btn = 'hidden-lg hidden-md';
                    $col_img = 'col-lg-3 col-md-3';
                    $col_text = 'col-lg-9 col-md-9';
                }

                if(!$img_ini)
                {
                    $col_img = 'hidden-lg hidden-md';
                    $col_btn = 'col-lg-3 col-md-3';
                    $col_text = 'col-lg-9 col-md-9';
                }

                if(!$btn_ini && !$img_ini)
                {
                    $col_btn = 'hidden-lg hidden-md';
                    $col_img = 'hidden-lg hidden-md';
                    $col_text = 'col-lg-12 col-md-12';
                }


                $mark1 = $col_text.'';
                $mark2 = $col_btn.' button';
                $mark3 = $col_img.' image';


                if($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view2')
                {
                    $view = '2';
                    $mark1 = $col_btn.' button';
                    $mark2 = $col_text.'';
                    $mark3 = $col_img.' image';
                }

                elseif($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view3')
                {
                    $view = '3';
                    $mark1 = $col_img.' image';
                    $mark2 = $col_btn.' button';
                    $mark3 = $col_text.'';
                }

                elseif($arItem["PROPERTIES"]['BLINK_POSITION']['VALUE_XML_ID'] == 'view4')
                {
                    $view = '4';
                    $mark1 = $col_img.' image';
                    $mark2 = $col_text.'';
                    $mark3 = $col_btn.' button';
                }
            ?>

            <div class="part-wrap <?=$arItem["PROPERTIES"]['BLINK_TEXT_COLOR']['VALUE_XML_ID']?>">

                <div class="part col-sm-8 col-xs-12 left <?=$mark1?>">
                    <div class="part-inner-wrap">

                        <div class="hidden-sm hidden-xs unset-margin-top-child">
                            <?if($view == '1'):?>

                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                    <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                <?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                    <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                <?endif;?>

                            <?elseif($view == '2'):?>

                                <?if($btn_ini):?>
                                  

                                    <a 

                                        <?

                                            if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                                            {
                                                $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                                echo "onclick='".$str_onclick."'";

                                                $str_onclick = "";
                                            }

                                        ?> 

                                        class="
                                            button-def
                                            <?=$b_options["MAIN_COLOR"]?> 
                                            <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> 

                                            <?=hamButtonEditClass(
                                                $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                                            <?if(strlen($b_options["STYLE"])):?>
                                                style = "<?=$b_options["STYLE"]?>"
                                            <?endif;?>

                                            <?=hamButtonEditAttr(
                                                $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                                $block_name, $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>

                                        <?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                            
                                    </a>

                                <?endif;?>

                            <?elseif($view == '3' || $view == '4'):?>

                                <?if($img_ini):?>

                                    <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                    <img class="img-responsive lazyload" data-src="<?=$img['src']?>" alt="<?=$arItem["PROPERTIES"]['BLINK_PICTURE']['DESCRIPTION']?>"/>

                                <?endif;?>

                            <?endif;?>
                        </div>

                        <noindex>
                            <div class="visible-sm visible-xs unset-margin-top-child">
                            
                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                    <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                <?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                    <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                <?endif;?>

                                <?if($btn_ini):?>
                                

                                    <a 

                                        <?

                                            if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                                            {
                                                $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                                echo "onclick='".$str_onclick."'";

                                                $str_onclick = "";
                                            }

                                        ?> 


                                        class="
                                            medium
                                            button-def
                                            <?=$b_options["MAIN_COLOR"]?>
                                            <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                            <?=hamButtonEditClass(
                                                $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                                            <?if(strlen($b_options["STYLE"])):?>
                                                style = "<?=$b_options["STYLE"]?>"
                                            <?endif;?>

                                            <?=hamButtonEditAttr(
                                                $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                                $block_name,
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>
                                        <?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                            
                                    </a>
                                    
                                <?endif;?>
                            </div>
                        </noindex> 
                        
                    </div>
                </div>

                <div class="part col-xs-0 center hidden-sm hidden-xs <?=$mark2?>">

                    <div class="part-inner-wrap">
                        <?if($view == '1' || $view == '3'):?>

                            <?if($btn_ini):?>
                                <a 

                                    <?

                                        if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                                        {
                                            $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                            echo "onclick='".$str_onclick."'";

                                            $str_onclick = "";
                                        }

                                    ?> 

                                    class="
                                        medium
                                        button-def
                                        <?=$b_options["MAIN_COLOR"]?>
                                        <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>

                                        <?=hamButtonEditClass(
                                            $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                            $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                            $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                                    <?if(strlen($b_options["STYLE"])):?>
                                        style = "<?=$b_options["STYLE"]?>"
                                    <?endif;?>

                                    <?=hamButtonEditAttr(
                                        $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                        $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                        $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                        $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                        $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                        $block_name,
                                        $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>

                                    <?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                        
                                </a>

                                
                            <?endif;?>

                        <?elseif($view == '2' || $view == '4'):?>

                            <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                            <?endif;?>

                            <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                            <?endif;?>

                        <?endif;?>

                    </div>
                </div>

                <div class="part col-sm-4 col-xs-12 right <?=$mark3?>">
                    <div class="part-inner-wrap">
                        <div class="hidden-sm hidden-xs unset-margin-top-child">

                            <?if($view == '1' || $view == '2'):?>

                                <?if($img_ini):?>

                                    <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                    <img class="img-responsive lazyload" src="<?=$img['src']?>" alt="<?=$arItem["PROPERTIES"]['BLINK_PICTURE']['DESCRIPTION']?>">
                                
                                <?endif;?>

                            <?elseif($view == '3'):?>

                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TITLE']['VALUE'])>0):?>
                                    <div class="text bold"><?=$arItem["PROPERTIES"]['BLINK_TITLE']['~VALUE']?></div>
                                <?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]['BLINK_TEXT']['VALUE']['TEXT'])>0):?>
                                    <div class="desc"><?=$arItem["PROPERTIES"]['BLINK_TEXT']['~VALUE']['TEXT']?></div>
                                <?endif;?>

                            <?elseif($view == '4'):?>
                                <?if($btn_ini):?>
                                    <a 

                                        <?

                                            if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                                            {
                                                $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                                                echo "onclick='".$str_onclick."'";

                                                $str_onclick = "";
                                            }

                                        ?> 

                                        class="
                                            medium
                                            button-def
                                            <?=$b_options["MAIN_COLOR"]?>
                                            <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                            <?=hamButtonEditClass(
                                                $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                                $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                                $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                                        <?if(strlen($b_options["STYLE"])):?>
                                            style = "<?=$b_options["STYLE"]?>"
                                        <?endif;?>

                                        <?=hamButtonEditAttr(
                                            $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                                            $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                                            $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                                            $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                                            $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                                            $block_name,
                                            $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>
                                        <?=$arItem["PROPERTIES"]['BLINK_NAME']['~VALUE']?>
                                        
                                    </a>
                                    
                                <?endif;?>
                            <?endif;?>

                        </div>

                        <noindex>
                            <div class="visible-sm visible-xs unset-margin-top-child">
                                <?if($img_ini):?>

                                    <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]['BLINK_PICTURE']['VALUE'], array('width'=>300, 'height'=>2900), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                    <img class="img-responsive lazyload" data-src="<?=$img['src']?>" alt="<?=$arItem["PROPERTIES"]['BLINK_PICTURE']['DESCRIPTION']?>" />
                                
                                <?endif;?>
                            </div>  
                        </noindex>
                    </div>
                </div>

            </div>

        </div>

        <?if($arItem["PROPERTIES"]['BLINK_LINK_BLOCK']['VALUE'] == 'Y' && strlen($arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'])>0):?>
            <a 

                <?

                    if(strlen($arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"])>0) 
                    {
                        $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["BLINK_ONCLICK"]["VALUE"]);

                        echo "onclick='".$str_onclick."'";

                        $str_onclick = "";
                    }

                ?> 

                class="wrap-link 
                    <?=hamButtonEditClass(
                        $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                        $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                        $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'])?>"

                <?=hamButtonEditAttr(
                    $arItem["PROPERTIES"]['BLINK_BTN_TYPE']['VALUE_XML_ID'],
                    $arItem["PROPERTIES"]['BLINK_BUTTON_FORM']['VALUE'],
                    $arItem["PROPERTIES"]['BLINK_MODAL']['VALUE'],
                    $arItem["PROPERTIES"]['BLINK_BUTTON_LINK']['VALUE'],
                    $arItem["PROPERTIES"]['BLINK_BUTTON_BLANK']['VALUE_XML_ID'],
                    $block_name,
                    $arItem["PROPERTIES"]['BLINK_BUTTON_QUIZ']['VALUE'])?>>
                    
            </a>
        
        <?endif;?>


    </div>

</div>

</div>
<?endif;?>