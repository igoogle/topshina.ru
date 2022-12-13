<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){
	global $arTheme;
	$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
	$iVisibleItemsLeftMenu = ($arTheme['MAX_VISIBLE_ITEMS_LEFT_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_LEFT_MENU']['VALUE'] : 20);
?>
	<?$iCountItems = count($arResult);?>
	<div class="menu_top_block catalog_block">
		<ul class="menu dropdown">
			<?foreach( $arResult as $key => $arItem ){?>
				<?$bShowChilds = $arParams["MAX_LEVEL"] > 1;
				$bWideMenu = (isset($arItem['PARAMS']['CLASS']) && strpos($arItem['PARAMS']['CLASS'], 'wide_menu') !== false);?>
				<li class="full <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current opened" : "");?> <?=($key > $iVisibleItemsLeftMenu && !$arItem["SELECTED"]  ? "hidden state" : "");?> m_<?=strtolower($arTheme["MENU_POSITION"]["VALUE"]);?> v_<?=strtolower($arTheme["MENU_TYPE_VIEW"]["VALUE"]);?>">
					<?$bHasImg = ($arItem["IMAGES"] && $arTheme["LEFT_BLOCK_CATALOG_ICONS"]["VALUE"] == "Y");?>
					<a class="icons_fa <?=($arItem["CHILD"] ? "parent" : "");?> <?=($bHasImg? "w-img" : "");?>" href="<?=$arItem["LINK"]?>" >
						<?if($bHasImg){?>
							<span class="image"><img src="<?=$arItem["IMAGES"]["src"];?>" alt="<?=$arItem["TEXT"];?>" /></span>
						<?}?>
						<span class="name"><?=$arItem["TEXT"]?></span>
						<div class="toggle_block"></div>
						<div class="clearfix"></div>
					</a>
					<?if($arItem["CHILD"]){?>
						<ul class="dropdown">
							<?=\Aspro\Functions\CAsproTires2::showSubMenu($arItem, "CHILD", $arParams, $bWideMenu, $iVisibleItemsMenu);?>
						</ul>
					<?}?>
				</li>
			<?}?>
			<?if($iCountItems > $iVisibleItemsLeftMenu):?>
				<li><div class="colored more_link" data-hide="<?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS_MENU_HIDE");?>"><span><?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS_MENU");?></span></div></li>
			<?endif;?>
		</ul>
	</div>
<?}?>