<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>



<?$this->SetViewTarget('lang_id');?><?if(strlen($arResult["SECTION"]["UF_LANG_FILE"]) > 0):?><?=$arResult["SECTION"]["UF_LANG_FILE"]?><?else:?>ru<?endif;?><?$this->EndViewTarget();?> 

<?ob_start();?>
<?
global $Landing;
$Landing = $arResult["SECTION"];

ChamDB::includeCustomMessages($Landing["ID"], $Landing["IBLOCK_ID"]);
?>
<?$this->SetViewTarget('inputs_info');?>
<input class="tmpl_path" name="tmpl_path" value="<?=SITE_TEMPLATE_PATH?>" type="hidden">
<input class="tmpl" name="tmpl" value="<?=SITE_TEMPLATE_ID?>" type="hidden">
<input class="site_id" name="site_id" value="<?=SITE_ID?>" type="hidden">
<input type="hidden" id="current_landing_id" name="current_landing_id" value="<?=$arResult["SECTION"]["ID"]?>" />
<input class="sect" name="section" value="<?=$arResult["SECTION"]["ID"]?>" type="hidden">
<input class="ib" name="ib" value="<?=$arResult["SECTION"]["IBLOCK_ID"]?>" type="hidden">
<input class="btn_type" name="btn_type" value="<?=$arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" type="hidden">
<?$this->EndViewTarget();?> 


<?
global $admin_active;
global $show_setting;
global $USER;
global $h1;
global $DB_cham;
global $components;
global $img_quality;
global $Folder;

$Folder = $templateFolder;

$img_quality = $arResult["SECTION"]["UF_QUAL_IMAGES"];
$h1 = 0;
$components = 0;
$admin_active = $USER->isAdmin();
$show_setting = $arResult["SECTION"]["UF_CHAM_SHOW_EDIT"];
?>

<?
function hamButtonEditClass ($xml_id, $form_id = '', $modal_id='')
{
    $classes = '';

    if($xml_id == "form" && strlen($form_id)>0)
        $classes = 'call-modal callform';

    elseif($xml_id == "modal" && strlen($modal_id)>0)
        $classes = 'call-modal callmodal';

    elseif($xml_id == "block")
        $classes = 'scroll';

    elseif($xml_id == "quiz")
        $classes = 'call-wqec';


    return $classes;
}
?>

<?
function hamButtonEditAttr($xml_id, $form_id = '', $modal_id = '', $link = '', $blank='', $header = '', $quiz_id = '', $arElement='')
{

    $attr = '';

    if($xml_id == "form" && strlen($form_id)>0)
    {
        $attr = 'data-header="'.$header.'" data-call-modal="form'.$form_id.'" data-element-id="'.$arElement.'"';
    }

    elseif($xml_id == "modal" && strlen($modal_id)>0)
        $attr = 'data-call-modal="modal'.$modal_id.'"';

    elseif($xml_id == "block" && strlen($link)>0)
        $attr = 'href = "#block'.$link.'"';

    elseif($xml_id == "blank" && strlen($link)>0)
        $attr = 'href = "'.$link.'" '.$blank;


    elseif($xml_id == "quiz")
        $attr = 'data-wqec-section-id="'.$quiz_id.'"';


    return $attr;
}
?>

<?function admin_setting($arItem, $center = false){?>

    <?global $admin_active;?>
    <?global $show_setting;?>
    <?global $hameleon_rights;?>

    <?if(($admin_active || $hameleon_rights > "R") && $show_setting == 1):?>

        <div class="tool-settings">
            <a href='/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arItem['~IBLOCK_ID']?>&type=<?=$arItem['~IBLOCK_TYPE_ID']?>&ID=<?=$arItem['ID']?>&find_section_section=<?=$arItem['IBLOCK_SECTION_ID']?>&WF=Y' class="tool-settings <?if($center):?>in-center<?endif;?>" data-toggle="tooltip" target="_blank" data-placement="right" title="<?=GetMessage("PAGE_GEN_EDIT")?> &quot;<?=TruncateText($arItem["NAME"], 35)?>&quot;"></a>

        </div>


    <?endif;?>
<?}
?>

<?function CreateSoc($arSection){?>

    <div class="socials">
    
        <?if(strlen($arSection["UF_CHAM_SOC_VK"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_VK"]?>" class="soc_ic soc_vk"><i class="concept-vkontakte"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_FB"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_FB"]?>" class="soc_ic soc_fb"><i class="concept-facebook-1"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_TW"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_TW"]?>" class="soc_ic soc_tw"><i class="concept-twitter-bird-1"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_YT"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_YT"]?>" class="soc_ic soc_yu"><i class="concept-youtube-play"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_IG"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_IG"]?>" class="soc_ic soc_ins"><i class="concept-instagram-4"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_TLG"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_TLG"]?>" class="soc_ic soc_tlg"><i class="concept-paper-plane"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_OK"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_OK"]?>" class="soc_ic soc_ok"><i class="concept-odnoklassniki"></i></a>
        <?endif;?>

        <?if(strlen($arSection["UF_CHAM_SOC_TIKTOK"])>0):?>
            <a target="_blank" href="<?=$arSection["UF_CHAM_SOC_TIKTOK"]?>" class="soc_ic soc_tiktok"><i class="concept-soc_tiktok"></i></a>
        <?endif;?>
        
    </div>

<?}?>

<?function CreateEmptyBlock($arSection){

    global $Folder;

    include($_SERVER["DOCUMENT_ROOT"].$Folder."/main/create_empty_block.php");
}?>


<?function CreateFirstSlider($arSlider){

    global $Landing;   
    global $h1;
    global $header_bg_on;
    global $img_quality;
    global $Folder;

    include($_SERVER["DOCUMENT_ROOT"].$Folder."/blocks/".$arSlider["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].".php");

}?>


<?function CreateHead($arItem, $min = false, $main_key){

    global $h1;
    global $Folder;

    if( strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0 )
        include($_SERVER["DOCUMENT_ROOT"].$Folder."/main/create_head.php");

}?>

<?function CreateButton($arItem, $center = true){
    global $Landing;
    global $Folder;
 

    if( strlen($arItem["PROPERTIES"]["BUTTON_NAME"]["VALUE"]) > 0 || strlen( $arItem["PROPERTIES"]["BUTTON_NAME_2"]["VALUE"] ) > 0 )
        include($_SERVER["DOCUMENT_ROOT"].$Folder."/main/create_button.php");
    
}?>


<?function CreateElement($arItem, $arSection, $mainkey){?>

    <?
        global $Landing;
        global $admin_active;
        global $show_setting;
        global $components;
        global $DB_cham;
        global $img_quality;
        global $header_bg_on;
        global $Folder;

        $main_key = $mainkey;

        $block_name = $arItem['~NAME'];

        if(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0)
            $block_name .= " (".$arItem["PROPERTIES"]["HEADER"]["~VALUE"].")";

        $block_name = htmlspecialcharsEx(strip_tags(html_entity_decode($block_name)));

        
        $style="";
        $style2="";
        $classBlock="";
        $attrsBlock="";


        $classBlock="block clearfix "
                    .$arItem["PROPERTIES"]["SHADOW"]["VALUE_XML_ID"]." "
                    .$arItem["PROPERTIES"]["COVER"]["VALUE_XML_ID"];

        if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y" && ($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "text"))
            $classBlock .= " cham-overflow";

        if(
            $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_MP4"]["VALUE"] > 0
            ||
            $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_WEBM"]["VALUE"] > 0
            ||
            $arItem["PROPERTIES"]["VIDEO_BACKGROUND_FILE_OGG"]["VALUE"] > 0
            ||
            strlen($arItem["PROPERTIES"]["VIDEO_BACKGROUND"]["VALUE"]) > 0
        )
            $classBlock .= " parent-video-bg"; 

        if($mainkey > 0)
        {
            $classBlock.=" lazyload";


            if(isset($arItem["PREVIEW_PICTURE"]["SRC"]{0}))
                $attrsBlock .=" data-src=\"".$arItem["PREVIEW_PICTURE"]["SRC"]."\"";


        }
        else
        {
            $classBlock.=" hameleon-first";
            if(isset($arItem["PREVIEW_PICTURE"]["SRC"]{0}))
                $style.=" background-image: url('".$arItem["PREVIEW_PICTURE"]["SRC"]."'); ";
        }


        if(!$arItem["PADDING_CHANGE"])
        {
            $classBlock.=" padding-on";

            if($mainkey == 0)
                $classBlock.=" padding-change";
        }

        if($arItem["PROPERTIES"]["HIDE_BLOCK"]["VALUE"] == "Y")
            $classBlock.=" hidden-xs";

        if($arItem["PROPERTIES"]["HIDE_BLOCK_LG"]["VALUE"] == "Y")
            $classBlock.=" hidden-lg hidden-md hidden-sm";

        if($arItem["PROPERTIES"]["PARALLAX"]["VALUE_XML_ID"] == "100")
            $classBlock.=" parallax-attachment";
        


        if(strlen($arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"]) > 0)
            $style .= " background-color: ".$arItem["PROPERTIES"]["BACKGROUND_COLOR"]["VALUE"].";";

        if($arItem["PROPERTIES"]["PARALLAX"]["VALUE_XML_ID"] == "30")
            $attrsBlock .=" data-enllax-ratio=\".25\"";

    
        
            
        /*if($arItem["PROPERTIES"]["PARALLAX"]["VALUE_XML_ID"] == "100")
            $style .= "background-attachment: fixed;";*/
    
        
        /*if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]) > 0)
            $style .= "margin-top: ".$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]."px;";

    
        if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]) > 0)
            $style .= "margin-bottom: ".$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]."px;";*/


        if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]) > 0 && $arItem["PADDING_CHANGE"])
        {
            /*if(!$arItem["PADDING_CHANGE"])
                $style .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
            else*/
                $style2 .= "padding-top: ".$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]."px;";
        }
        
        if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]) > 0 && $arItem["PADDING_CHANGE"]){
            
            /*if(!$arItem["PADDING_CHANGE"])
                $style .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
            else*/
                $style2 .= "padding-bottom: ".$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]."px;";
        }

        
    ?>

    

    <?if($arItem["PROPERTIES"]["COMPONENT_DESIGN"]["VALUE_XML_ID"] != "Y" && $arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "component"):?>

        <?include($_SERVER["DOCUMENT_ROOT"].$Folder."/blocks/".$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].".php");?>  

    <?else:?>
    
    
        <div id="block<?=$arItem["ID"]?>"
                class="<?=$classBlock?>"
                <?=$attrsBlock?>

                <?if(strlen($style)>0):?>
                    style="<?=$style?>"
                <?endif;?>
            >

            

            <?if(
            	strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0
            	|| strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"])>0 
            	|| strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"])>0

            ):?>

                <style>

					<?if(

						strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"])>0

					):?>

	                	@media (min-width: 768px){
							#block<?=$arItem["ID"]?>{
	                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP"]["VALUE"]?>px !important;<?endif;?>
	                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM"]["VALUE"]?>px !important;<?endif;?>
	                            <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"])>0 && !$arItem["PADDING_CHANGE"]):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP"]["VALUE"]?>px !important;<?endif;?>
	                            <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"])>0 && !$arItem["PADDING_CHANGE"]):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM"]["VALUE"]?>px !important;<?endif;?>
	                        }
	                	}

                	<?endif;?>


                	<?if(

						strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0 
		            	|| strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0

					):?>


                    @media (max-width: 767px){
                        #block<?=$arItem["ID"]?>{
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"])>0):?>margin-top: <?=$arItem["PROPERTIES"]["MARGIN_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"])>0):?>margin-bottom: <?=$arItem["PROPERTIES"]["MARGIN_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"])>0):?>padding-top: <?=$arItem["PROPERTIES"]["PADDING_TOP_MOB"]["VALUE"]?>px !important;<?endif;?>
                            <?if(strlen($arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"])>0):?>padding-bottom: <?=$arItem["PROPERTIES"]["PADDING_BOTTOM_MOB"]["VALUE"]?>px !important;<?endif;?>
                        }
                    }

                    <?endif;?>
                </style>

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
                        $iframe = ChamDB::createVideo($arItem['PROPERTIES']['VIDEO_BACKGROUND']['VALUE']);
                        $srcYB = $iframe["SRC"];

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

                <img class="lazyload img-for-lazyload videoBG-start" data-src="<?=SITE_TEMPLATE_PATH?>/images/one_px.png">

            <?endif;?>

            <div class="shadow"></div>

            <?
                if($header_bg_on)
                {
                    if($main_key == 0)
                        echo "<div class='top-shadow'></div>";
                }
            ?>

            <?
                if(is_array($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]) && !empty($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"]))
                {
                    foreach($arItem["PROPERTIES"]["SLIDES"]["VALUE_XML_ID"] as $arSlID)
                    {
                        echo "<div class='corner ".$arSlID." hidden-xs hidden-sm'></div>";
                    }
                }
            ?>
            
            <?if(!$arItem["TITLE_CHANGE"])
                CreateHead($arItem, false, $main_key);?>

            <div class="content <?if($arItem["TITLE_CHANGE"] || !(strlen($arItem["PROPERTIES"]["HEADER"]["VALUE"]) > 0 || strlen($arItem["PROPERTIES"]["SUBHEADER"]["VALUE"]) > 0)):?>no-margin<?endif;?>">

                <div class="container">
                    <div class="row">

                        <?include($_SERVER["DOCUMENT_ROOT"].$Folder."/blocks/".$arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"].".php");?>
                
                    </div>

                    <?if(!$arItem["BUTTON_CHANGE"]):?>
                        <?CreateButton($arItem);?>
                    <?endif;?>
                
                </div>
            </div>
                       
            <?if(!empty($arItem["PROPERTIES"]["LINES"]["VALUE_XML_ID"])):?> 
    
                <?foreach($arItem["PROPERTIES"]["LINES"]["VALUE_XML_ID"] as $line):?>
                    
                    <div class="line-ds <?=$line?>">
                        <div class="container">
                            <div class="ln"></div>
                        </div>
                    </div>

                <?endforeach;?>
            <?endif;?>

            <?admin_setting($arItem, true);?>
        </div>

    <?endif;?>    
<?}?>


<style>
    <?if($arResult["SECTION"]["UF_CHAM_HIDESCROLL"] == 1):?>
        ::-webkit-scrollbar{ 
            width: 0px; 
        }
    <?endif;?>

    <?if(strlen($arResult["SECTION"]["UF_CH_BODY_BG"])>0 || strlen($arResult["SECTION"]["UF_CH_BODY_BG_CLR"])>0):?>

    <?$bgBody = CFile::ResizeImageGet($arResult["SECTION"]["UF_CH_BODY_BG"], array('width'=>2000, 'height'=>12000), BX_RESIZE_IMAGE_PROPORTIONAL, false, false, false, $img_quality);?>
        body{
            <?if(!empty($bgBody)):?>background-image: url(<?=$bgBody["src"]?>);<?endif;?>
            background-attachment: <?=$arResult["SECTION"]["UF_CH_POS_BODY_BG_ENUM"]["XML_ID"]?>;
            background-repeat: <?=$arResult["SECTION"]["UF_CH_BODY_REPEAT_BG_ENUM"]["XML_ID"]?>;
            background-position: top center;
            background-color: <?=$arResult["SECTION"]["UF_CH_BODY_BG_CLR"]?>;
        }

    <?endif;?>
</style>

<div class="wrapper-outer main-color-btn-<?=$arResult["SECTION"]["UF_MAIN_COLOR_BTN_ENUM"]["XML_ID"]?>">
    <?if(!empty($arResult["MENU"])):?>
        <a class="menu-slide-close click-cl-menu tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>"></a>


        <div class="slide-menu tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>">
            <div class="inner">
                

                <div class="head-wrap">
                    <div class="head-table">        
                        
                        <div class="head-cell logotype">
                           <a href="#body" class="scroll close-from-menu"><img class="img-responsive lazyload" data-src="<?=CFile::getPath($arResult["SECTION"]["PICTURE"])?>" alt="" /></a> 
                        </div>

                        <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>   
                            <div class="head-cell descrip right hidden-xs"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>
                        <?endif;?>

                    </div>
                </div>

                <div class="menu-content no-margin-top-bot ">

                    <ul class="nav">

                         <?foreach($arResult["MENU"] as $keys => $arMenu):?>
                         
                            <li class="<?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>">
                                
                                <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                                
                                    <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?> class="scroll close-from-menu"><span><?=$arMenu["NAME"]?></span></a>
                              
                                <?else:?>
                                
                                    <a href="#block<?=$arMenu['ID']?>" class="scroll close-from-menu"><span><?=$arMenu["NAME"]?></span></a>
                                
                                <?endif;?>
                            </li>

                        <?endforeach;?>

                    </ul>

                </div>

                <div class="foot-wrap">
                    <div class="foot-inner">
                    
                        <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"] && $arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]>0):?>
                            <div class="part-cell left">
                                <a class="button-def primary big <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?> <?=$arResult["SECTION"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" data-header="<?=GetMessage("PAGE_GEN_HEADER_CALLBACK")?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>">
                                   <?=GetMessage("PAGE_GEN_CALLBACK")?>
                                </a>

                             
                            </div>
                        <?endif;?>

                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                            <div class="part-cell right">
                                <table>
                                    <tr>
                                        <td>
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                               <div class="number main1">
                                                    <?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?>
                                                </div>
                                            <?endif;?> 
                                            
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0 && strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) >= 0):?>     
                                                <div class="email">
                                                    <?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?>
                                                </div>
                                            <?endif;?>
                                            
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>     
                                                <div class="email">
                                                    <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                </div>
                                            <?endif;?>
                                        </td>
                                        
                                    </tr>
                                </table>
                                                    
                            </div>
                        <?endif;?>
                        
                        
                        <?if($arResult["SHOW_SOC"] && in_array("menu", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>

                            <div class="part-cell right hidden-sm">
                                <?CreateSoc($arResult["SECTION"])?>
                            </div>
                        
                        <?endif;?>

                    </div>
                    
                    <?if($arResult["SHOW_SOC"] && in_array("menu", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>

                        <div class="part-cell right visible-sm">
                            <?CreateSoc($arResult["SECTION"])?>
                        </div>
                    
                    <?endif;?>
                    
                </div>

            </div>

        </div> 

    <?endif;?>

    <div class="wrapper tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?>">
    	
       

        <?
            $header_class = "full";
            $header_style = "";

            if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]) > 0 || $arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0)
            {
                $header_class = "small";


                if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]) > 0)
                {
                    $arColor = $arResult["SECTION"]["UF_CHAM_HEADER_BACK"];

                    if($arColor == "transparent")
                        $header_style .= 'background-color: transparent; ';

                    else if(preg_match('/^\#/', $arResult["SECTION"]["UF_CHAM_HEADER_BACK"]))
                    {
                        $arColor = hex2rgb($arResult["SECTION"]["UF_CHAM_HEADER_BACK"]);
                        $arColor = implode(',',$arColor);

                        $percent = 1;
            
                        if(strlen($arResult["SECTION"]["UF_CHAM_HEADER_BK_O"])>0)
                            $percent = (100 - $arResult["SECTION"]["UF_CHAM_HEADER_BK_O"])/100;
                        
                        $header_style .= 'background-color: rgba('.$arColor.', '.$percent.'); ';
                    }

                    else
                        $header_style .= 'background-color: '.$arColor.'; ';
            
                    
                }

                if($arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0)
                    $header_style .= 'background-position: top center; background-repeat: no-repeat; ';
                

                if($arResult["SECTION"]["UF_CHAM_HEADER_IMG_F"])
                    $header_style .= 'background-size: cover; ';
                
            }

            global $header_bg_on;
            $header_bg_on = false;

            if(strlen($header_style)>0)
            {
                $header_style = "style = '".$header_style."'";
                $header_bg_on = true;
            }


            if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"]) 
                $header_class .= " type-1"; 
            else 
                $header_class .= " type-2"; 

            if($arResult["SECTION"]["UF_CHAM_SLIDEMENU"]) 
                $header_class .= " slide"; 

            if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] != "first" && !empty($arResult["MENU"]))
                $header_class .= " menu-open"; 

            if(!$arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"])
                $header_class .= " scroll-phone-hide"; 

            $header_class .= " ".$arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"];
            $header_class .= " tone-".$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"];
            $header_class .= " header-color-".$arResult["SECTION"]["UF_CH_COLOR_HEADER_ENUM"]["XML_ID"]; 

        ?>   

        <header class="<?=$header_class?> lazyload" <?=$header_style?> 
            <?if($arResult["SECTION"]["UF_CHAM_HEADER_IMG"] > 0):?>
                data-src="<?=CFile::getPath($arResult["SECTION"]["UF_CHAM_HEADER_IMG"])?>"
            <?endif;?>
        >

            <?/*if($header_class == "full"):?>
                <div class="shadow"></div>
            <?endif;*/?>
            
            <div class="scroll-wrap">

                <div class="container">
                    <div class="row">
        
                        
                        <div class="header-block header-table hidden-xs">

                            <div class="header-cell col-sm-4 col-xs-0 left">
                                <div class="row">
                                    
                                    <table class="tbl-lvl-1">
                                        <tr>
                                            <?if(!empty($arResult["MENU"])):?>
                                                <td class="td-lvl-1 ic_menu">
                                                    <a class="menu-link primary click-op-menu"><div class="icon-hamburger-wrap"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></a>
                                                </td>
                                            <?endif;?>
                                            
                                            
                                            <?if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"] == 0):?>
                                               
                                                <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                               
                                                    <td class="td-lvl-1 logotype">
                                                        <a class="scroll" href="#body">
                                                            <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                            <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt="">
                                                            
                                                        </a>
                                                    </td>
                                                
                                                <?endif;?>
                                                
                                            <?else:?>
                                                
                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                                                    <td class="td-lvl-1 descript">
                                                        <div class="main-desciption <?if($arResult["SECTION"]["UF_CHAM_DESCRIPT_BK"]):?>backdrop<?endif;?>">
                                                            <?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?>
                                                        </div> 
                                                    </td>
                                                <?endif;?>
                                                
                                            <?endif;?>
                                        </tr>
                                    </table>
                                </div>
                                        
                            </div>

                            <div class="header-cell col-sm-4 col-xs-0 center">
                                <div class="row">
                                    
                                    <table class="tbl-lvl-1">
                                        <tr>
                                    
                                            <?if($arResult["SECTION"]["UF_CHAM_LOGOTYPE"] == 1):?>
                                        
                                                <?if($arResult["SECTION"]["PICTURE"] > 0):?>
      
                                                    <td class="td-lvl-1 logotype">
                                                        <a class="scroll" href="#body">
                                                            
                                                            <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                            <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt=""/>
                                                        </a>
                                                    </td>
            
                                                <?endif;?>
                                                
                                            <?else:?>
                                                    
                                                <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                                <td class="td-lvl-1 logotype">
                                                    <a class="scroll" href="#body">
                                                        <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                        <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt="">
                                                        
                                                    </a>
                                                </td>
                                                <?endif;?>
                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                                                    <td class="td-lvl-1 descript">
                                                        <div class="main-desciption <?if($arResult["SECTION"]["UF_CHAM_DESCRIPT_BK"]):?>backdrop<?endif;?>">
                                                            <?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?>
                                                        </div>
                                                    </td>
                                                <?endif;?>
            
                                            <?endif;?>

                                        </tr>
                                    </table>

                                </div>
                                
                            </div>


                            <div class="header-cell col-sm-4 col-xs-0 right">
                                <div class="row">
                                
                                    <table class="tbl-lvl-1 right-inner">
                                        <tr>
                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                                <td class="td-lvl-1 hidden-xs">
                                                    <div class="main-phone">

                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?> 
                                                            <div class="element phone main1"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                        <?endif;?>
                                                            
                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0):?>
                                                            <div class="comment"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                        <?endif;?>
                                                            
                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                            
                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0):?> 
                                                                <div class="element email main1">
                                                            <?else:?>
                                                                <div class="comment">
                                                            <?endif;?>
                                                            
                                                            <a class="mail" href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                            
                                                            </div>

                                                        <?endif;?>


                                                        <?if($arResult["PHONES_SHOW_DOWN"]):?>

                                                            <div class="ic-open-list-contact open-list-contact"><span></span></div>

                                                            <div class="list-contacts">
                                                                <table>
                                                                
                                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                                                
                                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
                                                                                    <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                                                <?endif;?>
                                                                            </td>
                                                                        </tr>
                                                                    
                                                                    <?endif;?>
                                                                    
                                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
                                                                                
                                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
                                                                                    <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
                                                                                <?endif;?>
                                                                            </td>
                                                                        </tr>
                                                                    
                                                                    <?endif;?>
                                                                    
                                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                
                                                                                <div class="email">
                                                                                    <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><span class="bord"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></span></a>
                                                                                    </div>
                                                                                                                                                        
                                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
                                                                                    <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
                                                                                <?endif;?>
                                                                            </td>
                                                                        </tr>
                                                                    
                                                                    <?endif;?>
                                                                
                                                                    
                                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                                                        
                                                                        <tr>
                                                                            <td>
                                                                                
                                                                                <div class="email">
                                                                                    <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><span class="bord"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></span></a>
                                                                                </div>
                                                                                                                                                        
                                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
                                                                                    <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
                                                                                <?endif;?>
                                                                            </td>
                                                                        </tr>
                                                                    
                                                                    <?endif;?>
                                                                    
                                                                    <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                                                        <tr>
                                                                            <td>
                                                                                <?CreateSoc($arResult["SECTION"])?>
                                                                            </td>
                                                                        </tr>
                                                                    
                                                                    <?endif;?>
                                                                        
                                                                </table>
                                                                
                                                                
                                                            </div>

                                                        <?endif;?>

                                                    </div>
                                                </td>
                                            <?endif;?>

                                            <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"] && $arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]>0):?>
                                            
                                                <td class="td-lvl-1 hidden-xs">
        
                                                    <a class="callback primary <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>" data-header="<?=GetMessage("PAGE_GEN_HEADER_CALLBACK")?>"></a>  
                                                    
                                                </td>
                                            
                                            <?endif;?>
                                        </tr>
                                    </table>
                                    
                                </div>
                                 
                            </div>


                        </div>


                        <div class="col-xs-12 visible-xs">
                            <div class="header-block-mob-wrap">
                                <?
                                    $style = "";
                                    if($arResult["SECTION"]["UF_CH_BOX_ON"])
                                        $style .= "cart-on ";
                                    
                                    if(empty($arResult["MENU"]))
                                        $style .= "no-menu ";

                                    if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0)
                                        $style .= "no-contacts ";

                                    if(!$arResult["SECTION"]["UF_CH_BOX_ON"])
                                        $style .= "no-cart ";
                                ?>
                                <table class="header-block-mob <?=$style?>">
                                    <tr>
                                        <?if(!empty($arResult["MENU"])):?>
                                            <td class="mob-callmenu">
                                               <a class="menu-link primary click-op-menu"><div class="icon-hamburger-wrap"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></a>
                                            </td>
                                        <?endif;?>

                                        
                                        <td class="mob-logo">
                                            <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                            
                                                <a class="scroll" href="#body">
                                                    <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                    <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt=""/>
                                                </a>
                                            <?endif;?>
                                        </td>
                                        

                                        <?if($arResult["SECTION"]["UF_CH_BOX_ON"]):?>
                                            <td class="mob-cart area_for_mini_cart_mob">

                                                <?

                                                $frame = new \Bitrix\Main\Page\FrameHelper("mob-basket");
                                                $frame->begin();

                                                $APPLICATION->IncludeComponent(
                                                    "concept:hameleon_cart",
                                                    "mini_cart_mob",
                                                    Array(
                                                        "COMPOSITE_FRAME_MODE" => "A",
                                                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                                                        "CURRENT_LAND" => $arResult["SECTION"]["ID"],
                                                        "MESSAGE_404" => "",
                                                        "SET_STATUS_404" => "N",
                                                        "SHOW_404" => "N",
                                                        "LINK_EMPTY_BOX" => $arResult["SECTION"]["UF_LINK_EMPTY_BOX"]
                                                    )
                                                );

                                                $frame->end();

                                                ?>
                                            </td>

                                        <?endif;?>

                                        <td class="mob-contacts">

                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                
                                                  
                                                    <a class="primary" data-button="wind-modal" data-target=".wind-modalphones" data-toggle="modal">
                                                        <span></span>
                                                    </a>

                                            <?else:?>

                                                <?if(!$arResult["SECTION"]["UF_CH_BOX_ON"]):?>
                                                    <div class="empty-mob-block"></div>
                                                <?endif;?>
                                                 
                                                
                                            <?endif;?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="description visible-xs"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>          
                           
                    </div>
                </div>   

        
                
                <?if(($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] != "first") && !empty($arResult["MENU"])):?>
                
                    
                    <?
                    if(strlen($arResult["SECTION"]["UF_CHAM_MENU_PLANK"]) > 0)
                    {
                
                        $arColor = $arResult["SECTION"]["UF_CHAM_MENU_PLANK"];
                
                        if(preg_match('/^\#/', $arResult["SECTION"]["UF_CHAM_MENU_PLANK"]))
                        {
                            $arColor = hex2rgb($arResult["SECTION"]["UF_CHAM_MENU_PLANK"]);
                            $arColor = implode(',',$arColor);
                        }
                
                        $percent = 1;
                
                        if(strlen($arResult["SECTION"]["UF_CHAM_MENU_PLANK_O"])>0)
                            $percent = (100 - $arResult["SECTION"]["UF_CHAM_MENU_PLANK_O"])/100;
                        
                        $styleBg = 'background-color: rgba('.$arColor.', '.$percent.');';
                        $styleLn = 'border-bottom: 2px solid rgba('.$arColor.', '.$percent.');';
                    
                    }
                    ?>
                

                    <div class="menu-type2 hidden-xs <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "third"):?>active<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fifth"):?>active ln<?endif;?>" <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "third"):?>style="<?=$styleBg?>"<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fifth"):?>style="<?=$styleLn?>"<?endif;?> >
                    
                        <div class="container">

                            <div class="menu-type3  <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "second"):?>active<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fourth"):?>active ln<?endif;?>">

                                <div class="nav-wrap clearfix <?=$arResult["SECTION"]["UF_CH_COLOR_MENU_ENUM"]["XML_ID"]?>" <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "second"):?> style="<?=$styleBg?>"<?endif;?> <?if($arResult["SECTION"]["UF_CHAM_MENU_TYPE_ENUM"]["XML_ID"] == "fourth"):?>style="<?=$styleLn?>"<?endif;?>>

                                    <table class="wrap-main-menu">
                                        <tr>

                                            <td><div class="burger"><a class="click-op-menu"><div class="icon-hamburger-wrap"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></a></div></td>

                                            <td>
                                                <ul class="nav main-menu-nav">

                                                    <?foreach($arResult["MENU"] as $keys => $arMenu):?>
                                                     

                                                        <li class="lvl1 <?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>" id="element<?=$arMenu["ID"]?>">
                                                            <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                                    
                                                                <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?>><?=$arMenu["NAME"]?></a>
                                                          
                                                            <?else:?>
                                                        
                                                                <a href="#block<?=$arMenu['ID']?>" class="scroll" ><?=$arMenu["NAME"]?></a>
                                                            
                                                            <?endif;?>
                                                        </li>

                                                    <?endforeach;?>

                                                    
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
           
                            </div>  


                        </div>              
                    </div> 

                                

                <?endif;?>

                <?if($arResult["SECTION"]["UF_VIEW_SCRLL_MENU_ENUM"]["XML_ID"] == "menu-scroll-open"):?>

                    <div class="container hidden-xs">
                        
                        <div class="menu-slide-wrap">
            
                            <div class="row">

                                <?
                                    $cols_logo = "";
                                    $cols_menu = "col-sm-10 col-xs-0";
                                    $cols_contacs = "";
                                    $cols_callback = "";

                                    $arFile = CFile::GetFileArray($arResult["SECTION"]["PICTURE"]);
                                    if($arFile)
                                    {
                                        $cols_logo = "col-xs-1";

                                        if($arFile["WIDTH"] / $arFile["HEIGHT"] > 1.4)
                                        {
                                            $cols_logo = "col-sm-2 col-xs-0";

                                            if($arResult["SECTION"]["UF_CHAM_CALLBACK"])
                                                $cols_menu = "col-sm-9 col-xs-0";
                                        }
                                    }

                                    if($arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"])
                                    {
                                        $cols_contacs = "col-sm-4 col-xs-0";
                                        if($arFile)
                                            $cols_menu = "col-lg-7 col-sm-6 col-xs-0";
                                    }
                                    

                                    if($arResult["SECTION"]["UF_CHAM_CALLBACK"]){
                                        $cols_callback = "col-sm-1 col-xs-0";
                                        $cols_contacs = "col-lg-2 col-sm-3 col-xs-0";
                                    }

                                    if(strlen($cols_logo)<=0 && strlen($cols_contacs)<=0 && strlen($cols_callback)<=0)
                                        $cols_menu = "col-sm-12 col-xs-0";


                                ?>

                                <table class="menu-slide">
                                    <tr>
                                        <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                                            <td class="left <?=$cols_logo;?>">
                                                <a class="scroll" href="#body">
                                                    <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>400, 'height'=>180), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                                <img class="img-responsive lazyload" data-src="<?=$img["src"]?>" alt=""/>
                                                </a>
                                            </td>
                                        <?endif;?>

                                        <?if(!empty($arResult["MENU"])):?>
                                            <td class="center <?=$cols_menu?>">

                                                <div class="wrapper-main-menu">

                                                    <table class="wrap-main-menu">
                                                        <tr>
                                                            
                                                            <td><div class="burger-slide"><a class="menu-link primary click-op-menu"><div class="icon-hamburger-wrap"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></div></a></div></td>
                                                           
                                                            <td>
                                                                <ul class="nav main-menu-nav-slide t-left">
                                                        
                                                                    <?foreach($arResult["MENU"] as $keys => $arMenu):?>

                                                                        <li class="lvl1 <?if($arMenu["HIDE_LG"] == "Y") echo 'hidden-lg hidden-md'; if($arMenu["HIDE"] == "Y") echo 'hidden-sm hidden-xs';?>" id="element<?=$arMenu["ID"]?>">
                                                                            <?if(strlen($arMenu["MENU_LINK"]) > 0):?>
                                                    
                                                                                <a href="<?=$arMenu["MENU_LINK"]?>" <?if($arMenu["MENU_LINK_OPEN"] == "Y"):?>target="_blank"<?endif;?>><?=$arMenu["NAME"]?></a>
                                                                          
                                                                            <?else:?>
                                                                        
                                                                                <a href="#block<?=$arMenu['ID']?>" class="scroll" ><?=$arMenu["NAME"]?></a>
                                                                            
                                                                            <?endif;?>
                                                                        </li>

                                                                    <?endforeach;?>

                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </div>

                                            </td>
                                        <?endif;?>

                                        <?if($arResult["SECTION"]["UF_CHAM_SCRL_CNCTS"] && (strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0)):?>

                                            <td class="pre-right <?=$cols_contacs?>">
                                                <div class="main-phone">

                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?> 
                                                        <div class="element phone main1"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                    <?endif;?>
                                                        
                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 && strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) <= 0):?>
                                                        <div class="comment"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                    <?endif;?>
                                                        
                                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                        
                                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) <= 0):?> 
                                                            <div class="element email main1">
                                                        <?else:?>
                                                            <div class="comment">
                                                        <?endif;?>
                                                        
                                                        <a class="mail" href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                        
                                                        </div>

                                                    <?endif;?>


                                                    <?if($arResult["PHONES_SHOW_DOWN"]):?>

                                                        <div class="ic-open-list-contact open-list-contact"><span></span></div>

                                                        <div class="list-contacts">
                                                            <table>
                                                            
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
                                                                            
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
                                                                            
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            
                                                                            <div class="email">
                                                                                <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                                                                </div>
                                                                                                                                                    
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                            
                                                                
                                                                <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
                                                                    
                                                                    <tr>
                                                                        <td>
                                                                            
                                                                            <div class="email">
                                                                                <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></a>
                                                                            </div>
                                                                                                                                                    
                                                                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
                                                                                <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
                                                                            <?endif;?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                
                                                                <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                                                    <tr>
                                                                        <td>
                                                                            <?CreateSoc($arResult["SECTION"])?>
                                                                        </td>
                                                                    </tr>
                                                                
                                                                <?endif;?>
                                                                    
                                                            </table>
                                                            
                                                            
                                                        </div>

                                                    <?endif;?>

                                                </div>
                                            </td>

                                        <?endif;?>

                                        <?if($arResult["SECTION"]["UF_CHAM_CALLBACK"] && $arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]>0):?>
                                        
                                            <td class="right <?=$cols_callback?>">
                                                <a class="callback primary <?if(strlen($arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"])>0):?>call-modal callform<?endif;?>" data-call-modal="form<?=$arResult["SECTION"]["UF_CHAM_CALLBACK_FRM"]?>" data-header="<?=GetMessage("PAGE_GEN_HEADER_CALLBACK")?>"></a>    
                                            </td>
                                        
                                        <?endif;?>
                                        
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

                <?endif;?>
                     
                    
            </div>
      
        </header>
        
        
        
        <?if(!empty($arResult["ITEMS"])):?>
        
            <?foreach($arResult["ITEMS"] as $key=>$arItem):?>
            
                <?global $USER;?>
                
                <?if($arItem["PROPERTIES"]["TYPE"]["VALUE_XML_ID"] == "first_block"):?>
                
                    <?CreateFirstSlider($arItem);?>
                    
                <?else:?>
        
                     <?CreateElement($arItem, $arResult["SECTION"], $key);?>
                
                <?endif;?>
            
            <?endforeach;?>
        
        <?else:?>
            
            <?CreateEmptyBlock($arResult["SECTION"]);?>
            
        <?endif;?>    

        <?if(!$arResult["SECTION"]["UF_CHAM_FOOTER_HIDE"]):?>

            <?$footer_style = "";?>
            <?if(strlen($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]) > 0 || $arResult["SECTION"]["UF_CH_FTR_BG"] > 0):?>
                        
                <?if(strlen($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]) > 0):?>
                
                    <?
                        $arColor = $arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"];
                
                        if(preg_match('/^\#/', $arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]))
                        {
                            $arColor = hex2rgb($arResult["SECTION"]["UF_CH_FOOTER_BG_CLR"]);
                            $arColor = implode(',',$arColor);

                            $footer_style .= " background-color: rgb(".$arColor.");";
                        }

                        else
                            $footer_style .= " background-color: ".$arColor.";";
                
                        $percent = 1;
                
                        if(strlen($arResult["SECTION"]["UF_CH_FTR_CLR_OPACTY"])>0)
                            $percent = (100 - $arResult["SECTION"]["UF_CH_FTR_CLR_OPACTY"])/100;
                        
                        

                        $footer_style .= " opacity: ".$percent.";";

                    ?>
                
                <?endif;?>
                
                <?if(strlen($arResult["SECTION"]["UF_CH_FTR_BG"]) > 0):?>
                    <?$footer_style .= " background-position: top center; background-repeat: no-repeat;"?>
                <?endif;?>
                
            <?endif;?>

            <footer class="tone-<?=$arResult["SECTION"]["UF_CHAM_HEADER_CLR_ENUM"]["XML_ID"]?> <?if(strlen($footer_style)<=0 && $arResult["SECTION"]["UF_CH_FTR_BG"] <= 0):?>def-bg<?endif;?>">

            	<div class="bg-footer lazyload" <?if(strlen($footer_style)>0):?> style="<?=$footer_style?>"<?endif;?> <?if($arResult["SECTION"]["UF_CH_FTR_BG"] > 0):?>data-src="<?=CFile::getPath($arResult["SECTION"]["UF_CH_FTR_BG"])?>"<?endif;?>></div>

                <div class="container">
                   
                    <div class="footer-content-wrap no-margin-top-bot">
                        
                        <?if($arResult["SECTION"]["PICTURE"] > 0):?>
                        
                            <div class="logotype">
                                <?$img = CFile::ResizeImageGet($arResult["SECTION"]["PICTURE"], array('width'=>900, 'height'=>280), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                <img class="img-responsive center-block lazyload" data-src="<?=$img["src"]?>" atl="">
                            </div>
                        
                        <?endif;?>
                        
                        <?if(strlen($arResult["SECTION"]["UF_CHAM_DESCRIPT"]) > 0):?>
                            <div class="descript"><?=$arResult["SECTION"]["~UF_CHAM_DESCRIPT"]?></div>
                        <?endif;?>
                        
                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_CALL_TRACK"])>0 || ($arResult["SHOW_SOC"] && in_array("footer", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"]))):?>
                        
                            <div class="contacts-table-wrap">
                                <div class="contacts-table">
                                    
                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_CALL_TRACK"])>0):?>
                                        <div class="contacts-cell number main1">
                                            <?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></a> 
                                        </div>
                                    <?endif;?>

                                    <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>  
                                        <div class="contacts-cell email">
                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
                                        </div>
                                    <?endif;?>
                                    
                                    <?if($arResult["SHOW_SOC"] && in_array("footer", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
                                        <div class="contacts-cell socials">
                                            <?CreateSoc($arResult["SECTION"]);?>
                                        </div>
                                    <?endif;?>
                                    
                                </div>
                            </div>
                        
                        <?endif;?>
                        
                        <?if(strlen($arResult["SECTION"]["UF_CHAM_FOOTER"]) > 0):?>  
                            <div class="info"><?=$arResult["SECTION"]["~UF_CHAM_FOOTER"]?></div>
                        <?endif;?>

                        <?if(!empty($arResult["SECTION"]["AGREEMENTS"])):?>

                            <?$count = count($arResult["SECTION"]["AGREEMENTS"]);?>

                            <div class="wrap-agree">

                                <ul class="wrap-agree <?if($count == 1):?>alone<?endif;?>">
                                
                                <?foreach($arResult["SECTION"]["AGREEMENTS"] as $arAgreement):?>
                                
                                    <?
                                    $name = $arAgreement['~NAME'];
                                    
                                    if(strlen($arAgreement["PROPERTIES"]["IM_TEXT"]["VALUE"]) > 0)
                                        $name = $arAgreement["PROPERTIES"]["IM_TEXT"]["~VALUE"];
                                    ?>
                                
                                    <li><a class="call-modal callagreement" data-call-modal="agreement<?=$arAgreement["ID"]?>"><?=$name?></a></li>


                                <?endforeach;?>

                                </ul>

                            </div>

                        <?endif;?>
            
                        <?if(!$arResult["SECTION"]["UF_CHAM_COPYRIGHT"]):?>
                            

                            <?if($arResult["SECTION"]["UF_CHAM_CHOOSECOPY_ENUM"]["XML_ID"] == "cham" || $arResult["SECTION"]["UF_CHAM_CHOOSECOPY"] == "") :?>
                                <div class="copyright">
                                    <a class="hameleon" target="_blank" href="http://marketplace.1c-bitrix.ru/solutions/concept.hameleon/"></a>
                                </div>
                            <?endif;?>

                            <?if(
                                (strlen($arResult["SECTION"]["UF_CHAM_COPYPICTURE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_LINK_TEXT"]) > 0) 
                                && ($arResult["SECTION"]["UF_CHAM_CHOOSECOPY_ENUM"]["XML_ID"] == "user")):?> 
                                <?$img_img = CFile::ResizeImageGet($arResult["SECTION"]["UF_CHAM_COPYPICTURE"], array('width'=>150, 'height'=>20), BX_RESIZE_IMAGE_PROPORTIONAL, false);?>
                                
                                <div class="copyright">
                                
                                    <a class="users_copyright no-margin-left-right" <?if(strlen($arResult["SECTION"]["UF_CHAM_LINK"]) > 0):?> target="_blank" href="<?=$arResult["SECTION"]["UF_CHAM_LINK"]?>"<?endif;?>>
                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_LINK_TEXT"]) > 0):?>
                                        <span><?=$arResult["SECTION"]["~UF_CHAM_LINK_TEXT"]?></span>
                                        <?endif;?>

                                        <img class="img-responsive center-block lazyload" data-src="<?=$img_img["src"]?>" alt=""/>
                                    </a>
                                </div>

                            <?endif;?> 
                            

                        <?endif;?>

                    </div>
                </div>

                
                <?if(strlen($arResult["SECTION"]["UF_CHAM_FOOTER_REQS"]) > 0):?>
                    
                    <div class="footer-reqs">
                        
                        <div class="container">
                            <?=$arResult["SECTION"]["~UF_CHAM_FOOTER_REQS"]?>
                        </div>
                        
                    </div>
                
                <?endif;?>
                
            </footer>
        <?endif;?>

        <a href="#body" class="up scroll"></a>

        <?if($arResult["SECTION"]["UF_CHAM_SHARE"]!=0):?>
            
            <div class="public_shares hidden-xs">
            
                <a class='vkontakte' onclick="Share.vkontakte('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>','<?=$arResult["SEO"]["seo_img"]?>','<?=$arResult["SEO"]["seo_desc"]?>')"><i class="concept-vkontakte"></i><span><?=GetMessage("PAGE_GEN_HEADER_SHARES_DESC")?></span></a>
                
                <a class='facebook' onclick="Share.facebook('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>','<?=$arResult["SEO"]["seo_img"]?>','<?=$arResult["SEO"]["seo_desc"]?>')"><i class="concept-facebook-1"></i><span><?=GetMessage("PAGE_GEN_HEADER_SHARES_DESC")?></span></a>
                
                <a class='twitter' onclick="Share.twitter('<?=$arResult["SEO"]["seo_url"]?>','<?=$arResult["SEO"]["seo_title"]?>')"><i class="concept-twitter-bird-1"></i><span><?=GetMessage("PAGE_GEN_HEADER_SHARES_DESC")?></span></a>
                
            </div>
            
        <?endif;?>

        <?if($arResult["SECTION"]["UF_CALL_PHONE_ON"]):?>
            <div class="callphone-wrap">
                <?if(strlen($arResult["SECTION"]["UF_CALL_PHN_MOB_DESC"])>0):?>
                    <span class="callphone-desc"><?=$arResult["SECTION"]["UF_CALL_PHN_MOB_DESC"]?></span>
                <?endif;?>
                <a class='callphone mainColor' href='tel:<?=$arResult["SECTION"]["UF_CALL_PHONE_MOB"]?>'></a>
            </div>
        <?endif;?>

    </div> 
    <!-- /wrapper -->

    <div class="no-click-block"></div>

	<div class="wrap-modal">

	    <div class="scroll-close">
	        <div class="container row">
	            <a class="wrap-modal-close"></a>
	        </div>
	    </div>

	    <div class="modal-container"></div> 


	</div>


	<?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0 || strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
    
	    <div class="modal fade wind-modal wind-modalphones" >

	           <div class="click-for-reset"></div>
	           
	            <div class="modal-dialog">
	                <a aria-hidden="true" class="form-close" data-dismiss="modal" type="button"></a>

	                <div class="wind-content">
	                    
	                    <div class="list-contacts-modal">
	                        <table>
	                        
	                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE"]) > 0):?>
	                                
	                                <tr>
	                                    <td>
	                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE"]?></div>
	                                        
	                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM1"]) > 0 ):?>
	                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM1"]?></div>
	                                        <?endif;?>
	                                    </td>
	                                </tr>
	                            
	                            <?endif;?>
	                            
	                            <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONE2"]) > 0):?>
	                                
	                                <tr>
	                                    <td>
	                                        <div class="phone bold"><?=$arResult["SECTION"]["~UF_CHAM_PHONE2"]?></div>
	                                        
	                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_PHONECOMM2"]) > 0 ):?>
	                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_PHONECOMM2"]?></div>
	                                        <?endif;?>
	                                    </td>
	                                </tr>
	                            
	                            <?endif;?>
	                            
	                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL"]) > 0):?>
	                                
	                                <tr>
	                                    <td>
	                                        
	                                        <div class="email">
	                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL"]?></a>
	                                            </div>
	                                                                                                                
	                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM1"]) > 0 ):?>
	                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM1"]?></div>
	                                        <?endif;?>
	                                    </td>
	                                </tr>
	                            
	                            <?endif;?>
	                        
	                            
	                            <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAIL2"]) > 0):?>
	                                
	                                <tr>
	                                    <td>
	                                        
	                                        <div class="email">
	                                            <a href="mailto:<?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?>"><?=$arResult["SECTION"]["UF_CHAM_EMAIL2"]?></a>
	                                        </div>
	                                                                                                                
	                                        <?if(strlen($arResult["SECTION"]["UF_CHAM_EMAILCOMM2"]) > 0 ):?>
	                                            <div class="desc"><?=$arResult["SECTION"]["~UF_CHAM_EMAILCOMM2"]?></div>
	                                        <?endif;?>
	                                    </td>
	                                </tr>
	                            
	                            <?endif;?>
	                            
	                             <?if($arResult["SHOW_SOC"] && in_array("header", $arResult["SECTION"]["UF_CHAM_SOC_VIEW_ENUM"])):?>
	                                <tr>
	                                    <td>
	                                        <?CreateSoc($arResult["SECTION"])?>
	                                    </td>
	                                </tr>
	                            
	                            <?endif;?>
	                            
	          
	                                
	                        </table>
	                    </div>
	                    
	                </div>
	            </div>
	        </div>

	<?endif;?>




	<div class="shadow-agree"></div>

	<div class="modalArea modalAreaVideo"></div>
	<div class="modalArea modalAreaForm"></div>
	<div class="modalArea modalAreaWindow"></div>
	<div class="modalArea modalAreaAgreement"></div>

	<div class="xLoader"><div class="google-spin-wrapper"><div class="google-spin"></div></div></div>

    
</div>



<?

    $arMask["rus"] = "+7 (999) 999-99-99";
    $arMask["ukr"] = "+380 (99) 999-99-99";
    $arMask["blr"] = "+375 (99) 999-99-99";
    $arMask["kz"] = "+7 (999) 999-99-99";
    $arMask["user"] = $arResult["SECTION"]["UF_CH_USER_MASK"];
?>

<script type="text/javascript">
    /*mask phone*/
    $(document).on("focus", "form input.phone", 
        function()
        { 
            /*if(!device.android())*/
                $(this).mask("<?=$arMask[$arResult["SECTION"]["UF_CH_MASK_ENUM"]["XML_ID"]]?>");
        }
    );
</script>

<?$this->__component->arResult["CACHED_TPL"] = @ob_get_contents();
  ob_get_clean();?>