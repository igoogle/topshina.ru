<?if($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "flat"):?>

    <?
        $class = "";
        $count = count($arItem["ELEMENTS"]);
        
        if($count <= 3)
        {
            $class = "col-sm-4 col-xs-12";
            $col_lg = 3;
            $col_md = 3;
            $col_sm = 3;

            if($count == 2)
            {
            	$col_lg = 2;
                $col_md = 2;
                $col_sm = 2;
            }
        }
        else
        {
            $class = "col-md-3 col-sm-6 col-xs-12 four-elements";
            $col_lg = 4;
            $col_md = 4;
            $col_sm = 2;
        }
        
        $class2 = "";
        
        if($count == 1)
            $class2 = "col-sm-offset-4 col-xs-offset-0";

        elseif($count == 2)
            $class2 = "col-md-offset-2 col-xs-offset-0";
    ?>

    <div>
        <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">

        <div class="tariff-flat tarif col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?> parent-slider-item-js" <?if($arItem["PROPERTIES"]["TARIFF_ROUND_HEIGHT"]["VALUE"] == "Y"):?> data-round-height = "Y" data-col-lg="<?=$col_lg?>" data-col-md="<?=$col_md?>" data-col-sm="<?=$col_sm?>"<?endif;?>>

            <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
            
                <?foreach($arItem["ELEMENTS"] as $k=>$arTariff):?>

                    <div class="tarif-item <?=$class?> <?if($k==0):?><?=$class2?><?endif;?>">

                        <div class="row">
                            
                            <div class="tarif-element no-margin-top-bot <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                                <div class="tarif-element-inner">

                                    <div class="trff-top-part">
                            
                                        <?if($arTariff["PROPERTIES"]["TARIFF_HIT"]["VALUE"] == "Y"):?><div class="star"></div><?endif;?>
                                    
                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_NAME"]["VALUE"]) > 0):?>
                                            <div class="name main1">
                                                <?=$arTariff["PROPERTIES"]["TARIFF_NAME"]["~VALUE"]?>
                                            </div>
                                        <?endif;?>

                                        <?if($arTariff["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>
                                            
                                            <?$img = CFile::ResizeImageGet($arTariff["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"], array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality); ?>

                                            
                                            <?if((!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                <a class="btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="tariff" data-element-id="<?=$arTariff["ID"]?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                            <?endif;?>
                                            
                                            <img class="image lazyload" data-src="<?=$img["src"]?>" alt="<?=$arTariff["PROPERTIES"]["TARIFF_PICTURE"]["DESCRIPTION"]?>"/>
                                                
                                             <?if((!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                                </a>
                                            <?endif;?>
                                        
                                        <?endif;?>
                                        
                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                                            <div class="tarif-descript italic">
                                                <?=$arTariff["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["~VALUE"]?>
                                            </div>
                                        <?endif;?>
                                        
                                        <?if(!empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                                        
                                            <ul>
                                                
                                                <?if(is_array($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) && !empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                                    
                                                    <?foreach($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["~VALUE"] as $val):?>
                                                        <li class="point-green"><?=$val?></li>
                                                    <?endforeach;?>
                                                    
                                                <?endif;?>
                                                
                                                <?if(is_array($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) && !empty($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                                                    
                                                    <?foreach($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["~VALUE"] as $val):?>
                                                        <li><?=$val?></li>
                                                    <?endforeach;?>
                                                    
                                                <?endif;?>
                                                
                                            </ul>
                                        
                                        <?endif;?>

                                    </div>

                                    <div class="trff-bot-part">
                                    
                                        <?if((!empty($arTariff["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])) && (strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0)):?>
                                            <div class="line-grey"></div>
                                        <?endif;?>
                                        
                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                            
                                            <div class="price-wrap">
                                                
                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                                    <div class="old-price main2"><?=$arTariff["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></div>
                                                <?endif;?>

                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>
                                                    <div class="price main1"><?=$arTariff["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?></div>
                                                <?endif;?>
                                                
                                            </div>
                                        
                                        <?endif;?>

                                        
                                        <?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                            <?$arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                                        <?endif;?>
                                        
                                        <?if((strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0) || (!empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                        
                                            <div class="bot-wrap no-margin-top-bot">
                                                
                                                <?if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?>

                                                    <div class="button-wrap">

                                                        <a 
                                                            <?
                                                                if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"])>0) 
                                                                {

                                                                    $str_onclick = str_replace("'", "\"", $arTariff["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"]);

                                                                    echo "onclick='".$str_onclick."'";
                                                                    $str_onclick = "";
                                                                }


                                                                $b_options = array(
                                                                    "MAIN_COLOR" => "primary",
                                                                    "STYLE" => ""
                                                                );

                                                                if(strlen($arTariff["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"]))
                                                                {

                                                                    $b_options = array(
                                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                        "STYLE" => "background-color: ".$arTariff["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"].";"
                                                                    );

                                                                }



                                                            ?> 

                                                            class="
                                                                button-def
                                                                more-modal-info
                                                                <?=$b_options["MAIN_COLOR"]?>
                                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                                <?=hamButtonEditClass (
                                                                    $arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                                    $arTariff["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
                                                                    $arTariff["PROPERTIES"]["TARIFF_MODAL"]["VALUE"])?>

                                                                <?if($count <= 3):?>
                                                                    big
                                                                <?else:?>
                                                                    medium
                                                                <?endif;?>"

                                                            data-element-type = "TRF"

                                                            <?if(strlen($b_options["STYLE"])):?>
                                                                style = "<?=$b_options["STYLE"]?>"
                                                            <?endif;?>

                                                            <?=hamButtonEditAttr(
                                                                $arTariff["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                                $arTariff["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
                                                                $arTariff["PROPERTIES"]["TARIFF_MODAL"]["VALUE"],
                                                                $arTariff["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"],
                                                                $arTariff["PROPERTIES"]["TARIFF_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                $block_name,
                                                                $arTariff["PROPERTIES"]["TARIFF_BUTTON_QUIZ"]["VALUE"],
                                                                $arTariff["ID"])?>>

                                                            
                                                            <?=$arTariff["PROPERTIES"]["TARIFF_BUTTON_NAME"]["~VALUE"]?>
                                                            
                                                            
                                                        </a>
                                                    </div>

                                                  
                                                
                                                <?endif;?>

                                                <?if(
                                                    !empty($arTariff["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])
                                                    || !empty($arTariff["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):
                                                ?>

                                                    <div class="link-wrap no-margin-top-bot">
                                                        <a class="link-def btn-modal-open" 
                                                            data-header="<?=$block_name?>"
                                                            data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>"
                                                            data-site-id='<?=SITE_ID?>'
                                                            data-detail="tariff"
                                                            data-element-id="<?=$arTariff["ID"]?>">
                                                            <i class="fa fa-info" aria-hidden="true"></i><span class="bord">
                                                                <?if(strlen($arSection['~UF_MORE_NAME_TRFF'])>0)
                                                                    echo $arSection['~UF_MORE_NAME_TRFF'];
                                                                else
                                                                    echo GetMessage("PAGE_GEN_TARIFF_MORE_DETAIL");?></span>
                                                        </a>
                                                    </div>
                                                    
                                                <?endif;?>
                                            </div>
                                        
                                        <?endif;?>

                                    </div>

                                </div>
                                
                            
                            </div>
                            
                        </div>

                        <?admin_setting($arTariff)?>

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

                    <?
                        if($count > 3)
                        {
                            if( ($k+1) % 4 == 0)
                                $row++;
                    
                        }
                    ?>
                    
                <?endforeach;?>
            
            <?endif;?>
            
        </div>

        <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
    </div>
                    
<?endif;?>


<?if($arItem["PROPERTIES"]["TARIFF_VIEW"]["VALUE_XML_ID"] == "full"):?>
    
    <div class="tarif-2 <?=$arItem["PROPERTIES"]["TARIFF_TEXT_COLOR"]["VALUE_XML_ID"]?> clearfix">

        <?
            if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0)
                $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false);
        ?>

                                    
        <div class="tarif-table">

            <div class="tarif-cell text-part no-margin-top-bot <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>col-md-7 col-xs-12<?else:?>col-xs-12<?endif;?> <?if($arItem["PROPERTIES"]["TARIFF_PICTURE_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-push-5 col-xs-push-0<?endif;?>">
            
                <?if(strlen($arItem["PROPERTIES"]["TARIFF_NAME"]["VALUE"]) > 0):?>
                    <div class="title main1">
                        <?=$arItem["PROPERTIES"]["TARIFF_NAME"]["~VALUE"]?> <?if($arItem["PROPERTIES"]["TARIFF_HIT"]["VALUE"] == "Y"):?><span class="hit"></span><?endif;?>
                    </div>
                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["VALUE"]) > 0):?>
                    <div class="subtitle italic">
                        <?=$arItem["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["~VALUE"]?>
                    </div>
                <?endif;?>
                
                
                <div class="tarif-body no-margin-top-bot">
                    <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>

                        <noindex>

                            <div class="image-hidden visible-sm visible-xs">

                                <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                    <a class="btn-modal-open" data-header="<?=$block_name?>" data-site-id='<?=SITE_ID?>' data-detail="tariff" data-element-id="<?=$arItem["ID"]?>"  data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                                <?endif;?>
                            
                                <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt="<?=$arItem["PROPERTIES"]["TARIFF_PICTURE"]["DESCRIPTION"]?>"/>
                                
                                <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                                    </a>
                                <?endif;?>

                            </div>

                        </noindex>

                    <?endif;?>
                
                    <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                    
                        <div class="list-wrap">

                            <div class="price-wrap">
                            
                                <?if(strlen($arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
                                    <div class="old-price main2"><?=$arItem["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></div>
                                <?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>
                                    <div class="price main1"><?=$arItem["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?></div>
                                <?endif;?>
                                
                            </div>
                            
                        </div>
                    
                    <?endif;?>
                
                    
                    <?if(!empty($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                
                        <div class="list-wrap">
                            <div class="row clearfix">
                            
                                <?if(is_array($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
                                
                                    <div class="col-md-6 col-xs-12">
  
                                        <ul class="adv-plus-minus">
                                            
                                            <?foreach($arItem["PROPERTIES"]["TARIFF_INCLUDE"]["~VALUE"] as $val):?>
                                                <li class="point-green"><?=$val?></li>
                                            <?endforeach;?>
                                        
                                        </ul>

                                    </div>
                                
                                <?endif;?>
                                
                                <?if(is_array($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
                                 
                                    <div class="col-md-6 col-xs-12">
                                    
                                        
                                        <ul class="adv-plus-minus">
                                            
                                            <?foreach($arItem["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["~VALUE"] as $val):?>
                                                <li><?=$val?></li>
                                            <?endforeach;?>

                                        </ul>
                                        
                                    </div>
                                
                                <?endif;?>
                                
                            </div>
                        </div>
                    
                    <?endif;?>
                    
                    <?if(!empty($arItem["PROPERTIES"]["TARIFF_PRICES"]["VALUE"])):?>

                        <div class="list-wrap last">
                        
                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_PRICES_TITLE"]["VALUE"]) > 0):?>
                                <div class="name main1"><?=$arItem["PROPERTIES"]["TARIFF_PRICES_TITLE"]["~VALUE"]?></div>
                            <?endif;?>


                            <ul class="list-char">
                                
                                <?foreach($arItem["PROPERTIES"]["TARIFF_PRICES"]["~VALUE"] as $k=>$val):?>
                                    <li class="clearfix">
                                    
                                        <table>
                                            <tr>
                                                <td class="left">
                                                    <div class="left"><?=$val?></div>
                                                </td>
                                                
                                                <td class="dotted">
                                                    <div class="dotted"></div>
                                                </td>
                                                
                                                <td class="right">
                                                    <div class="main1 right"><?=$arItem["PROPERTIES"]["TARIFF_PRICES"]["~DESCRIPTION"][$k]?></div>
                                                </td>
                                            </tr>
                                        </table>
                                    
                                    </li>
                                <?endforeach;?>

                            </ul>
                        </div>
                    
                    <?endif;?>
                    
                    <?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                        <?$arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                    <?endif;?>
                    

                   
                    <?if(
                        strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0
                        || !empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])
                        || !empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>

                        <div class="buttons-wrap no-margin-left-right">
                        
                            <?if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?>

                                <?if(
                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "modal"
                                    || $arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "form"
                                    || $arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "quiz"
                                    || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "block" && strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"])>0)
                                    || ($arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] == "blank" && strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"])>0)):?>

                                    <div class="button-child">

                                        <a
                                            <?

                                                if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"])>0)
                                                {
                                                    $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"]);echo "onclick='".$str_onclick."'";
                                                    $str_onclick = "";
                                                }

                                                $b_options = array(
                                                    "MAIN_COLOR" => "primary",
                                                    "STYLE" => ""
                                                );

                                                if(strlen($arItem["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"]))
                                                {

                                                    $b_options = array(
                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                        "STYLE" => "background-color: ".$arItem["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"].";"
                                                    );

                                                }

                                            ?>

                                            class="
                                                button-def
                                                more-modal-info
                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                <?=$b_options["MAIN_COLOR"]?> 
                                                big
                                                <?=hamButtonEditClass (
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
                                                    $arItem["PROPERTIES"]["TARIFF_MODAL"]["VALUE"])?>

                                                <?if($count <= 3):?>
                                                    big
                                                <?else:?>
                                                    medium
                                                <?endif;?>"

                                                <?if(strlen($b_options["STYLE"])):?>
                                                    style = "<?=$b_options["STYLE"]?>"
                                                <?endif;?>

                                                data-element-type = "TRF"
                                                <?=hamButtonEditAttr(
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
                                                    $arItem["PROPERTIES"]["TARIFF_MODAL"]["VALUE"],
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"],
                                                    $arItem["PROPERTIES"]["TARIFF_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                    $block_name, $arItem["PROPERTIES"]["TARIFF_BUTTON_QUIZ"]["VALUE"],
                                                    $arItem["ID"])?>>

                                                
                                            <?=$arItem["PROPERTIES"]["TARIFF_BUTTON_NAME"]["~VALUE"]?>
                                                
                                        </a>
                                    </div>

                                <?endif;?>

                            <?endif;?>


                            <?if(!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]) || !empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>

                                <?
                                    $sec_btn_name = GetMessage("PAGE_GEN_TARIFF_MORE_DETAIL");
                                    if(strlen($arSection['~UF_MORE_NAME_TRFF'])>0)
                                        $sec_btn_name = $arSection['~UF_MORE_NAME_TRFF'];
                                ?>

                                <div class="button-child">
                                    <a class="button-def secondary big btn-modal-open <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" data-header="<?=$block_name?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="tariff"  data-element-id="<?=$arItem["ID"]?>">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                        <?=$sec_btn_name?>
                                    </a>
                                </div>
                            
                            <?endif;?>
                            
                        </div>
                    
                    <?endif;?>
                    
                </div>

            </div>

            <?if($arItem["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"] > 0):?>
            
                <div 
                    class="tarif-cell
                            image-part
                            hidden-sm
                            hidden-xs
                            col-md-5 col-sm-0 col-xs-12
                            <?if($arItem["PROPERTIES"]["TARIFF_PICTURE_POSITION"]["VALUE_XML_ID"] == "left"):?>
                                col-md-pull-7 col-xs-pull-0
                            <?endif;?>">
                    
                    <?if(!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])
                        || !empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>

                        <a 
                            class="btn-modal-open"
                            data-header="<?=$block_name?>"
                            data-site-id='<?=SITE_ID?>'
                            data-detail="tariff"
                            data-element-id="<?=$arItem["ID"]?>"
                            data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>">
                            
                    <?endif;?>
                
                    <img class="img-responsive center-block lazyload" data-src="<?=$img["src"]?>" alt="<?=$arItem["PROPERTIES"]["TARIFF_PICTURE"]["DESCRIPTION"]?>"/>
                    
                    <?if((!empty($arItem["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"])) || (!empty($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]) && is_array($arItem["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))):?>
                        </a>
                    <?endif;?>

                    <div class="name-wrap">
                        <div class="image-descrip italic">
                            <?=$arItem["PROPERTIES"]["TARIFF_PICTURE"]["~DESCRIPTION"]?>
                        </div>
                    </div>
                    
                </div>
            
            <?endif;?>
            
        </div>

    </div>

<?endif;?>