<div class="form-block <?if($arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"] == "bottom"):?> un-margin-bottom<?endif;?>">
    <div class="form-table">

        <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>

            <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?> 
            
                    <div class="form-cell image-part z-image left <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "right"):?> hidden-lg hidden-md <?endif;?> hidden-sm hidden-xs <?=$arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                    
                        <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) || !empty($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["VALUE"])):?>

                            <div class="text-wrap <?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>">
                                <?if($arItem["PROPERTIES"]["FORM_UPLINE"]["VALUE"] == 'Y'):?><div class="line main-color"></div><?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0):?><div class="form-text-title bold"><?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]?></div><?endif;?>

                                <?if(!empty($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["VALUE"])):?><div class="form-text-under-title italic"><?=$arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']?></div><?endif;?>

                            </div>

                        <?endif;?>

                        <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0):?>
                    
                            <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"], array('width'=>700, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                        
                            <img class="img-responsive hidden-xs lazyload" data-src="<?=$img["src"]?>" alt="<?=$arItem["PROPERTIES"]["FORM_IMAGE"]["DESCRIPTION"]?>"/>

                        <?endif;?>
                    
                    </div>
            <?endif;?>
            
        <?endif;?>

        <div class="form-cell text-part z-text" style="<?=$style2?>">
            <div class="">
                
                <?
                    
                    $timer_on = false;

                    if($arItem["PROPERTIES"]["FORM_TIMER_ON"]["VALUE"] == 'Y')
                        $timer_on = true;

                    if($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "")
                        $arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] = "light";

                    $style = '';

                    if(strlen($arItem["PROPERTIES"]["FORM_BGC"]["VALUE"]))
                        $style .= 'background-color:'.$arItem["PROPERTIES"]["FORM_BGC"]["VALUE"].';';

                    /*if(strlen($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"])>0)
                    {
                        $img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"], array('width'=>700, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, false);
                        $style .= 'background-image: url('.$img["src"].');';
                    }*/

                    if($arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] == "")
                        $arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] = "dark";
                ?>

                <form id = "form-<?=$arItem["ID"]?>" action="/" class="form-<?=$arItem["ID"]?> form send <?=$arItem["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"]?> <?if($timer_on):?>timer_form<?endif;?> lazyload" enctype="multipart/form-data" method="post" role="form" <?if($style):?>style='<?=$style?>'<?endif;?>

                    <?if(strlen($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"])>0):?>
                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_BACKGROUND"]["VALUE"], array('width'=>700, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                        data-src = "<?=$img["src"]?>"
                    <?endif;?>

                >

                    <input name="section" type="hidden" value="<?=$arSection["ID"]?>">
                    <input name="element" type="hidden" value="<?=$arItem["ID"]?>">
                    <input name="site_id" type="hidden" value="<?=SITE_ID?>">
                    <input name="url" type="hidden" value="">
                    <input name="header" type="hidden" value="<?=$block_name?>">
                    

                    <input name="important_id" type="hidden" value="access">

                    <table class="wrap-act">
                        <tr>
                            <td>

                                <div class="col-xs-12 questions active">

                                    <?if(strlen($arItem["PROPERTIES"]["FORM_TITLE"]["VALUE"]) > 0):?>

                                        <div class="title main1">
                                            <?=$arItem["PROPERTIES"]["FORM_TITLE"]["~VALUE"]?>
                                        </div>

                                    <?endif;?>

                                    <?if(strlen($arItem["PROPERTIES"]["FORM_SUBTITLE"]["VALUE"]) > 0):?>

                                        <div class="subtitle">
                                            <?=$arItem["PROPERTIES"]["FORM_SUBTITLE"]["~VALUE"]?>
                                        </div>

                                    <?endif;?>

                                    <?if($timer_on):?>
                                        <input type="hidden" class="timerVal" value="<?=$arItem["PROPERTIES"]["FORM_TIMER_SHOW"]["VALUE"]?>">
                                        <input type="hidden" class="forCookieTime" value="<?=$arItem["PROPERTIES"]["FORM_TIMER_HIDE"]["VALUE"]?>">
                                        <input type="hidden" class="idSect" value="<?=$arSection["ID"]?>">
                                       

                                        <div class="hameltimer">

                                        <div class="numbers bold">
                                            <div class="timer-part timer_left">
                                                <span class='t-top'>{hnn}</span>
                                                <span class='t-bot'>{hl}</span>
                                            </div>
                                            <div class="sep">:</div>
                                            <div class="timer-part timer_center">
                                                <span class='t-top'>{mnn}</span>
                                                <span class='t-bot'>{ml}</span>
                                            </div>
                                            <div class="sep">:</div>
                                            <div class="timer-part timer_right">
                                                <span class='t-top'>{snn}</span>
                                                <span class='t-bot'>{sl}</span>
                                            </div>
                                        </div>
                                    

                                        </div>

                                    <?endif;?>


                                    <div class="row">

                                        <div class="main-inuts">
                                            <div class="col-xs-12">
                                                <div class="input">
                                                    <div class="bg"></div>
                                                    <span class="desc">Name</span>
                                                    <input class='focus-anim input-name' name="name" type="text">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="input">
                                                    <div class="bg"></div>
                                                    <span class="desc">Email</span>
                                                    <input class='focus-anim input-name' name="email" type="email">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="input">
                                                    <div class="bg"></div>
                                                    <span class="desc">Phone</span>
                                                    <input class='focus-anim input-name' name="phone" type="tel">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <?if($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "light" || $arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == ""):?>
                                            

                                            <?if($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" || $arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check"):?>

                                                <div class="col-xs-12">

                                                    <?if(strlen($arItem["PROPERTIES"]["FORM_LIST_TITLE"]["VALUE"]) > 0):?>

                                                        <div class="name-tit bold">
                                                            <?=$arItem["PROPERTIES"]["FORM_LIST_TITLE"]["~VALUE"]?>
                                                        </div>

                                                    <?endif;?>

                                                     <?if($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" && is_array($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>

                                                            <ul class="form-radio">

                                                                <?foreach($arItem["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k=>$arElement):?>

                                                                    <li>

                                                                        <label>

                                                                            <input <?if($k == 0):?>checked <?endif;?> name='radiobutton<?=$arItem["ID"]?>' type="radio" value="<?=$arElement?>"><span></span><?=$arElement?>

                                                                        </label>
                                                                    </li>

                                                                <?endforeach;?>

                                                            </ul>

                                                     <?elseif ($arItem["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check" && is_array($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arItem["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>

                                                         <ul class="form-check">

                                                            <?foreach($arItem["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k => $arElement):?>

                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" name="checkbox<?=$arItem["ID"]?>[]" value="<?=$arElement?>">
                                                                        <span></span>                                                                          
                                                                        <span class="text"><?=$arElement?></span>
                                                                    </label>
                                                                </li>

                                                            <?endforeach;?>
                         
                                                        </ul>

                                                    <?endif;?>

                                                    

                                                </div>

                                            <?endif;?>

                                            <?if(is_array($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"])):?>

                                             

                                                <?foreach($arItem["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"] as $k=>$arInput):?>

                                                    <?if($arInput == "name"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input">
                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_NAME")?></span>
                                                                <input class='focus-anim <?if(in_array("name", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="bx-name" type="text">
                                                                
                                                            </div>
                                                        </div>
                                                    <?endif;?>

                                                    <?if($arInput == "phone"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input">

                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_PHONE")?></span>

                                                                <input class="phone focus-anim <?if(in_array("phone", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="bx-phone" type="text">
                                                            </div>
                                                        </div>
                                                    <?endif;?>

                                                    <?if($arInput == "email"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input">
                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage('PAGE_GEN_FORM_EMAIL')?></span>
                                                                <input class="focus-anim email <?if(in_array("email", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="bx-email" type="email">
                                                                
                                                            </div>
                                                        </div>
                                                    <?endif;?>


                                                    <?if($arInput == "count"):?>

                                                        <div class="col-xs-12">
                                                            <div class="input count <?if(in_array("count", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_COUNT")?></span>
                                                                <input class='focus-anim <?if(in_array("count", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="count" type="text"> <span class="plus"></span> <span class="minus"></span>
                                                            </div>
                                                        </div>

                                                    <?endif;?>


                                                    <?if($arInput == "date"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input date-wrap <?if(in_array("date", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_DATE")?></span>

                                                                <input class="date focus-anim <?if(in_array("date", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="date" type="text">
                                                            </div>
                                                        </div>
                                                    <?endif;?>

                                                    <?if($arInput == "address"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input input-textarea">

                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_ADDRESS")?></span>
                                                                <textarea class='focus-anim <?if(in_array("address", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="address"></textarea>
                                                            </div>
                                                        </div>
                                                    <?endif;?>

                                                    <?if($arInput == "textarea"):?>
                                                        <div class="col-xs-12">
                                                            <div class="input input-textarea">
                                                                <div class="bg"></div>
                                                                <span class="desc"><?=GetMessage("PAGE_GEN_FORM_TEXTAREA")?></span>
                                                                <textarea class='focus-anim <?if(in_array("textarea", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>' name="text"></textarea>
                                                            </div>
                                                        </div>
                                                    <?endif;?>


                                                    <?if($arInput == "file"):?>

                                                        <div class="col-xs-12">
                                                            <div class="load-file">
                                                                <label class="area-file">

                                                                    <div class="area-files-name">
                                                                        <span><?=GetMessage("PAGE_GEN_FORM_FILE")?></span>
                                                                    </div>

                                                  <input class="hidden <?if(in_array("file", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>" name="userfile[]" type="file" multiple="">

                                                                <?if(!empty($arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>

                                                                    <?if(in_array("file", $arItem["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?><span class="star-req"></span><?endif;?>

                                                                <?endif;?>

                                                                </label>
                                                            </div>
                                                        </div>

                                                    <?endif;?>

                                                <?endforeach;?>

                                            <?endif;?>
                        
                                        <?elseif($arItem["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "professional"):?>

                                            <?if(!empty($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"]) && is_array($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"])):?>
                                        
                                                <?foreach($arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"] as $key=>$arValue):?>
                                                    
                                                    <?if(strlen($arValue) > 0):?>
                                                        
                                                        <?$type = $arItem["PROPERTIES"]["FORM_PROP_INPUTS"]["DESCRIPTION"][$key];?>
                                                        
                                                        <?$type = explode(";", ToLower($type));?>

                                                        <?if(!empty($type) && is_array($type)):?>
                                                        
                                                            <?foreach($type as $k=>$val):?>
                                                                <?$type[$k] = trim($val);?>
                                                            <?endforeach;?>

                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "text"):?>
                                                            
                                                            <div class="col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text" />
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "textarea"):?>
                                                            
                                                            <div class="col-xs-12">
                                                                <div class="input input-textarea">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <textarea class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>"></textarea>
                                                                </div>
                                                            </div>

                                                        <?endif;?>

                                                        <?if($type[0] == "name"):?>
                                                        
                                                            <div class="col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?>' name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text" />
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "email"):?>
                                                        
                                                            <div class="col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="focus-anim email <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="email">
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "phone"):?>
                                                               
                                                            <div class="col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="phone focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text">
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "count"):?>
                                                                                                                     
                                                            <div class="col-xs-12">
                                                                <div class="input count <?if($type[1] == "y"):?>require<?endif;?>">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text"> <span class="plus"></span> <span class="minus"></span>
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "date"):?>
                                                        
                                                            <div class="col-xs-12">
                                                                <div class="input date-wrap <?if($type[1] == "y"):?>require<?endif;?>">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="date focus-anim <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arItem["ID"]?>_<?=$key?>" type="text">
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "password"):?>
                                                        
                                                            <div class="col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?>" name="input_<?=$arItem["ID"]?>_<?=$key?>" type="password">
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "file"):?>

                                                            <div class="col-xs-12">
                                                                <div class="load-file">
                                                                    <label class="area-file">

                                                                        <div class="area-files-name">
                                                                            <span><?=$arValue?></span>
                                                                        </div>

                                                                    <input class="hidden <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arItem["ID"]?>_<?=$key?>[]" type="file" multiple="">

                                                                    <?if($type[1] == "y"):?><span class="star-req"></span><?endif;?>

                                                                    </label>
                                                                </div>
                                                            </div>

                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "radio"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-xs-12">
                                                            
                                                                <?if(strlen($tit) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit?></div>
                                                                <?endif;?>

                                                                <ul class="form-radio">
                                                                
                                                                    <?$c = 0;?>

                                                                    <?if(!empty($list) && is_array($list)):?>

                                                                        <?foreach($list as $arElement):?>

                                                                            <li>

                                                                                <label>

                                                                                    <input <?if($c == 0):?>checked <?endif;?> name='input_<?=$arItem["ID"]?>_<?=$key?>' type="radio" value="<?=$arElement?>"><span></span><?=$arElement?>

                                                                                </label>
                                                                            </li>
                                                                            
                                                                            <?$c++;?>

                                                                        <?endforeach;?>

                                                                    <?endif;?>

                                                                </ul>

                                                            </div>
                                                        
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "checkbox"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit1 = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-xs-12">
                                                            
                                                                <?if(strlen($tit1) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit1?></div>
                                                                <?endif;?>

                                                                <ul class="form-check">

                                                                    <?if(!empty($list) && is_array($list)):?>
                                                                
                                                                        <?foreach($list as $arElement):?>

                                                                            <li>

                                                                                <label>

                                                                                    <input name='input_<?=$arItem["ID"]?>_<?=$key?>[]' type="checkbox" value="<?=$arElement?>"><span></span><span class="text"><?=$arElement?></span>

                                                                                </label>
                                                                            </li>
                                                                            
                                                                        <?endforeach;?>

                                                                    <?endif;?>

                                                                </ul>

                                                            </div>
                                                        
                                                        <?endif;?>

                                                        <?if($type[0] == "select"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit2 = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-xs-12">

                                                                <?if(strlen($tit2) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit2?></div>
                                                                <?endif;?>

                                                                <div class="input">
                                                            
                                                                    <div class="form-select">
                                                                        <div class="ar-down"></div>
                                                                        
                                                                        <div class="select-list-choose first"><span class="list-area"><?=GetMessage("PAGE_GEN_FORM_SELECT");?></span></div>

                                                                        <div class="select-list">

                                                                            <?if(!empty($list) && is_array($list)):?>
                                                                            <?foreach($list as $arElement):?>
                                                                                <label>
                                                                                    <span class="name">
                                                                                        
                                                                                        <input class="opinion" type="radio" name='input_<?=$arItem["ID"]?>_<?=$key?>' value="<?=$arElement?>">
                                                                                        <span class="text"><?=$arElement?></span>
                                                                                        
                                                                                    </span>
                                                                                </label>
                                                                            <?endforeach;?>

                                                                            <?endif;?>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                             
                                                            </div>
                                                        
                                                        <?endif;?>

                                                    <?endif;?>
                                                        
                                                    
                                                        
                                                <?endforeach;;?>

                                            <?endif;?>
                                        
                                                                                                            
                                        <?endif;?>


                                        <div class="col-xs-12">
                                            <div class="input-btn">
                                                <div class="load">
                                                    <div class="xLoader form-preload"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                                </div>

                                                <?
                                                    $btn_name = GetMessage("PAGE_GEN_FORM_SUBMIT");

                                                    if(strlen($arItem['PROPERTIES']['FORM_BUTTON']['VALUE']) > 0)
                                                        $btn_name = $arItem['PROPERTIES']['FORM_BUTTON']['~VALUE'];

                                                    $b_options = array(
                                                        "MAIN_COLOR" => "primary",
                                                        "STYLE" => ""
                                                    );

                                                    if(strlen($arItem["PROPERTIES"]["FORM_BUTTON_BG_COLOR"]["VALUE"]))
                                                    {

                                                        $b_options = array(
                                                            "MAIN_COLOR" => "btn-bgcolor-custom",
                                                            "STYLE" => "background-color: ".$arItem["PROPERTIES"]["FORM_BUTTON_BG_COLOR"]["VALUE"].";"
                                                        );

                                                    }
                                                ?>

                                                <button 
                                                    type="button"
                                                    class="
                                                        btn-submit
                                                        button-def
                                                        <?=$b_options["MAIN_COLOR"]?>
                                                        big
                                                        active
                                                        <?=$Landing["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>"

                                                    name="form-submit" 
                                                    
                                                    <?if(strlen($b_options["STYLE"])):?>
                                                        style = "<?=$b_options["STYLE"]?>"
                                                    <?endif;?>

                                                    <?if(strlen($arItem["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]) > 0):?> 
                                                        data-link='<?=$arItem["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]?>'
                                                    <?endif;?>>

                                                    <?=$btn_name?>
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <?if(!empty($arSection["AGREEMENTS"])):?>

                                        <?$cAgr = count($arSection["AGREEMENTS"]);?>

                                        <div class="wrap-agree">

                                            <label>
                                                <input type="checkbox" name="checkboxAgree" value="agree" <?if($arSection["UF_CHAM_AGREEMENTS_Y"]):?> checked<?endif;?>>
                                                <span></span>   
                                            </label>   

                                            <div class="wrap-desc">                                                                    
                                                <span class="text"><?if(strlen($arSection["UF_CHAM_AGREE_TEXT"])>0):?><?=$arSection["~UF_CHAM_AGREE_TEXT"]?><?else:?><?=GetMessage("PAGE_GEN_FORM_AGREEMENT")?><?endif;?> </span>
                                            
                                                <?foreach($arSection["AGREEMENTS"] as $countAg => $arAgreement):?>
                                                    <a class="call-modal callagreement" data-call-modal="agreement<?=$arAgreement["ID"]?>"><?if(strlen($arAgreement["PROPERTIES"]['CASE_TEXT']['VALUE'])>0):?><?=$arAgreement["PROPERTIES"]['CASE_TEXT']['~VALUE']?><?else:?><?=$arAgreement['~NAME']?><?endif;?></a><?if(($countAg+1) != $cAgr):?><span>, </span><?endif;?> 
                                                <?endforeach;?>
                                            </div>

                                        </div>
                                    <?endif;?>
                                </div>

                                <div class="col-xs-12 thank">
                                    <?if(!empty($arItem['PROPERTIES']['FORM_THANKS']['VALUE'])):?>
                                        <?=$arItem['PROPERTIES']['FORM_THANKS']['~VALUE']["TEXT"]?>
                                    <?else:?>
                                        <?=GetMessage("PAGE_GEN_FORM_THANK")?>
                                    <?endif;?>
                                </div>

                                <?if($timer_on):?>
                                    <div class="col-xs-12 timeout_text">
                                        <?if(!empty($arItem['PROPERTIES']['FORM_TIMER_TEXT']['VALUE'])):?>
                                            <?=$arItem['PROPERTIES']['FORM_TIMER_TEXT']['~VALUE']['TEXT']?>
                                        <?else:?>
                                            <?=GetMessage("PAGE_GEN_FORM_TIMEOUT")?>
                                        <?endif;?>
                                    </div>
                                <?endif;?>
                                
                            </td>
                        </tr>
                    </table>
                    
                    <div class="clearfix">
                    </div>
                </form>

            </div>

        </div>

        <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']) > 0 ):?>
        
            <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "right"):?> 
        
                <div class="form-cell image-part z-image right <?if($arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "" || $arItem["PROPERTIES"]["FORM_IMAGE_BLOCK_POSITION"]["VALUE_XML_ID"] == "left"):?> hidden-lg hidden-md <?endif;?> <?=$arItem["PROPERTIES"]["FORM_IMAGE_POSITION"]["VALUE_XML_ID"]?>">
                
                
                    <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]) || !empty($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"])):?>

                        <div class="text-wrap <?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>">
                        
                            <?if($arItem["PROPERTIES"]["FORM_UPLINE"]["VALUE"] == 'Y'):?>
                                <div class="line main-color"></div>
                            <?endif;?>

                            <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"])> 0):?>
                                <div class="form-text-title bold"><?=$arItem["PROPERTIES"]["FORM_TEXT_TITLE"]["~VALUE"]?></div>
                            <?endif;?>

                            <?if(strlen($arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT'])> 0):?>
                                <div class="form-text-under-title italic"><?=$arItem["PROPERTIES"]["FORM_TEXT_UNDER_TITLE"]["~VALUE"]['TEXT']?></div>
                            <?endif;?>

                        </div>

                    <?endif;?>

                    <?if($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"] > 0):?>
                
                        <?$img = CFile::ResizeImageGet($arItem["PROPERTIES"]["FORM_IMAGE"]["VALUE"], array('width'=>700, 'height'=>1500), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                    
                        <img class="img-responsive hidden-xs lazyload" data-src="<?=$img["src"]?>" alt="<?=$arItem["PROPERTIES"]["FORM_IMAGE"]["DESCRIPTION"]?>"/>

                    <?endif;?>
                
                </div>

            <?endif;?>
            
        <?endif;?>

    </div>
    
</div>