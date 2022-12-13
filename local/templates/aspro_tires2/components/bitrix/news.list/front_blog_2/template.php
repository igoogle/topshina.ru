<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if($arResult["ITEMS"]){?>
	<div class="banners-small blog table-elements blocks portfolio">
		<div class="top_block">
			<?if($arParams['TITLE_BLOCK']):?>
				<h2><?=$arParams['TITLE_BLOCK'];?></h2>
			<?endif;?>
			<?if($arParams['TITLE_BLOCK_ALL'] && $arParams['ALL_URL']):?>
				<a href="<?=SITE_DIR.$arParams['ALL_URL']?>" class="all_link"><?=$arParams['TITLE_BLOCK_ALL'];?></a>
			<?endif;?>			
		</div>
		<div class="items row flexbox">
			<?if(count($arResult["ITEMS"]) != 5):?>
				<?foreach($arResult["ITEMS"] as $key => $arItem){
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$img_source = ($arItem["PREVIEW_PICTURE"] ? $arItem["PREVIEW_PICTURE"] : ($arItem["DETAIL_PICTURE"] ? $arItem["DETAIL_PICTURE"] : ''));
					?>
					<div class="item_wrap col-md-3 col-sm-6 col-xs-6 col-xxs-12">
						<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item sliced shadow animation-box <?=(!$img_source ? 'nimg' : '');?>">
							<div class="inner-item">								
								<?if($img_source):?>
									<div class="image shine">
										<?$img = CFile::ResizeImageGet($img_source, array("width" => 700, "height" => 700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, false, false, 75 );?>
										<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
											<img src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>"  />
										</a>
									</div>
								<?endif;?>
								<div class="title">
									<?if($arItem['DISPLAY_ACTIVE_FROM']):?>
										<div class="date-block"><?=$arItem['DISPLAY_ACTIVE_FROM'];?></div>
									<?endif;?>
									<?if(isset($arItem['SECTIONS']) && $arItem['SECTIONS']):?>
										<div class="sticker-block">
											<?=implode(', ', $arItem['SECTIONS']);?>
										</div>
									<?endif;?>
									<div class="name">
										<a class="dark-color" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><span><?=$arItem["NAME"]?></span></a>
									</div>
									<?if(!$img_source && $arItem['PREVIEW_TEXT']):?>
										<div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
									<?endif;?>
								</div>
							</div>
						</div>
					</div>
				<?}?>
			<?else:?>
				<?$bEvenPage = (($arResult['NAV_RESULT'] && $arResult['NAV_RESULT']->NavPageCount && $arResult['NAV_RESULT']->NavPageNomer %2 == 0) || false);?>
				<?ob_start();?>
					<?foreach($arResult["ITEMS"] as $key => $arItem){
						if($key)
							continue;
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						$img_source = ($arItem["PREVIEW_PICTURE"] ? $arItem["PREVIEW_PICTURE"] : ($arItem["DETAIL_PICTURE"] ? $arItem["DETAIL_PICTURE"] : ''));
						?>
						<div class="item_wrap">
							<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item sliced wide-block <?=(!$img_source ? 'nimg' : '');?>">
								<div class="inner-item">
									<?if($img_source):?>
										<div class="image shine">
											<?$img = CFile::ResizeImageGet($img_source, array("width" => 700, "height" => 700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, false, false, 75 );?>
											<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
												<img src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>"  />
											</a>
										</div>
									<?endif;?>
									<div class="title">
										<?if($arItem['DISPLAY_ACTIVE_FROM']):?>
											<div class="date-block"><?=$arItem['DISPLAY_ACTIVE_FROM'];?></div>
										<?endif;?>
										<?if(isset($arItem['SECTIONS']) && $arItem['SECTIONS']):?>
											<div class="sticker-block">
												<?=implode(', ', $arItem['SECTIONS']);?>
											</div>
										<?endif;?>
										<div class="name">
											<a class="dark-color" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><span><?=$arItem["NAME"]?></span></a>
										</div>
										<?if($arItem['PREVIEW_TEXT'] && in_array('PREVIEW_TEXT', $arParams['FIELD_CODE'])):?>
											<div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
										<?endif;?>
									</div>
								</div>
							</div>
						</div>
					<?}?>
				<?$big_block = ob_get_clean();?>
				<?ob_start();?>
					<?$count = count($arResult["ITEMS"])-1;?>
					<div class="<?=($count > 2 ? 'items_wrapper' : '');?> wrapper s_<?=$count;?>">
						<div class="row <?=($count > 2 ? 'items' : '');?> flexbox">
							<?foreach($arResult["ITEMS"] as $key => $arItem){
								if(!$key)
									continue;
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								$img_source = ($arItem["PREVIEW_PICTURE"] ? $arItem["PREVIEW_PICTURE"] : ($arItem["DETAIL_PICTURE"] ? $arItem["DETAIL_PICTURE"] : ''));
								?>
								<div class="item_wrap col-md-6 col-sm-6 col-xs-6 col-xxs-12">
									<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item sliced <?=(!$img_source ? 'nimg' : '');?>">
										<?if($img_source):?>
											<div class="image shine">
												<?$img = CFile::ResizeImageGet($img_source, array("width" => 700, "height" => 700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, false, false, 75 );?>
												<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
													<img src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>"  />
												</a>
											</div>
										<?endif;?>
										<div class="title">
											<?if($arItem['DISPLAY_ACTIVE_FROM']):?>
												<div class="date-block"><?=$arItem['DISPLAY_ACTIVE_FROM'];?></div>
											<?endif;?>
											<?if(isset($arItem['SECTIONS']) && $arItem['SECTIONS']):?>
												<div class="sticker-block">
													<?=implode(', ', $arItem['SECTIONS']);?>
												</div>
											<?endif;?>
											<div class="name">
												<a class="dark-color" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><span><?=$arItem["NAME"]?></span></a>
											</div>
											<?if(!$img_source && $arItem['PREVIEW_TEXT']):?>
												<div class="prev_text-block"><?=$arItem['PREVIEW_TEXT'];?></div>
											<?endif;?>
										</div>
									</div>
								</div>
							<?}?>
						</div>
					</div>
				<?$items_block = ob_get_clean();?>
				<div class="col-md-6 col-sm-12 custom">
					<?if($bEvenPage):?>
						<?=$items_block;?>
					<?else:?>
						<?=$big_block;?>
					<?endif;?>
				</div>
				<div class="col-md-6 col-sm-12 custom">
					<?if($bEvenPage):?>
						<?=$big_block;?>
					<?else:?>
						<?=$items_block;?>
					<?endif;?>
				</div>
			<?endif;?>
		</div>
	</div>
<?}?>