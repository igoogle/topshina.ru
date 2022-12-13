<?$count = (!empty($arItem["ELEMENTS"]))?count($arItem["ELEMENTS"]):0;?>

<?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "flat"):?>
    
    <div class="services col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
        
        <?
            $class = "";
            
            
            if($count <= 3)
                $class = "col-sm-4 col-xs-12 service-item";
            else
                $class = "col-md-3 col-sm-6 col-xs-12 service-item four-elements";
              
            $class2 = "";
            
            if($count == 1)
                $class2 = "col-sm-offset-4 col-xs-offset-0";

            elseif($count == 2)
                $class2 = "col-md-offset-2 col-xs-offset-0";
        ?>

        <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>

            <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>     
                <div class="<?=$class?> <?if($k==0):?><?=$class2?><?endif;?>">

                    <div class="row">
                        
                        <div class="service-element no-margin-top-bot  <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                            <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?><div class="star"></div><?endif;?>
                            
                            <?if($arItem["SHOW_PICTURE"] > 0):?>
                                
                                <div class="image-table-wrap">
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="image-wrap <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?> btn-modal-open<?endif;?>" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                    <?if($count <= 3):?>
                                                        <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>500, 'height'=>250), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>

                                                    <?else:?>
                                                         <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>500, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>

                                                    <?endif;?>

                                                    <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt="<?=$arService["PROPERTIES"]["SERVICE_PICTURE"]["DESCRIPTION"]?>"/>

                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                        
                            <?endif;?>

                            <?if($arItem["SHOW_SUBNAME"] > 0):?>
                            
                                <div class="top-name">
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                        <?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?>
                                    <?endif;?>
                                </div>
                            
                            <?endif;?>

                            <?if($arItem["SHOW_NAME"] > 0):?>
                            
                                <div class="name-wrap">
                                    <div class="name main1">
                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>
                                            <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                        <?endif;?>
                                    </div>
                                </div>
                            
                            <?endif;?>

                            <?if($arItem["SHOW_PRICE"] > 0):?>
                                
                                <?if(($arItem["SHOW_NAME"] > 0 || $arItem["SHOW_SUBNAME"] > 0) && (strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0 || strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0)):?>
                                    <div class="line-grey"></div>
                                <?endif;?>
                                
                                <div class="price-wrap">
                                
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                        <div class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></div>
                                    <?endif;?>
                                    
                                    <div class="price main1">
                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0):?>
                                           <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                        <?endif;?>
                                    </div>
                                
                                </div>
                                
                                
                                
                            <?endif;?>
                            
                            <?if(
                                strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0 
                                || !empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]
                                || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])) 
                                || strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) > 0):?>

                                <div class="bot-wrap no-margin-top-bot">
                                    
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                        <div class="text">
                                            <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                        </div>
                                    <?endif;?>
                                    
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                        <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                    <?endif;?>
                                    
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>

                                        <div class="button-wrap">


                                            <a 
                                                <?
                                                    if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0)
                                                    {
                                                        $str_onclick = str_replace("'", "\"", $arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]);
                                                        echo "onclick='".$str_onclick."'";
                                                        $str_onclick = "";
                                                    }

                                                    $b_options = array(
                                                        "MAIN_COLOR" => "primary",
                                                        "STYLE" => ""
                                                    );

                                                    if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"]))
                                                    {

                                                        $b_options = array(
                                                            "MAIN_COLOR" => "btn-bgcolor-custom",
                                                            "STYLE" => "background-color: ".$arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"].";"
                                                        );

                                                    }
                                                ?>

                                                class="
                                                    button-def
                                                    <?=$b_options["MAIN_COLOR"]?>
                                                    more-modal-info
                                                    <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                    <?=hamButtonEditClass (
                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                                        $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>

                                                        <?if($count <= 3):?>
                                                            big
                                                        <?else:?>
                                                            medium
                                                        <?endif;?>"

                                                <?if(strlen($b_options["STYLE"])):?>
                                                    style = "<?=$b_options["STYLE"]?>"
                                                <?endif;?>

                                                data-element-type = "SRV"
                                                <?=hamButtonEditAttr(
                                                    $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                    $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                                    $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"],
                                                    $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"],
                                                    $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                    $block_name,
                                                    $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"],
                                                    $arService["ID"])?>>
                                                <?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?>
                                                    
                                            </a>
                                        </div>

                                    <?endif;?>
                                    
                                    <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>

                                        <?
                                            $sec_btn_name = GetMessage("PAGE_GEN_SERVICE_MORE_DETAIL");
                                            if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0)
                                                $sec_btn_name = $arSection['~UF_MORE_NAME_SRVC'];
                                        ?>
                                    
                                        <a class="link-def btn-modal-open" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?=$sec_btn_name?></span></a>
                                    
                                    
                                    <?endif;?>
                                    
                                </div>
                            
                            <?endif;?>
                            
                        </div>
                    
                    </div>

                    <?admin_setting($arService)?>
                </div>

                <?
                    if($count <= 3)
                    {
                        if(($k+1)%3 == 0)
                            echo "<span class='clearfix visible-lg visible-md visible-sm'></span>";
                    }

                    else
                    {
                        if(($k+1)%2 == 0)
                            echo "<span class='clearfix visible-sm'></span>";

                        if(($k+1)%4 == 0)
                            echo "<span class='clearfix visible-lg visible-md'></span>";
                    }
                ?>

            <?endforeach;?>
            
        <?endif;?>
        
    </div>
    
<?endif;?>


<?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "table"):?>

    <div class="services-2 col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
        
        <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
        
            <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>
                <div class="wrap-service-table">

                    <div class="service-table <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">
                        
                        <?if($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"] > 0):?>
                        
                            <div class="service-cell image-wrap 

                                <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 
                                    || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>
                                    btn-modal-open<?endif;?>" data-site-id='<?=SITE_ID?>'  data-detail="service" data-element-id="<?=$arService["ID"]?>" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>"

                                >
                                
                                <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality); ?>
                                
                                <img class="img-responsive center-block lazyload" data-src="<?=$img["src"]?>" alt="<?=$arService["PROPERTIES"]["SERVICE_PICTURE"]["DESCRIPTION"]?>"/>

                            </div>
                        
                        <?endif;?>

                        <div class="service-cell text-wrap no-margin-top-bot">
                            
                            <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                <div class="top-name"><?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?></div>
                            <?endif;?>
                         
                            
                            <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>            
                                <div class="name main1">
                                    <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                    
                                    <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?>
                                        <span class="hit"></span>
                                    <?endif;?>

                                </div>
                            <?endif;?>

                            <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                <div class="text">
                                    <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                </div>
                            <?endif;?>
                            
                            <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0 || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                <div class="price-sm main1 visible-sm">
                                    <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                    
                                    <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                        <span class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span>
                                    <?endif;?>
                                </div>
                            <?endif;?>

                            <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>
                                <div class="link-wrap">
                                <a class="link-def btn-modal-open" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="service"  data-element-id="<?=$arService["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0) echo $arSection['~UF_MORE_NAME_SRVC']; else echo GetMessage("PAGE_GEN_SERVICE_MORE_DETAIL");?></a>
                                </div>

                                                                               
                            <?endif;?>
                            
                        </div>

                        <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0  || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                            <div class="service-cell price-wrap main1 hidden-sm">
                                <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                
                                <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                    <span class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span>
                                <?endif;?>
                            </div>
                        <?endif;?>
                        
                        <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                            <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                        <?endif;?>
                        
                        <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>                    
                            <div class="service-cell button-wrap">
                                <a
                                    <?
                                        if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0)
                                        {
                                            $str_onclick = str_replace("'", "\"", $arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]);
                                            echo "onclick='".$str_onclick."'";
                                            $str_onclick = "";
                                        }

                                        $b_options = array(
                                            "MAIN_COLOR" => "primary",
                                            "STYLE" => ""
                                        );

                                        if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"]))
                                        {

                                            $b_options = array(
                                                "MAIN_COLOR" => "btn-bgcolor-custom",
                                                "STYLE" => "background-color: ".$arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"].";"
                                            );

                                        }
                                    ?>

                                    class="button-def
                                        <?=$b_options["MAIN_COLOR"]?>
                                        more-modal-info
                                        big
                                        <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                        <?=hamButtonEditClass (
                                            $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                            $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                            $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>"

                                    <?if(strlen($b_options["STYLE"])):?>
                                        style = "<?=$b_options["STYLE"]?>"
                                    <?endif;?>

                                    data-element-type = "SRV"

                                    <?=hamButtonEditAttr(
                                        $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                        $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                        $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"],
                                        $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"],
                                        $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"],
                                        $block_name,
                                        $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"],
                                        $arService["ID"])?>>

                                    <?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?>
                                        
                                </a>
                            </div>                                                
                        <?endif;?>
                        
                    </div>

                    <?admin_setting($arService)?>

                </div>
                
            <?endforeach;?>
            
        <?endif;?>
    
    </div>
    
<?endif;?>


<?if($arItem["PROPERTIES"]["SERVICE_VIEW"]["VALUE_XML_ID"] == "slider"):?>

        </div>
    </div>
        
        <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>

            <div class="img-for-lazyload-parent">
                <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
                
                <div class="images-animate hidden-sm hidden-xs clearfix">
                    
                    <div class="slider-services-images">
                        
                        <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>
                            
                            <div class="service-slide <?if($k!=0) echo 'noactive-slide-lazyload';?>">
                                <?if($arService["PROPERTIES"]["SERVICE_ADD_BACK_PICTURE"]["VALUE"] > 0):?>

                                    <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_ADD_BACK_PICTURE"]["VALUE"], array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                    <img class="center-block img-responsive show-on lazyload" data-src="<?=$img["src"]?>" alt=""/>
                                
                                <?endif;?>
                                
                            </div>
                        
                        <?endforeach;?>

                    </div>
                    
                </div>
                
                
                <div class="slider-services-wrap clearfix">
            
                        
                    <?if($count > 1):?>
                    
                        <button type="button" class="slick-prev"></button>
                        <button type="button" class="slick-next"></button>
                    
                    <?endif;?>
                    
                    
                    <div class="slider-services <?=($count>1)?"parent-slider-item-js":""?>">
                        
                        <?foreach($arItem["ELEMENTS"] as $k=>$arService):?>

                            <div class="service-slide <?if($k!=0 && $count>1) echo 'noactive-slide-lazyload';?>">
                                <div class="element-table-wrap">
                            
                                    <div class="element-table <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>">
                                        
                                        <?if($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"] > 0):?>
                                        
                                            <?$img = CFile::ResizeImageGet($arService["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>900, 'height'=>900), BX_RESIZE_IMAGE_PROPORTIONAL, false); ?>
                                        
                                        
                                            <div class="element-cell image-wrap radius-on">
                                            
                                                <div class="image-wrap 
                                                    <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?> btn-modal-open<?endif;?>" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="service" data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>"
                                                    >
                                                
                                                    <img class="center-block img-responsive show-on lazyload" data-src="<?=$img["src"]?>" alt="<?=$arService["PROPERTIES"]["SERVICE_PICTURE"]["DESCRIPTION"]?>"/>
                                                
                                                </div>
                                                
                                            </div>
                                            
                                        <?endif;?>


                                        <div class="element-cell text-wrap no-margin-top-bot show-on <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>">

                                            <div class="wrap-padding-left">
                                                
                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
                                                    <div class="name"><?=$arService["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?></div>
                                                <?endif;?>
         
                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>            
                                                    <div class="title main1">
                                                        <?=$arService["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?>
                                                        
                                                        <?if($arService["PROPERTIES"]["SERVICE_HIT"]["VALUE"] == "Y"):?>
                                                            <span class="hit"></span>
                                                        <?endif;?>
                                                    </div>
                                                <?endif;?>

                                                <div class="line"></div>
                                                
                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                                    <div class=" text text-content <?=$arService["PROPERTIES"]["SERVICE_TEXT_COLOR"]["VALUE_XML_ID"]?>" >
                                                        <?=$arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
                                                    </div>
                                                <?endif;?>

                                                
                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0  || strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                 
                                                    <div class="price-wrap no-margin-top-bot">
                                                        
                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
                                                            <div class="old-price main2"><?=$arService["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></div>
                                                        <?endif;?>
                                                            
                                                        <div class="price main1">
                                                            <?=$arService["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
                                                        </div>
                                                    
                                                    </div>
                                                 
                                                    
                                                <?endif;?>
                                                
                                              
                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                    <?$arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                <?endif;?>
                           

                                                <?if(strlen($arService["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"]) || strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>
                                                    
                                                    <div class="buttons-wrap">

                                                        <?if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>
                                                        
                                                            <div class="button-wrap-inner">

                                                                <a 

                                                                    <?
                                                                        if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0)
                                                                        {
                                                                            $str_onclick = str_replace("'", "\"", $arService["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]);
                                                                            echo "onclick='".$str_onclick."'";
                                                                            $str_onclick = "";
                                                                        }

                                                                        $b_options = array(
                                                                            "MAIN_COLOR" => "primary",
                                                                            "STYLE" => ""
                                                                        );

                                                                        if(strlen($arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"]))
                                                                        {

                                                                            $b_options = array(
                                                                                "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                                "STYLE" => "background-color: ".$arService["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"].";"
                                                                            );

                                                                        }
                                                                    ?>

                                                                    class="
                                                                        button-def
                                                                        <?=$b_options["MAIN_COLOR"]?>
                                                                        big
                                                                        more-modal-info
                                                                        <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                                        <?=hamButtonEditClass (
                                                                            $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                                            $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                                                            $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>"


                                                                    <?if(strlen($b_options["STYLE"])):?>
                                                                        style = "<?=$b_options["STYLE"]?>"
                                                                    <?endif;?>

                                                                    data-element-type = "SRV"
                                                                    <?=hamButtonEditAttr(
                                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
                                                                        $arService["PROPERTIES"]["SERVICE_MODAL"]["VALUE"],
                                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"],
                                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                        $block_name,
                                                                        $arService["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"],
                                                                        $arService["ID"])?>>
                                                                    <?=$arService["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?>
                                                                </a>
                                                            </div>
                                                        <?endif;?>
        
                                                        <?if(!empty($arService["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"]) > 0 || !empty($arService["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>
                                                            <?
                                                                $sec_btn_name = GetMessage("PAGE_GEN_SERVICE_MORE_DETAIL");
                                                                if(strlen($arSection['~UF_MORE_NAME_SRVC'])>0)
                                                                    $sec_btn_name = $arSection['~UF_MORE_NAME_SRVC'];
                                                            ?>

                                                            <div class="button-wrap-inner">
                                                                <a class="button-def secondary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> big btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="service"  data-element-id="<?=$arService["ID"]?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                                                    <i class="fa fa-info" aria-hidden="true"></i>
                                                                    <?=$sec_btn_name?>
                                                                </a>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                    </div>
                                                    
                                                <?endif;?>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <?admin_setting($arService, true)?>

                                </div>
                            </div>
                                                                            
                        <?endforeach;?>
                    
                    </div>

                </div>

                <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">

            </div>

        <?endif;?>

    <div class="container">
        <div class="row">

<?endif;?>