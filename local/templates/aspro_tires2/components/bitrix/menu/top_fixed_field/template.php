<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?if($arResult):?>
	<?
	global $arTheme;
	$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
	$bHideDepth1 = (isset($arParams['HIDE_SECTION_DEPTH_1']) && $arParams['HIDE_SECTION_DEPTH_1'] == 'Y' ? true : false);
	?>
	<?$bIndexBot = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false);?>
	<ul class="nav nav-pills responsive-menu visible-xs" id="mainMenuF">
		<?foreach($arResult as $arItem):?>
			<?
			$bShowChilds = ($arParams["MAX_LEVEL"] > 1 && $arItem["PARAMS"]["CHILD"]!="N");
			$bHideSectionsDepth1 = (isset($arItem['PARAMS']['HIDE_SECTIONS_DEPTH_1']) && $arItem['PARAMS']['HIDE_SECTIONS_DEPTH_1'] == 'Y' ? true : false);
			?>
			<li class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown" : "")?> <?=($arItem["SELECTED"] ? "active" : "")?>">
				<a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>">
					<?=$arItem["TEXT"]?>
					<?if($arItem["CHILD"] && $bShowChilds):?>
						<i class="fa fa-angle-right"></i>
					<?endif;?>
				</a>
				<?if($arItem["CHILD"] && $bShowChilds && !$bIndexBot):?>
					<ul class="dropdown-menu fixed_menu_ext">
						<?=\Aspro\Functions\CAsproTires2::showSubMenu2($arItem, "CHILD", $arParams, $bWideMenu, $bHideDepth1, $iVisibleItemsMenu, $bHideSectionsDepth1);?>
					</ul>
				<?endif;?>
			</li>
		<?endforeach;?>
	</ul>
<?endif;?>