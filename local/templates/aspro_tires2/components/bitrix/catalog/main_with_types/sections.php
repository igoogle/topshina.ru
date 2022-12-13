<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

global $arTheme, $arRegion;

$sVariable = $request->get(\Bitrix\Main\Config\Option::get("aspro.tires2", "PODBOR_ELEMENTS_URL", "search"));
if($sVariable == "Y" || (isset($bPodborPage) && $bPodborPage == true))
{
	$isAjax="N";
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"  && isset($_GET["ajax_get"]) && $_GET["ajax_get"] == "Y" || (isset($_GET["ajax_basket"]) && $_GET["ajax_basket"]=="Y")){
		$isAjax="Y";
	}
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["ajax_get_filter"]) && $_GET["ajax_get_filter"] == "Y" ){
		$isAjaxFilter="Y";
	}

	if($isAjaxFilter == "Y")
		$isAjax="N";

	if($arParams["FILTER_NAME"] == '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
		$arParams["FILTER_NAME"] = "arrFilter";

	if($arParams['STORES'])
	{
		foreach($arParams['STORES'] as $key => $store)
		{
			if(!$store)
				unset($arParams['STORES'][$key]);
		}
	}
	if($arRegion)
	{
		if($arRegion['LIST_PRICES'])
		{
			if(reset($arRegion['LIST_PRICES']) != 'component')
				$arParams['PRICE_CODE'] = array_keys($arRegion['LIST_PRICES']);
		}
		if($arRegion['LIST_STORES'])
		{
			if(reset($arRegion['LIST_STORES']) != 'component')
				$arParams['STORES'] = $arRegion['LIST_STORES'];
		}
	}

	$title = ($APPLICATION->GetProperty("PODBOR_TITLE") ? $APPLICATION->GetProperty("PODBOR_TITLE") : Loc::getMessage("PODBOR"));

	$APPLICATION->SetTitle($title);
	$APPLICATION->SetPageProperty("title", $title);

	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>

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
	
		<?if($arTheme["FILTER_VIEW"]["VALUE"]!="HORIZONTAL" && $arParams["USE_FILTER"] != "N"):?>
			<?ob_start()?>
				<?$arResult["URL_TEMPLATES"]["smart_filter"] = str_replace(array('#SECTION_CODE_PATH#', '#SECTION_CODE#', '#SECTION_ID#'), $sVariable, $arResult["URL_TEMPLATES"]["smart_filter"]);?>
				<div class="visible_filter">
					<?if($arParams["AJAX_FILTER_CATALOG"]=="Y"):?>
					<div class="ajax_filter">
					<?endif;?>			
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.smart.filter",
						($arParams["AJAX_FILTER_CATALOG"]=="Y" ? "main_ajax" : "main"),
						Array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"AJAX_FILTER_FLAG" => $isAjaxFilter,
							"SECTION_ID" => '',
							"FILTER_NAME" => $arParams["FILTER_NAME"],
							"PRICE_CODE" => ($arParams["USE_FILTER_PRICE"] == 'Y' ? $arParams["FILTER_PRICE_CODE"] : $arParams["PRICE_CODE"]),
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_NOTES" => "",
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"SAVE_IN_SESSION" => "N",
							"XML_EXPORT" => "Y",
							"SECTION_TITLE" => "NAME",
							"SECTION_DESCRIPTION" => "DESCRIPTION",
							"SHOW_HINTS" => $arParams["SHOW_HINTS"],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'DISPLAY_ELEMENT_COUNT' => $arParams['DISPLAY_ELEMENT_COUNT'],
							"INSTANT_RELOAD" => "Y",
							"VIEW_MODE" => strtolower($arTheme["FILTER_VIEW"]["VALUE"]),
							"SEF_MODE" => (strlen($arResult["URL_TEMPLATES"]["smart_filter"]) ? "Y" : "N"),
							"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
							"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
							"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
						),
						$component);
					?>
					<?if($arParams["AJAX_FILTER_CATALOG"]=="Y"):?>
					</div>
					<?endif;?>
				</div>
			<?$html=ob_get_clean();?>
			<?$APPLICATION->AddViewContent('filter_content', $html);?>
		<?endif;?>
	<?if($isAjax=="N" && $isAjaxFilter !="Y"):?>
		<div class="right_block wide_N">
	<?endif;?>

		<?if($arTheme["FILTER_VIEW"]["VALUE"]=="HORIZONTAL"){?>
			<div class="filter_horizontal">
				<?$arResult["URL_TEMPLATES"]["smart_filter"] = '';?>
				<?include_once("filter.php")?>
			</div>
		<?}?>
<div class="js_wrapper_block">
	<div class="js_top_block">
		<?
		//seo
		$arSeoItems = CTires2Cache::CIBLockElement_GetList(array('CACHE' => array("MULTI" =>"Y", "TAG" => CTires2Cache::GetIBlockCacheTag(CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_info"][0]))), array("IBLOCK_ID" => CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_info"][0], "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_PICTURE", "PROPERTY_FILTER_URL", "PROPERTY_LINK_REGION", "PROPERTY_FORM_QUESTION", "PROPERTY_SECTION_SERVICES", "PROPERTY_TIZERS", "PROPERTY_SECTION", "DETAIL_TEXT", "ElementValues"));
		$arSeoItem = $arTmpRegionsLanding = array();
		if($arSeoItems)
		{
			$iLandingItemID = 0;
			$current_url =  $APPLICATION->GetCurDir();
			$url = urldecode(str_replace(' ', '+', $current_url));
			foreach($arSeoItems as $arItem)
			{
				if(urldecode($arItem["PROPERTY_FILTER_URL_VALUE"]) == $url)
				{
					$arSeoItem = $arItem;
					$iLandingItemID = $arSeoItem['ID'];
					break;
				}
			}
			if($arRegion)
			{
				if($arSeoItem)
				{
					if($arSeoItem['PROPERTY_LINK_REGION_VALUE'])
					{
						if(!is_array($arSeoItem['PROPERTY_LINK_REGION_VALUE']))
							$arSeoItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arSeoItem['PROPERTY_LINK_REGION_VALUE'];
						if(!in_array($arRegion['ID'], $arSeoItem['PROPERTY_LINK_REGION_VALUE']))
							$arSeoItem = array();
					}
				}
				else
				{
					foreach($arSeoItems as $arItem)
					{
						if($arItem['PROPERTY_LINK_REGION_VALUE'])
						{
							if(!is_array($arItem['PROPERTY_LINK_REGION_VALUE']))
								$arItem['PROPERTY_LINK_REGION_VALUE'] = (array)$arItem['PROPERTY_LINK_REGION_VALUE'];
							if(!in_array($arRegion['ID'], $arItem['PROPERTY_LINK_REGION_VALUE']))
								$arTmpRegionsLanding[] = $arItem['ID'];
						}
					}
				}
			}
		}
		?>
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
					<div class="landing_tizers1">
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
									0 => "PREVIEW_TEXT",
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
	<div class="js_bottom_block">
		<div class="middle catalog">

			<?if($isAjax=="Y"):?>
				<?$APPLICATION->RestartBuffer();?>
			<?endif;?>
			<?$arDisplays = array("block", "list", "table");
			if(array_key_exists("display", $_REQUEST) || (array_key_exists("display", $_SESSION)) || $arParams["DEFAULT_LIST_TEMPLATE"]){
				if($_REQUEST["display"] && (in_array(trim($_REQUEST["display"]), $arDisplays))){
					$display = trim($_REQUEST["display"]);
					$_SESSION["display"]=trim($_REQUEST["display"]);
				}
				elseif($_SESSION["display"] && (in_array(trim($_SESSION["display"]), $arDisplays))){
					$display = $_SESSION["display"];
				}
				else{
					$display = $arParams["DEFAULT_LIST_TEMPLATE"];
				}
			}
			else{
				$display = "block";
			}
			$template = "catalog_".$display;
			?>
			<?if ($arParams["USE_FILTER"] != "N"):?>
				<div class="adaptive_filter">
					<a class="filter_opener<?=($_REQUEST["set_filter"] == "y" ? " active" : "")?>"><i></i><span><?=GetMessage("CATALOG_SMART_FILTER_TITLE")?></span></a>
				</div>
			<?endif;?>
			<div class="sort_header view_<?=$display?>">
				<!--noindex-->
					<div class="sort_filter">
						<?
						$arAvailableSort = array();
						$arSorts = $arParams["SORT_BUTTONS"];
						if(in_array("POPULARITY", $arSorts)){
							$arAvailableSort["SHOWS"] = array("SHOWS", "desc");
						}
						if(in_array("NAME", $arSorts)){
							$arAvailableSort["NAME"] = array("NAME", "asc");
						}
						if(in_array("PRICE", $arSorts)){
							$arSortPrices = $arParams["SORT_PRICES"];
							if($arSortPrices == "MINIMUM_PRICE" || $arSortPrices == "MAXIMUM_PRICE"){
								$arAvailableSort["PRICE"] = array("PROPERTY_".$arSortPrices, "desc");
							}
							else{
								if($arSortPrices == "REGION_PRICE")
								{
									global $arRegion;
									if($arRegion)
									{
										if(!$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] || $arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"] == "component")
										{
											$price = CCatalogGroup::GetList(array(), array("NAME" => $arParams["SORT_REGION_PRICE"]), false, false, array("ID", "NAME"))->GetNext();
											$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc");
										}
										else
										{
											$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$arRegion["PROPERTY_SORT_REGION_PRICE_VALUE"], "desc"); 
										}
									}
									else
									{
										$price_name = ($arParams["SORT_REGION_PRICE"] ? $arParams["SORT_REGION_PRICE"] : "BASE");
										$price = CCatalogGroup::GetList(array(), array("NAME" => $price_name), false, false, array("ID", "NAME"))->GetNext();
										$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc"); 
									}
								}
								else
								{
									$price = CCatalogGroup::GetList(array(), array("NAME" => $arParams["SORT_PRICES"]), false, false, array("ID", "NAME"))->GetNext();
									$arAvailableSort["PRICE"] = array("CATALOG_PRICE_".$price["ID"], "desc"); 
								}
							}
						}
						if(in_array("QUANTITY", $arSorts)){
							$arAvailableSort["CATALOG_AVAILABLE"] = array("QUANTITY", "desc");
						}
						$sort = "SHOWS";
						if((array_key_exists("sort", $_REQUEST) && array_key_exists(ToUpper($_REQUEST["sort"]), $arAvailableSort)) || (array_key_exists("sort", $_SESSION) && array_key_exists(ToUpper($_SESSION["sort"]), $arAvailableSort)) || $arParams["ELEMENT_SORT_FIELD"]){
							if($_REQUEST["sort"]){
								$sort = ToUpper($_REQUEST["sort"]);
								$_SESSION["sort"] = ToUpper($_REQUEST["sort"]);
							}
							elseif($_SESSION["sort"]){
								$sort = ToUpper($_SESSION["sort"]);
							}
							else{
								$sort = ToUpper($arParams["ELEMENT_SORT_FIELD"]);
							}
						}

						$sort_order=$arAvailableSort[$sort][1];
						if((array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc"))) || (array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ) || $arParams["ELEMENT_SORT_ORDER"]){
							if($_REQUEST["order"]){
								$sort_order = $_REQUEST["order"];
								$_SESSION["order"] = $_REQUEST["order"];
							}
							elseif($_SESSION["order"]){
								$sort_order = $_SESSION["order"];
							}
							else{
								$sort_order = ToLower($arParams["ELEMENT_SORT_ORDER"]);
							}
						}
						?>
						<?foreach($arAvailableSort as $key => $val):?>
							<?$newSort = $sort_order == 'desc' ? 'asc' : 'desc';?>
							<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order', 'ajax_get_filter', 'ajax_get'))?>" class="sort_btn <?=($sort == $key ? 'current' : '')?> <?=$sort_order?> <?=$key?>">
								<i class="icon" title="<?=GetMessage('SECT_SORT_'.$key)?>"></i><span><?=GetMessage('SECT_SORT_'.$key)?></span><i class="arr icons_fa"></i>
							</a>
						<?endforeach;?>
						<?
						if($sort == "PRICE"){
							$sort = $arAvailableSort["PRICE"][0];
						}
						if($sort == "CATALOG_AVAILABLE"){
							$sort = "CATALOG_QUANTITY";
						}
						?>
					</div>
					<div class="sort_display">
						<?foreach($arDisplays as $displayType):?>
							<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('display='.$displayType, 	array('display', 'ajax_get_filter', 'ajax_get'))?>" class="sort_btn <?=$displayType?> <?=($display == $displayType ? 'current' : '')?>"><i title="<?=GetMessage("SECT_DISPLAY_".strtoupper($displayType))?>"></i></a>
						<?endforeach;?>
					</div>
					<div class="clearfix"></div>
				<!--/noindex-->
			</div>
			<div class="ajax_load <?=$display;?>">
				<div class="catalog <?=$display;?> search">
					<?if($isAjax=="Y"):?>
						<?$APPLICATION->RestartBuffer();?>
					<?endif;?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						$template,
						array(
							"USE_REGION" => ($arRegion ? "Y" : "N"),
							"STORES" => $arParams['STORES'],
							"TYPE_SKU" => $arTheme["TYPE_SKU"]["VALUE"],
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => $sort,
							"ELEMENT_SORT_ORDER" => $sort_order,
							"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
							"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
							"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],

							"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
							"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],
							'VISIBLE_LIST_PROP_COUNT'  => $arParams['VISIBLE_LIST_PROP_COUNT'],
							"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
							"OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
							"OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
							"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
							"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
							'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
							"SHOW_COUNTER_LIST" => $arParams["SHOW_COUNTER_LIST"],
							"DISPLAY_WISH_BUTTONS" => $arParams["DISPLAY_WISH_BUTTONS"],

							"SECTION_URL" => $arParams["SECTION_URL"],
							"DETAIL_URL" => $arParams["DETAIL_URL"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
							"USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
							"SHOW_DISCOUNT_PERCENT_NUMBER" => $arParams["SHOW_DISCOUNT_PERCENT_NUMBER"],
							"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
							"PAGER_TITLE" => $arParams["PAGER_TITLE"],
							"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
							"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
							"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
							"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
							"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
							"FILTER_NAME" => $arParams["FILTER_NAME"],
							"SECTION_ID" => "",
							"SECTION_CODE" => "",
							"SECTION_USER_FIELDS" => array(),
							"INCLUDE_SUBSECTIONS" => "Y",
							"SHOW_ALL_WO_SECTION" => "Y",
							"META_KEYWORDS" => "",
							"META_DESCRIPTION" => "",
							"BROWSER_TITLE" => "",
							"ADD_SECTIONS_CHAIN" => "N",
							"SET_TITLE" => "N",
							"SET_STATUS_404" => "N",
							"CACHE_FILTER" => "Y",
							"AJAX_REQUEST" => (($isAjax == "Y" && $isAjaxFilter != "Y") ? "Y" : "N"),
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"DISPLAY_SHOW_NUMBER" => "N",
							"DEFAULT_COUNT" => $arParams["DEFAULT_COUNT"],
							"SHOW_DISCOUNT_PERCENT" => $arParams["SHOW_DISCOUNT_PERCENT"],
							"SHOW_OLD_PRICE" => $arParams["SHOW_OLD_PRICE"],
							"SALE_STIKER" => $arParams["SALE_STIKER"],
							"STIKERS_PROP" => $arParams["STIKERS_PROP"],
							"SHOW_RATING" => $arParams["SHOW_RATING"],
							"SHOW_DISCOUNT_TIME" => $arParams["SHOW_DISCOUNT_TIME"],
							"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
							"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
							"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
							"OFFER_HIDE_NAME_PROPS" => $arParams["OFFER_HIDE_NAME_PROPS"],
							"SHOW_MEASURE" => $arParams["SHOW_MEASURE"],
							"HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
						),
						$arResult["THEME_COMPONENT"]
					);?>
					<?if($isAjax=="Y" && $isAjaxFilter != "Y"):?>
						<?die();?>
					<?endif;?>
				</div>
			</div>
			<?if($isAjax=="Y"):?>
				<?die();?>
			<?endif;?>
		</div>
		<?if($isAjax=="N"){?>
			<?if($arSeoItem):?>
				<?if($arSeoItem["DETAIL_TEXT"]):?>
					<?=$arSeoItem["DETAIL_TEXT"];?>
				<?endif;?>
				<?$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');?>
			<?endif;?>
			<?if($arSeoItems && $arSeoItem && ($arSeoItem["PROPERTY_SECTION_VALUE"] || $arSeoItem["PROPERTY_SECTION_SERVICES_VALUE"])):?>
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
	</div>
	</div>
	<?if($isAjax=="N" && $isAjaxFilter !="Y"):?>		
</div>
	<div class="left_block filter_visible">
		<div class="visible_mobile_filter"><?$APPLICATION->ShowViewContent('filter_content');?></div>
		<?$APPLICATION->ShowViewContent('under_sidebar_content');?>

		<?CTires2::get_banners_position('SIDE', 'Y');?>
		<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => SITE_DIR."include/left_block/comp_subscribe.php",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "include_area.php"
			),
			false
		);?>
	</div>
	<?endif;?>

	<?
	if($arSeoItem)
	{
		$langing_seo_h1 = ($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != "" ? $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] : $arSeoItem["NAME"]);

		$APPLICATION->SetTitle($langing_seo_h1);
		$APPLICATION->AddChainItem($langing_seo_h1);

		if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]){
			$APPLICATION->SetPageProperty("title", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]);
		}
		else{
			
			//$APPLICATION->AddChainItem($arSeoItem["NAME"].$postfix);
			$APPLICATION->SetPageProperty("title", $arSeoItem["NAME"].$postfix);
		}

		if($arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"])
			$APPLICATION->SetPageProperty("description", $arSeoItem["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]);

		if($arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS'])
			$APPLICATION->SetPageProperty("keywords", $arSeoItem["IPROPERTY_VALUES"]['ELEMENT_META_KEYWORDS']);
	}
	else{
		$APPLICATION->SetTitle($title);
		$APPLICATION->AddChainItem($title);
	}
	?>
	<?if($isAjaxFilter):?>
		<?global $APPLICATION;?>
		<?$arAdditionalData['TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle());
		if($arSeoItem)
		{
			$postfix = '';
		}
		$arAdditionalData['WINDOW_TITLE'] = htmlspecialcharsback($APPLICATION->GetTitle('title').$postfix);?>
		<script type="text/javascript">
			var arAjaxPageData = <?=CUtil::PhpToJSObject($arAdditionalData);?>;
			if (arAjaxPageData.TITLE)
			{
				BX.ajax.UpdatePageTitle(arAjaxPageData.TITLE);
				$('.breadcrumbs > span:last span:last').text(arAjaxPageData.TITLE);
			}
			if (arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE)
				BX.ajax.UpdateWindowTitle(arAjaxPageData.WINDOW_TITLE || arAjaxPageData.TITLE);
		</script>
	<?endif;?>	
	<?if(\Bitrix\Main\Loader::includeModule("sotbit.seometa")):?>
		<?$APPLICATION->IncludeComponent(
			"sotbit:seo.meta",
			".default",
			array(
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"SECTION_ID" => $arSection['ID'],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
			)
		);?>
	<?endif;?>
	<?return;?>
<?}
else
{
	@include_once('page_blocks/'.$arParams["SECTIONS_TYPE_VIEW"].'.php');
}?>
