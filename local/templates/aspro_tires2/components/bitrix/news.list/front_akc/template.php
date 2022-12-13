<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if($arResult["ITEMS"]){?>
	<hr>
	<div class="grey_block">
		<div class="maxwidth-theme">
			<div class="news_akc_block clearfix">
				<div class="top_block">
					<?
					$title_block=($arParams["TITLE_BLOCK"] ? $arParams["TITLE_BLOCK"] : GetMessage('AKC_TITLE'));
					$title_all_block=($arParams["TITLE_BLOCK_ALL"] ? $arParams["TITLE_BLOCK_ALL"] : GetMessage('ALL_AKC'));
					$url=($arParams["ALL_URL"] ? $arParams["ALL_URL"] : "sale/");
					$count=ceil(count($arResult["ITEMS"])/4);
					?>
					<h2 class="title_block"><?=$title_block;?></h2>
					<a class="all_link" href="<?=SITE_DIR.$url;?>"><?=$title_all_block;?></a>
				</div>
				<?$col=4;
				if($arParams["LINE_ELEMENT_COUNT"]>=3 && $arParams["LINE_ELEMENT_COUNT"]<4)
					$col=3;?>
				<div class="news_wrapp">
					<div class="loading_state shadow border custom_flex top_right" data-lg_count="5">
						<div class="items row flexbox">
							<?foreach($arResult["ITEMS"] as $arItem){
								$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
								$img_source='';
								?>
								<div class="item_block visible col-m-20 col-sm-4 col-xs-6">
									<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="item inner_wrap">
										<div class="wrap">
											<?if($arItem["PREVIEW_PICTURE"]){
												$img_source=$arItem["PREVIEW_PICTURE"];
											}elseif($arItem["DETAIL_PICTURE"]){
												$img_source=$arItem["DETAIL_PICTURE"];
											}?>
											<?if($img_source){?>
												<div class="img shine">
													<?$img = CFile::ResizeImageGet($img_source, array("width" => 400, "height" => 270), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, false, false, 75 );?>
													<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
														<img src="<?=$img["src"]?>" alt="<?=$arItem["NAME"];?>"  />
													</a>
												</div>
											<?}?>
											<div class="info">
												<a class="name dark_link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
												<?if($arParams["DISPLAY_DATE"]=="Y"){?>
													<?if( $arItem["PROPERTIES"]["PERIOD"]["VALUE"] ){?>
														<div class="date"><?=$arItem["PROPERTIES"]["PERIOD"]["VALUE"]?></div>
													<?}elseif($arItem["DISPLAY_ACTIVE_FROM"]){?>
														<div class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></div>
													<?}?>
												<?}?>
											</div>
										</div>
									</div>
								</div>
							<?}?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?}?>