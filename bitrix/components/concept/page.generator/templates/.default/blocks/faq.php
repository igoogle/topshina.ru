<?if(is_array($arItem["ELEMENTS"]) && !empty($arItem["ELEMENTS"])):?>
    <div class="faq-block col-xs-12 <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
        <div class="row">

            <div class="col-md-4 col-xs-12 hidden-xs">
                <div class="photo">

                    <?if($arItem["PROPERTIES"]["FAQ_PICTURE"]["VALUE"] > 0):?>
                        <?$img_big = CFile::ResizeImageGet($arItem["PROPERTIES"]["FAQ_PICTURE"]["VALUE"], array('width'=>700, 'height'=>1096), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                        <img class="img-responsive center-block hidden-sm lazyload" data-src="<?=$img_big["src"]?>" alt="<?=$arItem["PROPERTIES"]["FAQ_PICTURE"]["DESCRIPTION"]?>"/>
                    <?else:?>
                        <img class="img-responsive center-block hidden-sm lazyload" data-src="<?=SITE_TEMPLATE_PATH?>/images/faqq.png" alt="">
                    <?endif;?>

                    <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"]) > 0):?>
                        <div class="comm">
                            <?=GetMessage("PAGE_GEN_FAQ_DESC")?>
                        </div>
                    <?endif;?>
                   
                    <div class="bot">
                        <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"]) > 0):?>
                            <div class="wrap">
                                <div class="name">
                                    <?if(strlen($arItem["PROPERTIES"]["FAQ_NAME"]["VALUE"])):?>
                                        <span class="main1"><?=$arItem["PROPERTIES"]["FAQ_NAME"]["~VALUE"]?></span><br>
                                    <?endif;?>
                                    <?if(strlen($arItem["PROPERTIES"]["FAQ_PROF"]["VALUE"])):?>
                                        <span class="prof italic"><?=$arItem["PROPERTIES"]["FAQ_PROF"]["~VALUE"]?></span>
                                    <?endif;?>
                                </div>
                            </div>
                        <?endif;?>

                        <div class="hidden-sm">
                            <?if($arItem["BUTTON_CHANGE"]):?>
                                <?CreateButton($arItem);?>
                            <?endif;?>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xs-12">
                <div class="l_wrap">
                    <div class="faq">

                        <?foreach($arItem["ELEMENTS"] as $k=>$arFaq):?>
                            <div class="faq-element  <?if($k == 0):?> active <?endif;?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>">

                                <div class="question">
                                    <span><?=$arFaq["~NAME"]?></span>
                                </div>

                                <div class="text text-content italic">
                                    <?=$arFaq["~PREVIEW_TEXT"]?>
                                </div>

                                <?admin_setting($arFaq)?>
                            </div>
                        <?endforeach;?>

                        <div class="btn_wrap visible-sm visible-xs">
                            <?if($arItem["BUTTON_CHANGE"]):?>
                                <?CreateButton($arItem);?>
                            <?endif;?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?endif;?>