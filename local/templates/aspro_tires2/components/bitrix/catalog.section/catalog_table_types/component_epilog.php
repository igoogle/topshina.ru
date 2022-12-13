<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader,
	Bitrix\Main\Localization\Loc;
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])):?>
				<?if($arParams["USE_REVIEW"] == "Y" && $arParams["FORUM_ID"]):?>
					<div class="tab-pane reviews_item_tab" id="reviews_item">
						<div class="title-tab-heading visible-xs"><?=Loc::getMessage("SECTION_ITEM_REVIEWS")?></div>
						<div>
							<?if($templateData["YM_ELEMENT_ID"]):?>
								<div id="reviews_content">
									<?$APPLICATION->IncludeComponent(
										"aspro:api.yamarket.reviews_model.tires2",
										"main",
										Array(
											"YANDEX_MODEL_ID" => $templateData["YM_ELEMENT_ID"]
										)
									);?>
								</div>
							<?elseif(IsModuleInstalled("forum")):?>
								<div id="reviews_content">
									<?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("area");?>
										<?$APPLICATION->IncludeComponent(
											"aspro:forum.topic.reviews",
											"main",
											Array(
												"CACHE_TYPE" => $arParams["CACHE_TYPE"],
												"CACHE_TIME" => $arParams["CACHE_TIME"],
												"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
												"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
												"FORUM_ID" => $arParams["FORUM_ID"],
												"ELEMENT_ID" => $arResult["ID"],
												"IBLOCK_ID" => $arParams["IBLOCK_ID"],
												"AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
												"SHOW_RATING" => "N",
												"SHOW_MINIMIZED" => "Y",
												"SECTION_REVIEW" => "Y",
												"POST_FIRST_MESSAGE" => "Y",
												"MINIMIZED_MINIMIZE_TEXT" => Loc::getMessage("HIDE_FORM"),
												"MINIMIZED_EXPAND_TEXT" => Loc::getMessage("ADD_REVIEW"),
												"SHOW_AVATAR" => "N",
												"SHOW_LINK_TO_FORUM" => "N",
												"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
											),	false
										);?>
									<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("area", "");?>
								</div>
							<?endif;?>
						</div>
					</div>
				<?endif;?>
				<?if($arParams["VIDEO"]):?>
					<?global $arVideoSection;?>
					<div class="tab-pane video_item_tab" id="video_item">
						<div class="title-tab-heading visible-xs"><?=Loc::getMessage("SECTION_ITEM_VIDEO")?></div>
						<div>
							<div class="video_block">
								<?if(count($arParams["~VIDEO"]) > 1):?>
									<table class="video_table">
										<tbody>
											<?foreach($arParams["~VIDEO"] as $v => $value):?>
												<?if(($v + 1) % 2):?>
													<tr>
												<?endif;?>
												<td width="50%"><?=str_replace('src=', 'width="458" height="257" src=', str_replace(array('width', 'height'), array('data-width', 'data-height'), $value));?></td>
												<?if(!(($v + 1) % 2)):?>
													</tr>
												<?endif;?>
											<?endforeach;?>
											<?if(($v + 1) % 2):?>
												</tr>
											<?endif;?>
										</tbody>
									</table>
								<?else:?>
									<?=$arParams["~VIDEO"][0]?>
								<?endif;?>
							</div>
						</div>
					</div>
				<?endif;?>
				<?if($arParams["DESCRIPTION"]):?>
					<div class="tab-pane desc_item_tab" id="desc_item">
						<div class="title-tab-heading visible-xs"><?=Loc::getMessage("SECTION_ITEM_DESCRIPTION")?></div>
						<div>
							<?=$arParams["~DESCRIPTION"];?>
						</div>
					</div>
				<?endif;?>
			</div> <?// .tab-content?>
		</div> <?// .tabs?>
	</div> <?// .tabs_section?>

	<?$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);

	if($loadCurrency):?>
		<script type="text/javascript">
			BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
		</script>
	<?endif;?>

<?endif;?>