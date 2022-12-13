<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<div class="tizers_block">
	<div class="row flexbox">
		<?foreach($arResult["ITEMS"] as $arItem){
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$name=strip_tags($arItem["~NAME"], "<br><br/>");
			?>
			<div class="item_wrap col-md-3 col-sm-6 col-xs-6">
				<div class="item clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<?if(isset($arItem['DISPLAY_PROPERTIES']['ICON']) && $arItem['DISPLAY_PROPERTIES']['ICON']['VALUE']):?>
						<div class="img">
							<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
								<a class="name" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
							<?endif;?>
							<?$arImage = CFile::ResizeImageGet($arItem['DISPLAY_PROPERTIES']['ICON']['VALUE'], array( "width" => 44, "height" => 44 ), BX_RESIZE_IMAGE_PROPORTIONAL,true );?>
							<img src="<?=$arImage['src'];?>" alt="<?=$name;?>" title="<?=$name;?>"/>
							<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
								</a>
							<?endif;?>
						</div>
					<?endif;?>
					<div class="info_tizer">
						<div class="title">
							<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
								<a class="dark-color" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
							<?endif;?>
								<?=$name;?>
							<?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
								</a>
							<?endif;?>
						</div>
						<?if($arItem['FIELDS']['PREVIEW_TEXT']):?>
							<div class="previewtext"><?=$arItem['FIELDS']['PREVIEW_TEXT'];?></div>
						<?endif;?>
					</div>
				</div>
			</div>
		<?}?>
	</div>
</div>