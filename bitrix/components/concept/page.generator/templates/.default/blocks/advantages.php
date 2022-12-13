<?if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == '') $arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] = 'big';
    if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == '') $arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] = 'images';
?>


<?if($arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == "flat" || $arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == ""):?>
    <?$count = $arItem["PIC_MAX"];?>


    <div class="advantages clearfix <?=$arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?><?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?> image-on<?endif;?>">

        <div class="advantages-table clearfix">

            <div class="advantages-cell clearfix text-part z-text <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"] > 0):?>col-md-7 col-xs-12 <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-push-5 col-xs-push-0 right<?endif;?><?else:?>col-xs-12<?endif;?>" style="<?=$style2?>">
            
                <div class="<?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"] > 0):?><?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">

                    <?if($arItem["TITLE_CHANGE"]):?>
                        <?CreateHead($arItem, true, $main_key)?>
                        <div class="clearfix"></div>
                    <?endif;?>

                    <div class="part-wrap row clearfix <?if($arItem["TITLE_CHANGE"]):?>min<?endif;?>">

                        <?if(strlen($count)>0):?>

                            <?  
                                $rest1 = 5 % 3;
                                $rest2 = 7 % 3;
                                $rowRest = -1;

                                $class = "col-md-4 col-sm-6 col-xs-12";
                                $class2 = "";
                                

                                if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small")
                                {
                                    if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0)
                                        $class = "col-sm-6 col-xs-12";
                                }

                                else
                                {
                                    if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0)
                                        $class = "col-sm-6 col-xs-12";

                                    else
                                    {
                                        if($count % 4 == 0)
                                            $class = "col-md-3 col-sm-6 col-xs-12 four-cols";

                                        elseif($count % 3 == $rest1)
                                        {
                                            $class2 = "col-md-offset-2 col-xs-offset-0";
                                            $rowRest = $count-2;
                                        }
                                            
                                        elseif($count % 3 == $rest2)
                                        {
                                            $class2 = "col-md-offset-4 col-xs-offset-0";
                                            $rowRest = $count-1;
                                        }

                                    }                                                          

                                }
                            ?>

                            <?for($i = 0; $i < $count; $i++):?>

                                <div class="<?=$class?><?if($i == $rowRest):?> <?=$class2?><?endif;?>">

                                    <div class="element <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?> <?=$arItem["PROPERTIES"]["ADVANTAGES_TEXT_COLOR"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"]?>">
                                        

                                        <?if($arItem["PIC_COUNT"] > 0 || $arItem["IC_COUNT"]):?>
                                    
                                            <div class="image-table">
                                                <div class="image-cell">

                                                    <?if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "images" || $arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == ""):?>
                                                
                                                        <?if($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i] > 0):?>


                                                            <?if($arItem["TITLE_CHANGE"]):?>

                                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>720, 'height'=>256), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

                                                            <?else:?>

                                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>720, 'height'=>470), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>

                                                            <?endif;?>


                                                            <img class="img-responsive lazyload" data-src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["DESCRIPTION"][$i]?>"/>


                                                        <?endif;?>

                                                    <?elseif($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "icons"):?>

                                                        <i class="style-ic <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"][$i]?>" style="color: <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["~DESCRIPTION"][$i]?>"></i>

                                                    <?endif;?>
                                                    
                                                </div>
                                            </div>
                                        
                                        <?endif;?>


                                        
                                        <?if($arItem["PIC_DESC_COUNT"] > 0 || $arItem["PIC_NAME_COUNT"] > 0):?>
                                        
                                            <div class="text-wrap no-margin-top-bot  <?if($arItem["PIC_COUNT"] > 0):?>icons-on<?endif;?>">

                                                <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0 || $arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small"):?>



                                                    <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]) > 0):?>

                                                        <div class="name main1">
                                                            <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?>
                                                        </div>

                                                    <?endif;?>


                                                <?else:?>


                                                    <?if(strlen($arItem["PIC_NAME_COUNT"]) > 0):?>

                                                        <div class="name main1">
                                                            <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?>
                                                        </div>

                                                    <?endif;?>


                                                <?endif;?>



                                                <?if(strlen($arItem["PIC_DESC_COUNT"]) > 0):?>
                                                
                                                    <div class="text">
                                                        <?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i]?>
                                                    </div>

                                                <?endif;?>

                                            </div>
                                        
                                        <?endif;?>

                                    </div>

                                </div>

                                <?if($arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"] == "small"):?>

                                    <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>
                                        <?if(($i+1) % 2 == 0):?>
                                            <span class="clearfix"></span>
                                        <?endif;?>
                                        
                                    <?else:?>
                                        <?if(($i+1) % 2 == 0):?>
                                            <span class="clearfix visible-sm"></span>
                                        <?endif;?>
                                        <?if(($i+1) % 3 == 0):?>
                                            <span class="clearfix hidden-sm"></span>
                                        <?endif;?>

                                    <?endif;?>

                                <?else:?>

                                    <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>

                                        <?if(($i+1) % 2 == 0):?>
                                            <span class="clearfix"></span>
                                        <?endif;?>

                                    <?else:?>
                                        <?if($count % 4 == 0):?>

                                            <?if(($i+1) % 4 == 0):?>
                                                <span class="clearfix hidden-sm"></span>
                                            <?endif;?>

                                        <?else:?>
                                            <?if(($i+1) % 3 == 0):?>
                                                <span class="clearfix hidden-sm"></span>
                                            <?endif;?>

                                        <?endif;?>

                                        

                                        <?if(($i+1) % 2 == 0):?>
                                            <span class="clearfix visible-sm"></span>
                                        <?endif;?>

                                    <?endif;?>  

                                <?endif;?>
                            
                            <?endfor;?>

                        <?endif;?>

                    </div>

                    <?if($arItem["BUTTON_CHANGE"]):?>
                        <?=CreateButton($arItem, false)?>
                    <?endif;?>
                </div>

            </div>

            <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"]) > 0):?>
            
                <div class="advantages-cell image-part hidden-sm hidden-xs col-md-5 col-sm-0 col-xs-12 <?if($arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["ADVANTAGES_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-pull-7 col-xs-pull-0<?endif;?> <?=$arItem["PROPERTIES"]["ADVANTAGES_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                
                    <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                
                    <img class="img-responsive center-block lazyload" data-src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["ADVANTAGES_IMAGE"]["DESCRIPTION"]?>"/>
                
                </div>
                
            <?endif;?>

        </div>

    </div><!-- ^advantages -->

<?elseif($arItem["PROPERTIES"]["ADVANTAGES_VIEW"]["VALUE_XML_ID"] == "slider"):?>

    <div>
        <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">

        <div class="slider-advantages 
            <?=$arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"]?>
            <?=$arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"]?>-slide
            advantages-<?=$arItem["PROPERTIES"]["ADVANTAGES_VIEW_SIZE"]["VALUE_XML_ID"]?>-slide
            clearfix
            <?=$arItem["PROPERTIES"]["ADVANTAGES_TEXT_COLOR"]["VALUE_XML_ID"]?>
            parent-slider-item-js">

            <?for($i = 0; $i < $arItem["PIC_MAX"]; $i++):?>

                <div class="col-xs-12 <?if($i!=0) echo 'noactive-slide-lazyload';?>">
                    <div class="div-table">
                           

                       <?if($arItem["PIC_COUNT"] > 0 || $arItem["IC_COUNT"]):?>
                            <div class="div-cell left">
                                <table>
                                    <tr>
                                        <td>
                                            <?if($arItem["PROPERTIES"]["ADVANTAGES_TYPE_PICTURE"]["VALUE_XML_ID"] == "icons"):?>

                                                 <i class="style-ic <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["VALUE"][$i]?>" style="color: <?=$arItem["PROPERTIES"]["ADVANTAGES_ICONS"]["~DESCRIPTION"][$i]?>"></i>
                                            
                                            <?else:?>
                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["VALUE"][$i], array('width'=>1200, 'height'=>960), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                <img class="img-responsive center-block lazyload" data-src="<?=$file['src']?>" alt="<?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES"]["DESCRIPTION"][$i]?>">

                                            <?endif;?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <?endif;?>

                        <div class="div-cell right">

                            <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i])>0):?>
                                <div class="title bold"><?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~DESCRIPTION"][$i]?></div>
                            <?endif;?>

                            <?if(strlen($arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i])>0):?>
                                <div class="desc"><?=$arItem["PROPERTIES"]["ADVANTAGES_PICTURES_DESC"]["~VALUE"][$i]?></div>
                            <?endif;?>

                        </div>

                    </div>

                </div>

            <?endfor;?>

        </div>
        
        <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
    </div>

<?endif;?>