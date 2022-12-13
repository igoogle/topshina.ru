<?
// SEO
    global $HAMELEON_TEMPLATE_ARRAY;

    if(Bitrix\Main\Loader::includeModule("concept.hameleon"))
    {
        ChamDB::getIblockIDs(array("CODES"=> array("concept_hameleon_site")));

        $arResult["SECTION"]=array();

        $arSelect = array("IBLOCK_ID", "ID", "NAME", "IBLOCK_SECTION_ID", "UF_CHAM_META_TAGS", "UF_CHAM_NOINDEX", "UF_CHAM_OG_TITLE", "UF_CHAM_OG_DESC", "UF_CHAM_OG_IMAGE");

        $arFilter = Array('IBLOCK_ID' => $HAMELEON_TEMPLATE_ARRAY['CONSTRUCTOR']["IBLOCK_ID"], "ID"=>$GLOBALS["CURRENT_SECTION_ID"]);
        $dbResSect = CIBlockSection::GetList(Array("sort"=>"asc"), $arFilter, false, $arSelect);
        
        $arResult["SECTION"] = $dbResSect->GetNext();



        if(!empty($arResult["SECTION"]))
        {

        	$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
			    $arResult["SECTION"]["IBLOCK_ID"],
			    $arResult["SECTION"]["ID"]
			    );
			     
		    $arResult["SECTION"]["IPROPERTY_VALUES"] = $ipropValues->getValues();

        	if($arResult["SECTION"]["UF_CHAM_OG_IMAGE"] > 0)
			{
			    $rsFile = CFile::GetByID($arResult["SECTION"]["UF_CHAM_OG_IMAGE"]);
			    $arFile = $rsFile->Fetch();
			    
			    $arResult["SECTION"]["OG_IMAGE"] = $arFile["ORIGINAL_NAME"];
			}

            $h1 = $GLOBALS["h1_main"];
            $points = 0;


            
            if($arResult["SECTION"]["UF_CHAM_NOINDEX"])
            {
                $arMess = Array();
                
                $arMess["class"] = "bad";
                $arMess["TEXT"] = "HAMELEON_SEO_NOINDEX_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            
            
            
            //title
            $title = $arResult["SECTION"]["NAME"];
                                                                
            if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
                $title = $arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_TITLE"];
                
                
            if(strlen($title) > 0)
            {
                $points += 40;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE1_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
     
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "bad";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE1_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
                
            }
            
            
            if(strlen($title) > 0 && strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
            {
                $points += 5;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE2_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE2_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
            }
            
            if(strlen($title) > 0 && strlen($title) <= 70)
            {
                $points += 3;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE3_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
     
            }
            elseif(strlen($title) > 0 && strlen($title) > 70)
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_TITLE3_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_TITLE_MESSAGE"][] = $arMess;
            }
            
            
            
            
            //description
            if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) > 0)
            {
                $points += 15;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION1_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $points += 2;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION2_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                    
                    
                if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) <= 200)
                {
                    $points += 2;
                
                    $arMess = Array();
                    
                    $arMess["class"] = "good";
                    $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION3_GOOD";
                    
                    $arResult["SEO_MESSAGE"][] = $arMess;
                }
                else
                {
                    $arMess = Array();
                
                    $arMess["class"] = "notbad";
                    $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION3_BAD";
                    
                    $arResult["SEO_MESSAGE"][] = $arMess;
                    
                    $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
                }
                
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "bad";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION1_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
            }
            
            if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]) > 0 && $arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"] != $title)
            {
                $points += 10;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION4_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "bad";
                $arMess["TEXT"] = "HAMELEON_SEO_DESCRIPTION4_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_DESCRIPTION_MESSAGE"][] = $arMess;
            }
            
            //keywords
            if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_KEYWORDS"]) > 0)
            {
                $points += 2;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_KEYWORDS1_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_KEYWORDS1_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
                
                $arResult["SEO_KEYWORDS_MESSAGE"][] = $arMess;
            }
            
            
        
            //h1
            if($h1 == 1)
            {
                $points += 15;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_H1_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "bad";
                $arMess["TEXT"] = "HAMELEON_SEO_H1_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            
            
            //og
            if(strlen($arResult["SECTION"]["UF_CHAM_OG_TITLE"]) > 0)
            {
                $points += 2;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_TITLE_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_TITLE_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            
            if(strlen($arResult["SECTION"]["UF_CHAM_OG_DESC"]) > 0)
            {
                $points += 2;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_DESCRIPTION_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_DESCRIPTION_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }


            
            if($arResult["SECTION"]["UF_CHAM_OG_IMAGE"] > 0)
            {
                $points += 2;
                
                $arMess = Array();
                
                $arMess["class"] = "good";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_IMAGE_GOOD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            else
            {
                $arMess = Array();
                
                $arMess["class"] = "notbad";
                $arMess["TEXT"] = "HAMELEON_SEO_OG_IMAGE_BAD";
                
                $arResult["SEO_MESSAGE"][] = $arMess;
            }
            
            
            
            
            if($arResult["SECTION"]["UF_CHAM_NOINDEX"])
                $points = 0;
            
            
            $arResult["SEO_POINTS"] = $points;
            
            if($points <= 50)
            {
                $arResult["SEO_CLASS"] = "bad";
                $arResult["SEO_STATUS"] = "BAD";
            }  
            elseif($points > 50 && $points <= 85)
            {
                $arResult["SEO_CLASS"] = "notbad";
                $arResult["SEO_STATUS"] = "NOTBAD";
            } 
            elseif($points > 85)
            {
                $arResult["SEO_CLASS"] = "good";
                $arResult["SEO_STATUS"] = "GOOD";
            }


        }
    }
// SEO
?>



<div class="hidden-sm hidden-xs">

    <div class="hameleon-main-setting">
        <div class="hameleon-btn mgo-widget-call_pulse">
            
        </div>
        <span><?=GetMessage("HAM_PUBLIC_SET_BUTTON_TIP")?></span>
    </div>

    <div class="hameleon-sets-list-wrap">

        <div class="hameleon-sets-list">

            <div class="hameleon-sets-list-table">
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item addpage hameleon-sets-open" data-open-set='addpage'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_ADDPAGE")?></span>
                    </a>
                    <div class="vertic-line"></div>
                </div>
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item edit-sets hameleon-sets-open" data-open-set='edit-sets'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_EDIT_SETS")?></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                   
                    <a class="hameleon-sets-list-item addblock" href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$HAMELEON_TEMPLATE_ARRAY['CONSTRUCTOR']["IBLOCK_ID"]?>&type=<?=$HAMELEON_TEMPLATE_ARRAY['CONSTRUCTOR']["IBLOCK_TYPE"]?>&ID=0&lang=ru&IBLOCK_SECTION_ID=<?=$GLOBALS["CURRENT_SECTION_ID"]?>&find_section_section=<?=$GLOBALS["CURRENT_SECTION_ID"]?>&from=iblock_list_admin' target='_blank'>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_ADDBLOCK")?></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                    <a class="hameleon-sets-list-item seo hameleon-sets-open init" data-open-set='seo'>
                        <span class="seo-name">SEO</span>
                        <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_SEO")?></span>
                        <span class="status-seo seo-<?=$arResult["SEO_CLASS"]?>"></span>
                    </a>
                </div>
                <div class="hameleon-sets-list-cell">
                    <div class="hameleon-sets-list-close">
                        
                    </div>
                    <span><?=GetMessage("HAM_PUBLIC_SET_CLOSE_LIST_SET")?></span>
                </div>
            </div>
        </div>


        <div class="hameleon-sets-list-left">
           
            <a class="hameleon-sets-list-item hameleon-sets-open forms" data-open-set='forms'>
                <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_FORMS")?></span>
            </a>
            <a class="hameleon-sets-list-item hameleon-sets-open modals" data-open-set='modals'>
                <span class="set-icon"><?=GetMessage("HAM_PUBLIC_SET_MODAL")?></span>
            </a>              
          
        </div>

    </div>


    <div class="sets-shadow"></div>

    <div class="hameleon-setting edit-sets"></div>

    <div class="hameleon-setting addpage"></div>

    <div class="hameleon-setting newpage"></div>

    <div class="hameleon-setting modals list-style"></div>

    <div class="hameleon-setting forms list-style"></div>


    <div class="hameleon-setting seo">
        <div class="inner">

            <div class="hameleon-set-head">
                <table>
                    <tr>
                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-3 hameleon-set-image"><div></div></td>
                        <td class="col-lg-8 col-md-8 col-sm-8 col-xs-6 hameleon-set-name bold"><?=GetMessage("HAMELEON_SEO_BLOCK_TITLE")?></td>
                        <td class="col-lg-2 col-md-2 col-sm-2 col-xs-3"></td>
                    </tr>
                </table>

                <a class="hameleon-set-close"></a>
                
            </div>
            

            <form action="/" class="form-sets-js form form-seo" enctype="multipart/form-data" method="post" role="form">

                
                <input type="hidden" name="server_url" value="<?=$arResult["SERVER_URL"]?>" />
                <input type="hidden" name="site_id" id="site_id" value="<?=SITE_ID?>" />
                
                <input type="hidden" name="section_id" name="section_id" value="<?=$GLOBALS["CURRENT_SECTION_ID"]?>" />
                

                <div class="hameleon-set-top">
                    <div class="progress-wrap">
                        <div class="progress-top">
                            <div class="progress-name seo-<?=$arResult["SEO_CLASS"]?>"><?=GetMessage("HAMELEON_SEO_".$arResult["SEO_STATUS"])?></div>
                                    
                            <div class="points">(<?=$arResult["SEO_POINTS"]?> <?=GetMessage("HAMELEON_SEO_POINT")?> 100 <?=GetMessage("HAMELEON_SEO_POINTS")?>)</div>
                            <div class="seo-more_info"><span class='show_info'><?=GetMessage("HAMELEON_SEO_SHOW_INFO")?></span><span class='hide_info'><?=GetMessage("HAMELEON_SEO_HIDE_INFO")?></span></div>
                        </div>
                        <div class="progress-bar-hameleon">
                            <div class="progress-status" style='width: <?=$arResult["SEO_POINTS"]?>%;'></div>
                        </div>
                    </div>
                    <div class="progress-info">
                        <ul>
                            <?

	                            if(!empty($arResult["SEO_MESSAGE"]))
	                            {
		                            foreach($arResult["SEO_MESSAGE"] as $arMess):?>
		                                <li class='seo-<?=$arMess["class"]?>'><?=GetMessage($arMess["TEXT"])?></li>
		                            <?endforeach;
	                            }

                            ?>
                        </ul>

                        <div class="spec-comment italic">
                            <?=GetMessage("HAMELEON_SEO_COMMENT")?>
                        </div>
                        
                    </div>
                </div>


                <div class="hameleon-set-content">

                    <table class="sides">
                        <tr>
                            <td class='set-side-left'>
                            
                                <ul class="set-tabs">
                                    <li class='active' data-set='meta'><?=GetMessage("HAMELEON_SEO_META")?></li>
                                    <li data-set='og'><?=GetMessage("HAMELEON_SEO_SOC")?></li>
                                    <li data-set='other-meta'><?=GetMessage("HAMELEON_SEO_OTHER_META")?></li>
                                </ul>
                                
                                <!-- <div class="instruct">
                                    <a href="https://goo.gl/uDNEPN" target="_blank"><?=GetMessage("HAMELEON_SEO_INSTRUCT")?></a>
                                </div> -->
                                
                            </td>
                            
                            <td class='set-side-right'>

                                <div class="set-content active" data-set='meta'>
                                
                                    
                                    <div class="input-wrap">
                                
                                        <ul class="form-check">                                                
                                            <li>
                                                <label>
                                                    <input class='on-save' name="hameleon_seo_noindex" <?if($arResult["SECTION"]["UF_CHAM_NOINDEX"] == 1):?>checked<?endif;?> type="checkbox" value="1"><span></span><span><?=GetMessage("HAMELEON_SEO_NOINDEX")?></span> 
                                                </label>
                                                <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_1")?>"></span>
                                               
                                            </li>
                                            
                                        </ul>
                                    
                                    </div>
                                
                                
                                    <div class="input-wrap middle clearfix">

                                        <div class="name bold">
                                        
                                            <?=GetMessage("HAMELEON_SEO_TITLE")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_2")?>"></span>
                                        
                                            <?if(!empty($arResult["SEO_TITLE_MESSAGE"])):?>
                                                
                                                <span class="answ-seo seo-<?=$arResult["SEO_TITLE_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_TITLE_MESSAGE"][0]["TEXT"])?>"></span>
                                            <?endif;?>
                                            
                                        
                                        
                                        
                                        </div>
                                        
                                        <div class="row">
                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            
                                                <div class="textarea on-save">
                                                    
                                                    <?
                                                    $seo_title = $arResult["SECTION"]["NAME"];
                                                    
                                                    if(strlen($arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_TITLE"]) > 0)
                                                        $seo_title = $arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_TITLE"];
                                                    ?>
                                                
                                                    <textarea name="hameleon_seo_title"><?=$seo_title?></textarea>
                                                </div>
                                            
                                            </div>
                                
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="input-wrap middle clearfix">

                                        <div class="name bold">
                                            
                                            <?=GetMessage("HAMELEON_SEO_DESCRIPTION")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_3")?>"></span>
                                            
                                            <?if(!empty($arResult["SEO_DESCRIPTION_MESSAGE"])):?>
                                                
                                                <span class="answ-seo seo-<?=$arResult["SEO_DESCRIPTION_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_DESCRIPTION_MESSAGE"][0]["TEXT"])?>"></span>
                                            <?endif;?>
                                            
                                        </div>
                                        
                                        <div class="row">
                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            
                                                <div class="textarea on-save">
                                                
                                                    <textarea name="hameleon_seo_description"><?=$arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]?></textarea>
                                                </div>
                                            
                                            </div>
                                
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="input-wrap middle clearfix">

                                        <div class="name bold">
                                        
                                            <?=GetMessage("HAMELEON_SEO_KEYWORDS")?> <span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_4")?>"></span>
                                        
                                            
                                            <?if(!empty($arResult["SEO_KEYWORDS_MESSAGE"])):?>
                                                
                                                <span class="answ-seo seo-<?=$arResult["SEO_KEYWORDS_MESSAGE"][0]["class"]?>" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?=GetMessage($arResult["SEO_KEYWORDS_MESSAGE"][0]["TEXT"])?>"></span>
                                            <?endif;?>
                                            
                                        </div>
                                        
                                        <div class="row">
                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            
                                                <div class="textarea on-save">
   
                                                    <textarea name="hameleon_seo_keywords"><?=$arResult["SECTION"]["IPROPERTY_VALUES"]["SECTION_META_KEYWORDS"]?></textarea>
                                                </div>
                                            
                                            </div>
                                
                                        </div>
                                        
                                    </div>


                                    <div class="spec-comment italic">
                                    <?=GetMessage("HAMELEON_SEO_HINT_6")?></div>
                                    
                                    

                                </div>
                                
                                
                                <div class="set-content" data-set='og'>
                                
                                    
                                    <div class="input-wrap middle clearfix">
                                        
                                        
                                        <div class="clearfix">
                                            
                                            <div class="row">
                                            
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                
                                                    <div class="input to-right clearfile-parent">
    
                                                        <label class="file on-save <?if(strlen($arResult["SECTION"]["OG_IMAGE"]) > 0):?>focus-anim<?endif;?>">
                                                        
                                                            <input type="hidden" name="imageogimage" value="<?=$arResult["SECTION"]["UF_CHAM_OG_IMAGE"]?>">
    
                                                            <input type="hidden" class='hameleon_file_del' name="hameleon_seo_og_image_del" value="">
    
                                                            <span class="ex-file-desc"><?=GetMessage("HAMELEON_SEO_OG_IMAGE")?></span>
                                                            <span class="ex-file"><?=$arResult["SECTION"]["OG_IMAGE"]?></span>
                                                            <input type="file" accept="image/*" class="hidden" id="hameleon_seo_og_image" name="hameleon_seo_og_image"  />
                                                        </label>
    
                                                        <div class="clearfile on-save <?if(strlen($arResult["SECTION"]["OG_IMAGE"]) > 0):?>on<?endif;?>"></div>
    
                                                    </div>
                                                    
                                                </div>
                                            
                                            </div>
                                        
                                        </div>
                                        
                                        
                                        

                                        <div class="input <?if(strlen($arResult["SECTION"]['UF_CHAM_OG_TITLE']) > 0):?>in-focus<?endif;?>">  
                                            <div class="bg"></div>
                                            <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_TITLE")?></span>
                                            <input type="text" class='focus-anim on-save' name="hameleon_seo_og_title" value="<?=$arResult["SECTION"]['UF_CHAM_OG_TITLE']?>">
                                        
                                        </div>
                                    
                                    
                                        
                                        <div class="input <?if(strlen($arResult["SECTION"]['UF_CHAM_OG_DESC']) > 0):?>in-focus<?endif;?>"> 
                                         
                                            <div class="bg"></div> 
                                            <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_DESCRIPTION")?></span>
                                            <input type="text" class='focus-anim on-save' name="hameleon_seo_og_description" value="<?=$arResult["SECTION"]['UF_CHAM_OG_DESC']?>">
                                        
                                        </div>
                                    
                                    
                                    
                                        
                                        
                                        <div class="input-wrap clearfix"></div>
                                        
                                        <div class="name bold"><?=GetMessage("HAMELEON_SEO_OG_NOT_NESSESARY")?></div>
                                        
                                        
                                        <div class="input <?if(strlen($arResult["SECTION"]['UF_CHAM_OG_URL']) > 0):?>in-focus<?endif;?>">  
                                            <div class="bg"></div>  
                                            <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_URL")?></span>
                                            <input type="text" class='focus-anim on-save' name="hameleon_seo_og_url" value="<?=$arResult["SECTION"]['UF_CHAM_OG_URL']?>">
                                        
                                        </div>
               
                                        
                                        <div class="input <?if(strlen($arResult["SECTION"]['UF_CHAM_OG_TYPE']) > 0):?>in-focus<?endif;?>">  
                                            <div class="bg"></div>
                                            <span class="desc"><?=GetMessage("HAMELEON_SEO_OG_TYPE")?></span>
                                            <input type="text" class='focus-anim on-save' name="hameleon_seo_og_type" value="<?=$arResult["SECTION"]['UF_CHAM_OG_TYPE']?>">
                                        
                                        </div>

                                        <div class="spec-comment italic">
                                
                                            <?=GetMessage("HAMELEON_SEO_HINT_7")?>
                                                
                                        </div>
                                    
                                    
                                    </div>
                                    
                                </div>
                                
                                
                                <div class="set-content" data-set='other-meta'>
                                
                                    
                                    <div class="name bold"><?=GetMessage("HAMELEON_SEO_OTHER_META")?><span class="answer" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=GetMessage("HAMELEON_SEO_HINT_5")?>"></span></div>
                                    
                                    <div class="parent-row">

                                        <div class="empty-template">
                                            <div class="input">                                       
                                                <input type="text" class="text seo-name on-save" name="hameleon_other_meta[n<?=count($arResult["SECTION"]["UF_CHAM_META_TAGS"])?>]" value="">
                                            </div>
                                        </div>

                                        <div class="area-for-clone">
                                            
                                            <?
	                                            if(!empty($arResult["SECTION"]["UF_CHAM_META_TAGS"]))
	                                            {
		                                            foreach($arResult["SECTION"]["UF_CHAM_META_TAGS"] as $k=>$arTag):?>
		                                            
		                                                <div class="input">                                       
		                                                    <input type="text" class="text seo-name on-save" name="hameleon_other_meta[n<?=$k?>]" value="<?=$arTag?>" />
		                                                </div>
		                                            
		                                            <?endforeach;
	                                            }
                                            ?>
                                            
                                        </div>
                                     

                                        <div class="addrow-seo on-save">+ <span><?=GetMessage("HAMELEON_SEO_OTHER_ADD")?></span></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="hameleon-set-foot off">
                    <table>
                        <tr>
                            <td class='set-left'>
                                <div class="load">
                                    <div class="xLoader form-preload set-load"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                </div>
                                <button class="active btn-submit btn-submit-style btn-submit-form-seo" id="form-submit" name="form-submit" type="button" value=""><?=GetMessage("HAM_PUBLIC_SET_SAVE")?></button>
                               </td>
                            <td class='set-right'>
                                <div class='hameleon-set-close'><?=GetMessage("HAM_PUBLIC_SET_CLOSE")?></iiv>
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </form>
        
        </div>
    </div>



    <input type="hidden" name="currentSectionId" value="<?=$GLOBALS["CURRENT_SECTION_ID"]?>">

    <?if(\Bitrix\Main\Config\Option::get("concept.hameleon", "hameleon_hide_adv", false, "") == "Y"):?>

        <div class="hide-adv" data-user="<?=$USER->getId()?>"></div>

    <?endif;?>
</div>