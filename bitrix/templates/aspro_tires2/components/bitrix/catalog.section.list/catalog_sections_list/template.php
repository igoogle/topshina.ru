<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true );?>
<?use \Bitrix\Main\Localization\Loc;?>
<?/*set array props for component_epilog*/
$templateData = array(
	'COUNTS_ALL_SECTIONS' => $arResult['COUNTS_ALL_SECTIONS'],
	'PAGE' => $arResult['PAGE'],
);
/**/?>
<?if($arResult['SECTIONS']):?>
	<?if($arParams["IS_AJAX"] == "N"):?>
	<div class="sections_inner_wrapper model_view">
		<div class="item_types_block">
			<?$bShowProps = ((isset($arResult["SEZON_PROPS"]["SPIKES"]) && count($arResult["SEZON_PROPS"]["SPIKES"]) > 1) || (isset($arResult["SEZON_PROPS"]["SEZON"]) && count($arResult["SEZON_PROPS"]["SEZON"]) > 1));?>
			<div class="block_wrapper <?=(!$bShowProps ? "only_one" : "");?>">
				<div class="title"><?=$arResult["TITLES"]["TOP"]?></div>
			</div>
			<?if($bShowProps):?>
				<div class="block_wrapper">
					<div class="items">
						<div class="item colored active" <?=($arParams["AJAX_FILTER_ITEM"] != "N" ? 'data-ajax="Y"' : '');?> data-group="all"><span><?=$arResult["TITLES"]["ALL"]?></span></div>
						<?if(isset($arResult["SEZON_PROPS"]["SEZON"])):?>
							<?foreach($arResult["SEZON_PROPS"]["SEZON"] as $key => $arProp):?>
								<div class="item colored" <?=($arParams["AJAX_FILTER_ITEM"] != "N" ? 'data-ajax="Y"' : '');?> data-type="SEZON" data-group="<?=$arProp["ID"];?>"><span><?=$arProp["VALUE"];?></span></div>
							<?endforeach;?>
						<?endif?>

						<?if(isset($arResult["SEZON_PROPS"]["SPIKES"])):?>
							<?foreach($arResult["SEZON_PROPS"]["SPIKES"] as $key => $arProp):?>
								<div class="item colored" <?=($arParams["AJAX_FILTER_ITEM"] != "N" ? 'data-ajax="Y"' : '');?> data-type="SPIKES" data-group="<?=$arProp["ID"];?>"><span><?=$arProp["VALUE"];?></span></div>
							<?endforeach;?>
						<?endif?>
					</div>
				</div>
			<?endif;?>
			<div class="sort_header view_block">
				<!--noindex-->
					<div class="sort_display">
						<a rel="nofollow" href="<?=str_replace('+', '%2B', $APPLICATION->GetCurPageParam('display=block', array('display')));?>" class="sort_btn block <?=("block" == $arParams["DISPLAY"] ? 'current' : '')?>"><i title="<?=Loc::getMessage("SECT_DISPLAY_BLOCK");?>"></i></a>
						<a rel="nofollow" href="<?=str_replace('+', '%2B', $APPLICATION->GetCurPageParam('display='.$arParams["DISPLAY"], array('display')));?>" class="sort_btn list <?=("list" == $arParams["DISPLAY"] ? 'current' : '')?>"><i title="<?=Loc::getMessage("SECT_DISPLAY_LIST")?>"></i></a>
					</div>
				<!--/noindex-->
			</div>
		</div>
	<?endif;?>
		<div class="list items">
			<div class="display_list">
				<?foreach($arResult['SECTIONS'] as $arSection):
					$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
					$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));?>
					<div class="list_item_wrapp item_wrap item <?=($arSection["SHOW_DATA_CONDITION"] ? $arSection["SHOW_DATA_CONDITION"] : "")?>">
						<table class="list_item" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
							<tbody>
								<tr class="adaptive_name">
									<td colspan="<?=(($arParams["SHOW_SECTION_LIST_PICTURES"]!="N") ? 3 : 2);?>">
										<div class="desc_name"><a href="<?=$arSection['SECTION_PAGE_URL'];?>"><span><?=$arSection["NAME"];?></span></a></div>
									</td>
								</tr>
								<tr>
									<?if($arParams["SHOW_SECTION_LIST_PICTURES"]!="N"):?>
										<td class="image_block">
											<div class="image_wrapper_block">
												<?if($arSection["STICKERS"]):?>
													<div class="stickers">
														<?foreach($arSection["STICKERS"] as $arSticker):?>
															<div><div class="<?=$arSticker['CLASS']?>"><?=$arSticker['VALUE']?></div></div>
														<?endforeach;?>
													</div>
												<?endif;?>
												<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="thumb shine">
													<?if($arSection["PICTURE"]["SRC"]):?>
														<?$img = CFile::ResizeImageGet($arSection["PICTURE"]["ID"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPRTIONAL_ALT, true );?>
														<img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" />
													<?elseif($arSection["~PICTURE"]):?>
														<?$img = CFile::ResizeImageGet($arSection["~PICTURE"], array( "width" => 170, "height" => 170 ), BX_RESIZE_IMAGE_PROPRTIONAL_ALT, true );?>
														<img src="<?=$img["src"]?>" alt="<?=($arSection["PICTURE"]["ALT"] ? $arSection["PICTURE"]["ALT"] : $arSection["NAME"])?>" title="<?=($arSection["PICTURE"]["TITLE"] ? $arSection["PICTURE"]["TITLE"] : $arSection["NAME"])?>" />
													<?else:?>
														<img src="<?=\Aspro\Functions\CAsproTires2::showNoImage($arParams["IBLOCK_ID"])?>" alt="<?=$arSection["NAME"]?>" title="<?=$arSection["NAME"]?>" />
													<?endif;?>
												</a>
											</div>
										</td>
									<?endif;?>
									<td class="description_wrapp">
										<div class="item_info <?=$arParams["TYPE_SKU"]?>">
											<div class="items-title">
												<a href="<?=$arSection['SECTION_PAGE_URL'];?>" class="dark_link"><span><?=$arSection["NAME"];?></span></a>
												<?if($arSection["SEZON_PROPS"]):?>
													<div class="sezons line">
														<?if(isset($arSection["SEZON_PROPS"]["SEZON"])):?>
															<?foreach($arSection["SEZON_PROPS"]["SEZON"] as $arSticker):?>
																<div><div class="<?=$arSticker["CLASS"]?>" title="<?=$arSticker["VALUE"]?>"><?=$arSticker["VALUE"]?></div></div>
															<?endforeach;?>
														<?endif;?>
														<?if(isset($arSection["SEZON_PROPS"]["SPIKES"])):?>
															<?foreach($arSection["SEZON_PROPS"]["SPIKES"] as $arSticker):?>
																<div><div class="<?=$arSticker["CLASS"]?>" title="<?=$arSticker["VALUE"]?>"><?=$arSticker["VALUE"]?></div></div>
															<?endforeach;?>
														<?endif;?>
													</div>
												<?endif;?>
											</div>
											<div class="wrapp_stockers">
												<?if($arParams["SHOW_RATING"] == "Y"):?>
													<div class="rating rating_wrapper">
														<div class="iblock-vote small">
															<?$rating = (round($arSection["SUMM_RATING"]/$arSection["ITEMS_COUNT"]));?>
															<table>
																<tbody>
																	<tr>
																		<?for($i=0; $i < 5; $i++):?>
																			<td><div class="star-<?=(($rating > $i) ? "voted" : "empty");?>" title="<?=$i+1;?>"></div></td>
																		<?endfor;?>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												<?endif;?>

												<?$frame = $this->createFrame('quantity_'.$arSection["ID"])->begin('');?>
													<?$arQuantityData = CTires2::GetQuantityArray($arSection["TOTAL_QUANTITY_COUNT"]);?>
													<?if($arQuantityData["HTML"]):?>
														<div class="quantity_block_wrapper">
															<?=$arQuantityData["HTML"];?>
														</div>
													<?endif;?>
												<?$frame->end();?>
											</div>
											<?if($arParams["SECTIONS_LIST_PREVIEW_DESCRIPTION"] != "N"):?>
												<?$arTmpSection = CTires2Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" =>"N", "TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $arSection["ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]));?>
												<?if($arTmpSection[$arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]]):?>
													<div class="preview_text"><?=$arTmpSection[$arParams["SECTIONS_LIST_PREVIEW_PROPERTY"]]?></div>
												<?elseif($arItems["DESCRIPTION"]):?>
													<div class="preview_text"><?=$arItems["DESCRIPTION"]?></div>
												<?endif;?>
											<?endif;?>
										</div>
									</td>
									<td class="information_wrapp main_item_wrapper">
										<div class="information">
											<div class="information_inner">
												<?if($arSection["MIN_PRICE"]):?>
													<?$frame = $this->createFrame('price_'.$arSection["ID"])->begin('');?>
														<div class="prices_block">
															<div class="cost prices clearfix">
																<div class="price">
																	<?=Loc::getMessage("PRICES_FROM")." ".\Aspro\Functions\CAsproItem::getCurrentPrice($arSection["MIN_PRICE"]["DISCOUNT_PRICE"], $arSection["MIN_PRICE"], false);?>
																</div>
															</div>
														</div>
													<?$frame->end();?>
												<?endif;?>
												<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="btn btn-default basket read_more"><?=\Bitrix\Main\Config\Option::get("aspro.tires2", "EXPRESSION_READ_MORE_OFFERS_DEFAULT", GetMessage("EXPRESSION_READ_MORE_OFFERS_DEFAULT"), SITE_ID)?></a>
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				<?endforeach;?>
			</div>
		</div>
	<?if($arParams["IS_AJAX"] == "N"):?>
	</div>
	<?endif;?>
<?endif;?>