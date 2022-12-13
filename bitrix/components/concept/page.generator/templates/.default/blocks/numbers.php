<div class="info-num col-xs-12 clearfix <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>parent-animate<?endif;?>">
    <div class="row">

        <?
            $class = "";
            $class2 = "";

            $count = count($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"]);
            
            if($count <= 3)
                $class = "col-sm-4 col-xs-12";
            else
                $class = "col-md-3 col-sm-6 col-xs-12 four-elements";
    
            if($count == 1)
                $class2 = "col-sm-offset-4 col-xs-offset-0";

            elseif($count == 2)
                $class2 = "col-md-offset-2 col-sm-offset-0 col-xs-offset-0";
        ?>


        <?if(is_array($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"]) && !empty($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["VALUE"])):?>
                                                   
            <?foreach($arItem["PROPERTIES"]["NUMBERS_TEXTS"]["~VALUE"] as $k => $arValue):?>
                    
                <div class="info-num-element no-margin-top-bot <?=$class?> <?if($k==0):?><?=$class2?><?endif;?> <?=$arItem["PROPERTIES"]["NUMBERS_TEXTS_COLOR"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?>child-animate opacity-zero<?endif;?>" >
                    <?if($arItem["STRING_NUM"] > 0):?>

                        <div class="title main1" <?if(strlen($arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"]) > 0):?> style="font-size: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"]?>px; line-height: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"] + 3?>px; min-height: <?=$arItem["PROPERTIES"]["NUMBERS_FONT_SIZE"]["VALUE"] + 3?>px "<?endif;?>>
                            <?=$arValue?>
                        </div>

                    <?endif;?>


                    <div class="text">
                        <?=$arItem["PROPERTIES"]["NUMBERS_TEXTS"]["~DESCRIPTION"][$k]?>
                    </div>
                </div>

                <?
                    if($count <= 3)
                    {
                        if(($k+1)%3 == 0)
                            echo "<span class='clearfix visible-lg visible-md visible-sm'></span>";
                    }

                    else
                    {
                        if(($k+1)%2 == 0)
                            echo "<span class='clearfix visible-sm'></span>";

                        if(($k+1)%4 == 0)
                            echo "<span class='clearfix visible-lg visible-md'></span>";
                    }
                ?>
          
            <?endforeach;?>

        <?endif;?>

    </div>
</div>