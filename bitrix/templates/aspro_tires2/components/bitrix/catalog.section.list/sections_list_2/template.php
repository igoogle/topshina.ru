<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?/*set array props for component_epilog*/
$templateData = array(
	'COUNTS_ALL_SECTIONS' => $arResult['COUNTS_ALL_SECTIONS'],
	'PAGE' => $arResult['PAGE'],
);
/**/?>
<?if($arResult["SECTIONS"]){?>
	<div>
		<div class="catalog_section_list type_2 row items flexbox">

			<?foreach( $arResult["SECTIONS"] as $arItems ){
				$this->AddEditAction($arItems['ID'], $arItems['EDIT_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_EDIT"));
				$this->AddDeleteAction($arItems['ID'], $arItems['DELETE_LINK'], CIBlock::GetArrayByID($arItems["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
			?>
				<div class="item_block col-m-20 col-sm-4 col-xs-6">
					<div class="section_item item" id="<?=$this->GetEditAreaId($arItems['ID']);?>">
						<div class="section_item_inner">
							<?if ($arParams["SHOW_SECTION_LIST_PICTURES"]=="Y"):?>
								<?$collspan = 2;?>
								<div class="image">
									<?if($arItems["PICTURE"]["SRC"]):?>
										<?$img = CFile::ResizeImageGet($arItems["PICTURE"]["ID"], array( "width" => 120, "height" => 50 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true );?>
										<img class="img-responsive" src="<?=$img["src"]?>" alt="<?=($arItems["PICTURE"]["ALT"] ? $arItems["PICTURE"]["ALT"] : $arItems["NAME"])?>" title="<?=($arItems["PICTURE"]["TITLE"] ? $arItems["PICTURE"]["TITLE"] : $arItems["NAME"])?>" />
									<?elseif($arItems["~PICTURE"]):?>
										<?$img = CFile::ResizeImageGet($arItems["~PICTURE"], array( "width" => 120, "height" => 50 ), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true );?>
										<img class="img-responsive" src="<?=$img["src"]?>" alt="<?=($arItems["PICTURE"]["ALT"] ? $arItems["PICTURE"]["ALT"] : $arItems["NAME"])?>" title="<?=($arItems["PICTURE"]["TITLE"] ? $arItems["PICTURE"]["TITLE"] : $arItems["NAME"])?>" />
									<?else:?>
										<img class="img-responsive" src="<?=SITE_TEMPLATE_PATH?>/images/svg/catalog_section_no_image.svg" alt="<?=$arItems["NAME"]?>" title="<?=$arItems["NAME"]?>" />
									<?endif;?>
								</div>
							<?endif;?>
							<div class="section_info">
								<div class="name"><?=$arItems["NAME"]?></div>
							</div>
							<a href="<?=$arItems["SECTION_PAGE_URL"]?>" class="thumb"></a>
						</div>
					</div>
				</div>
			<?}?>
		</div>
	</div>
<?}?>