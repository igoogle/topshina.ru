<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?if($arResult['ITEMS']):?>
	<div class="sections_wrapper">
		<?if(isset($arParams['TITLE']) && $arParams['TITLE']):?>
			<h2><?=$arParams['TITLE'];?></h2>
		<?endif;?>
		<div class="list items">
			<div class="row margin0 flexbox">
				<?foreach($arResult['ITEMS'] as $arItem):
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "SECTION_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));?>
					<div class="col-m-20 col-sm-4 col-xs-6">
						<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
							<div class="img shine">
								<?if($arItem['FIELDS']["PREVIEW_PICTURE"]):?>
									<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'];?>" class="thumb"><img src="<?=$arItem["PREVIEW_PICTURE"]['SRC'];?>" alt="<?=($arItem["PREVIEW_PICTURE"]["ALT"] ? $arItem["PREVIEW_PICTURE"]["ALT"] : $arItem["NAME"])?>" title="<?=($arItem["PREVIEW_PICTURE"]["TITLE"] ? $arItem["PREVIEW_PICTURE"]["TITLE"] : $arItem["NAME"])?>" /></a>
								<?else:?>
									<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'];?>" class="thumb"><img src="<?=SITE_TEMPLATE_PATH.'/images/svg/catalog_category_noimage.svg';?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
								<?endif;?>
							</div>
							<div class="name">
								<a href="<?=$arItem['DISPLAY_PROPERTIES']['LINK']['VALUE'];?>" class="dark_link"><?=$arItem['NAME'];?></a>
							</div>
							<?if($arItem['FIELDS']['PREVIEW_TEXT']):?>
								<div class="previewtext"><?=$arItem['FIELDS']['PREVIEW_TEXT'];?></div>
							<?endif;?>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
	</div>
<?endif;?>