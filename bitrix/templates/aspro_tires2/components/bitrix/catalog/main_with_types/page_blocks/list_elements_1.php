<?
/* hide compare link from module options */
if(CTires2::GetFrontParametrValue('CATALOG_COMPARE') == 'N')
	$arParams["USE_COMPARE"] = 'N';
/**/

/* hide delay link from module options */
if(CTires2::GetFrontParametrValue('CATALOG_DELAY') == 'N')
	$arParams["DISPLAY_WISH_BUTTONS"] = 'N';
/**/
?>

<div class="js_wrapper_block">
	<div class="js_top_block">
		<?if($arSeoItem):?>
			<div class="seo_block">
				<?if($arSeoItem["DETAIL_PICTURE"]):?>
					<img src="<?=CFile::GetPath($arSeoItem["DETAIL_PICTURE"]);?>" alt="" title="" class="img-responsive"/>
				<?endif;?>
				
				<?$APPLICATION->ShowViewContent('sotbit_seometa_top_desc');?>

				<?if($arSeoItem["PREVIEW_TEXT"]):?>
					<?=$arSeoItem["PREVIEW_TEXT"]?>
				<?endif;?>
				<?if($arSeoItem["PROPERTY_FORM_QUESTION_VALUE"]):?>
					<table class="order-block noicons">
						<tbody>
							<tr>
								<td class="col-md-9 col-sm-8 col-xs-7 valign">
									<div class="text">
										<?$APPLICATION->IncludeComponent(
											 'bitrix:main.include',
											 '',
											 Array(
												  'AREA_FILE_SHOW' => 'page',
												  'AREA_FILE_SUFFIX' => 'ask',
												  'EDIT_TEMPLATE' => ''
											 )
										);?>
									</div>
								</td>
								<td class="col-md-3 col-sm-4 col-xs-5 valign">
									<div class="btns">
										<span><span class="btn btn-default btn-lg white transparent animate-load" data-event="jqm" data-param-form_id="ASK" data-name="question"><span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : GetMessage('S_ASK_QUESTION'))?></span></span></span>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				<?endif;?>
				<?if($arSeoItem["PROPERTY_TIZERS_VALUE"]):?>
					<div class="landing_tizers">
						<?$GLOBALS["arLandingTizers"] = array("ID" => $arSeoItem["PROPERTY_TIZERS_VALUE"]);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"tires2",
							array(
								"IBLOCK_TYPE" => "aspro_tires2_content",
								"IBLOCK_ID" => CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_content"]["aspro_tires2_tizers"][0],
								"NEWS_COUNT" => "4",
								"SORT_BY1" => "SORT",
								"SORT_ORDER1" => "ASC",
								"SORT_BY2" => "ID",
								"SORT_ORDER2" => "DESC",
								"FILTER_NAME" => "arLandingTizers",
								"FIELD_CODE" => array(
									0 => "",
									1 => "",
								),
								"PROPERTY_CODE" => array(
									0 => "LINK",
									1 => "ICON",
								),
								"CHECK_DATES" => "Y",
								"DETAIL_URL" => "",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"AJAX_OPTION_HISTORY" => "N",
								"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"PREVIEW_TRUNCATE_LEN" => "",
								"ACTIVE_DATE_FORMAT" => "j F Y",
								"SET_TITLE" => "N",
								"SET_STATUS_404" => "N",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"HIDE_LINK_WHEN_NO_DETAIL" => "N",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"INCLUDE_SUBSECTIONS" => "Y",
								"PAGER_TEMPLATE" => "",
								"DISPLAY_TOP_PAGER" => "N",
								"DISPLAY_BOTTOM_PAGER" => "N",
								"PAGER_TITLE" => "",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"COMPONENT_TEMPLATE" => "tires2",
								"SET_BROWSER_TITLE" => "N",
								"SET_META_KEYWORDS" => "N",
								"SET_META_DESCRIPTION" => "N",
								"SET_LAST_MODIFIED" => "N",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"SHOW_404" => "N",
								"MESSAGE_404" => ""
							),
							false, array("HIDE_ICONS" => "Y")
						);?>
					<?endif;?>
				</div>
				<?$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');?>
			</div>
		<?endif;?>

	</div>

	<?$context=\Bitrix\Main\Application::getInstance()->getContext();
	$request=$context->getRequest();?>

	<?global $arTheme;?>

	<?$isAjax="N";?>
	<?if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && ($request["ajax_get"] == "Y" || $request["ajax_basket"]=="Y" || $_POST["AJAX_POST"] == "Y"))
		$isAjax="Y";

	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && $request["ajax_get_filter"] == "Y")
		$isAjaxFilter="Y";

	if($isAjaxFilter == "Y")
		$isAjax="N";?>

	<?if($arParams['AJAX_MODE'] == 'Y' && strpos($_SERVER['REQUEST_URI'], 'bxajaxid') !== false):?>
		<script type="text/javascript">
			setStatusButton();
		</script>
	<?endif;?>

	<div class="js_bottom_block">
		<div class="right_block1 clearfix catalog <?=strtolower($arTheme["FILTER_VIEW"]["VALUE"]);?>" id="right_block_ajax">
			<div class="inner_wrapper">
				<?if($arSection["BANNER"] && !$arSeoItem && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
					<div class="img_banner_wrapper"><img src="<?=CFile::GetPath($arSection["BANNER"]);?>" alt="<?=$arSection["NAME"];?>" title="<?=$arSection["NAME"];?>" class="img-responsive"/></div>
				<?endif;?>
		<?if(!$iSectionsCount):?>
			<?if($arSection):?>
				<div class="list_model_wrapper">
					<div class="list_model_Inner_wrapper">
						<div class="img_wrapper">
							<?=$APPLICATION->ShowViewContent('section_stickers')?>
							<div class="img_inner">
								<?if($arSection["PICTURE"]):?>
									<?$arImage = CFile::GetFileArray($arSection["PICTURE"]);?>
									<a href="<?=$arImage["SRC"];?>" class="popup_link fancy" title="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>">
										<img src="<?=$arImage["SRC"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>"/>
										<div class="zoom"></div>
									</a>
								<?else:?>
									<img src="<?=\Aspro\Functions\CAsproTires2::showNoImage($arParams["IBLOCK_ID"]);?>" alt="<?=$arSection["NAME"];?>" />
								<?endif;?>
							</div>
						</div>
						<div class="info_wrapper">
							<div class="info_item">
								<div class="top_info">
									<div class="rows_block">
										<?if($arParams["SHOW_RATING"] == "Y"):?>
											<div class="item_block col-2">
												<?=$APPLICATION->ShowViewContent('section_rating')?>
											</div>
										<?endif;?>
										<?if($arSection["DEPTH_LEVEL"] != 1):?>
											<div class="item_block col-2">
												<div class="brand">
													<?$picture = ($sectionRoot["PICTURE"] ? $sectionRoot["PICTURE"] : $sectionRoot["DETAIL_PICTURE"]);?>
													<a href="<?=$sectionRoot["SECTION_PAGE_URL"]?>" title="<?=$sectionRoot["NAME"]?>">
														<?if($picture):?>
															<?$arImage = CFile::GetFileArray($picture);?>
															<img src="<?=$arImage["SRC"];?>" alt="<?=$sectionRoot["NAME"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $sectionRoot["NAME"]);?>" />
														<?else:?>
															<?=$sectionRoot["NAME"]?>
														<?endif;?>
													</a>
												</div>
											</div>
										<?endif;?>
									</div>
								</div>
								<div class="middle_info main_item_wrapper">
									<?=$APPLICATION->ShowViewContent('section_price')?>
									<?=$APPLICATION->ShowViewContent('section_quantity')?>
									<?=$APPLICATION->ShowViewContent('section_item_props')?>
									<?if($arParams["USE_REVIEW"] == "Y"):?>
										<div class="count_reviews">
											<div class="text colored" data-block="reviews_item_tab"><?=\Aspro\Functions\CAsproTires2::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/recommend.svg');?><?=GetMessage("RECOMEND_MODEL");?> <span><span>0 <?=GetMessage("PEOPLE");?></span></span></div>
										</div>
									<?endif;?>
								</div>
								<?if($arSection["UF_SECTION_DESCR"]):?>
									<div class="preview_wrapper">
										<div class="preview_text dotdot"><?=$arSection["UF_SECTION_DESCR"]?></div>
									</div>
									<?if(strlen($arSection["DESCRIPTION"])):?>
										<div class="top_props">
											<div class="props"><span class="choise colored" data-block="desc_item_tab"><?=\Bitrix\Main\Config\Option::get('aspro.tires2', "EXPRESSION_READ_MORE_OFFERS_DEFAULT", GetMessage("EXPRESSION_READ_MORE_OFFERS_DEFAULT"));?></span></div>
										</div>
									<?endif;?>
								<?endif;?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<?
					/*get tizers section*/
					if(is_array($arSection["UF_TIZERS"]) && $arSection["UF_TIZERS"]){
						$arTizersData = array();
						$tizerCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'IDS'=>$arSection["UF_TIZERS"]);
						$obCache = new CPHPCache();
						if($obCache->InitCache(3600000, serialize($tizerCacheID), "/hlblock/tizers")):
							$arTizersData = $obCache->GetVars();
						elseif($obCache->StartDataCache()):
							$arItems=array();
							$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter'=>array('=TABLE_NAME'=>'tires2_tizers_reference')));
							if($arData = $rsData->fetch()):
								$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
								$entityDataClass = $entity->getDataClass();
								$fieldsList = $entityDataClass::getMap();
								if(count($fieldsList) === 1 && isset($fieldsList['ID']))
									$fieldsList = $entityDataClass::getEntity()->getFields();

								$directoryOrder = array();
								if(isset($fieldsList['UF_SORT']))
									$directoryOrder['UF_SORT'] = 'ASC';
								$directoryOrder['ID'] = 'ASC';

								$arFilter = array(
									'order' => $directoryOrder,
									'limit' => 4,
									'filter' => array(
										'=ID' => $arSection["UF_TIZERS"]
									)
								);

								$rsPropEnums = $entityDataClass::getList($arFilter);
								while($arEnum = $rsPropEnums->fetch())
								{
									if($arEnum["UF_FILE"])
									{
										$arEnum['PREVIEW_PICTURE'] = CFile::ResizeImageGet(
											$arEnum['UF_FILE'],
											array("width" => 50, "height" => 50),
											BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
											true
										);

									}
									$arItems[]=$arEnum;
								}
							endif;
							$arTizersData=$arItems;

							$obCache->EndDataCache($arTizersData);
						endif;
						if($arTizersData):?>
							<div class="tizers_block_detail tizers_block">
								<div class="row flexbox">
									<?$count_t_items=count($arTizersData);?>
									<?foreach($arTizersData as $arItem):?>
										<div class="item_wrap_detail col-md-3 col-sm-3 col-xs-6">
											<div class="inner_wrapper item">
												<?if($arItem["UF_FILE"]){?>
													<div class="img">
														<?if($arItem["UF_LINK"]){?>
															<a href="<?=$arItem["UF_LINK"];?>" <?=(strpos($arItem["UF_LINK"], "http") !== false ? "target='_blank' rel='nofollow'" : '')?>>
														<?}?>
														<img src="<?=$arItem["PREVIEW_PICTURE"]["src"];?>" alt="<?=$arItem["UF_NAME"];?>" title="<?=$arItem["UF_NAME"];?>">
														<?if($arItem["UF_LINK"]){?>
															</a>
														<?}?>
													</div>
												<?}?>
												<div class="info_tizer">
													<div class="title">
														<?if($arItem["UF_LINK"]){?>
															<a class="dark-color" href="<?=$arItem["UF_LINK"];?>" <?=(strpos($arItem["UF_LINK"], "http") !== false ? "target='_blank' rel='nofollow'" : '')?>>
														<?}?>
														<?=$arItem["UF_NAME"];?>
														<?if($arItem["UF_LINK"]){?>
															</a>
														<?}?>
													</div>
												</div>
											</div>
										</div>
									<?endforeach;?>
								</div>
							</div>
						<?endif;?>
					<?}?>
				</div>
			<?endif;?>

			<?if($isAjax=="N"):?>
				<?$frame = new \Bitrix\Main\Page\FrameHelper("viewtype-block");
				$frame->begin();?>
			<?endif;?>

				<?if($isAjax=="Y"):?>
					<?$APPLICATION->RestartBuffer();?>
				<?endif;?>

				<?if($isAjax=="N"):?>
					<div class="ajax_load table">
				<?endif;?>

				<?$APPLICATION->IncludeComponent(
					"bitrix:catalog.section",
					"catalog_table_types",
					Array(
						"USE_REGION" => ($arRegion ? "Y" : "N"),
						"STORES" => $arParams['STORES'],
						"SHOW_UNABLE_SKU_PROPS"=>$arParams["SHOW_UNABLE_SKU_PROPS"],
						"ALT_TITLE_GET" => $arParams["ALT_TITLE_GET"],
						"SEF_URL_TEMPLATES" => $arParams["SEF_URL_TEMPLATES"],
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"AJAX_REQUEST" => $isAjax,
						"ELEMENT_SORT_FIELD" => $sort,
						"ELEMENT_SORT_ORDER" => $sort_order,
						"SHOW_CHEAPER_FORM" => $arParams["SHOW_CHEAPER_FORM"],
						"SHOW_DISCOUNT_TIME_EACH_SKU" => $arParams["SHOW_DISCOUNT_TIME_EACH_SKU"],
						"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
						"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
						"PAGE_ELEMENT_COUNT" => 9999,
						"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
						"DISPLAY_TYPE" => $display,
						"TYPE_SKU" => ($typeSKU ? $typeSKU : $arTheme["TYPE_SKU"]["VALUE"]),
						"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
						"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
						"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],

						"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
						"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],

						"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

						"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						"BASKET_URL" => $arParams["BASKET_URL"],
						"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						"PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"PRODUCT_PROPS_VARIABLE" => "prop",
						"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
						"AJAX_MODE" => $arParams["AJAX_MODE"],
						"AJAX_OPTION_JUMP" => $arParams["AJAX_OPTION_JUMP"],
						"AJAX_OPTION_STYLE" => $arParams["AJAX_OPTION_STYLE"],
						"AJAX_OPTION_HISTORY" => $arParams["AJAX_OPTION_HISTORY"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
						"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
						"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
						"ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
						'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						"SET_TITLE" => $arParams["SET_TITLE"],
						"SET_STATUS_404" => $arParams["SET_STATUS_404"],
						"SHOW_404" => $arParams["SHOW_404"],
						"MESSAGE_404" => $arParams["MESSAGE_404"],
						"FILE_404" => $arParams["FILE_404"],
						"PRICE_CODE" => $arParams['PRICE_CODE'],
						"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
						"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
						"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
						"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
						"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],

						"PAGER_TITLE" => $arParams["PAGER_TITLE"],
						"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
						"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
						"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
						"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
						"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

						"AJAX_OPTION_ADDITIONAL" => "",
						"ADD_CHAIN_ITEM" => "N",
						"SHOW_QUANTITY" => $arParams["SHOW_QUANTITY"],
						"SHOW_QUANTITY_COUNT" => $arParams["SHOW_QUANTITY_COUNT"],
						"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
						"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
						"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
						"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
						"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
						"CURRENCY_ID" => $arParams["CURRENCY_ID"],
						"USE_STORE" => $arParams["USE_STORE"],
						"MAX_AMOUNT" => $arParams["MAX_AMOUNT"],
						"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
						"USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
						"USE_ONLY_MAX_AMOUNT" => $arParams["USE_ONLY_MAX_AMOUNT"],
						"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],
						"LIST_DISPLAY_POPUP_IMAGE" => $arParams["LIST_DISPLAY_POPUP_IMAGE"],
						"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
						"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
						"SHOW_HINTS" => $arParams["SHOW_HINTS"],
						"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
						"SHOW_SECTIONS_LIST_PREVIEW" => $arParams["SHOW_SECTIONS_LIST_PREVIEW"],
						"SECTIONS_LIST_PREVIEW_PROPERTY" => $arParams["SECTIONS_LIST_PREVIEW_PROPERTY"],
						"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_LIST_PICTURES"],
						"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
						"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
						"SALE_STIKER" => $arParams["SALE_STIKER"],
						"STIKERS_PROP" => $arParams["STIKERS_PROP"],
						"SHOW_RATING" => $arParams["SHOW_RATING"],
						"ADD_PICT_PROP" => $arParams["ADD_PICT_PROP"],
						"USE_REVIEW" => $arParams["USE_REVIEW"],
						"FORUM_ID" => $arParams["FORUM_ID"],
						"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
						"USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
						"REVIEW_AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
						"STIKERS_PROP" => $arParams["STIKERS_PROP"],
						"DESCRIPTION" => $arSection["DESCRIPTION"],
						"YM_ELEMENT_ID" => $arSection["YM_ELEMENT_ID"],
						"VIDEO" => $arSection["VIDEO"],
					), $component, array("HIDE_ICONS" => $isAjax)
				);?>

				<?if($isAjax=="Y"):?>
					<?die();?>
				<?endif;?>

			<?if($isAjax!="Y"):?>
				</div> 
				<?$frame->end();?>
			<?endif;?>

		<?else:?>
			<div class="section_block_wrapper">
				<?$section_pos_top = \Bitrix\Main\Config\Option::get("aspro.tires2", "TOP_SECTION_DESCRIPTION_POSITION", "UF_SECTION_DESCR", SITE_ID );?>
				<?$section_pos_bottom = \Bitrix\Main\Config\Option::get("aspro.tires2", "BOTTOM_SECTION_DESCRIPTION_POSITION", "DESCRIPTION", SITE_ID );?>

				<?if(!$arSeoItem):?>
					<?if($arParams["SHOW_SECTION_DESC"] != 'N' && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
						<?if($posSectionDescr=="BOTH"):?>
							<?if($arSection[$section_pos_top]):?>
								<div class="group_description_block top detail partners">
									<?if($arSection["PICTURE"]):?>
										<?$arImage = CFile::GetFileArray($arSection["PICTURE"]);?>
										<div class="detailimage">
											<div class="img-partner">
												<img src="<?=$arImage["SRC"];?>" alt="<?=$arSection["NAME"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>" class="img-responsive"/>
											</div>
										</div>
									<?endif;?>
									<div class="post-content"><?=$arSection[$section_pos_top]?></div>
								</div>
							<?endif;?>
						<?elseif($posSectionDescr=="TOP"):?>
							<?if ($arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]):?>
								<div class="group_description_block top detail partners">
									<?if($arSection["PICTURE"]):?>
										<?$arImage = CFile::GetFileArray($arSection["PICTURE"]);?>
										<div class="detailimage">
											<div class="img-partner">
												<img src="<?=$arImage["SRC"];?>" alt="<?=$arSection["NAME"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>" class="img-responsive"/>
											</div>
										</div>
									<?endif;?>
									<div class="post-content"><?=$arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]?></div>
								</div>
							<?elseif ($arSection["DESCRIPTION"]):?>
								<div class="group_description_block top detail partners">
									<?if($arSection["PICTURE"]):?>
										<?$arImage = CFile::GetFileArray($arSection["PICTURE"]);?>
										<div class="detailimage">
											<div class="img-partner">
												<img src="<?=$arImage["SRC"];?>" alt="<?=$arSection["NAME"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>" class="img-responsive"/>
											</div>
										</div>
									<?endif;?>
									<div class="post-content"><?=$arSection["DESCRIPTION"]?></div>
								</div>
							<?elseif($arSection["UF_SECTION_DESCR"]):?>
								<div class="group_description_block top detail partners">
									<?if($arSection["PICTURE"]):?>
										<?$arImage = CFile::GetFileArray($arSection["PICTURE"]);?>
										<div class="detailimage">
											<div class="img-partner">
												<img src="<?=$arImage["SRC"];?>" alt="<?=$arSection["NAME"];?>" alt="<?=($arImage["DESCRIPTION"] ? $arImage["DESCRIPTION"] : $arSection["NAME"]);?>" class="img-responsive"/>
											</div>
										</div>
									<?endif;?>
									<div class="post-content"><?=$arSection["UF_SECTION_DESCR"]?></div>
								</div>
							<?endif;?>
						<?endif;?>
					<?endif;?>
				<?endif;?>
				<?
				$arDisplays = array("block", "list");
				if($request["display"] || array_key_exists("DISPLAY_SECTION_TEMPLATE", $_SESSION))
				{
					if($request["display"] && (in_array(trim($request["display"]), $arDisplays)))
					{
						$display = trim($request["display"]);
						$_SESSION["DISPLAY_SECTION_TEMPLATE"] = $display;
					}
					elseif($_SESSION["DISPLAY_SECTION_TEMPLATE"] && (in_array(trim($_SESSION["DISPLAY_SECTION_TEMPLATE"]), $arDisplays)))
					{
						$display = $_SESSION["DISPLAY_SECTION_TEMPLATE"];
					}
					elseif($arSection["DISPLAY"])
					{
						$display = $arSection["DISPLAY"];
					}
					else
					{
						$display = $arParams["DEFAULT_LIST_TEMPLATE"];
					}
				}
				else
				{
					$display = "block";
					$_SESSION["DISPLAY_SECTION_TEMPLATE"] = $display;
				}
				$template = "catalog_sections_".$display;
				?>

				<?if($isAjax=="N"):?>
					<?$frame = new \Bitrix\Main\Page\FrameHelper("viewtype-block-section");
					$frame->begin();?>
				<?endif;?>

					<?if($isAjax=="Y"):?>
						<?$APPLICATION->RestartBuffer();?>
					<?endif;?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section.list",
						$template,
						Array(
							"SHOW_RATING" => $arParams["SHOW_RATING"],
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
							"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
							"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							// "CACHE_TYPE" => "N",
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

							"STORES" => $arParams["STORES"],
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],

							"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
							"COUNT_ELEMENTS" => "N",
							"ADD_SECTIONS_CHAIN" => ((!$iSectionsCount || $arParams['INCLUDE_SUBSECTIONS'] !== "N") ? 'N' : 'Y'),

							"SECTIONS_LIST_PREVIEW_PROPERTY" => ($arParams["SHOW_SUBSECTION_PREVIEW_PROPERTY"] ? $arParams["SHOW_SUBSECTION_PREVIEW_PROPERTY"] : "UF_SECTION_DESCR"),
							"SECTIONS_LIST_PREVIEW_DESCRIPTION" => $arParams["SHOW_SUBSECTION_DESC"],
							"SHOW_SECTION_LIST_PICTURES" => $arParams["SHOW_SECTION_PICTURES"],
							"SECTION_PAGE_ELEMENT" => ($arParams["SECTION_PAGE_ELEMENT"] ? $arParams["SECTION_PAGE_ELEMENT"] : 8),
							"AJAX_FILTER_ITEM" => ($arParams["AJAX_FILTER_ITEM"] ? $arParams["AJAX_FILTER_ITEM"] : "N"),
							"SECTION_LINE_ELEMENT" => ($arParams["SECTION_LINE_ELEMENT"] ? $arParams["SECTION_LINE_ELEMENT"] : 4),

							"DISPLAY" => $display,
							"IS_AJAX" => $isAjax,
							"PAGE" => $request["PAGEN_2"],
							"FILTER_PROP" => $request["FILTER_PROP"],
							"TYPE_FILTER" => $request["TYPE_FILTER"],
							"TOP_DEPTH" => "1",
						),
						$component
					);?>

					<?if($isAjax=="Y"):?>
						<?die();?>
					<?endif;?>

				<?if($isAjax!="Y"):?>
					<?$frame->end();?>
				<?endif;?>

				<?$APPLICATION->AddChainItem($arSection["NAME"], $arSection["SECTION_PAGE_URL"]);?>

				<?if(!$arSeoItem):?>
					<?if($arParams["SHOW_SECTION_DESC"] != 'N' && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
						<?if($posSectionDescr=="BOTH"):?>
							<?if($arSection[$section_pos_bottom]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection[$section_pos_bottom]?></div>
								</div>
							<?endif;?>
						<?elseif($posSectionDescr=="BOTTOM"):?>
							<?if($arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection[$arParams["SECTION_PREVIEW_PROPERTY"]]?></div>
								</div>
							<?elseif ($arSection["DESCRIPTION"]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection["DESCRIPTION"]?></div>
								</div>
							<?elseif($arSection["UF_SECTION_DESCR"]):?>
								<div class="group_description_block bottom">
									<div><?=$arSection["UF_SECTION_DESCR"]?></div>
								</div>
							<?endif;?>
						<?endif;?>
					<?endif;?>

					<?$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');?>
					<?$APPLICATION->ShowViewContent('sotbit_seometa_add_desc');?>
				<?endif;?>
			</div>
		<?endif;?>

		<?if($isAjax=="N"){?>
			<?if($arSeoItem):?>
				<?if($arSeoItem["DETAIL_TEXT"]):?>
					<?=$arSeoItem["DETAIL_TEXT"];?>
				<?endif;?>
				<?$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');?>
			<?endif;?>
			<?if($arSeoItems && $arSection):?>
				<?$arLandingFilter = array();
				if($arSeoItem)
				{
					$arLandingFilter = array(
						array(
							"LOGIC" => "OR",
							"PROPERTY_SECTION" => $arSeoItem["PROPERTY_SECTION_VALUE"],
							"PROPERTY_SECTION_SERVICES" => $arSeoItem["PROPERTY_SECTION_SERVICES_VALUE"],
						),
						"!ID" => $arSeoItem["ID"]
					);
				}
				else
				{
					$arLandingFilter[] = array(
						"LOGIC" => "OR",
						"PROPERTY_SECTION" => $arSection["ID"],
						"PROPERTY_SECTION_SERVICES" => $arSection["ID"],
					);
					if($iLandingItemID)
						$arLandingFilter["!ID"] = $iLandingItemID;
					elseif($arTmpRegionsLanding)
						$arLandingFilter["!ID"] = $arTmpRegionsLanding;
				}
				?>
				<?$GLOBALS["arLandingSections"] = $arLandingFilter;?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"landings_list",
					array(
						"IBLOCK_TYPE" => "aspro_tires2_catalog",
						"IBLOCK_ID" => CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_info"][0],
						"NEWS_COUNT" => "999",
						"SHOW_COUNT" => $arParams["LANDING_SECTION_COUNT"],
						"COMPARE_FIELD" => "FILTER_URL",
						"COMPARE_PROP" => "Y",
						"SORT_BY1" => "SORT",
						"SORT_ORDER1" => "ASC",
						"SORT_BY2" => "ID",
						"SORT_ORDER2" => "DESC",
						"FILTER_NAME" => "arLandingSections",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"PROPERTY_CODE" => array(
							0 => "LINK",
							1 => "",
						),
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"AJAX_OPTION_HISTORY" => "N",
						"CACHE_TYPE" =>$arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "N",
						"PREVIEW_TRUNCATE_LEN" => "",
						"ACTIVE_DATE_FORMAT" => "j F Y",
						"SET_TITLE" => "N",
						"SET_STATUS_404" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"INCLUDE_SUBSECTIONS" => "Y",
						"PAGER_TEMPLATE" => "",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"PAGER_TITLE" => "",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"COMPONENT_TEMPLATE" => "tires2",
						"SET_BROWSER_TITLE" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_LAST_MODIFIED" => "N",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"TITLE_BLOCK" => $arParams["LANDING_TITLE"],
						"SHOW_404" => "N",
						"MESSAGE_404" => ""
					),
					false, array("HIDE_ICONS" => "Y")
				);?>
			<?endif;?>
		<?}?>
		<div class="clear"></div>

		<?global $arSite, $arTheme;
		$postfix = "";

		$bBitrixAjax = (strpos($_SERVER["QUERY_STRING"], "bxajaxid") !== false);
		if($arTheme["HIDE_SITE_NAME_TITLE"]["VALUE"] == "N" && ($bBitrixAjax || $isAjaxFilter))
		{
			$postfix = " - ".$arSite["NAME"];
		}?>
		<?if(!$section):?>
			<?\Bitrix\Iblock\Component\Tools::process404(
				trim($arParams["MESSAGE_404"]) ?: GetMessage("T_NEWS_NEWS_NA")
				,true
				,$arParams["SET_STATUS_404"] === "Y"
				,$arParams["SHOW_404"] === "Y"
				,$arParams["FILE_404"]
			);?>
		<?else:?>
			<?
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($arParams["IBLOCK_ID"], IntVal($arSection["ID"]));
			$arValues = $ipropValues->getValues();
			if($arParams["SET_TITLE"] !== 'N'){
				$page_h1 = $arValues['SECTION_PAGE_TITLE'] ? $arValues['SECTION_PAGE_TITLE'] : $arSection["NAME"];
				if($page_h1){
					$APPLICATION->SetTitle($page_h1);
				}
				else{
					$APPLICATION->SetTitle($arSection["NAME"]);
				}
			}
			$page_title = $arValues['SECTION_META_TITLE'] ? $arValues['SECTION_META_TITLE'] : $arSection["NAME"];
			if($page_title){
				$APPLICATION->SetPageProperty("title", $page_title.$postfix);
			}
			if($arValues['SECTION_META_DESCRIPTION']){
				$APPLICATION->SetPageProperty("description", $arValues['SECTION_META_DESCRIPTION']);
			}
			if($arValues['SECTION_META_KEYWORDS']){
				$APPLICATION->SetPageProperty("keywords", $arValues['SECTION_META_KEYWORDS']);
			}
			?>

				</div>
			</div>
			<?if($bBitrixAjax)
			{
				$page_title = $arValues['SECTION_META_TITLE'] ? $arValues['SECTION_META_TITLE'] : $arSection["NAME"];
				if($page_title){
					$APPLICATION->SetPageProperty("title", $page_title.$postfix);
				}
			}?>
		<?endif;?>
		<?
		if($arSeoItem)
		{
			$langing_seo_h1 = ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != "" ? $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arSeoItem["NAME"]);

			$APPLICATION->SetTitle($langing_seo_h1);

			if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"])
				$APPLICATION->SetPageProperty("title", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]);
			else
				$APPLICATION->SetPageProperty("title", $arSeoItem["NAME"].$postfix);

			if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])
				$APPLICATION->SetPageProperty("description", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]);

			if($arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS'])
				$APPLICATION->SetPageProperty("keywords", $arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']);
			?>
		<?}?>
		<?if($isAjaxFilter):?>
			<?global $APPLICATION;?>
			<?$arAdditionalData['TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle());
			if($arSeoItem)
			{
				$postfix = '';
			}
			$arAdditionalData['WINDOW_TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle('title').$postfix);?>
			<script type="text/javascript">
				BX.removeCustomEvent("onAjaxSuccessFilter", function tt(e){});
				BX.addCustomEvent("onAjaxSuccessFilter", function tt(e){
					var arAjaxPageData = <?=CUtil::PhpToJSObject($arAdditionalData);?>;
					if (arAjaxPageData.TITLE)
						BX.ajax.UpdatePageTitle(arAjaxPageData.TITLE);
					if (arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE)
						BX.ajax.UpdateWindowTitle(arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE);
				});
			</script>
		<?endif;?>
	</div>
</div>