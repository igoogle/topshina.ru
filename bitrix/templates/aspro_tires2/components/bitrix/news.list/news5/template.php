<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?$isAjax = (isset($_GET["AJAX_REQUEST"]) && $_GET["AJAX_REQUEST"] == "Y");?>
<?if($arResult['ITEMS']):?>
	<?if(!$isAjax):?>
		<?=($arParams['TITLE'] ? '<h4>'.$arParams['TITLE'].'</h4>' : '');?>
		<div class="banners-small blog blocks">
	<?endif;?>
		<div class="items row flexbox">
			<?foreach($arResult['ITEMS'] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				
				// preview image
				$bImage = (is_array($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']);
				$imageSrc = ($bImage ? $arItem['PREVIEW_PICTURE']['SRC'] : false);

				// use detail link?
				$bDetailLink = $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

				$isWideBlock = (isset($arItem['CLASS_WIDE']) && $arItem['CLASS_WIDE']);
				$hasWideBlock = (isset($arItem['CLASS']) && $arItem['CLASS']);
				?>
				<div class="col-md-4 col-sm-4">
					<div class="item shadow animation-boxs <?=($isWideBlock ? 'wide-block' : '')?> <?=($hasWideBlock ? '' : 'normal-block')?>"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<div class="inner-item">
							<?if($bImage):?>
								<div class="image shine">
									<?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?endif;?>
									<img src=<?=$imageSrc?> alt="<?=($bImage ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME'])?>" title="<?=($bImage ? $arItem['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME'])?>" />
									<?if($bDetailLink):?></a><?endif;?>
								</div>
							<?endif;?>
							<div class="title">
								<?if($bDetailLink):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?endif;?>
									<span><?=$arItem['NAME']?></span>
								<?if($bDetailLink):?></a><?endif;?>
								<?if($arItem['PREVIEW_TEXT'] && ($isWideBlock || !$bImage)):?>
									<div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
								<?endif;?>
								<?if($arItem['DISPLAY_ACTIVE_FROM']):?>
									<div class="date-block"><?=$arItem['DISPLAY_ACTIVE_FROM'];?></div>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>
		<div class="bottom_nav" <?=($isAjax ? "style='display: none; '" : "");?>>
			<?if( $arParams["DISPLAY_BOTTOM_PAGER"] == "Y" ){?><?=$arResult["NAV_STRING"]?><?}?>
		</div>
	<?if(!$isAjax):?>
		</div>
	<?endif;?>
<?endif;?>