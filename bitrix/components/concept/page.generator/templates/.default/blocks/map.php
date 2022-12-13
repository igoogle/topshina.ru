    </div>
</div>


<div class="map-block <?if(!strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>no-map<?endif;?>">
    <?if(strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>
        <img class="lazyload img-for-lazyload map-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png">
    <?endif;?>

    <?if($arItem["PROPERTIES"]["MAP_VIEW"]["VALUE_XML_ID"] == "info-on-map" && strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>

        <div class="map-descript-wrap">

            <div class="container">
                <div class="row">

                    <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0 || !empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"]) || !empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"]) || strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]) > 0):?>

                        <div class="col-md-5 col-xs-12"> 

                            <table class="wrap-table">
                                <tr>
                                    <td>

                                        <div class="map-descript">

                                            <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0):?>

                                                <div class="name">
                                                    <?=$arItem["PROPERTIES"]["MAP_NAME"]["~VALUE"]?>
                                                </div>

                                            <?endif;?>


                                            <div class="text-table-wrap">

                                                <?if(strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["VALUE"]) > 0):?>

                                                    <div class="text-table">
                                                        <div class="text-cell icon icon-point"></div>

                                                        <div class="text-cell text">

                                                            <?=$arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]?>

                                                        </div>
                                                    </div>

                                                <?endif;?>

                                                <?if(!empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"])):?>

                                                    <div class="text-table">
                                                        <div class="text-cell icon icon-phone">
                                                        </div>


                                                        <div class="text-cell text phone bold">

                                                            <?foreach($arItem["PROPERTIES"]["MAP_PHONE"]["~VALUE"] as $k => $arPhone):?>  

                                                                <?$phone=preg_replace('/[^0-9+]/', '', $arPhone);?>

                                                                <?if($k != 0):?>
                                                                    <br>
                                                                <?endif;?>

                                                                <a href="tel:<?=$phone?>"><?=$arPhone?></a>

                                                            <?endforeach;?>

                                                        </div>
                                                    </div>

                                                <?endif;?>

                                                <?if(!empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"])):?>

                                                    <div class="text-table">
                                                        <div class="text-cell icon icon-mail">
                                                        </div>


                                                        <div class="text-cell text e-mail">
                                                            <?foreach($arItem["PROPERTIES"]["MAP_MAIL"]["~VALUE"] as $k => $arMail):?>   

                                                                <?if($k != 0):?>
                                                                    <br>
                                                                <?endif;?>

                                                                 <a href="mailto:<?=$arMail?>"><?=$arMail?></a>

                                                            <?endforeach;?>

                                                        </div>
                                                    </div>

                                                <?endif;?>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </table>                                                    
                        </div>

                        <span class="clearfix"></span>

                    <?endif;?>

                </div>
            </div>

        </div>

    <?else:?>

        <div class="bot-wrap">
            <div class="container">

                <?if( strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) || strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["VALUE"]) || !empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"]) || !empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"]) ):?>
            
                    <div class="text-table-wrap clearfix">
                        <?if(strlen($arItem["PROPERTIES"]["MAP_NAME"]["VALUE"]) > 0):?>
                            <div class="text-cell-wrap col-md-2 col-sm-6 col-xs-12">
                                <div class="name">
                                    <?=$arItem["PROPERTIES"]["MAP_NAME"]["~VALUE"]?>
                                </div>
                            </div>
                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["MAP_ADDRESS"]["VALUE"]) > 0):?>
                            <div class="text-cell-wrap col-md-4 col-sm-6 col-xs-12">
                                <div class="text-table">
                                    <div class="text-cell icon icon-point">
                                    </div>


                                    <div class="text-cell text">
                                        <?=$arItem["PROPERTIES"]["MAP_ADDRESS"]["~VALUE"]?>
                                    </div>

                                </div>
                            </div>
                        <?endif;?>

                        <span class="clearfix visible-sm"></span>

                        <?if(!empty($arItem["PROPERTIES"]["MAP_PHONE"]["VALUE"])):?>
                            <div class="text-cell-wrap col-md-3 col-sm-6 col-xs-12">

                                <div class="text-table">

                                    <div class="text-cell icon icon-phone"></div>


                                    <div class="text-cell text phone bold">

                                        <?foreach($arItem["PROPERTIES"]["MAP_PHONE"]["~VALUE"] as $k => $arPhone):?>  

                                            <?$phone=preg_replace('/[^0-9+]/', '', $arPhone);?>

                                            <?if($k != 0):?>
                                                <br>
                                            <?endif;?>

                                            <a href="tel:<?=$phone?>"><?=$arPhone?></a>

                                        <?endforeach;?>

                                    </div>
                                </div>
                            </div>
                        <?endif;?>

                        <?if(!empty($arItem["PROPERTIES"]["MAP_MAIL"]["VALUE"])):?>
                            <div class="text-cell-wrap col-md-3 col-sm-6 col-xs-12">
                                <div class="text-table">
                                    <div class="text-cell icon icon-mail">
                                    </div>


                                    <div class="text-cell text e-mail">
                                       <?foreach($arItem["PROPERTIES"]["MAP_MAIL"]["~VALUE"] as $k => $arMail):?>   

                                            <?if($k != 0):?>
                                                <br>
                                            <?endif;?>
                                            <a href="mailto:<?=$arMail?>"><?=$arMail?></a>

                                        <?endforeach;?>
                                    </div>
                                </div>
                            </div>

                        <?endif;?>
                    </div>

                <?endif;?>

            </div>
               
        </div>

    <?endif;?>


    <div class="container">

        <div class="main-button-wrap center">
    
            <a class="map-show button-def secondary "><?=GetMessage("PAGE_GEN_MAP_SHOW")?></a>    
              
        </div>

    </div>
    
    <?if(strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]) > 0):?>

        <div class="map-height">

            <?if (preg_match("<script>", $arItem["PROPERTIES"]["MAP"]["VALUE"])):?>
               
               <?$map = str_replace("<script ", "<script data-skip-moving='true' ", $arItem["PROPERTIES"]["MAP"]["~VALUE"]);?>
               <?$map = str_replace("scroll=true", "scroll=false", $map);?>

               <div class="iframe-map-area" data-src="<?=htmlspecialcharsbx($map)?>"></div>
               
           <?elseif(preg_match("<iframe>", $arItem["PROPERTIES"]["MAP"]["VALUE"])):?>

                <div class="iframe-map-area" data-src="<?=htmlspecialcharsbx($arItem["PROPERTIES"]["MAP"]["~VALUE"])?>"></div>
                <div class="overlay" onclick="style.pointerEvents='none'"></div>
                                      
           <?endif;?>

       </div>

    <?endif;?>
              
    
</div>

<div class="container">
    <div class="row">