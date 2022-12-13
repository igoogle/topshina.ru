<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>
	<div class="item-views services-items type_2 front<?=(isset($arParams['SECTION_CLASS']) && $arParams['SECTION_CLASS'] ? ' '.$arParams['SECTION_CLASS'] : '');?><?=(isset($arParams['SCROLL_CLASS']) && $arParams['SCROLL_CLASS'] ? ' '.$arParams['SCROLL_CLASS'] : '')?>">
		<div class="row">
			<div class="col-md-12">
				<?if($arParams['PAGER_SHOW_ALL']):?>
					<a class="show_all pull-right" href="<?=str_replace('#SITE'.'_DIR#', SITE_DIR, $arResult['LIST_PAGE_URL'])?>"><span><?=(strlen($arParams['SHOW_ALL_TITLE']) ? $arParams['SHOW_ALL_TITLE'] : GetMessage('S_TO_SHOW_ALL_SERVICES'))?></span></a>
				<?endif;?>
				<h2><?=($arParams["TITLE"] ? $arParams["TITLE"] : Loc::getMessage("TITLE_SERVICES"));?></h2>
				<div class="clearfix"></div>
				<div class="items">
					<?foreach($arResult['ITEMS'] as $arItem):?>
						<?
						// edit/add/delete buttons for edit mode
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

						// preview picture
						if($bShowSectionImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE'])){
							$bImage = strlen($arItem['PREVIEW_PICTURE']['SRC']);
							$arSectionImage = ($bImage ? CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 388, 'height' => 10000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
							$imageSectionSrc = ($bImage ? $arSectionImage['src'] : '');
						}
						?>

						<div class="item border shadow<?=($bShowSectionImage && strlen($imageSectionSrc) ? '' : ' wti')?> <?=$arParams['IMAGE_CATALOG_POSITION'];?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
							<div class="wrap clearfix">
								<?// icon or preview picture?>
								<?if($bShowSectionImage && strlen($imageSectionSrc)):?>
									<div class="image shine">
										<div class="wrap">
											<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
												<img src="<?=$imageSectionSrc?>" alt="<?=( $arItem['PREVIEW_PICTURE']['ALT'] ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME']);?>" title="<?=( $arItem['PREVIEW_PICTURE']['TITLE'] ? $arItem['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME']);?>" class="img-responsive" />
											</a>
										</div>
									</div>
								<?endif;?>
								
								<div class="body-info">
									<?// section name?>
									<?if(in_array('NAME', $arParams['FIELD_CODE'])):?>
										<div class="title">
											<a class="dark-color" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
										</div>
									<?endif;?>
									
									<?// section description?>
									<?if(in_array('PREVIEW_TEXT', $arParams['FIELD_CODE']) && strlen($arItem['PREVIEW_TEXT'])):?>
										<div class="previewtext font_sm"><?=$arItem['PREVIEW_TEXT'];?></div>
									<?endif?>
								</div>
							</div>
						</div>
					<?endforeach;?>
				</div>
			</div>
		</div>
	</div>
<?endif;?>