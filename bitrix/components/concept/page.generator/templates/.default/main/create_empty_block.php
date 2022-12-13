<div class="block light empty-block padding-on">
    
    <div class="shadow"></div>
 
    <div class="head def">
        
        <div class="container">
        
            <div class="no-margin-top-bot">
            
                <h2 class="main1"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_TITLE")?></h2>

                <div class="descrip"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_SUBTITLE")?></div>
                
                
            </div>

        </div>
        
    </div>
    
    <div class="content">

        <div class="container">
            <div class="row">
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    
                    <div class="start-block">
                        
                        <div class="icon start1"></div>
                        
                        <div class="text"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_STEP1")?></div>
                        
                        <div class="button">
                            <a class="button-def primary big <?=$arSection["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?> hameleon-sets-open" data-open-set="edit-sets"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_BUTTON1")?></a>
                        </div>
                    
                    </div>
                    
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 hidden-xs">
                   <div class="start-del"></div> 
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    
                    <div class="start-block">
                        
                        <div class="icon start2"></div>
                        
                        <div class="text"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_STEP2")?></div>
                        
                        <div class="button">
                            <a class="button-def primary big <?=$arSection["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>" target="_blank" href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=<?=$arSection["IBLOCK_ID"]?>&type=concept_hameleon&ID=0&lang=ru&IBLOCK_SECTION_ID=<?=$arSection["ID"]?>&find_section_section=<?=$arSection["ID"]?>&from=iblock_list_admin"><?=GetMessage("PAGE_GEN_EMPTYBLOCK_BUTTON2")?></a>
                        </div>
                    
                    </div>
                    
                </div>
            
            </div>
        </div>
        
    </div>

</div>