<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true);?>
<?
global $arTheme;
$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
$bHideDepth1 = (isset($arParams['HIDE_SECTION_DEPTH_1']) && $arParams['HIDE_SECTION_DEPTH_1'] == 'Y' ? true : false);
?>
<?if($arResult):?>
	<?$bIndexBot = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false);?>
	<div class="table-menu">
		<table>
			<tr>
				<?foreach($arResult as $arItem):?>					
					<?$bShowChilds = $arParams["MAX_LEVEL"] > 1;
					$bWideMenu = (isset($arItem['PARAMS']['CLASS']) && strpos($arItem['PARAMS']['CLASS'], 'wide_menu') !== false);
					$bHideSectionsDepth1 = (isset($arItem['PARAMS']['HIDE_SECTIONS_DEPTH_1']) && $arItem['PARAMS']['HIDE_SECTIONS_DEPTH_1'] == 'Y' ? true : false);
					?>
					<td class="menu-item unvisible <?=($arItem["CHILD"] ? "dropdown" : "")?> <?=(isset($arItem["PARAMS"]["CLASS"]) ? $arItem["PARAMS"]["CLASS"] : "");?>  <?=($arItem["SELECTED"] ? "active" : "")?>">
						<div class="wrap">
							<a class="<?=($arItem["CHILD"] && $bShowChilds ? "dropdown-toggle" : "")?>" href="<?=$arItem["LINK"]?>">
								<div>
									<?=$arItem["TEXT"]?>
									<div class="line-wrapper"><span class="line"></span></div>
								</div>
							</a>
							<?if($arItem["CHILD"] && $bShowChilds && !$bIndexBot):?>
								<span class="tail"></span>
								<?
								$childIndex = 0;
								$countItems = count($arItem["CHILD"]["ITEMS"]);
								?>
								<ul class="dropdown-menu<?=($arItem["CHILD"] && $arItem["CHILD2"] ? ' double_childs' : '')?><?=($countItems == 1 ? ' one_left_item' : '');?>">
									<?if($arItem["CHILD"] && $arItem["CHILD2"]):?>
										<li class="double_menu left<?=($countItems == 1 ? ' one_item' : '');?>">
											<div class="items_wrap left">
												<?foreach($arItem["CHILD"]["ITEMS"] as $arBlock):?>
													<?
													if($countItems > 1 && $childIndex == $countItems - 1) continue;
													?>
													<div class="childs_wrap">
														<div class="name"><?=$arBlock["NAME"]?></div>
														<div class="items">
															<?foreach($arBlock["ITEMS"] as $arTmpItem):?>
																<div class="item"><a href="<?=$arTmpItem["PROPERTY_URL_VALUE"]?>"><?=$arTmpItem["NAME"]?></a></div>
															<?endforeach;?>
														</div>
													</div>
													<?++$childIndex;?>
												<?endforeach;?>
											</div>
											<?if($countItems > 1):?>
												<div class="items_wrap right">
													<div class="name"><?=end($arItem["CHILD"]["ITEMS"])["NAME"]?></div>
													<div class="items">
														<?foreach(end($arItem["CHILD"]["ITEMS"])['ITEMS'] as $arTmpItem):?>
															<div class="item"><a href="<?=$arTmpItem["PROPERTY_URL_VALUE"]?>"><?=$arTmpItem["NAME"]?></a></div>
														<?endforeach;?>
													</div>
												</div>
											<?endif;?>
										</li>
										<li class="double_menu right<?=($countItems == 1 ? ' one_item' : '');?>">
											<div class="title_wrap clearfix">
												<a class="all_brands pull-right" href="<?=$arItem['LINK'];?>"><?=GetMessage('ALL_BRANDS_TITLE');?></a>
												<div class="name"><?=GetMessage('POPULAR_TITLE');?></div>
											</div>
											<ul>
												<?=\Aspro\Functions\CAsproTires2::showSubMenu2($arItem, "CHILD2", $arParams, $bWideMenu, $bHideDepth1, $iVisibleItemsMenu, $bHideSectionsDepth1);?>
											</ul>
										</li>
									<?else:?>
										<?=\Aspro\Functions\CAsproTires2::showSubMenu2($arItem, "CHILD", $arParams, $bWideMenu, $bHideDepth1, $iVisibleItemsMenu, $bHideSectionsDepth1);?>
									<?endif;?>
								</ul>
							<?endif;?>
						</div>
					</td>
				<?endforeach;?>

				<td class="menu-item dropdown js-dropdown nosave unvisible">
					<div class="wrap">
						<a class="dropdown-toggle more-items" href="#">
							<span><?=\Bitrix\Main\Localization\Loc::getMessage("S_MORE_ITEMS");?></span>
						</a>
						<span class="tail"></span>
						<ul class="dropdown-menu"></ul>
					</div>
				</td>

			</tr>
		</table>
	</div>
<?endif;?>