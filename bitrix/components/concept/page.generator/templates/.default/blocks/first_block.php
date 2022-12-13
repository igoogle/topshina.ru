<?if(!empty($arSlider["ELEMENTS_LG"]) && is_array($arSlider["ELEMENTS_LG"]) || !empty($arSlider["ELEMENTS_XS"]) && is_array($arSlider["ELEMENTS_XS"])):?>
    <style>
        
        <?if(!empty($arSlider["ELEMENTS_LG"]) && is_array($arSlider["ELEMENTS_LG"])):?>
            <?foreach($arSlider["ELEMENTS_LG"] as $k => $arItem):?>

                <?if(
                    strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"])>0

                ):?>

                    @media (min-width: 768px){
                        .first_slider_<?=$arItem["ID"]?>{
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"])>0):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"])>0):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]?>px !important;<?endif;?>
                        }
                    }

                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>
                    @media (min-width: 768px){

                        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>
                            .first_slider_<?=$arItem["ID"]?> div.head div.title, .first_slider_<?=$arItem["ID"]?> div.head h1, .first_slider_<?=$arItem["ID"]?> div.head h2{
                                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>

                                <?
                                    $line_height_tit = intval($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"]) + 5;
                                    if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"])>0)
                                        $line_height_tit = $arItem["PROPERTIES"]["TITLE_SIZE"]["DESCRIPTION"];
                                ?>

                                line-height: <?=$line_height_tit?>px !important;
                            }
                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>

                        .first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                            <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]?>px !important;<?endif;?>
                            <?
                                $line_height_sub = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"]) + 3;
                                if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"])>0)
                                    $line_height_sub = $arItem["PROPERTIES"]["SUBTITLE_SIZE"]["DESCRIPTION"];
                            ?>

                            line-height: <?=$line_height_sub?>px !important;

                        }
                        <?endif;?>
                    }

                <?endif;?>

            <?endforeach;?>
        <?endif;?>

        <?if(!empty($arSlider["ELEMENTS_XS"]) && is_array($arSlider["ELEMENTS_XS"])):?>
            <?foreach($arSlider["ELEMENTS_XS"] as $k => $arItem):?>

                <?if(

                    strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0

                ):?>

            
                    @media (max-width: 767px){
                        .first_slider_<?=$arItem["ID"]?>{
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                        }
                    }

                <?endif;?>

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 
                    || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>
                    @media (max-width: 767px){

                     <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>
                        .first_slider_<?=$arItem["ID"]?> div.head div.title, .first_slider_<?=$arItem["ID"]?> div.head h1, .first_slider_<?=$arItem["ID"]?> div.head h2{
                            <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>

                            <?
                                $line_height_tit_mob = intval($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"]) + 5;
                                if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                    $line_height_tit_mob = $arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["DESCRIPTION"];
                            ?>

                            line-height: <?=$line_height_tit_mob?>px !important;
                        }
                        <?endif;?>

                        <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>
                        .first_slider_<?=$arItem["ID"]?> div.head .subtitle{
                            <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>font-size: <?=$arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?
                                $line_height_sub_mob = intval($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"]) + 3;
                                if(strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"])>0)
                                    $line_height_sub_mob = $arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["DESCRIPTION"];
                            ?>

                            line-height: <?=$line_height_sub_mob?>px !important;
                        }
                        <?endif;?>
                    }

                <?endif;?>

            <?endforeach;?>
        <?endif;?>
       
    </style>
<?endif;?>


<div class="parent-scroll-down img-for-lazyload-parent">
    <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arSlider["ID"]?>">

    <?$h1_used = false;?>

    <?if(!empty($arSlider["ELEMENTS_LG"]) && is_array($arSlider["ELEMENTS_LG"])):?>
        <div class="wrap-first-slider hidden-xs" 
            data-desktop-height = "<?=( ($arSlider["START_DESKTOP"]["PROPERTIES"]["FB_HEIGHT_WINDOW"]["VALUE"] == "Y") ? "Y" : "")?>"

            data-autoslide = "<?= ($Landing["UF_CHAM_SLIDER_TIME"] > 0) ? "Y" : "";?>"
            data-autoslide-time = "<?=$Landing["UF_CHAM_SLIDER_TIME"]*1000?>"

            >
                <?if(!$header_bg_on) echo "<div class='top-shadow'></div>";?>

                <div class="first-slider slider-lg parent-slider-item-js" id="block<?=$arSlider["ID"]?>">

                    <?foreach($arSlider["ELEMENTS_LG"] as $k=> $arItem):?>

                        <?
                            global $USER;

                            $block_name = '';

                            if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
                                $block_name = $arItem["PROPERTIES"]["HEADER"]["~VALUE"];
                            else
                                $block_name = $arItem['~NAME'];

                            $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

                            $style = "";


                            if(strlen($arItem["PREVIEW_PICTURE"]["SRC"])>0)
                        		$style .= "background-image: url(".$arItem["PREVIEW_PICTURE"]["SRC"].");";
                        	
                        	

                        	if(isset($arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]{0}))
								$style .= "background-color: ".$arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"].";";

                            /*if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]) > 0)
                                $style .= "margin-top: ".$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]."px;";

                            if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]) > 0)
                                $style .= "margin-bottom: ".$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]."px;";
                            
                            if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]) > 0)
                                $style .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
                        
                            if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]) > 0)
                                $style .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
                                */

                        ?> 


                        <div id="first_slider_<?=$arItem["ID"]?>" 
                            class="
                                <?=(
                                    $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"] > 0
                                    ||
                                    $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"] > 0
                                    ||
                                    $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"] > 0
                                    ||
                                    strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0
                                )? "parent-video-bg" : "";?>
                                first_slider_<?=$arItem["ID"]?>
                                first-block
                                
                                <?if($k!=0) echo 'noactive-slide-lazyload';?>
                                <?=$arItem["PROPERTIES"]["SHADOW"]["VALUE_XML_ID"]?>
                                <?=$arItem["PROPERTIES"]["COVER"]["VALUE_XML_ID"]?>"

                            style="<?=$style?>">

                                

                            

                            <?if(is_array($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"])):?>
                
                                <?foreach($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"] as $arSlID):?>
                                    <?if($arSlID == 'top tb' || $arSlID == 'top bt') continue;?>
                                    <div class="corner <?=$arSlID?> hidden-xs hidden-sm"></div>
                                <?endforeach;?>
                                    
                            <?endif;?>

                            <?if(
                                $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"] > 0
                                ||
                                $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"] > 0
                                ||
                                $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"] > 0
                                ||
                                strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0
                            ):?>

                                <?

                                    if(
                                        $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"] > 0
                                        ||
                                        $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"] > 0
                                        ||
                                        $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"] > 0
                                    )
                                    {
                                        $iframeType = "file";

                                        if($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"])
                                            $srcMP4 = CFile::GetPath($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"]);

                                        if($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"])
                                            $srcWEBM = CFile::GetPath($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"]);

                                        if($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"])
                                            $srcOGG = CFile::GetPath($arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"]);
                                    }

                                    
                                    elseif(strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0)
                                    {
                                        $iframeType = "iframe";
                                        $iframe = ChamDB::createVideo($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]);
                                        $srcYB = "https://www.youtube.com/embed/".$iframe["ID"]."?rel=0&amp;mute=1&amp;controls=0&amp;loop=1&amp;showinfo=0&amp;autoplay=1&amp;playlist=".$iframe["ID"];

                                    }
                                ?>

                                <div 
                                    class="videoBG hidden-xs"
                                    data-type = "<?=$iframeType?>"

                                    <?if(strlen($srcYB)):?>
                                        data-srcYB = "<?=$srcYB?>"
                                    <?endif;?>

                                    <?if(strlen($srcMP4)):?>
                                        data-srcMP4 = "<?=$srcMP4?>"
                                    <?endif;?>

                                    <?if(strlen($srcWEBM)):?>
                                        data-srcWEBM = "<?=$srcWEBM?>"
                                    <?endif;?>

                                    <?if(strlen($srcOGG)):?>
                                        data-srcOGG = "<?=$srcOGG?>"
                                    <?endif;?>
                                >
                                </div>

                                <img class="lazyload img-for-lazyload videoBG-start-fb" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png">

                            <?endif;?>

                            <div class="shadow"></div>
                        
                            <div class="container">
                                <div class="row">

                                    <div class="first-block-container <?=$arItem["PROPERTIES"]["FB_TEXT_COLOR"]["VALUE_XML_ID"]?>">
                                        
                                        <div class="first-block-cell text-part <?if($arItem["TWO_COLS"] == "Y"):?>col-md-7 col-sm-8 col-xs-12 two-cols <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-push-5 col-sm-push-4 col-xs-push-0 right<?endif;?><?else:?>col-xs-12<?endif;?>">
                                        
                                            <div class="<?if($arItem["TWO_COLS"] == "Y"):?><?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">
                   
                                                <div class="head no-margin-top-bot <?if($arItem["TWO_COLS"] == "Y"):?>min left<?endif;?> <?=$arItem["PROPERTIES"]["TITLE_SHADOW"]["VALUE_XML_ID"]?> <?=$animate;?> <?=$arItem["PROPERTIES"]["SUBTITLE_SHADOW"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"]?>">

                                                  
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0):?>
                                                            
                                                        <?
                                                            $tit = Array();
                                                            $title = Array();

                                                            if(substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "}") > 0)
                                                            {
                                                                $tit = explode("{", $arItem["PROPERTIES"]["HEADER"]["VALUE"]);
                                                                $title[] = $tit[0];
                                                                $tit = $tit[1];
                                                                
                                                                $tit = explode("}", $tit);
                                                                $title[] = $tit[1];
                                                                $tit = $tit[0];

                                                                $tit = explode("|", $tit);
                                                                
                                                            }
                                                        ?>
                                                    
                                                        <div class="title main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>

                                                            <?$h1_close = 0;?>
                                                            
                                                            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1 == 0 && isset($arItem["H1_MAIN"])):?>
                                                                <h1>
                                                                
                                                                <?
                                                                    $h1 = 1;
                                                                    $h1_close = 1;
                                                                    $h1_used = 1;
                                                                ?>
                                                            <?endif;?>
                                                        
                                                            <?if(!empty($tit)):?>
                                                                <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                            <?else:?>
                                                                <?=$arItem["PROPERTIES"]["HEADER"]["~VALUE"]?>
                                                            <?endif;?>
                                                            
                                                            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1_close == 1):?>
                                                                </h1>
                                                            <?endif;?>
                                                        
                                                                                                            
                                                        </div>
                                                        
                                                        <?if(!empty($tit)):?>
                            
                                                            <script>
                                                                $(document).ready(
                                                                    function(){
                                                                    $("div#first_slider_<?=$arItem["ID"]?> div.title span.typed").typed({
                                                                        strings: ["<?=implode('","', $tit)?>"],
                                                                        typeSpeed: 50,
                                                                        startDelay: 3000,
                                                                        backDelay: 2000,
                                                                    });
                                                                });
                                                            </script>
                                                        
                                                        <?endif;?>
                                                    
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>
                                                    
                                                        
                                                        <?

                                                        $tit = Array();
                                                        $title = Array();
                                                        if(substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "}") > 0)
                                                        {
                                                            $tit = explode("{", $arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]);
                                                            $title[] = $tit[0];
                                                            $tit = $tit[1];
                                                            
                                                            $tit = explode("}", $tit);
                                                            $title[] = $tit[1];
                                                            $tit = $tit[0];
                                                                                                                        
                                                            $tit = explode("|", $tit);
                                                            
                                                        }
                                                        ?>
                                                    
                                                        <div class="subtitle <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                                                        
                                                            <?if(!empty($tit)):?>
                                                                <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                            <?else:?>
                                                                <?=$arItem["PROPERTIES"]["SUBHEADER"]["~VALUE"]?>
                                                            <?endif;?>
                                                        
                                                        </div>
                                                        
                                                        <?if(!empty($tit)):?>
                            
                                                            <script>
                                                                $(document).ready(
                                                                    function(){
                                                                    $("div#first_slider_<?=$arItem["ID"]?> div.subtitle span.typed").typed({
                                                                        strings: ["<?=implode('","', $tit)?>"],
                                                                        typeSpeed: 50,
                                                                        startDelay: 3000,
                                                                        backDelay: 2000,
                                                                    });
                                                                });
                                                            </script>
                                                        
                                                        <?endif;?>
                                                        
                                                    <?endif;?>

                                                    <?if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "icons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
                                                        
                                                        <div class="icons row">
                                                            <?
                                                                $class = "";
                                                                if($arItem["TWO_COLS"] == "Y")
                                                                    $class = "col-sm-6 col-xs-12 min";
                                                                else
                                                                {
                                                                    if($arItem["ICONS_MAX"] <= 3)
                                                                        $class = "col-sm-4 col-xs-6";

                                                                    else
                                                                        $class = "col-md-3 col-xs-6";
                                                                }
                                                            ?>

                                                            <?for($i = 0; $i < $arItem["ICONS_MAX"]; $i++):?>
                                                            
                                                                <?if($i > 3) continue;?>
                                                            
                                                                <div class="<?=$class?> element">
                                                                    
                                                                    <div class="icon">
                                                                        
                                                                        <?if($arItem["ICONS_COUNT"] > 0):?>
                                                                    
                                                                            <div class="image-table">
                                                                                <div class="image-cell">
                                                                                
                                                                                    <?if($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i] > 0):?>
                                                                                        <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality);?>
                                                                                        <img class="img-responsive lazyload" src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["FB_ICONS"]["DESCRIPTION"][$i]?>"/>
                                                                                    <?endif;?>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        <?endif;?>
                                                                        
                                                                        <?if($arItem["ICONS_DESC_COUNT"] > 0):?>
                                                                        
                                                                            <div class="text-wrap no-margin-top-bot">
                                                                                <div class="text">
                                                                                    <?=$arItem["PROPERTIES"]["FB_ICONS_DESC"]["~VALUE"][$i]?>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        <?endif;?>
                                                                    </div>
                                                                </div>

                                                                <?
                                                                    if($arItem["TWO_COLS"] == "Y")
                                                                    {
                                                                        if(($i+1)%2 == 0)
                                                                            echo "<div class='clearfix'></div>";
                                                                    }

                                                                    else
                                                                    {
                                                                        if($arItem["ICONS_MAX"] <= 3)
                                                                        {
                                                                            if(($i+1)%2 == 0)
                                                                                echo "<div class='clearfix visible-xs'></div>";

                                                                            if(($i+1)%3 == 0)
                                                                                echo "<div class='clearfix hidden-xs'></div>";
                                                                        }
                                                                        else
                                                                        {
                                                                            if(($i+1)%2 == 0)
                                                                                echo "<div class='clearfix visible-sm visible-xs'></div>";

                                                                            if(($i+1)%4 == 0)
                                                                                echo "<div class='clearfix hidden-sm hidden-xs'></div>";
                                                                        }
                                                                    }
                                                                ?>                                                        
                                                            <?endfor;?>                                                        
                                                        </div>
                                                        
                                                    <?endif;?>
                                                    
                                                    <?if(
                                                        $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "" 
                                                        || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "buttons" 
                                                        || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
                    
                                                        <div class="buttons 
                                                            clearfix

                                                            <?if($arItem["TWO_COLS"] == "Y"):?>
                                                                row
                                                            <?else:?>
                                                                no-image
                                                            <?endif;?> 

                                                            

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"])>0):?>
                                                                left-button-on
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"])>0):?>
                                                                right-button-on
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"])>0):?>
                                                                video-button-on
                                                            <?endif;?>

                                                            <?=$arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"]?>">
                                                            
                                                            <?if($arItem["TWO_COLS"] != "Y"):?>
                                                                                                              
                                                                <?/*if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                                <?endif;*/?>
                                                                
                                                                <?if($arItem["BUTTONS_COUNT"] == 2):?>
                                                                    <div class="col-lg-2 col-sm-0 col-xs-12"></div>
                                                                <?endif;?>
                
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                                <?$arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                            
                                                                <div class="
                                                                    <?if($arItem["TWO_COLS"] == "Y"):?>
                                                                        col-sm-6 col-xs-12
                                                                    <?else:?>

                                                                        <?if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                            col-xs-12
                                                                        <?else:?>
                                                                            col-lg-4 col-sm-6 col-xs-12
                                                                        <?endif;?>

                                                                    <?endif;?>">

                                                                    
                                                                    
                                                                    <div class="button left">

                                                                        <a 
                                                                        
                                                                            <?
                                                                                if(strlen($arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"])>0) 
                                                                                {
                                                                                    $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"]);

                                                                                    echo "onclick='".$str_onclick."'";

                                                                                    $str_onclick = "";
                                                                                }

                                                                                $b_left_options = array(
                                                                                    "MAIN_COLOR" => "primary",
                                                                                    "STYLE" => ""
                                                                                );

                                                                                if(strlen($arItem["PROPERTIES"]["FB_LB_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] != "empty")
                                                                                {

                                                                                    $b_left_options = array(
                                                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                                        "STYLE" => "background-color: ".$arItem["PROPERTIES"]["FB_LB_BG_COLOR"]["VALUE"].";"
                                                                                    );

                                                                                }
                                                                            ?>

                                                                            class="button-def 
                                                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> 
                                                                                <?if($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "" 
                                                                                    || $arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "solid"):?>
                                                                                    <?=$b_left_options["MAIN_COLOR"]?>
                                                                                <?elseif($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "shine"):?>
                                                                                    shine <?=$b_left_options["MAIN_COLOR"]?> 
                                                                                <?else:?>
                                                                                    secondary
                                                                                <?endif;?>

                                                                                <?=hamButtonEditClass($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"])?>"

                                                                            <?if(strlen($b_left_options["STYLE"])):?>
                                                                                style = "<?=$b_left_options["STYLE"]?>"
                                                                            <?endif;?>
                                                                                
                                                                            <?=hamButtonEditAttr($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"],
                                                                                $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_LINK"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                                $block_name,
                                                                                $arItem["PROPERTIES"]["FB_LB_QUIZ"]["VALUE"])?>>
                                                                                
                                                                            <?=$arItem["PROPERTIES"]["FB_LB_NAME"]["~VALUE"]?>    
                                                                        </a>
                                                                    </div>

                                                                    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"]) > 0):?>
                      
                                                                <div class="
                                                                    <?if($arItem["TWO_COLS"] == "Y"):?>

                                                                        col-sm-6 col-xs-12

                                                                    <?else:?>

                                                                        <?if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                            col-xs-12
                                                                        <?else:?>
                                                                            col-lg-4 col-sm-6 col-xs-12
                                                                        <?endif;?>

                                                                    <?endif;?>">

                                                                    <?$iframe = ChamDB::createVideo($arItem['PROPERTIES']['FB_VIDEO_LINK']['VALUE']);?>

                                                                    <a class="link-video call-modal callvideo" data-call-modal="<?=$iframe["ID"]?>">
                                                                        <div class="video-cont">
                                                                            <div class="video">
                                                                            
                                                                                <div class="play-button"></div>
                                                                                <table>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="video-name"><?=$arItem["PROPERTIES"]["FB_VIDEO_NAME"]["~VALUE"]?></div>
                                                                                            <div class="video-comm"><?=$arItem["PROPERTIES"]["FB_VIDEO_COMMENT"]["~VALUE"]?></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                
                                                                            </div> 
                                                                        </div>
                                                                    </a>
                                                                    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"]) <= 0)
                                                                $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                  
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                            
                                                                <?if($arItem["BUTTONS_COUNT"] == 3 && $arItem["TWO_COLS"] == "Y"):?>
                                                                    <span class="clearfix"></span>
                                                                <?endif;?>
                                                            
                                                                <div class="<?if($arItem["TWO_COLS"] == "Y"):?>col-sm-6 col-xs-12<?else:?><?if($arItem["BUTTONS_COUNT"] == 1):?>col-xs-12<?else:?>col-lg-4 col-sm-6 col-xs-12<?endif;?><?endif;?>">
                                                                
                                                                    <div class="button right">
                                                                        <a 

                                                                            <?
                                                                                if(strlen($arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"])>0) 
                                                                                {
                                                                                    $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"]);

                                                                                    echo "onclick='".$str_onclick."'";

                                                                                    $str_onclick = "";
                                                                                }

                                                                                $b_right_options = array(
                                                                                    "MAIN_COLOR" => "primary",
                                                                                    "STYLE" => ""
                                                                                );

                                                                                if(strlen($arItem["PROPERTIES"]["FB_RB_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] != "empty")
                                                                                {

                                                                                    $b_right_options = array(
                                                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                                        "STYLE" => "background-color: ".$arItem["PROPERTIES"]["FB_RB_BG_COLOR"]["VALUE"].";"
                                                                                    );

                                                                                }
                                                                            ?>

                                                                            class="button-def
                                                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                                                <?if($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == ""
                                                                                    || $arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "solid"):?>
                                                                                        <?=$b_right_options["MAIN_COLOR"]?> 
                                                                                <?elseif($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "shine"):?>
                                                                                    shine <?=$b_right_options["MAIN_COLOR"]?> 
                                                                                <?else:?>
                                                                                    secondary
                                                                                <?endif;?>

                                                                                <?=hamButtonEditClass (
                                                                                    $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"])?>" 


                                                                                    <?if(strlen($b_right_options["STYLE"])):?>
                                                                                        style = "<?=$b_right_options["STYLE"]?>"
                                                                                    <?endif;?>

                                                                                <?=hamButtonEditAttr (
                                                                                    $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_LINK"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                                    $block_name,
                                                                                    $arItem["PROPERTIES"]["FB_RB_QUIZ"]["VALUE"])?>>
                                                                            <?=$arItem["PROPERTIES"]["FB_RB_NAME"]["~VALUE"]?>
                                                                                
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                        </div>
                                                    
                                                    <?endif;?>

                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?if($arItem["TWO_COLS"] == "Y"):?>
                                        
                                            <div class="first-block-cell image-part hidden-xs col-md-5 col-sm-4 col-xs-12 <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-pull-7 col-sm-pull-8 col-xs-pull-0<?endif;?> <?=$arItem["PROPERTIES"]["FB_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                                
                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ADD_PICTURE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60);?>
                                                <img class="img-responsive center-block lazyload" src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["FB_ADD_PICTURE"]["DESCRIPTION"]?>"/>
                                                
                                            </div>
                                        
                                        <?endif;?>
                                        
                                    </div>

                                </div>
                            </div>


                            <?if($arItem["PROPERTIES"]["FB_CLICK_DOWN"]["VALUE"] == "Y"):?>
                                <div class="wrap-down hidden-xs">
                                    <div class="down-scroll">
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            <?endif;?>

                            <?admin_setting($arItem, true)?>

                        </div>

                    <?endforeach;?>

                </div>

                
        </div>
    <?endif;?>

    <?if(!empty($arSlider["ELEMENTS_XS"]) && is_array($arSlider["ELEMENTS_XS"])):?>
        <div class="wrap-first-slider visible-xs" 
            
            data-mobile-height = "<?=( ($arSlider["START_MOBILE"]["PROPERTIES"]["FB_HEIGHT_WINDOW"]["VALUE"] == "Y") ? "Y" : "")?>"
            data-autoslide = "<?= ($Landing["UF_CHAM_SLIDER_TIME"] > 0) ? "Y" : "";?>"
            data-autoslide-time = "<?=$Landing["UF_CHAM_SLIDER_TIME"]*1000?>"
            >
                <?if(!$header_bg_on) echo "<div class='top-shadow'></div>";?>

                <div class="first-slider slider-xs parent-slider-item-js" id="block<?=$arSlider["ID"]?>">

                    <?foreach($arSlider["ELEMENTS_XS"] as $k => $arItem):?>

                        <?
                            global $USER;

                            $block_name = '';

                            if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
                                $block_name = $arItem["PROPERTIES"]["HEADER"]["~VALUE"];
                            else
                                $block_name = $arItem['~NAME'];

                            $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

                            $style = "";


                            if(strlen($arItem["PREVIEW_PICTURE"]["SRC"])>0)
                        		$style .= "background-image: url(".$arItem["PREVIEW_PICTURE"]["SRC"].");";
                        	
                        	

                        	if(isset($arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]{0}))
								$style .= "background-color: ".$arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"].";";
							
                            /*

                            if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]) > 0)
                                $style .= "margin-top: ".$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]."px;";

                            if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]) > 0)
                                $style .= "margin-bottom: ".$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]."px;";
                            
                            if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]) > 0)
                                $style .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
                        
                            if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]) > 0)
                                $style .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
                                */



                        ?> 


                        <div id="first_slider_<?=$arItem["ID"]?>" 

                            class="
                                first_slider_<?=$arItem["ID"]?>
                                first-block
                                
                                <?if($k!=0) echo 'noactive-slide-lazyload';?>
                                <?=$arItem["PROPERTIES"]["SHADOW"]["VALUE_XML_ID"]?>
                                <?=$arItem["PROPERTIES"]["COVER"]["VALUE_XML_ID"]?>"


                            style="<?=$style?>">

                            <?if(is_array($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"])):?>
                
                                <?foreach($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"] as $arSlID):?>
                                    <?if($arSlID == 'top tb' || $arSlID == 'top bt') continue;?>
                                    <div class="corner <?=$arSlID?> hidden-xs hidden-sm"></div>
                                <?endforeach;?>
                                    
                            <?endif;?>

                            <div class="shadow"></div>
                        
                            <div class="container">
                                <div class="row">

                                    <div class="first-block-container <?=$arItem["PROPERTIES"]["FB_TEXT_COLOR"]["VALUE_XML_ID"]?>">
                                        
                                        <div class="first-block-cell text-part <?if($arItem["TWO_COLS"] == "Y"):?>col-md-7 col-sm-8 col-xs-12 two-cols <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-push-5 col-sm-push-4 col-xs-push-0 right<?endif;?><?else:?>col-xs-12<?endif;?>">
                                        
                                            <div class="<?if($arItem["TWO_COLS"] == "Y"):?><?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>wrap-padding-left<?else:?>wrap-padding-right<?endif;?><?endif;?>">
                   
                                                <div class="head no-margin-top-bot <?if($arItem["TWO_COLS"] == "Y"):?>min left<?endif;?> <?=$arItem["PROPERTIES"]["TITLE_SHADOW"]["VALUE_XML_ID"]?> <?=$animate;?> <?=$arItem["PROPERTIES"]["SUBTITLE_SHADOW"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"]?>">

                                                  
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0):?>
                                                            
                                                        <?
                                                            $tit = Array();
                                                            $title = Array();

                                                            if(substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["HEADER"]["VALUE"], "}") > 0)
                                                            {
                                                                $tit = explode("{", $arItem["PROPERTIES"]["HEADER"]["VALUE"]);
                                                                $title[] = $tit[0];
                                                                $tit = $tit[1];
                                                                
                                                                $tit = explode("}", $tit);
                                                                $title[] = $tit[1];
                                                                $tit = $tit[0];

                                                                $tit = explode("|", $tit);
                                                                
                                                            }
                                                        ?>
                                                    
                                                        <div class="title main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>

                                                            <?$h1_close = 0;?>
                                                            
                                                            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1 == 0  && isset($arItem["H1_MAIN"]) && !$h1_used):?>
                                                                <h1>
                                                                
                                                                <?
                                                                    $h1 = 1;
                                                                    $h1_close = 1;
                                                                    $h1_used = 1;
                                                                ?>
                                                            <?endif;?>
                                                        
                                                            <?if(!empty($tit)):?>
                                                                <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                            <?else:?>
                                                                <?=$arItem["PROPERTIES"]["HEADER"]["~VALUE"]?>
                                                            <?endif;?>
                                                            
                                                            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1_close == 1):?>
                                                                </h1>
                                                            <?endif;?>
                                                        
                                                                                                            
                                                        </div>
                                                        
                                                        <?if(!empty($tit)):?>
                            
                                                            <script>
                                                                $(document).ready(
                                                                    function(){
                                                                    $("div#first_slider_<?=$arItem["ID"]?> div.title span.typed").typed({
                                                                        strings: ["<?=implode('","', $tit)?>"],
                                                                        typeSpeed: 50,
                                                                        startDelay: 3000,
                                                                        backDelay: 2000,
                                                                    });
                                                                });
                                                            </script>
                                                        
                                                        <?endif;?>
                                                    
                                                    <?endif;?>
                                                    
                                                    <?if(strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>
                                                    
                                                        
                                                        <?

                                                        $tit = Array();
                                                        $title = Array();
                                                        if(substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "{") > 0 && substr_count($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"], "}") > 0)
                                                        {
                                                            $tit = explode("{", $arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]);
                                                            $title[] = $tit[0];
                                                            $tit = $tit[1];
                                                            
                                                            $tit = explode("}", $tit);
                                                            $title[] = $tit[1];
                                                            $tit = $tit[0];
                                                                                                                        
                                                            $tit = explode("|", $tit);
                                                            
                                                        }
                                                        ?>
                                                    
                                                        <div class="subtitle <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                                                        
                                                            <?if(!empty($tit)):?>
                                                                <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                                                            <?else:?>
                                                                <?=$arItem["PROPERTIES"]["SUBHEADER"]["~VALUE"]?>
                                                            <?endif;?>
                                                        
                                                        </div>
                                                        
                                                        <?if(!empty($tit)):?>
                            
                                                            <script>
                                                                $(document).ready(
                                                                    function(){
                                                                    $("div#first_slider_<?=$arItem["ID"]?> div.subtitle span.typed").typed({
                                                                        strings: ["<?=implode('","', $tit)?>"],
                                                                        typeSpeed: 50,
                                                                        startDelay: 3000,
                                                                        backDelay: 2000,
                                                                    });
                                                                });
                                                            </script>
                                                        
                                                        <?endif;?>
                                                        
                                                    <?endif;?>

                                                    <?if($arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "icons" || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
                                                        
                                                        <div class="icons row">
                                                            <?
                                                                $class = "";
                                                                if($arItem["TWO_COLS"] == "Y")
                                                                    $class = "col-sm-6 col-xs-12 min";
                                                                else
                                                                {
                                                                    if($arItem["ICONS_MAX"] <= 3)
                                                                        $class = "col-sm-4 col-xs-6";

                                                                    else
                                                                        $class = "col-md-3 col-xs-6";
                                                                }
                                                            ?>

                                                            <?for($i = 0; $i < $arItem["ICONS_MAX"]; $i++):?>
                                                            
                                                                <?if($i > 3) continue;?>
                                                            
                                                                <div class="<?=$class?> element">
                                                                    
                                                                    <div class="icon">
                                                                        
                                                                        <?if($arItem["ICONS_COUNT"] > 0):?>
                                                                    
                                                                            <div class="image-table">
                                                                                <div class="image-cell">
                                                                                
                                                                                    <?if($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i] > 0):?>
                                                                                        <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ICONS"]["VALUE"][$i], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality);?>
                                                                                        <img class="img-responsive lazyload" src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["FB_ICONS"]["DESCRIPTION"][$i]?>"/>
                                                                                    <?endif;?>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        <?endif;?>
                                                                        
                                                                        <?if($arItem["ICONS_DESC_COUNT"] > 0):?>
                                                                        
                                                                            <div class="text-wrap no-margin-top-bot">
                                                                                <div class="text">
                                                                                    <?=$arItem["PROPERTIES"]["FB_ICONS_DESC"]["~VALUE"][$i]?>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        <?endif;?>
                                                                    </div>
                                                                </div>

                                                                <?
                                                                    if($arItem["TWO_COLS"] == "Y")
                                                                    {
                                                                        if(($i+1)%2 == 0)
                                                                            echo "<div class='clearfix'></div>";
                                                                    }

                                                                    else
                                                                    {
                                                                        if($arItem["ICONS_MAX"] <= 3)
                                                                        {
                                                                            if(($i+1)%2 == 0)
                                                                                echo "<div class='clearfix visible-xs'></div>";

                                                                            if(($i+1)%3 == 0)
                                                                                echo "<div class='clearfix hidden-xs'></div>";
                                                                        }
                                                                        else
                                                                        {
                                                                            if(($i+1)%2 == 0)
                                                                                echo "<div class='clearfix visible-sm visible-xs'></div>";

                                                                            if(($i+1)%4 == 0)
                                                                                echo "<div class='clearfix hidden-sm hidden-xs'></div>";
                                                                        }
                                                                    }
                                                                ?>                                                        
                                                            <?endfor;?>                                                        
                                                        </div>
                                                        
                                                    <?endif;?>
                                                    
                                                    <?if(
                                                        $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "" 
                                                        || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "buttons" 
                                                        || $arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"] == "mixed"):?>
                    
                                                        <div class="buttons 
                                                            clearfix

                                                            <?if($arItem["TWO_COLS"] == "Y"):?>
                                                                row
                                                            <?else:?>
                                                                no-image
                                                            <?endif;?> 

                                                            

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"])>0):?>
                                                                left-button-on
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"])>0):?>
                                                                right-button-on
                                                            <?endif;?>

                                                            <?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"])>0):?>
                                                                video-button-on
                                                            <?endif;?>

                                                            <?=$arItem["PROPERTIES"]["FB_VIEW"]["VALUE_XML_ID"]?>">
                                                            
                                                            <?if($arItem["TWO_COLS"] != "Y"):?>
                                                                                                              
                                                                <?/*if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                                <?endif;*/?>
                                                                
                                                                <?if($arItem["BUTTONS_COUNT"] == 2):?>
                                                                    <div class="col-lg-2 col-sm-0 col-xs-12"></div>
                                                                <?endif;?>
                
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                                                                <?$arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_LB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                            
                                                                <div class="
                                                                    <?if($arItem["TWO_COLS"] == "Y"):?>
                                                                        col-sm-6 col-xs-12
                                                                    <?else:?>

                                                                        <?if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                            col-xs-12
                                                                        <?else:?>
                                                                            col-lg-4 col-sm-6 col-xs-12
                                                                        <?endif;?>

                                                                    <?endif;?>">

                                                                    
                                                                    
                                                                    <div class="button left">

                                                                        <a 
                                                                        
                                                                            <?
                                                                                if(strlen($arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"])>0) 
                                                                                {
                                                                                    $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["FB_LB_ONCLICK"]["VALUE"]);

                                                                                    echo "onclick='".$str_onclick."'";

                                                                                    $str_onclick = "";
                                                                                }

                                                                                $b_left_options = array(
                                                                                    "MAIN_COLOR" => "primary",
                                                                                    "STYLE" => ""
                                                                                );

                                                                                if(strlen($arItem["PROPERTIES"]["FB_LB_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] != "empty")
                                                                                {

                                                                                    $b_left_options = array(
                                                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                                        "STYLE" => "background-color: ".$arItem["PROPERTIES"]["FB_LB_BG_COLOR"]["VALUE"].";"
                                                                                    );

                                                                                }
                                                                            ?>

                                                                            class="button-def 
                                                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> 
                                                                                <?if($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "" 
                                                                                    || $arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "solid"):?>
                                                                                    <?=$b_left_options["MAIN_COLOR"]?> 
                                                                                <?elseif($arItem["PROPERTIES"]["FB_LB_VIEW"]["VALUE_XML_ID"] == "shine"):?>
                                                                                    shine <?=$b_left_options["MAIN_COLOR"]?> 
                                                                                <?else:?>
                                                                                    secondary
                                                                                <?endif;?>

                                                                                <?=hamButtonEditClass($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"])?>"

                                                                            <?if(strlen($b_left_options["STYLE"])):?>

                                                                                style = "<?=$b_left_options["STYLE"]?>"

                                                                            <?endif;?>
                                                                                
                                                                            <?=hamButtonEditAttr($arItem["PROPERTIES"]["FB_LB_TYPE"]["VALUE_XML_ID"],
                                                                                $arItem["PROPERTIES"]["FB_LB_FORM"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_MODAL"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_LINK"]["VALUE"],
                                                                                $arItem["PROPERTIES"]["FB_LB_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                                $block_name,
                                                                                $arItem["PROPERTIES"]["FB_LB_QUIZ"]["VALUE"])?>>
                                                                                
                                                                            <?=$arItem["PROPERTIES"]["FB_LB_NAME"]["~VALUE"]?>    
                                                                        </a>
                                                                    </div>

                                                                    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_VIDEO_LINK"]["VALUE"]) > 0):?>
                      
                                                                <div class="
                                                                    <?if($arItem["TWO_COLS"] == "Y"):?>

                                                                        col-sm-6 col-xs-12

                                                                    <?else:?>

                                                                        <?if($arItem["BUTTONS_COUNT"] == 1):?>
                                                                            col-xs-12
                                                                        <?else:?>
                                                                            col-lg-4 col-sm-6 col-xs-12
                                                                        <?endif;?>

                                                                    <?endif;?>">

                                                                    <?$iframe = ChamDB::createVideo($arItem['PROPERTIES']['FB_VIDEO_LINK']['VALUE']);?>

                                                                    <a class="link-video call-modal callvideo" data-call-modal="<?=$iframe["ID"]?>">
                                                                        <div class="video-cont">
                                                                            <div class="video">
                                                                            
                                                                                <div class="play-button"></div>
                                                                                <table>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="video-name"><?=$arItem["PROPERTIES"]["FB_VIDEO_NAME"]["~VALUE"]?></div>
                                                                                            <div class="video-comm"><?=$arItem["PROPERTIES"]["FB_VIDEO_COMMENT"]["~VALUE"]?></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                
                                                                            </div> 
                                                                        </div>
                                                                    </a>
                                                                    
                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"]) <= 0)
                                                                $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] = "form";?>
                                                  
                                                            
                                                            <?if(strlen($arItem["PROPERTIES"]["FB_RB_NAME"]["VALUE"]) > 0 && $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"] != ""):?>
                                                            
                                                                <?if($arItem["BUTTONS_COUNT"] == 3 && $arItem["TWO_COLS"] == "Y"):?>
                                                                    <span class="clearfix"></span>
                                                                <?endif;?>
                                                            
                                                                <div class="<?if($arItem["TWO_COLS"] == "Y"):?>col-sm-6 col-xs-12<?else:?><?if($arItem["BUTTONS_COUNT"] == 1):?>col-xs-12<?else:?>col-lg-4 col-sm-6 col-xs-12<?endif;?><?endif;?>">
                                                                
                                                                    <div class="button right">
                                                                        <a 

                                                                            <?
                                                                                if(strlen($arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"])>0) 
                                                                                {
                                                                                    $str_onclick = str_replace("'", "\"", $arItem["PROPERTIES"]["FB_RB_ONCLICK"]["VALUE"]);

                                                                                    echo "onclick='".$str_onclick."'";

                                                                                    $str_onclick = "";
                                                                                }

                                                                                $b_right_options = array(
                                                                                    "MAIN_COLOR" => "primary",
                                                                                    "STYLE" => ""
                                                                                );

                                                                                if(strlen($arItem["PROPERTIES"]["FB_RB_BG_COLOR"]["VALUE"]) && $arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] != "empty")
                                                                                {

                                                                                    $b_right_options = array(
                                                                                        "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                                        "STYLE" => "background-color: ".$arItem["PROPERTIES"]["FB_RB_BG_COLOR"]["VALUE"].";"
                                                                                    );

                                                                                }
                                                                            ?>

                                                                            class="button-def
                                                                                <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
                                                                                <?if($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == ""
                                                                                    || $arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "solid"):?>
                                                                                        <?=$b_right_options["MAIN_COLOR"]?> 
                                                                                <?elseif($arItem["PROPERTIES"]["FB_RB_VIEW"]["VALUE_XML_ID"] == "shine"):?>
                                                                                    shine <?=$b_right_options["MAIN_COLOR"]?> 
                                                                                <?else:?>
                                                                                    secondary
                                                                                <?endif;?>

                                                                                <?=hamButtonEditClass (
                                                                                    $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"])?>" 


                                                                                    <?if(strlen($b_right_options["STYLE"])):?>

                                                                                        style = "<?=$b_right_options["STYLE"]?>"

                                                                                    <?endif;?>

                                                                                <?=hamButtonEditAttr (
                                                                                    $arItem["PROPERTIES"]["FB_RB_TYPE"]["VALUE_XML_ID"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_FORM"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_MODAL"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_LINK"]["VALUE"],
                                                                                    $arItem["PROPERTIES"]["FB_RB_BUTTON_BLANK"]["VALUE_XML_ID"],
                                                                                    $block_name,
                                                                                    $arItem["PROPERTIES"]["FB_RB_QUIZ"]["VALUE"])?>>
                                                                            <?=$arItem["PROPERTIES"]["FB_RB_NAME"]["~VALUE"]?>
                                                                                
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                            
                                                            <?endif;?>
                                                            
                                                        </div>
                                                    
                                                    <?endif;?>

                                                </div>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <?if($arItem["TWO_COLS"] == "Y"):?>
                                        
                                            <div class="first-block-cell image-part hidden-xs col-md-5 col-sm-4 col-xs-12 <?if($arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FB_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?>col-md-pull-7 col-sm-pull-8 col-xs-pull-0<?endif;?> <?=$arItem["PROPERTIES"]["FB_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                                                
                                                <?$file = CFile::ResizeImageGet($arItem["PROPERTIES"]["FB_ADD_PICTURE"]["VALUE"], array('width'=>800, 'height'=>800), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, 60);?>
                                                <img class="img-responsive center-block lazyload" src="<?=$file["src"]?>" alt="<?=$arItem["PROPERTIES"]["FB_ADD_PICTURE"]["DESCRIPTION"]?>"/>
                                                
                                            </div>
                                        
                                        <?endif;?>
                                        
                                    </div>

                                </div>
                            </div>


                            <?if($arItem["PROPERTIES"]["FB_CLICK_DOWN"]["VALUE"] == "Y"):?>
                                <div class="wrap-down hidden-xs">
                                    <div class="down-scroll">
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            <?endif;?>

                            <?admin_setting($arItem, true)?>

                        </div>

                    <?endforeach;?>

                </div>
        </div>
    <?endif;?>

    <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arSlider["ID"]?>">
</div>
