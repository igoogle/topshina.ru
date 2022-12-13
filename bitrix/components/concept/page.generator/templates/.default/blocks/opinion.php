<?if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "slider"):?>

    <div class="opinion">

        <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
        <?$count_opin = count($arItem["ELEMENTS"])?>

        <?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>

            <div class="slider opinion-slider parent-slider-item-js" data-count = "<?=$count_opin;?>">
                <div class="slider-nav-wrap">

                    <?if($count_opin > 3 || $count_opin == 1):?>
                        <div class="slider-icon-center primary"><span></span></div>
                    <?endif;?>

                    <div class="slider-nav <?=$arItem["ELEMENTS"][0]["PROPERTIES"]["OPINION_ROUND_OFF"]["VALUE_XML_ID"]?>">
            
                        <?foreach($arItem["ELEMENTS"] as $k=>$arOpinion):?>

                            <div class="for-count <?if($k!=0) echo 'noactive-slide-lazyload';?>">
                                <div class="slider-image">
                                    <div class="image-child">

                                        <?admin_setting($arOpinion)?>
                                    
                                        <?if($arOpinion["PROPERTIES"]["OPINION_IMAGE"]["VALUE"] > 0):?>
                                            <?$img_big = CFile::ResizeImageGet($arOpinion["PROPERTIES"]["OPINION_IMAGE"]["VALUE"], array('width'=>234, 'height'=>234), BX_RESIZE_IMAGE_EXACT , false, false, false, $img_quality);?>
                                            <img class="img-responsive center-block lazyload" data-src="<?=$img_big["src"]?>" alt="<?=$arOpinion["PROPERTIES"]["OPINION_IMAGE"]["DESCRIPTION"]?>"/>
                                        <?else:?>
                                            <img class="img-responsive center-block lazyload" data-src="<?=SITE_TEMPLATE_PATH?>/images/quote.png" alt=""/>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>

                        <?endforeach;?>
                    </div>
                        
                </div>
                

                <div class="slider-for">
                    <?foreach($arItem["ELEMENTS"] as $k=>$arOpinion):?>
                        <div class="<?if($k!=0) echo 'noactive-slide-lazyload';?>">

                            <?if(!empty($arOpinion["PROPERTIES"]["OPINION_TEXT"]["VALUE"])):?>

                                <div class="text italic no-margin-top-bot">
                                    <?=$arOpinion["PROPERTIES"]["OPINION_TEXT"]["~VALUE"]["TEXT"]?>
                                </div>

                            <?endif;?>

                            <?if(strlen($arOpinion["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arOpinion["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                                <div class="descrip-wrap">

                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>
                                        <div class="name main1">
                                            <?=$arOpinion["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                                        </div>
                                    <?endif;?>

                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                                        <div class="proof">
                                            <?=$arOpinion["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                                        </div>
                                    <?endif;?>

                                </div>

                            <?endif;?>

                            <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0 || strlen($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                <div class="more-info-wrap">

                                    <div class="more-info no-margin-left-right no-margin-top-bot">
                                        
                                        <?if(strlen($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                                            <div class="link-wrap no-margin-top-bot">

                                                <?
                                                    $arFile = CFile::MakeFileArray($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"]);
                                                    $is_image = CFile::IsImage($arFile["name"], $arFile["type"]);
                                                ?>

                                                <a href="<?=CFile::GetPath($arOpinion["PROPERTIES"]["OPINION_FILE"]["VALUE"])?>" <?if(!$is_image):?> target="_blank" <?else:?> data-gallery="s<?=$arOpinion['ID']?>" <?endif;?>class="link-blank">
                                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_FILE_TEXT"]["VALUE"]) > 0):?>
                                                        <span><?=$arOpinion["PROPERTIES"]["OPINION_FILE_TEXT"]["~VALUE"]?></span>
                                                    <?endif;?>
                                                </a>

                                            </div>

                                        <?endif;?>

                                        <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0):?>

                                            <div class="link-wrap no-margin-top-bot">

                                                <?$iframe = ChamDB::createVideo($arOpinion['PROPERTIES']['OPINION_VIDEO']['VALUE']);?>  

                                                <a class="link-video call-modal callvideo" data-call-modal="<?=$iframe["ID"]?>">
                                                    <?if(strlen($arOpinion["PROPERTIES"]["OPINION_VIDEO_TEXT"]["VALUE"]) > 0):?>

                                                        <span><?=$arOpinion["PROPERTIES"]["OPINION_VIDEO_TEXT"]["~VALUE"]?></span>

                                                    <?endif;?>
                                                </a>
                                            </div>
                                     
                                        <?endif;?>

                                    </div>
                                </div>

                            <?endif;?>


                        </div>
                    <?endforeach;?>
                </div>
        
            </div>
            
           

        <?endif;?>

        <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
    </div>
                    
<?endif;?>


<?if($arItem["PROPERTIES"]["OPINION_VIEW"]["VALUE_XML_ID"] == "block"):?>

    <div class="opinion">

        <div class="opinion-table">

            <div class="opinion-cell text-part no-margin-top-bot col-md-7 col-sm-8 col-xs-12 <?if($arItem["PROPERTIES"]["OPINION_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?> col-md-push-5 col-sm-push-4 col-xs-push-0<?endif;?>">
                <?if($arItem["TITLE_CHANGE"]):?>
                    <?CreateHead($arItem, true, $main_key)?>
                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["OPINION_TEXT"]["VALUE"]['TEXT']) > 0):?>
                    <div class="text no-margin-top-bot italic">
                        <?=$arItem["PROPERTIES"]["OPINION_TEXT"]["~VALUE"]['TEXT']?>
                    </div>
                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                    <div class="name-wrap no-margin-top-bot visible-xs">

                        <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>

                            <div class="name main1">
                                <?=$arItem["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                            </div>

                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                            <div class="prof">
                                <?=$arItem["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                            </div>
                        <?endif;?>
                    </div>

                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                    <div class="more-info no-margin-top-bot">

                        <?if(strlen($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]) > 0):?>

                            <?$arFile = CFile::MakeFileArray($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"]);?>
                            <?$is_image = CFile::IsImage($arFile["name"], $arFile["type"]);?>

                            <div class="link-wrap no-margin-top-bot">

                                <a href="<?=CFile::GetPath($arItem["PROPERTIES"]["OPINION_FILE"]["VALUE"])?>" <?if(!$is_image):?> target="_blank" <?else:?> data-gallery="s<?=$arItem['ID']?>" <?endif;?>class="link-blank">

                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_FILE_TEXT"]["VALUE"]) > 0):?>

                                        <span><?=$arItem["PROPERTIES"]["OPINION_FILE_TEXT"]["~VALUE"]?></span>

                                    <?endif;?>

                                </a>
                            </div>

                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO"]["VALUE"]) > 0):?>

                            <div class="link-wrap no-margin-top-bot">
                                
                             <?$iframe = ChamDB::createVideo($arItem['PROPERTIES']['OPINION_VIDEO']['VALUE']);?>  

                                    <a class="link-video call-modal callvideo" data-call-modal="<?=$iframe["ID"]?>">


                                    <?if(strlen($arItem["PROPERTIES"]["OPINION_VIDEO_TEXT"]["VALUE"]) > 0):?>

                                        <span><?=$arItem["PROPERTIES"]["OPINION_VIDEO_TEXT"]["~VALUE"]?></span>

                                    <?endif;?>
                                </a>
                            </div>
                     
                        <?endif;?>

                        <?if($arItem["BUTTON_CHANGE"]):?>
                            <?=CreateButton($arItem, false)?>
                        <?endif;?>
                    </div>

                <?endif;?>
            </div>

            
            <div class="opinion-cell z-image image-part hidden-xs col-md-5 col-sm-4 col-xs-12 <?if($arItem["PROPERTIES"]["OPINION_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-pull-7 col-sm-pull-8 col-xs-pull-0<?endif;?>">                                 

                <?if($arItem["PROPERTIES"]["OPINION_IMAGE"]["VALUE"] > 0):?>
                    <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["OPINION_IMAGE"]["VALUE"], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                    <img class="img-responsive center-block lazyload" data-src="<?=$img_big["src"]?>" alt="<?=$arItem["PROPERTIES"]["OPINION_IMAGE"]["DESCRIPTION"]?>"/>
                <?else:?>
                    <img class="img-responsive center-block lazyload" data-src="<?=SITE_TEMPLATE_PATH?>/images/quote.png" alt=""/>
                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>

                    <div class="name-wrap no-margin-top-bot">
                        <?if(strlen($arItem["PROPERTIES"]["OPINION_NAME"]["VALUE"]) > 0):?>
                            <div class="name main1">
                                 <?=$arItem["PROPERTIES"]["OPINION_NAME"]["~VALUE"]?>
                            </div>

                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["OPINION_PROF"]["VALUE"]) > 0):?>
                            <div class="prof">
                                <?=$arItem["PROPERTIES"]["OPINION_PROF"]["~VALUE"]?>
                            </div>
                        <?endif;?>
                    </div>

                <?endif;?>
                
            </div>

        </div>
    </div>

<?endif;?>