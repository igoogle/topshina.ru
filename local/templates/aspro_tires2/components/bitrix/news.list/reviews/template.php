<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<div class="item-views list list-type-block <?=($arParams['IMAGE_POSITION'] ? 'image_'.$arParams['IMAGE_POSITION'] : '')?> <?=$templateName;?>">
	<?// top pagination?>
	<?if($arParams['DISPLAY_TOP_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>

	<?if($arResult['SECTIONS']):?>
		<div class="group-content">
			<?// group elements by sections?>
			<?foreach($arResult['SECTIONS'] as $si => $arSection):?>
				<?if($arParams['SHOW_SECTION_PREVIEW_DESCRIPTION'] == 'Y'):?>
					<?// section name?>
					<?if(strlen($arSection['NAME'])):?>
						<h3><?=$arSection['NAME']?></h3>
					<?endif;?>

					<?// section description text/html?>
					<?if(strlen($arSection['DESCRIPTION'])):?>
						<div class="text_before_items">
							<?=$arSection['DESCRIPTION']?>
						</div>
					<?endif;?>
				<?endif;?>

				<?// show section items?>
				<div class="row sid-<?=$arSection['ID']?> items">
					<?foreach($arSection['ITEMS'] as $i => $arItem):?>
						<?
						// edit/add/delete buttons for edit mode
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						// post
						$post = $arItem['DISPLAY_PROPERTIES']['POST']['VALUE'];
						
						$bImage = strlen($arItem['~PREVIEW_PICTURE']);
						$arImage = ($bImage ? CFile::ResizeImageGet($arItem['~PREVIEW_PICTURE'], array('width' => 100, 'height' => 100), BX_RESIZE_IMAGE_PROPORTIONAL, true) : array());
						$imageSrc = ($bImage ? $arImage['src'] : SITE_TEMPLATE_PATH.'/images/svg/no-photo-reviews_big.svg');
						?>
						<div class="col-md-12">
							<div class="item review clearfix" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
								<?if($imageSrc):?>
									<div class="img_wrapper">
										<div class="quote">
											<?=CTires2::showIconSvg('quote colored', SITE_TEMPLATE_PATH.'/images/svg/quote.svg', '', false);?>
										</div>
									</div>
									<div class="image  <?=($bImage ? '' : 'wpi')?>">
										<img src="<?=$imageSrc;?>" alt="<?=( $arItem['PREVIEW_PICTURE']['ALT'] ? $arItem['PREVIEW_PICTURE']['ALT'] : $arItem['NAME']);?>" title="<?=( $arItem['PREVIEW_PICTURE']['TITLE'] ? $arItem['PREVIEW_PICTURE']['TITLE'] : $arItem['NAME']);?>" class="img-responsive" />
									</div>
								<?endif;?>
								<div class="body-info">
									<?$bHasSocProps = (isset($arItem['SOCIAL_PROPS']) && $arItem['SOCIAL_PROPS']);?>
									<div class="title-wrapper <?=($bHasSocProps ? 'bottom-props' : '');?>">
										<div class="title"><?=$arItem['NAME']?></div>
										<?if($bHasSocProps):?>
											<!-- noindex -->
												<?foreach($arItem['SOCIAL_PROPS'] as $arProp):?>
													<a href="<?=$arProp['VALUE'];?>" target="_blank" rel="nofollow" class="value <?=strtolower($arProp['CODE']);?>"><?=$arProp['VALUE'];?></a>
												<?endforeach;?>
											<!-- /noindex -->
										<?endif;?>
									</div>
									<?if($arItem['DISPLAY_PROPERTIES']['POST']['VALUE']):?>
										<div class="post"><?=$arItem['DISPLAY_PROPERTIES']['POST']['VALUE']?></div>
									<?endif;?>
									<?if($arItem["PREVIEW_TEXT"]):?>
										<div class="text"><?=$arItem['PREVIEW_TEXT']?></div>
									<?endif;?>
									<?if($arItem['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE']):?>
										<div class="files_block">
											<div class="row flexbox">
												<?foreach($arItem['DISPLAY_PROPERTIES']['DOCUMENTS']['VALUE'] as $fileID):?>
													<div class="col-md-4 col-sm-6">
														<?$arFile=CTires2::GetFileInfo($fileID);?>
														<div class="file_type clearfix <?=$arFile["TYPE"];?>">
															<i class="icon"></i>
															<div class="description">
																<a target="_blank" href="<?=$arFile["SRC"];?>" class="dark_link"><?=$arFile["DESCRIPTION"];?></a>
																<span class="size">
																	<?=$arFile["FILE_SIZE_FORMAT"];?>
																</span>
															</div>
														</div>
													</div>
												<?endforeach;?>
											</div>
										</div>
									<?endif;?>
									<?if($arItem['DISPLAY_PROPERTIES']['VIDEO']['VALUE']):?>
										<div class="video">
											<?foreach($arItem['DISPLAY_PROPERTIES']['VIDEO']['~VALUE'] as $value):?>
												<div class="video-inner"><?=$value;?></div>
											<?endforeach;?>
										</div>
									<?endif;?>
								</div>
							</div>
						</div>
					<?endforeach;?>
				</div>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?// bottom pagination?>
	<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
		<?=$arResult['NAV_STRING']?>
	<?endif;?>
</div>