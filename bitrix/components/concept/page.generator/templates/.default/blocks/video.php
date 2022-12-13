<div class="video-block col-xs-12 clearfix <?=$arItem["PROPERTIES"]["VIDEO_BLOCK_COLOR"]["VALUE_XML_ID"]?>">

    <img class="lazyload img-for-lazyload video-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png">

    <?if(count($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]) <= 1):?>
    
        <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"][0]) > 0):?>

            <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0]) > 0)
                $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0], array('width'=>800, 'height'=>480), BX_RESIZE_IMAGE_PROPORTIONAL, false);
            ?>

            <div class="video-content lazyload" <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0]) > 0):?>data-src="<?=$img["src"]?>"<?endif;?>>
            
                <?$iframe = ChamDB::createVideo($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"][0]);?>

                <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][0])<=0):?>

                    <div class="iframe-video-area" data-src="<?=htmlspecialcharsbx($iframe["HTML"])?>"></div>

                <?else:?>
                    <a class="call-modal callvideo big-play" data-call-modal="<?=$iframe["ID"]?>"></a>
                <?endif;?>
                
            </div>

            <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][0])>0):?>
                <div class="desc-one"><?=$arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][0]?></div>
            <?endif;?>
        
        <?endif;?>
        
    <?else:?>

        <?
            $countVideo = count($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]);
            $class="";
            $offsetClass = "";

            if($countVideo == 2)
            {
                $offsetClass = 'col-lg-offset-1 col-xs-offset-0';
                $class="col-lg-5 col-sm-6 col-xs-12";
            }

            else
            {

                $arNeed = array(
                    "0.25" => array("OFFSET"=>"col-lg-offset-four col-md-offset-four col-sm-offset-one", "NUM" => 0), 
                    "0.5" => array("OFFSET"=>"col-sm-offset-3 col-xs-offset-0", "NUM" => 1), 
                    "0.75" =>  array("OFFSET"=>"col-lg-offset-one col-md-offset-one col-sm-offset-2 col-xs-offset-0", "NUM" => 2));

                $residual = $countVideo / 4;

                if($countVideo > 4)
                {
                    $residual = $residual - floor($residual);
                }
                $residual = strval($residual);
                $needKey = $countVideo - $arNeed[$residual]["NUM"];

                $class="col-sm-3 col-xs-12";

            }
        ?>



        <?if(is_array($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"]) && !empty($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"])):?>
            <div class="row ">
                
                <div class="video-gallery-wrap <?if($countVideo == 2):?>two-video<?endif;?> clearfix">

                <?foreach($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["VALUE"] as $k=>$arVideo):?>

                    <?
                        if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k])>0)
                        {
                            if($countVideo == 2)
                                $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k], array('width'=>460, 'height'=>260), BX_RESIZE_IMAGE_EXACT, false); 
                            
                            else
                                $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["VIDEO_BLOCK_PICTURES"]["VALUE"][$k], array('width'=>300, 'height'=>150), BX_RESIZE_IMAGE_EXACT, false); 
                        }

                        else
                            $img["src"] = SITE_TEMPLATE_PATH."/images/video-pic.jpg";
                    ?>

                    <div class="video-gallery <?=$class?><?if($k == 0):?> <?=$offsetClass?><?endif;?><?if(($k+1) == $needKey):?> <?=$arNeed[$residual]["OFFSET"]?><?endif;?>">
                        <div class="video-gallery-element">

                        <?$iframe = ChamDB::createVideo($arVideo);?>  
                            <table class="videoimage-wrap" style='background-image: url(<?=$img["src"]?>);'>
                                <tr>
                                    <td>
                                        <a class="call-modal callvideo" data-call-modal="<?=$iframe["ID"]?>">       
                                            <div class="play"></div>
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <?if(strlen($arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][$k])>0):?>
                                <div class="desc"><?=$arItem["PROPERTIES"]["VIDEO_BLOCK_CODE"]["DESCRIPTION"][$k]?></div>
                            <?endif;?>
                        </div>

                    </div>  

                    <?if(($k+1) % 4 == 0):?>
                        <div class="clearfix"></div>    
                    <?endif;?>

                <?endforeach;?>

                </div>
            </div>
        <?endif;?>

    <?endif;?>

    <?if(strlen($arItem["DETAIL_TEXT"]) > 0):?>

        <div class="text text-content">
            <?=$arItem["~DETAIL_TEXT"]?>
        </div>

    <?endif;?>

</div>