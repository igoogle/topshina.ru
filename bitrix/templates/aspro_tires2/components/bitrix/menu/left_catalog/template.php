<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){
	global $arTheme;
	$iVisibleItemsMenu = ($arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] ? $arTheme['MAX_VISIBLE_ITEMS_MENU']['VALUE'] : 10);
	?>
	
	<div class="menu_top_block catalog_block">
		<ul class="menu dropdown">
			<?foreach( $arResult as $key => $arItem ){?>
				<li class="full <?=($arItem["CHILD"] ? "has-child" : "");?> <?=($arItem["SELECTED"] ? "current opened" : "");?> m_<?=strtolower($arTheme["MENU_POSITION"]["VALUE"]);?> v_<?=strtolower($arTheme["MENU_TYPE_VIEW"]["VALUE"]);?>">
					<a class="icons_fa <?=($arItem["CHILD"] ? "parent" : "");?>" href="<?=$arItem["LINK"]?>" >
						<?if($arItem["IMAGES"] && $arTheme["LEFT_BLOCK_CATALOG_ICONS"]["VALUE"] == "Y"){?>
							<span class="image"><img src="<?=$arItem["IMAGES"]["src"];?>" alt="<?=$arItem["TEXT"];?>" /></span>
						<?}?>
						<span class="name"><?=$arItem["TEXT"]?></span>
						<div class="toggle_block"></div>
						<div class="clearfix"></div>
					</a>
					<?if($arItem["CHILD"]){?>
						<?$iCountChilds = count($arItem["CHILD"]);?>
						<ul class="dropdown">
							<?$i = 1;?>
							<?foreach($arItem["CHILD"] as $arChildItem){?>
								<li class="<?=($arChildItem["CHILD"] ? "has-childs" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
									<?if($arChildItem["IMAGES"] && $arTheme['SHOW_CATALOG_SECTIONS_ICONS']['VALUE'] == 'Y' && $arTheme["MENU_TYPE_VIEW"]["VALUE"] !== 'BOTTOM'){?>
										<span class="image"><a href="<?=$arChildItem["LINK"];?>"><img src="<?=$arChildItem["IMAGES"]["src"];?>" alt="<?=$arChildItem["TEXT"];?>" /></a></span>
									<?}?>
									<a class="section" href="<?=$arChildItem["LINK"];?>"><span><?=$arChildItem["TEXT"];?></span></a>
									<?if($arChildItem["CHILD"]){?>
										<ul class="dropdown">
											<?foreach($arChildItem["CHILD"] as $arChildItem1){?>
												<li class="menu_item <?if($arChildItem1["SELECTED"]){?> current <?}?>">
													<a class="parent1 section1" href="<?=$arChildItem1["LINK"];?>"><span><?=$arChildItem1["TEXT"];?></span></a>
												</li>
												<?if($i > $iVisibleItemsMenu - 1):?>
													<?break;?>
												<?endif;?>
												<?++$i;?>														
											<?}?>
										</ul>
									<?}?>
									<div class="clearfix"></div>
								</li>
							<?}?>
						</ul>
					<?}?>
				</li>
			<?}?>
		</ul>
	</div>
<?}?>