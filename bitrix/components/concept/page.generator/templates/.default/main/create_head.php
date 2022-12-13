<?$animate = '';
    $animate_set = '';

    if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y")
    {
        $animate = 'wow fadeInDown';
        $animate_set = 'data-wow-offset="250" data-wow-duration="0.5s" data-wow-delay="0.2s"';
    }

    if($arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"] == "")
        $arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"] = "def";
?>

<?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>

    <style>

        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE"]["VALUE"])>0):?>

            @media (min-width: 992px){

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE"]["VALUE"])>0):?>
                    #block<?=$arItem["ID"]?> div.head h1, #block<?=$arItem["ID"]?> div.head h2{
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
                    #block<?=$arItem["ID"]?> div.head .descrip, #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
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

        <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0 || strlen($arItem["PROPERTIES"]["SUBTITLE_SIZE_MOB"]["VALUE"])>0):?>
            @media (max-width: 991px){

                <?if(strlen($arItem["PROPERTIES"]["TITLE_SIZE_MOB"]["VALUE"])>0):?>
                    #block<?=$arItem["ID"]?> div.head h1, #block<?=$arItem["ID"]?> div.head h2{
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
                    #block<?=$arItem["ID"]?> div.head .descrip, #first_slider_<?=$arItem["ID"]?> div.head .subtitle{
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

    </style>

<?endif;?>

<div class="head <?if($min):?>min<?endif;?> <?=$animate?> <?=$arItem["PROPERTIES"]["MAIN_TITLE_POS"]["VALUE_XML_ID"]?> <?=$arItem["PROPERTIES"]["TITLE_SHADOW"]["VALUE_XML_ID"]?>  <?=$arItem["PROPERTIES"]["SUBTITLE_SHADOW"]["VALUE_XML_ID"]?>" <?=$animate_set?>>

    <?if(!$min):?>
        <div class="container">
    <?endif;?>
    
    <div class="no-margin-top-bot">
    
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

                $h1_close = 0;

            ?>

            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1 == 0 && isset($arItem["H1_MAIN"])):?>
                <h1 class="main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
                <?
                    $h1 = 1;
                    $h1_close = 1;
                ?>
            <?else:?>

                <h2 class="main1 <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["TITLE_COLOR"]["VALUE"]?>;"<?endif;?>>

            <?endif;?>
                
            <?if(!empty($tit)):?>
                <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
            <?else:?>
                <?=$arItem["PROPERTIES"]["HEADER"]["~VALUE"]?>
            <?endif;?>

            <?if($arItem["PROPERTIES"]["THIS_H1"]["VALUE"] == "Y" && $h1_close == 1):?>
                </h1>
            <?else:?>
                </h2>
            <?endif;?>
            
            <?if(!empty($tit)):?>
            
                <?if($main_key == 0):?>
                
                    <script>
                        $(document).ready(function(){
                                                         
                            $("div#block<?=$arItem["ID"]?> span.typed").typed({
                                strings: ["<?=implode('","', $tit)?>"],
                                typeSpeed: 50,
                                startDelay: 2000,
                                backDelay: 2000,
                            });

                        });
                    </script>
                
                <?else:?>
                
                    <script>
                        $(document).ready(function(){
                                                         
                            $(window).scroll(
                                function()
                                {
                                    if($(document).scrollTop() + $(window).height() > $("div#block<?=$arItem["ID"]?>").offset().top + 200)
                                    {
                                        $("div#block<?=$arItem["ID"]?> span.typed").typed({
                                            strings: ["<?=implode('","', $tit)?>"],
                                            typeSpeed: 50,
                                            startDelay: 2000,
                                            backDelay: 2000,
                                        });
                                    }
                                    
                                }
                            );

                        });
                    </script>
                
                <?endif;?>
            
            <?endif;?>                
            
        <?endif;?>

        <?if(strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0):?>
        
            <?$tit = Array();?>
            <?$title = Array();?>
        
            <?
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
        
            <div class="descrip <?=$arItem["PROPERTIES"]["HEADER_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"])>0):?> style="color: <?=$arItem["PROPERTIES"]["SUBTITLE_COLOR"]["VALUE"]?>;"<?endif;?>>
            
                <?if(!empty($tit)):?>
                    <?=htmlspecialcharsBack($title[0])?><span class="typed"></span><?=htmlspecialcharsBack($title[1])?>
                <?else:?>
                    <?=$arItem["PROPERTIES"]["SUBHEADER"]["~VALUE"]?>
                <?endif;?>
            
            </div>
            
            <?if(!empty($tit)):?>
            
                <?if($main_key == 0):?>
                
                    <script>
                        $(document).ready(function(){
                                                         
                            $("div#block<?=$arItem["ID"]?> div.descrip span.typed").typed({
                                strings: ["<?=implode('","', $tit)?>"],
                                typeSpeed: 50,
                                startDelay: 2000,
                                backDelay: 2000,
                            });

                        });
                    </script>
                
                <?else:?>
                
                    <script>
                        $(document).ready(function(){
                                                         
                            $(window).scroll(
                                function()
                                {
                                    
                                    if($(document).scrollTop() + $(window).height() > $("div#block<?=$arItem["ID"]?>").offset().top + 200)
                                    {
                                        $("div#block<?=$arItem["ID"]?> div.descrip span.typed").typed({
                                            strings: ["<?=implode('","', $tit)?>"],
                                            typeSpeed: 50,
                                            startDelay: 2000,
                                            backDelay: 2000,
                                        });
                                    }
                                    
                                }
                            );

                        });
                    </script>
                
                <?endif;?>
            
            <?endif;?>
            
            
        <?endif;?>
        
    </div>
    
    <?if(!$min):?>
        </div>
    <?endif;?>
    
</div>