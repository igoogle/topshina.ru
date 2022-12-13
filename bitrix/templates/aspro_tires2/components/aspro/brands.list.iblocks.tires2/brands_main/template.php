<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?
global $arTheme;
$slideshowSpeed = abs(intval($arTheme['PARTNERSBANNER_SLIDESSHOWSPEED']['VALUE']));
$animationSpeed = abs(intval($arTheme['PARTNERSBANNER_ANIMATIONSPEED']['VALUE']));
$bAnimation = (bool)$slideshowSpeed;
?>

<div class="brands_slider_wrapp flexslider loading_state clearfix" data-plugin-options='{"animation": "slide", "directionNav": true, "itemMargin":30, "controlNav" :false, "animationLoop": true, <?=($bAnimation ? '"slideshow": true,' : '"slideshow": false,')?> <?=($slideshowSpeed >= 0 ? '"slideshowSpeed": '.$slideshowSpeed.',' : '')?> <?=($animationSpeed >= 0 ? '"animationSpeed": '.$animationSpeed.',' : '')?> "counts": [6,4,3,2,2]}'>
	<ul class="brands_slider slides flexbox">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$arSectionButtons = CIBlock::GetPanelButtons($arItem['IBLOCK_ID'], 0, $arItem['ID'], array('SESSID' => false, 'CATALOG' => true));

			$this->AddEditAction($arItem['ID'], $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_EDIT'));
			$this->AddDeleteAction($arItem['ID'], $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li class="visible" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<?if(in_array('PICTURE', $arParams['SECTION_FIELDS']) && $arItem["PICTURE"]):?>
					<div class="image">
						<a href="<?=$arItem["SECTION_PAGE_URL"]?>"><img class="noborder" src="<?=($arItem["PICTURE"] ? $arItem["PICTURE"]['src'] : SITE_TEMPLATE_PATH.'/images/svg/catalog_section_no_image.svg');?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
					</div>
				<?elseif(in_array('NAME', $arParams['SECTION_FIELDS'])):?>
					<div class="title"><a href="<?=$arItem["SECTION_PAGE_URL"]?>"><?=$arItem['NAME'];?></a></div>
				<?endif;?>
			</li>
		<?endforeach;?>
	</ul>
</div>