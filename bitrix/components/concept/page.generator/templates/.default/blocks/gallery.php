<?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "slider"):?>

    <?
        $arWaterMark = Array();

        if($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"] > 0){

            $arWaterMark = Array(
                array(
                    "name" => "watermark",
                    "position" => "center",
                    "type" => "image",
                    "size" => "big",
                    "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"]), 
                    "fill" => "exact",
                )
            );
        }
    ?>

    <div class="col-xs-12 img-for-lazyload-parent">
        <img class="lazyload img-for-lazyload slider-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">
        <?
            $count_slide = 1;

            if($arItem["PROPERTIES"]["GALLERY_PICS_IN_SLIDE"]["VALUE"] > 0)
            {
                $count_slide = $arItem["PROPERTIES"]["GALLERY_PICS_IN_SLIDE"]["VALUE"];

                if($count_slide < 1)
                    $count_slide = 1;

                if($count_slide > 6)
                    $count_slide = 6;
            }
                
        ?>
        <div class="slider-gallery clearfix <?if($count_slide > 1):?>over-one<?endif;?> slider-gallery-<?=$count_slide?> parent-slider-item-js" data-slide-visible = "<?=$count_slide?>">

            <?foreach($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $k=>$photo):?>

                <div class="slide-style <?if($k!=0) echo 'noactive-slide-lazyload';?>">

                    <div class="wrap-slide">
                    
                        <table>
                            <tr>
                                <td>
                                    <?
                                        $img = CFile::ResizeImageGet($photo, array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, $img_quality);
                                        $img_big = CFile::ResizeImageGet($photo, array('width'=>2000, 'height'=>2000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, $img_quality);
                                    ?>

                                    <a href="<?=$img_big["src"]?>" title="<?=Chameleon::prepareText($arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k])?>" data-gallery="gal<?=$arItem['ID']?>" class="cursor-loop">
                                        <div class="slide-element lazyload" data-src="<?=$img["src"]?>"></div>
                                    </a>                                                            
                                </td>
                            </tr>
                        </table>
                        
                        <?if($arItem["GALLERY_COUNT_DESC"] && $count_slide == 1):?>
                            <div class="desc"><?=$arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]?></div>
                        <?endif;?>

                    </div>

                    
                </div>

            <?endforeach;?>
            
        </div>

        <img class="lazyload img-for-lazyload slider-finish" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png" data-id="<?=$arItem["ID"]?>">

    </div>
    <div class="clearfix"></div>

<?else:?>

    <?
        $arWaterMark = Array();

        if($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"] > 0){

            $arWaterMark = Array(
                array(
                    "name" => "watermark",
                    "position" => "center",
                    "type" => "image",
                    "size" => "real",
                    "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arItem["PROPERTIES"]["GALLERY_WATERMARK"]["VALUE"]), 
                    "fill" => "exact",
                )
            );
        }                                 
    ?>

    <div class="gallery-block clearfix <?if($arItem["PROPERTIES"]["GALLERY_BORDER"]["VALUE"] == "Y"):?>border-img-on<?endif;?> <?=$arItem["PROPERTIES"]["GALLERY_DESK_COLOR"]["VALUE_XML_ID"]?> <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?>nogallery<?endif;?>">
        
            
        <?if(is_array($arItem["PROPERTIES"]["GALLERY"]["VALUE"]) && !empty($arItem["PROPERTIES"]["GALLERY"]["VALUE"])):?>

            <? 
                $arSize = Array();

                $arSize[3] = array('width'=>400, 'height'=>400);
                $arSize[4] = array('width'=>300, 'height'=>300);
                $arSize[6] = array('width'=>200, 'height'=>200);

                $arStyle = Array();

                $arStyle[3] = 'big';
                $arStyle[4] = 'middle';
                $arStyle[6] = 'small';

                $class = "";
                $str = 1;
                $rows = 0;

            ?>

            

            <?foreach($arItem["PROPERTIES"]["GALLERY"]["VALUE"] as $k=>$photo):?>

                <?if($photo <= 0) continue;?>

                <?$rows++;?>  

                <?$class = 12 / $arItem["GALLERY_COUNT"][$str];?>
                   
                <div class="col-lg-<?=$class?> col-md-<?=$class?> col-sm-<?=$class?> <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?> col-xs-6 <?else:?> col-xs-4<?endif;?> <?=$arStyle[$arItem["GALLERY_COUNT"][$str]]?>">
                    
                    <?
                        $img_big = CFile::ResizeImageGet($photo, array('width'=>1600, 'height'=>1200), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arWaterMark);
                        if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery")
                            $img = CFile::ResizeImageGet($photo, $arSize[$arItem["GALLERY_COUNT"][$str]], BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, false, false, $img_quality);
                        else
                            $img = CFile::ResizeImageGet($photo, $arSize[$arItem["GALLERY_COUNT"][$str]], BX_RESIZE_IMAGE_EXACT, false, false, false, $img_quality);
                    ?>

                    <div class="gallery-img">

                        <a title="<?=Chameleon::prepareText($arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k])?>" href="<?=$img_big["src"]?>" data-gallery="gal<?=$arItem['ID']?>" class="cursor-loop">

                            <?if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery"):?>

                                <table>
                                    <tr>
                                        <td>
                                            <div class="gallery-img-wrap">
                                                <div class="corner-line mainColor"></div>
                                                <img class="img-responsive center-block lazyload" data-src="<?=$img["src"]?>" alt="<?=$arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]?>"/>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <?if(strlen($arItem["PROPERTIES"]["GALLERY"]["DESCRIPTION"][$k]) > 0 ):?>
                                    <div class="text-img">
                                        <?=$arItem["PROPERTIES"]["GALLERY"]["~DESCRIPTION"][$k]?>
                                    </div>
                                <?endif;?>

                            <?else:?>

                                <div class="corner-line mainColor"></div>
                                <img class="img-responsive center-block lazyload" data-src="<?=$img["src"]?>" alt=""/>

                            <?endif;?>
                            
                        </a>

                    </div>

                </div> 

                <?

                    if($arItem["PROPERTIES"]["GALLERY_VIEW"]["VALUE_XML_ID"] == "nogallery")
                    {
                        if(($k+1)%2==0)
                            echo "<span class='clearfix visible-xs'></span>";
                    }
                    else
                    {
                        if(($k+1)%3==0)
                            echo "<span class='clearfix visible-xs'></span>";
                    }

                    if($rows >= $arItem["GALLERY_COUNT"][$str])
                    {
                        $rows = 0;
                        $str++;

                        if($str>4) $str=4;

                        echo "<span class='clearfix hidden-xs'></span>";
                    }
                ?>
                                            
            <?endforeach;?>

        <?endif;?>
                
    </div>

<?endif;?>