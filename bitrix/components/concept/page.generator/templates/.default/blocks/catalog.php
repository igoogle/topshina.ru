<?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
        </div>
    </div>
    <?
        $two_cols = false;

        if($arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] == "")
            $arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] = "6";
            
        
        if($arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"] == "6")
            $two_cols = true;
    ?>

    <div class="catalog-block tab-control <?if(!isset($_COOKIE['__ham_box_'.$arSection["ID"]]) && $arSection["UF_CH_BOX_FCLICK_OPN"]):?>first-click-box-on first-click-box<?endif;?> <?if($two_cols):?>two-cols<?else:?>one-col<?endif;?>">
        <div class="container">
            <div class="row">
                <?
                    $count_sections = count($arItem["ELEMENTS"]);
                    $class = '';
                    $class2 = '';

                    if($count_sections > 1 && $count_sections < 5)
                    {
                        $class = 'col-md-3 col-xs-0';
                        
                        if($count_sections == 2)
                            $class2 = 'col-md-offset-3 col-sm-offset-0 col-xs-offset-0';

                        elseif($count_sections == 3)
                            $class2 = 'col-lg-offset-one col-md-offset-one';

                    }

                    elseif($count_sections > 4 && $count_sections < 6)
                        $class = 'col-lg-five col-md-five col-sm-five col-xs-five';
                    
                    elseif($count_sections > 5)
                        $class = 'col-md-2 col-xs-0';
                ?>

                <?if($count_sections > 1):?>
                    <div class="tabs-wrap  hidden-sm hidden-xs clearfix" >

                        <?foreach($arItem["ELEMENTS"] as $cell=>$arCatalog):?> 

                            <?if(($cell+1) > 6) continue;?>
                            
                            <div class="tabs-element tab-child <?=$class?> <?if($cell == 0):?> active <?=$class2?> <?endif;?> tab-menu" data-tab='id_<?=$arCatalog['ID']?>'>

                                <?if($arItem["SHOW_CATALOG_PICTURE"] > 0):?>

                                    <div class="image-parent hidden-sm hidden-xs">
                                        <div class="image-child">

                                            <?$img_big = CFile::ResizeImageGet($arCatalog["PICTURE"], array('width'=>400, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                            <img class="img-responsive center-block lazyload" data-src="<?=$img_big["src"]?>" alt="">
                                        
                                        </div>
                                    </div>

                                <?endif;?>

                                <div class="name" title='<?=$arCatalog["NAME"]?>'>
                                    <span><?=$arCatalog["NAME"]?><div class="primary"></div></span>
                                </div>
                            </div>

                        <?endforeach;?>

                    </div>
                <?endif;?>
            </div>
        </div>
            
        <?if($count_sections > 1):?>
            <div class="block-grey-line hidden-sm hidden-xs"></div>
        <?endif;?>

        <div class="catalog-content-wrap">
            <div class="container">

                <div class="tabb-content-wrap">

                    <?$cols = "catalog-element col-md-3 col-sm-4 col-xs-".$arItem["PROPERTIES"]["CATALOG_VIEW_XS"]["VALUE_XML_ID"];?>
              
                    <?foreach($arItem["ELEMENTS"] as $cell=>$arCatalog):?>

                        <?
                            $count = count($arCatalog["SECT_ELEMENTS"]);

                            $class = "";

                            if($count == 1)
                                $class = "col-lg-offset-four col-md-offset-four col-sm-offset-four";
                            
                            elseif($count == 2)
                                $class = "col-md-offset-3 col-xs-offset-0";
                            
                            elseif($count == 3)
                                $class = "col-lg-offset-one col-md-offset-one";
                            
                        ?>

                        <div class="catalog-content tabb-content show-hidden-parent parent-slide-show <?if($cell == 0):?> active<?endif;?> <?if($count_sections <= 1):?> no-tab<?endif;?> parent-box" data-tab='id_<?=$arCatalog['ID']?>'>
                        
                            <?if($count_sections > 1):?>
                                <div class="mob-title click-slide-show <?if($cell == 0):?> active<?endif;?>">
                                    <?=$arCatalog["NAME"]?>
                                    <div class="primary"></div>
                                    <span></span>
                                </div>
                            <?endif;?>

                            <div class="mob-show content-slide-show <?if($cell == 0):?> active<?endif;?>">
                                <div class="row clearfix">
                                
                                    <?
                                        $count_line = 8;

                                        if(strlen($arItem["PROPERTIES"]["CATALOG_COUNT"]["VALUE"]))
                                            $count_line = $arItem["PROPERTIES"]["CATALOG_COUNT"]["VALUE"];
                                       
                                    ?>

                                    <?foreach($arCatalog["SECT_ELEMENTS"] as $key=>$arElement):?>
                                       
                                        <div class="<?=$cols?><?if($key == 0):?> <?=$class?><?endif;?><?if( ($key+1) > $count_line):?> hidden<?endif;?><?/*if($key > 5):?>hidden-sm<?endif;*/?>">
                                            <!-- <a href="#" class="link-element-wrap"></a> -->

                                            <div class="element-wrap element-outer elem-hover">  

                                                <div class="element elem-hover-height-more">

                                                    <div class="element-inner elem-hover-height">

                                                        <?if(!$two_cols):?><div class="row clearfix"><?endif;?>
                                                    
                                                            <div class="image-wrap <?if(!$two_cols):?>col-sm-12 col-xs-5<?endif;?>">

                                                                <table>
                                                                    <tr>
                                                                        <td class="parent_anim_img_area">

                                                                        <?

                                                                            $more_on = false;

                                                                            if(!empty($arElement["PROPERTIES"]["CHARACTERISTICS"]["VALUE"]) && !$more_on)
                                                                                $more_on = true;

                                                                            if(!empty($arElement["PROPERTIES"]["OTHER_COMPLECT"]["VALUE"]) && !$more_on)
                                                                                $more_on = true;

                                                                            if(strlen($arElement["DETAIL_TEXT"]) > 0 && !$more_on)
                                                                                $more_on = true;

                                                                            if(strlen($arElement["PREVIEW_TEXT"]) > 0 && !$more_on)
                                                                                $more_on = true;
                                                                        ?>

                                                                        <?if($more_on):?>

                                                                            <a class="btn-modal-open" data-header = "<?=$block_name;?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"][$arCatalog["ID"]])?>" data-section-id="<?=$arSection["ID"]?>" data-site-id='<?=SITE_ID?>'  data-detail="catalog"  data-element-id="<?=$arElement['ID']?>" data-main-catalog-id="<?=$arItem["ID"]?>">

                                                                        <?endif;?>

                                                                        <?if($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0] > 0):?>

                                                                            <?if($arElement["PROPERTIES"]["RESIZE_IMAGES"]["VALUE_XML_ID"] == "scale"):?>
                                                                                <?$img_big = CFile::ResizeImageGet($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>240, 'height'=>240), BX_RESIZE_IMAGE_PROPORTIONAL, false, Array(), false, $img_quality);?>
                                                                            <?else:?>
                                                                                <?$img_big = CFile::ResizeImageGet($arElement["PROPERTIES"]["PICTURES"]["VALUE"][0], array('width'=>240, 'height'=>240), BX_RESIZE_IMAGE_EXACT, false, Array(), false, $img_quality);?>
                                                                            <?endif;?>

                                                                            <img class="img-responsive center-block animate_to_box lazyload" data-src="<?=$img_big["src"]?>" data-box-id-img="<?=$arElement["ID"]?>" alt="">

                                                                        <?else:?>
                                                                            <img class="img-responsive center-block animate_to_box lazyload" data-src="<?=SITE_TEMPLATE_PATH?>/images/catalog.png" data-box-id-img="<?=$arElement["ID"]?>" alt="">
                                                                        <?endif;?>

                                                                        <?if($more_on):?>
                                                                            </a>
                                                                        <?endif;?>

                                                                    </td>
                                                                    </tr>
                                                                </table>
                                                                

                                                                <?if(!empty($arElement["PROPERTIES"]["HNA"]["VALUE_XML_ID"])):?>

                                                                    <div class="icons-wrap">

                                                                        <?foreach($arElement["PROPERTIES"]["HNA"]["VALUE_XML_ID"] as $arHits):?>

                                                                            <?if($arHits == "action"):?>
                                                                                <div class="icon ic_act"></div>
                                                                            <?endif;?>

                                                                            <?if($arHits == "hit"):?>
                                                                                <div class="icon ic_pop"></div>
                                                                            <?endif;?>

                                                                            <?if($arHits == "new"):?>
                                                                                <div class="icon ic_new"></div>
                                                                            <?endif;?>

                                                                        <?endforeach;?>

                                                                    </div>

                                                                <?endif;?>

                                                            </div>

                                                            <div class="bot-part <?if(!$two_cols):?>col-sm-12 col-xs-7<?endif;?>">

                                                                <div class="name">
                                                                    <?=$arElement["~NAME"]?>
                                                                </div>

                                                                <?if(strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 || strlen($arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0):?>

                                                                    <div class="price-table">

                                                                        <?if(strlen($arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"])>0 && $arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] != "Y"):?>
                                                                            <div class="price-cell old-price main2">
                                                                                <?=$arElement["PROPERTIES"]["CUR_OLD_PRICE"]["VALUE"]?>
                                                                            </div>
                                                                        <?endif;?>

                                                                        <?if(strlen($arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"])>0 || $arElement["PROPERTIES"]["REQUEST_PRICE"]["VALUE"] == "Y"):?>
                                                                        
                                                                            <div class="price-cell price">
                                                                                <?=$arElement["PROPERTIES"]["CUR_PRICE"]["VALUE"]?>
                                                                            </div>
                                                                        <?endif;?>
                                                                      
                                                                    </div>

                                                                <?endif;?>

                                                            </div>

                                                        <?if(!$two_cols):?></div><?endif;?>

                                                    </div>

                                                    <?if($more_on || $arElement["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y" || ($arSection["UF_CH_BOX_ON"] && $arElement["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y") ):?>

                                                        <div class="btn-detail-wrap elem-hover-show">

                                                            <?if($arSection["UF_CH_BOX_ON"] && $arElement["PROPERTIES"]["BOX_ADD"]["VALUE"] == "Y"):?>

                                                                <?
                                                                    $btn_name = GetMessage("PAGE_GEN_CATALOG_ADD");

                                                                    if(strlen($arElement["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"]) > 0)
                                                                        $btn_name = $arElement["PROPERTIES"]["BOX_BUTTON_NAME"]["~VALUE"];

                                                                    else if(strlen($arSection["~UF_CH_BOX_BUTTONNAME"]) > 0)
                                                                        $btn_name = $arSection["~UF_CH_BOX_BUTTONNAME"];



                                                                    $btn_name2 = GetMessage("PAGE_GEN_CATALOG_ADDED");

                                                                    if(strlen($arElement["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"]) > 0)
                                                                        $btn_name2 = $arElement["PROPERTIES"]["BOX_BUTTON_NAME_ADDED"]["~VALUE"];

                                                                    else if(strlen($arSection["~UF_CH_BOX_BTNNAME_AD"]) > 0)
                                                                        $btn_name2 = $arSection["~UF_CH_BOX_BTNNAME_AD"];


                                                                ?>
                                                                <div class="def-wrap-btn">

                                                                    <div class="button-def primary <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> click_box" data-box-id="<?=$arElement["ID"]?>" data-box-step="<?=$arElement["PROPERTIES"]["BOX_PRICE_STEP"]["VALUE"]?>" data-box-action = "add">

                                                                        <span class="first">
                                                                           <span class="txt"><?=$btn_name?></span>
                                                                        </span>

                                                                        <span class="second">
                                                                            <span class="txt"><?=$btn_name2?></span>
                                                                        </span>
                                                                        
                                                                    </div>

                                                                </div>

                                                            <?endif;?>


                                                            <?if($arElement["PROPERTIES"]["SHOW_FORM"]["VALUE"] == "Y"):?>

                                                                <?
                                                                    $form_id = $Landing["UF_CHAM_CATALOG_FRM"];

                                                                    if($arItem["PROPERTIES"]["CATALOG_FORM"]["VALUE"])
                                                                        $form_id = $arItem["PROPERTIES"]["CATALOG_FORM"]["VALUE"];
                                                                    

                                                                    if($arElement["PROPERTIES"]["ORDER_FORM"]["VALUE"] > 0)
                                                                        $form_id = $arElement["PROPERTIES"]["ORDER_FORM"]["VALUE"];


                                                                    $btn_name = GetMessage("PAGE_GEN_CATALOG_BUTTON");

                                                                    if(strlen($arElement["PROPERTIES"]["BUTTON_NAME"]["~VALUE"]) > 0)
                                                                        $btn_name = $arElement["PROPERTIES"]["BUTTON_NAME"]["~VALUE"];

                                                                    else if(strlen($arItem["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"]) > 0)
                                                                        $btn_name = $arItem["PROPERTIES"]["CATALOG_BUTTON_NAME"]["~VALUE"];

                                                                    else if(strlen($arSection["~UF_CHAM_CATAL_BTN_N2"]) > 0)
                                                                        $btn_name = $arSection["~UF_CHAM_CATAL_BTN_N2"];

                                                                    
                                                                ?>

                                                                <?if(isset($btn_name) && intval($form_id)>0):?>

                                                                    <div class="def-wrap-btn">
                                                                
                                                                        <a class="button-def primary more-modal-info <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> <?if(strlen($form_id)>0):?>call-modal callform<?endif;?> catalog" data-element-type = "CTL" data-call-modal="form<?=$form_id?>" data-element-id="<?=$arElement["ID"]?>" data-header="<?=$block_name?>">
                                                                            <?=$btn_name?>
                                                                        </a>

                                                                    </div>

                                                                <?endif;?>

                                                            <?endif;?>


                                                            <?if($more_on):?>
                                                                <div class="def-wrap-btn">
                                                                    <a class=" link-def btn-modal-open" data-header = "<?=$block_name;?>" data-all-id = "<?=implode("," , $arItem["ID_ALL"][$arCatalog["ID"]])?>" data-site-id='<?=SITE_ID?>' data-section-id="<?=$arSection["ID"]?>"  data-detail="catalog" data-element-id="<?=$arElement['ID']?>" data-main-catalog-id="<?=$arItem["ID"]?>"><i class="fa fa-info" aria-hidden="true"></i> <span class="bord"><?if(strlen($arSection['~UF_MORE_NAME_CTLG'])>0) echo $arSection['~UF_MORE_NAME_CTLG']; else echo GetMessage("PAGE_GEN_CATALOG_MORE_DETAIL");?></span></a>
                                                                </div>
                                                            <?endif;?>
                                                        </div>

                                                   <?endif;?>

                                                <?admin_setting($arElement)?>
                                               </div>
                                            </div>
                                        </div>

                                        <?
                                            if(($key+1) % 3 == 0)
                                                echo "<span class='clearfix visible-sm'></span>";

                                            if(($key+1) % 2 == 0)
                                                echo "<span class='clearfix visible-xs'></span>";

                                            if(($key+1) % 4 == 0)
                                                echo "<span class='clearfix hidden-sm'></span>";
                                        ?>

                                    <?endforeach;?>

                                    <div class="clearfix"></div>

                                </div>

                                <?if($count > $count_line):?>

                                    <div class="show-btn-wrap show-hidden-wrap" >

                                        <a class="button-def secondary big show-hidden <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>"><?=GetMessage("PAGE_GEN_CATALOG_SHOW_ALL")?></a>
                                        
                                    </div>

                                <?endif;?>
                            </div>

                        </div>

                    <?endforeach;?>

                </div>
            </div>
        </div>
        
    </div>


    <div class="container">
        <div class="row">
<?endif;?>