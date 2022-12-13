<?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
    <?if($arItem["PROPERTIES"]["NEWS_VIEW"]["VALUE_XML_ID"] == "chrono"):?>

            </div>
        </div>
            <?if(strlen($arItem["PROPERTIES"]["NEWS_PICTURE"]["VALUE"]) > 0):?>
                <div class="container">
                    <div class="row">
                    
                        <div class="col-xs-12 news-image">
                            <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["NEWS_PICTURE"]["VALUE"], array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                            <img class="img-responsive center-block lazyload" data-src="<?=$img_big["src"]?>" alt="<?=$arItem["PROPERTIES"]["NEWS_PICTURE"]["DESCRIPTION"]?>">
                            
                        </div>
                        
                    </div>
                </div>
            <?endif;?>

            <div class="news <?if($arItem["SHOW_SUBNAME"] == 0):?>no-date<?endif;?>">
                <div class="bg_line">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="slider slider-news mainColor">
                            <?foreach($arItem["ELEMENTS"] as $k=>$arNews):?>

                                <div class="col-xs-12">
                                    <div class="element">

                                        <?if($arItem["SHOW_SUBNAME"] > 0):?>
                                            <div class="date">
                                               <?=$arNews["PROPERTIES"]["DATE"]["~VALUE"]?>
                                            </div>
                                        <?endif;?>


                                        <div class="point"></div>


                                        <div class="name main1">
                                            <?=$arNews["~NAME"]?>
                                        </div>

                                        <?if(strlen($arNews["PROPERTIES"]["NEWS_DETAIL_TEXT"]["VALUE"]['TEXT']) > 0):?>
                                            <div class="text">

                                                <?=$arNews["PROPERTIES"]["NEWS_DETAIL_TEXT"]["~VALUE"]['TEXT']?>
                                            </div>
                                        <?endif;?>

                                        <?if(strlen($arNews["~PREVIEW_TEXT"])>0 || !empty($arNews["PROPERTIES"]["NEWS_GALLERY"]["VALUE"])):?>
                                            <div class="btn-detail-wrap no-margin-top-bot">
                                                <a class=" link-def btn-modal-open" data-all-id = "<?=implode("," , $arItem["ID_ALL"])?>" data-site-id='<?=SITE_ID?>' data-detail="news"  data-element-id="<?=$arNews["ID"]?>">
                                                <i class="fa fa-info" aria-hidden="true"></i><span class="bord"><?=GetMessage("PAGE_GEN_NEWS_DETAIL")?></span></a>

                                            </div>
                                        <?endif;?>

                                        <?admin_setting($arNews)?>
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
<?endif;?>