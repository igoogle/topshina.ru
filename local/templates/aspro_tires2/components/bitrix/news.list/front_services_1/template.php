<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if($arResult['ITEMS']):?>
	<div class="item-views services-items type_1 front<?=(isset($arParams['SCROLL_CLASS']) && $arParams['SCROLL_CLASS'] ? ' '.$arParams['SCROLL_CLASS'] : '')?>">
		<div class="row flexbox">
			<div class="left_wrap col-md-4">
				<div class="left_block">
					<?// intro text?>
					<?if($arParams['PAGER_SHOW_ALL']):?>
						<div class="button_more media pull-right"><a href="<?=str_replace('#SITE'.'_DIR#', SITE_DIR, $arResult['LIST_PAGE_URL'])?>"><?=(isset($arParams['SHOW_ALL_TITLE']) && strlen($arParams['SHOW_ALL_TITLE']) ? $arParams['SHOW_ALL_TITLE'] : Loc::getMessage('S_TO_SHOW_ALL_SERVICES'))?></a></div>
					<?endif?>
					<div class="text_before_items"><!--
						--><?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR."include/mainpage/services.php",
								"EDIT_TEMPLATE" => ""
							)
						);?><!--
					--></div>
					<?if($arParams['PAGER_SHOW_ALL']):?>
						<div class="button_more"><a class="btn btn-default white btn-lg" href="<?=str_replace('#SITE'.'_DIR#', SITE_DIR, $arResult['LIST_PAGE_URL'])?>"><?=(isset($arParams['SHOW_ALL_TITLE']) && strlen($arParams['SHOW_ALL_TITLE']) ? $arParams['SHOW_ALL_TITLE'] : Loc::getMessage('S_TO_SHOW_ALL_SERVICES'))?></a></div>
					<?endif?>
				</div>
			</div>
			<div class="right_wrap col-md-8">
				<?if($arParams['PAGER_SHOW_ALL']):?>
					<div class="button_more"><a href="<?=str_replace('#SITE'.'_DIR#', SITE_DIR, $arResult['LIST_PAGE_URL'])?>"><?=(isset($arParams['SHOW_ALL_TITLE']) && strlen($arParams['SHOW_ALL_TITLE']) ? $arParams['SHOW_ALL_TITLE'] : Loc::getMessage('S_TO_SHOW_ALL_SERVICES'))?></a></div>
				<?endif?>
			
				<div class="items row flexbox">
					<?foreach($arResult['ITEMS'] as $arItem):?>
						<?
						// edit/add/delete buttons for edit mode
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

						// preview picture
						if($bShowSectionImage = in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE'])){
							$bImage = strlen($arItem['PREVIEW_PICTURE']['SRC']);
							$arSectionImage = ($bImage ? CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width' => 735, 'height' => 10000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
							$imageSectionSrc = ($bImage ? $arSectionImage['src'] : '');
						}
						?>
						<div class="item col-md-4 col-sm-4 col-xs-6 <?=($bShowSectionImage && $imageSectionSrc ? '' : ' wti')?> <?=$arParams['IMAGE_CATALOG_POSITION'];?>" data-id="<?=$arItem['ID'];?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
							<div class="wrap shadow">
								<?// icon or preview picture?>
								<?if($bShowSectionImage && $imageSectionSrc):?>
									<div class="image shine">
										<div class="wrap"><a href="<?=$arItem['DETAIL_PAGE_URL'];?>"><img src="<?=$imageSectionSrc?>" alt="<?=($arItem['PREVIEW_PREVIEW_PICTURE']['ALT'] ? $arItem['PREVIEW_PREVIEW_PICTURE']['ALT'] : $arItem['NAME']);?>" title="<?=( $arItem['PREVIEW_PREVIEW_PICTURE']['TITLE'] ? $arItem['PREVIEW_PREVIEW_PICTURE']['TITLE'] : $arItem['NAME']);?>" class="img-responsive" /></a></div>
									</div>
								<?endif;?>
								
								<div class="body-info">
									<div class="wrap">
										<?// section name?>
										<?if(in_array('NAME', $arParams['FIELD_CODE'])):?>
											<div class="title"><a class="dark-color" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
										<?endif;?>
										<?// section description?>
										<?if(in_array('PREVIEW_TEXT', $arParams['FIELD_CODE']) && strlen($arItem['DESCRIPTION'])):?>
											<div class="bottom-block">
												<div class="previewtext font_xs"><?=CPriority::truncateLengthText($arItem['DESCRIPTION'], $arParams['PREVIEW_TRUNCATE_LEN'])?></div>
											</div>
										<?endif?>
									</div>
								</div>
							</div>
						</div>
					<?endforeach;?>
				</div>			
			</div>
		</div>
	</div>
<?endif;?>