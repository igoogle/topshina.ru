<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$bIsMainPage = $APPLICATION->GetCurDir(false) == SITE_DIR;?>


<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("area");?>

    <?if($USER->isAdmin() || $hameleon_rights > "R"):?>  

        <?\Bitrix\Main\Data\StaticHtmlCache::getInstance()->markNonCacheable();?>


        <?$APPLICATION->IncludeFile(
            SITE_TEMPLATE_PATH."/include/settings_panel.php",
            array(),
            array("MODE"=>"text")
        );?>

    <?endif;?>

<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("area");?>


<div class="blueimp-gallery blueimp-gallery-controls" id="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev"></a> 
    <a class="next"></a> 
    <a class="close"></a>
</div>

<?$APPLICATION->ShowViewContent("service_close_body");?>


<?for($i=1;$i<=10;$i++):?>
    <input type="hidden" id="custom-input-<?=$i?>" name="custom-input-<?=$i?>" value="">
<?endfor;?>

</body>

</html>