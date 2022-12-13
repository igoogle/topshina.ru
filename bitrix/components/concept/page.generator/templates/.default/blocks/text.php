<?if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "")
        $arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] = "left";

    $class1="col-xs-12";
    $class2="";

    $offset1="";
    $offset2="";

    if($arItem["TITLE_CHANGE"])
    {
        $class1="col-md-7 col-sm-8 col-xs-12";
        $class2="col-md-5 col-sm-4 col-xs-12";

        $imgHiddenXs = ($arItem["PROPERTIES"]["TEXT_BLOCK_HIDE_MOB_PICTURE"]["VALUE_XML_ID"] == "Y")?"hidden-sm hidden-xs":"";

        if(isset($imgHiddenXs{0}))
        {
            $class1="col-md-7 col-sm-12 col-xs-12";
            $class2="col-md-5 col-sm-0 col-xs-12";
        }


        if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "right")
        {
            $offset1="col-md-pull-5 col-sm-pull-4 col-xs-pull-0 right";
            $offset2="col-md-push-7 col-sm-push-8 col-xs-push-0";

            if(isset($imgHiddenXs{0}))
            {
                $offset1="col-md-pull-5 col-sm-pull-0 col-xs-pull-0 right";
                $offset2="col-md-push-7 col-sm-push-0 col-xs-push-0";
            }
        }
    }

    $count_gallery = 0;
    if(!empty($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"]))
        $count_gallery = count($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"]);
?>

<div class="descriptive">

    <div class="descriptive-table">

        <?if($arItem["TITLE_CHANGE"]):?>
        
            <div class="descriptive-cell image-part z-image <?=$class2?> <?=$offset2?> <?=$arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["TEXT_BLOCK_HIDE_MOB_PICTURE"]["VALUE_XML_ID"] == "Y"):?> hidden-sm hidden-xs<?endif;?>">
            
                <?
                    $file = CFile::ResizeImageGet($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                    $animate = '';
                    $animate_set = '';

                    if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y")
                    {
                        if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "middle")
                            $animate = 'wow zoomIn';

                        if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "bottom")
                            $animate = 'wow slideInUp';

                        if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_POSITION"]["VALUE_XML_ID"] == "top")
                            $animate = 'wow zoomIn';

                        $animate_set = 'data-wow-offset="250" data-wow-duration="1s" data-wow-delay="0.5s"';
                    }
                ?>

                <img class="img-responsive center-block <?=$animate;?> lazyload" data-src="<?=$file["src"]?>" <?=$animate_set?> alt="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE"]["DESCRIPTION"]?>"/>
            
            </div>
            
        <?endif;?>

    
        <div class="descriptive-cell <?=$class1?> text-part z-text <?=$offset1?>" style="<?=$style2?>">
        
            <div class="<?if($arItem["TITLE_CHANGE"]):?><?if($arItem["PROPERTIES"]["TEXT_BLOCK_PICTURE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">

                <?if($arItem["TITLE_CHANGE"]):?>
                    <?CreateHead($arItem, true, $main_key)?>
                <?endif;?>
                
                
                <?if(!$arItem["TITLE_CHANGE"] && $count_gallery > 0):?>

                    <div class="descriptive-tabs-wrap">
                    
                        <div class="images-wrap">
                            
                            <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                            
                                <div class="image-content <?if($k == 0):?>active<?endif;?>">
                                    
                                    <?if($count_gallery > 1):?>
                                        <div class="mob-tab visible-xs <?if($k == 0):?>active<?endif;?>">
                                            <?if(strlen($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]) > 0):?>
                                                <?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>
                                            <?else:?>
                                                <?=$k+1?>
                                            <?endif;?>
                                            <div class="primary"></div>
                                        </div>
                                    <?endif;?>

                                    <div class="mob-content <?if($k == 0):?>active<?endif;?>">
                                    
                                        <?$file = CFile::ResizeImageGet($photo, array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                        <img class="img-responsive center-block lazyload" data-src="<?=$file["src"]?>"  alt="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>"/>

                                    </div>
                                </div>
                                
                            <?endforeach;?>

                        </div>

                        <?if($count_gallery > 1):?>
                        
                            <ul class="tabs hidden-xs">
                                
                                <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                                    <li class="<?if($k == 0):?>active<?endif;?> mainColor">
                                    
                                        <?if(strlen($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]) > 0):?>
                                            <?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>
                                        <?else:?>
                                            <?=$k+1?>
                                        <?endif;?>

                                    </li>
                                <?endforeach;?>

                            </ul>
                        
                        <?endif;?>
                        
                    </div>
                
                <?endif;?>
                

                <?if(isset($arItem["TEXT"])):?>
                    <div class="text-wrap text-content no-margin-top-bot <?=$arItem["PROPERTIES"]["TEXT_BLOCK_COLOR"]["VALUE_XML_ID"]?> <?if(!$arItem["TITLE_CHANGE"]):?>center<?endif;?>">
                        <?=$arItem["TEXT"]?>
                    </div>
                <?endif;?>
                
                <?if($arItem["TITLE_CHANGE"] && $count_gallery > 0):?>

                    <div class="gallery <?if($arItem["PROPERTIES"]["TEXT_BLOCK_BORDER"]["VALUE"]):?>border-img-on<?endif;?>">
                        <div class="row clearfix">
                        
                            <?foreach($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["VALUE"] as $k=>$photo):?>
                                
                                <?$file_small = CFile::ResizeImageGet($photo, array('width'=>200, 'height'=>140), BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality);?>
                                <?$file_big = CFile::ResizeImageGet($photo, array('width'=>1500, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                
                                <div class="col-xs-3">
                                
                                    <div class="img-wrap">
                                        <a title="<?=Chameleon::prepareText($arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k])?>" data-gallery="gal<?=$arItem['ID']?>" data-gallery="a<?=$arItem["ID"]?>" class="cursor-loop" href="<?=$file_big["src"]?>">
                                            <img class="img-responsive lazyload" data-src="<?=$file_small["src"]?>" alt="<?=$arItem["PROPERTIES"]["TEXT_BLOCK_GALLERY"]["DESCRIPTION"][$k]?>"/>
                                        </a>
                                    </div>
                                </div>
                                
                                <?if(($k+1)%4 == 0):?>
                                    <span class="clearfix"></span>
                                <?endif;?>
                            
                            <?endforeach;?>
                        
                        </div>
                    </div>
                
                <?endif;?>

                <?if($arItem["BUTTON_CHANGE"]):?>
                    <?=CreateButton($arItem, false)?>
                <?endif;?>
            
            </div>

        </div>
    </div>
</div>

<?unset($class1, $class2, $offset1, $offset2);?>