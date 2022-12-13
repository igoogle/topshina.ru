<?if(!empty($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"])):?>
    </div>
        </div>

        <div class="switcher">

            <?if($arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == "tabs-left" || $arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == ""):?>

                <div class="container">
                    <div class="row clearfix">
                        
                        <div class="col-md-4 col-xs-0 hidden-sm hidden-xs">
                            <ul class="switcher-tab left">

                            <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>  
                                

                                <li<?if($k == 0):?> class="active"<?endif;?>>
                                    <span><?=$arTabs;?></span>
                                </li>

                                <?endforeach;?>
                                
                            </ul>
                        </div>

                        <div class="col-md-8 col-xs-12">
                            <div class="switcher-content-wrap left">

                                <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>

                                    <div class="switcher-wrap <?if($k == 0):?>active<?endif;?>">

                                        <div class="switcher-title visible-sm visible-xs <?if($k == 0):?>active<?endif;?>"><?=$arTabs?><div class="primary"></div></div>   

                                        <div class="switcher-content text-content<?if($k == 0):?> active<?endif;?>">
                                            
                                            <?=str_replace(array("#MAP_START#","#VIDEO_START#"), array('<img class="lazyload img-for-lazyload map-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">','<img class="lazyload img-for-lazyload video-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">'), $arItem["PROPERTIES"]["SWITCHER_HTML"]["~VALUE"][$k]["TEXT"])?>
                                        </div>

                                    </div>
                                <?endforeach;?>

                            </div>
                        </div>

                    </div>
                </div>

                

            <?elseif($arItem["PROPERTIES"]["SWITCHER_VIEW"]["VALUE_XML_ID"] == "tabs-up"):?>

                <?$count_sections = count($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"]);?>
                <?$class = ''?>
                <?$class2 = ''?>

                <?if($count_sections > 1 && $count_sections < 5):?>
                    <?$class = 'col-md-3 col-xs-0'?>

                    <?if($count_sections == 2):?>
                        <?$class2 = 'col-md-offset-3 col-xs-offset-0'?>

                    <?elseif($count_sections == 3):?>

                        <?$class2 = 'col-lg-offset-one col-md-offset-one'?>

                    <?endif;?>

                <?elseif($count_sections > 4 && $count_sections < 6):?>

                    <?$class = 'col-lg-five col-md-five col-sm-five col-xs-five'?>

                <?elseif($count_sections > 5):?>
                    <?$class = 'col-md-2 col-xs-0'?>
                <?endif;?>

                <div class="container hidden-sm hidden-xs">
                    <div class="row">
                
                        <ul class="switcher-tab">

                            <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>  
                            <?if(($cell+1) > 6) continue;?>

                            <li class="<?=$class?> <?if($k == 0):?>active <?=$class2?><?endif;?>">
                                <span><?=$arTabs;?><div class="primary"></div></span>
                            </li>

                            <?endforeach;?>
                            
                        </ul> 

                    </div> 

                  

                </div>

                <div class="block-grey-line hidden-sm hidden-xs"></div>

                <div class="container">
                    <div class="switcher-content-wrap">
                        
                    
                        <?foreach($arItem["PROPERTIES"]["SWITCHER_TABNAME"]["~VALUE"] as $k => $arTabs):?>

                            <div class="switcher-wrap <?if($k == 0):?>active<?endif;?>">

                                <div class="switcher-title visible-sm visible-xs <?if($k == 0):?>active<?endif;?>"><?=$arTabs?><div class="primary"></div></div>   

                                <div class="switcher-content text-content<?if($k == 0):?> active<?endif;?>">
                                    

                                    <?=str_replace(array("#MAP_START#","#VIDEO_START#"), array('<img class="lazyload img-for-lazyload map-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">','<img class="lazyload img-for-lazyload video-start" data-src="'.SITE_TEMPLATE_PATH.'/images/one_px.png">'), $arItem["PROPERTIES"]["SWITCHER_HTML"]["~VALUE"][$k]["TEXT"])?>


                                </div>

                            </div>
                        <?endforeach;?>

                    </div>

                </div>

            <?endif;?>

        </div>

    <div class="container">
        <div class="row">
<?endif;?>