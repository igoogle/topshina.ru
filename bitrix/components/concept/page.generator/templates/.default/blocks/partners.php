<?if(is_array($arItem["PROPERTIES"]["PARTNERS"]["VALUE"]) && !empty($arItem["PROPERTIES"]["PARTNERS"]["VALUE"])):?>

    <?
        $countPartners = count($arItem["PROPERTIES"]["PARTNERS"]["VALUE"]);

        $class = "";
        $offsetClass = "";

        if($countPartners <= 6)
        {

            if($countPartners <= 4)
                $class="col-md-3 col-sm-4 col-xs-6 big";
            
            else
                $class="col-md-2 col-sm-4 col-xs-6";
            

            $arNeed = array(
                "0.16" => array("OFFSET"=>"col-lg-offset-four col-md-offset-four col-sm-offset-four col-xs-offset-3"), 
                "0.33" => array("OFFSET"=>"col-md-offset-3 col-xs-offset-0"), 
                "0.5" =>  array("OFFSET"=>"col-lg-offset-one col-md-offset-one col-sm-offset-0 col-xs-offset-0"),
                "0.66" =>  array("OFFSET"=>""),
                "0.83" =>  array("OFFSET"=>"col-md-offset-1 col-xs-offset-0"));
    
            $residual = strval(floor(($countPartners / 6)*100)/100);
            $needKey = 1;
        }

        else
        {
            $class="col-md-2 col-sm-4 col-xs-6";

            $arNeed = array(
                "0.16" => array("OFFSET"=>"col-md-offset-5 col-sm-offset-0 col-xs-offset-3", "NUM" => 0), 
                "0.33" => array("OFFSET"=>"col-md-offset-4 col-xs-offset-0", "NUM" => 1), 
                "0.5" =>  array("OFFSET"=>"col-md-offset-3 col-xs-offset-0", "NUM" => 2),
                "0.66" =>  array("OFFSET"=>"col-md-offset-2 col-xs-offset-0", "NUM" => 3),
                "0.83" =>  array("OFFSET"=>"col-md-offset-1 col-xs-offset-0", "NUM" => 4));

    
            $residual = strval((floor(($countPartners / 6)*100)/100) - (intval($countPartners / 6))) ;
            $needKey = $countPartners - $arNeed[$residual]["NUM"];
        }

    ?>

    <div class="partners clearfix">

        <?foreach($arItem["PROPERTIES"]["PARTNERS"]["VALUE"] as $k => $arPartner):?>

            <div class="<?=$class?> <?if(($k+1) == $needKey):?> <?=$arNeed[$residual]["OFFSET"]?> <?endif;?>">

                <?if($countPartners <= 4):?>
                    <?$img = CFile::ResizeImageGet($arPartner, array('width'=>360, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                <?else:?>
                    <?$img = CFile::ResizeImageGet($arPartner, array('width'=>288, 'height'=>144), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                <?endif;?>

                <div class="partners-wrap">

                    <table>
                        <tr>
                            <td><img class="img-responsive <?if($arItem["PROPERTIES"]["PARTNERS_SHADOW"]["VALUE"] == "Y"):?>shadow<?endif;?> lazyload" data-src="<?=$img["src"]?>"></td>
                        </tr>
                    </table>

                    <?if(strlen($arItem["PROPERTIES"]["PARTNERS"]["DESCRIPTION"][$k]) > 0):?>

                        <div class="partners-part-bot hidden-sm hidden-xs">
                            <?=$arItem["PROPERTIES"]["PARTNERS"]["~DESCRIPTION"][$k]?>
                        </div>

                    <?endif;?>

                </div>
                
            </div>

            <?
                if(($k+1) % 2 == 0)
                    echo "<div class='clearfix visible-xs'></div>";
               
                if(($k+1) % 3 == 0)
                    echo "<div class='clearfix visible-sm'></div>";
             
                if(($k+1) % 6 == 0)
                    echo "<div class='clearfix'></div>";
            ?>

        <?endforeach;?>

    </div>

<?endif;?>