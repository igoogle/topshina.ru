<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?$bImage = strlen($arResult['FIELDS']['PREVIEW_PICTURE']['SRC']);
$arImage = ($bImage ? CFile::ResizeImageGet($arResult['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 50, 'height' => 50), BX_RESIZE_IMAGE_EXACT, true) : array());
$imageSrc = ($bImage ? $arImage['src'] : SITE_TEMPLATE_PATH.'/images/svg/noimage_review_sm.svg');?>
<span class="jqmClose close"><i></i></span>

<div class="review-detail">
	<div class="item-views reviews slider front">
		<div class="item">
			<div class="header-block">
				<?if($imageSrc):?>
					<div class="image <?=($bImage ? '' : 'wpi')?>">
						<div class="image-wrapper">
							<div class="image-inner">
								<img class="img-responsive" src="<?=$imageSrc?>" alt="<?=($bImage ? $arResult['PREVIEW_PICTURE']['ALT'] : $arResult['NAME'])?>" title="<?=($bImage ? $arResult['PREVIEW_PICTURE']['TITLE'] : $arResult['NAME'])?>" />
							</div>
						</div>
					</div>
				<?endif;?>
				<div class="text">
					<div class="title">
						<?=$arResult['NAME'];?>
					</div>
					<?if($arResult['PROPERTIES']['POST']['VALUE']):?>
						<div class="company"><?=$arResult['PROPERTIES']['POST']['VALUE'];?></div>
					<?endif;?>
				</div>
			</div>
			<div class="bottom-block">
				<?if($arResult["PREVIEW_TEXT"] && (isset($arResult['FIELDS']['PREVIEW_TEXT']) && $arResult['FIELDS']['PREVIEW_TEXT'])):?>
					<div class="preview-text-wrapper">
						<div class="quote"><?=CTires2::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Quote.svg', '', false);?></div>
						<?=$arResult['FIELDS']['PREVIEW_TEXT'];?>
					</div>
				<?endif;?>
				<div class="close-block">
					<span class="btn btn-default btn-lg jqmClose"><?=Loc::getMessage('CLOSE');?></span>
				</div>
			</div>
		</div>
	</div>
</div>