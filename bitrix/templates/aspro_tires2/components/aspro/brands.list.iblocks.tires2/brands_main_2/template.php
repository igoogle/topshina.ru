<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if($arResult):?>
	<div class="main_brands type_2 tab_slider_wrapp">
		<div class="top_blocks clearfix">
			<?if($arParams['TITLE']):?>
				<h2><?=$arParams['TITLE'];?></h2>
			<?endif;?>
			<ul class="tabs">
				<?$i = 0;?>
				<?foreach($arResult as $key => $arIBlock):?>
					<li class="<?=($i == 0 ? 'cur clicked' : '');?>" data-code="<?=$arIBlock['CODE'];?>"><span><?=$arIBlock['NAME'];?></span></li>
					<?++$i;?>
				<?endforeach;?>
			</ul>
		</div>
		<ul class="tabs_content">
			<?$i = 0;?>
			<?foreach($arResult as $arIBlock):?>
				<li class="tab items flexbox catalog_section_list type_2 row<?=($i == 0 ? ' cur' : '');?>" data-code="<?=$arIBlock['CODE'];?>">
					<?foreach($arIBlock["ITEMS"] as $arItem):?>
						<?
						if(!$arItem['PICTURE']){
							continue;
						}
						
						$arSectionButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], 0, $arItem['ID'], array('SESSID' => false, 'CATALOG' => true));

						$this->AddEditAction($arItem['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
						<div class="item_block col-m-20 col-sm-4 col-xs-6">
							<div class="section_item item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
								<div class="section_item_inner">
									<div class="image">
										<img class="img-responsive" src="<?=($arItem['PICTURE'] ? $arItem['PICTURE']['src'] : SITE_TEMPLATE_PATH.'/images/svg/catalog_section_no_image.svg');?>" alt="<?=($arItem["PICTURE"]["ALT"] ? $arItem["PICTURE"]["ALT"] : $arItem["NAME"])?>" title="<?=($arItem["PICTURE"]["TITLE"] ? $arItem["PICTURE"]["TITLE"] : $arItem["NAME"]);?>" />
									</div>
									<a href="<?=$arItem["SECTION_PAGE_URL"]?>" class="thumb"></a>
								</div>
							</div>
						</div>
					<?endforeach;?>
				</li>
			<?++$i;?>
			<?endforeach;?>
		</ul>
	</div>
<?endif;?>