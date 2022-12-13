<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

global $arTheme, $arRegion;

$sVariable = $request->get(\Bitrix\Main\Config\Option::get("aspro.tires2", "PODBOR_ELEMENTS_URL", "search"));
if($sVariable == "Y")
{
	$isAjax="N";
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"  && isset($_GET["ajax_get"]) && $_GET["ajax_get"] == "Y" || (isset($_GET["ajax_basket"]) && $_GET["ajax_basket"]=="Y")){
		$isAjax="Y";
	}
	if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest" && isset($_GET["ajax_get_filter"]) && $_GET["ajax_get_filter"] == "Y" ){
		$isAjaxFilter="Y";
	}

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

	if($arRegion)
	{
		if($arRegion["LIST_STORES"] && $arParams["HIDE_NOT_AVAILABLE"] == "Y")
		{
			if (CTires2::checkVersionModule('18.6.200', 'iblock')) {
				$arTmpFilter[]['STORE_NUMBER'] = $arParams['STORES'];
				$arTmpFilter[]['>STORE_AMOUNT'] = 0;
			} else {
				$arTmpFilter["LOGIC"] = "OR";
				foreach($arParams['STORES'] as $storeID)
				{
					$arTmpFilter[] = array(">CATALOG_STORE_AMOUNT_".$storeID => 0);
				}
			}
			$GLOBALS[$arParams["FILTER_NAME"]][] = $arTmpFilter;
		}
	} elseif ($arParams["HIDE_NOT_AVAILABLE"] == "Y") {
		if (CTires2::checkVersionModule('18.6.200', 'iblock')) {
			$GLOBALS[$arParams["FILTER_NAME"]]["=AVAILABLE"] = "Y";
		} else {
			$GLOBALS[$arParams["FILTER_NAME"]]["CATALOG_AVAILABLE"] = "Y";
		}
	}

	$title = ($APPLICATION->GetProperty("PODBOR_TITLE") ? $APPLICATION->GetProperty("PODBOR_TITLE") : Loc::getMessage("PODBOR"));

	$APPLICATION->SetTitle($title);
	$APPLICATION->SetPageProperty("title", $title);
	$APPLICATION->AddChainItem($title);

	$APPLICATION->SetPageProperty("HIDE_LEFT_BLOCK", "Y");
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>

	<?if($arTheme["FILTER_VIEW"]["VALUE"]!="HORIZONTAL" && $arParams["USE_FILTER"] != "N"):?>
		<?ob_start()?>
			<?$arResult["URL_TEMPLATES"]["smart_filter"] = str_replace(array('#SECTION_CODE_PATH#', '#SECTION_CODE#', '#SECTION_ID#'), $sVariable, $arResult["URL_TEMPLATES"]["smart_filter"]);?>
			<div class="visible_filter">
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
						"SEF_MODE" => "N",
						"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
						"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
						"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],

						"PROP_TYRE_SHIRINA_PROFILYA" => ($arParams["PROP_TYRE_SHIRINA_PROFILYA"] ? $arParams["PROP_TYRE_SHIRINA_PROFILYA"] : "SHIRINA_PROFILYA"),
						"PROP_TYRE_VYSOTA_PROFILYA" => ($arParams["PROP_TYRE_VYSOTA_PROFILYA"] ? $arParams["PROP_TYRE_VYSOTA_PROFILYA"] : "VYSOTA_PROFILYA"),
						"PROP_TYRE_POSADOCHNYY_DIAMETR" => ($arParams["PROP_TYRE_POSADOCHNYY_DIAMETR"] ? $arParams["PROP_TYRE_POSADOCHNYY_DIAMETR"] : "POSADOCHNYY_DIAMETR"),

						"PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA" => ($arParams["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"] ? $arParams["PROP_DIKS_POSADOCHNYY_DIAMETR_DISKA"] : "POSADOCHNYY_DIAMETR_DISKA"),
						"PROP_DIKS_SHIRINA_DISKA" => ($arParams["PROP_DIKS_SHIRINA_DISKA"] ? $arParams["PROP_DIKS_SHIRINA_DISKA"] : "SHIRINA_DISKA"),
						"PROP_DIKS_MEZHBOLTOVOE_RASSTOYANIE" => ($arParams["PROP_DIKS_MEZHBOLTOVOE_RASSTOYANIE"] ? $arParams["PROP_DIKS_MEZHBOLTOVOE_RASSTOYANIE"] : "MEZHBOLTOVOE_RASSTOYANIE"),
						"PROP_DIKS_COUNT_OTVERSTIY" => ($arParams["PROP_DIKS_COUNT_OTVERSTIY"] ? $arParams["PROP_DIKS_COUNT_OTVERSTIY"] : "COUNT_OTVERSTIY"),
						"PROP_DIKS_VYLET_DISKA" => ($arParams["PROP_DIKS_VYLET_DISKA"] ? $arParams["PROP_DIKS_VYLET_DISKA"] : "VYLET_DISKA"),
						"PROP_DIKS_DIAMETR_STUPITSY" => ($arParams["PROP_DIKS_DIAMETR_STUPITSY"] ? $arParams["PROP_DIKS_DIAMETR_STUPITSY"] : "DIAMETR_STUPITSY"),
						
						"PROP_AKB_LENGTH" => ($arParams["PROP_AKB_LENGTH"] ? $arParams["PROP_AKB_LENGTH"] : "LENGTH"),
						"PROP_AKB_WIDTH" => ($arParams["PROP_AKB_WIDTH"] ? $arParams["PROP_AKB_WIDTH"] : "WIDTH"),
						"PROP_AKB_HEIGHT" => ($arParams["PROP_AKB_HEIGHT"] ? $arParams["PROP_AKB_HEIGHT"] : "HEIGHT"),
						"PROP_AKB_EMKOST" => ($arParams["PROP_AKB_EMKOST"] ? $arParams["PROP_AKB_EMKOST"] : "EMKOST"),
						"PROP_AKB_POLARNOST" => ($arParams["PROP_AKB_POLARNOST"] ? $arParams["PROP_AKB_POLARNOST"] : "POLARNOST"),
						"PROP_AKB_TYPE" => ($arParams["PROP_AKB_TYPE"] ? $arParams["PROP_AKB_TYPE"] : "KLEMMY"),
						"PROP_AKB_VOLTAG" => ($arParams["PROP_AKB_VOLTAG"] ? $arParams["PROP_AKB_VOLTAG"] : "VOLTAG"),
					),
					$component);
				?>
			</div>
		<?$html=ob_get_clean();?>
		<?$APPLICATION->AddViewContent('filter_content', $html);?>
	<?endif;?>
	<div class="right_block wide_N">
		<?if($arTheme["FILTER_VIEW"]["VALUE"]=="HORIZONTAL"){?>
			<div class="filter_horizontal">
				<?$arResult["URL_TEMPLATES"]["smart_filter"] = '';?>
				<?include_once("filter.php")?>
			</div>
		<?}?>
	<div class="js_bottom_block">
		<div class="middle">

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
			<script type="text/javascript">
				$(".filter_opener").click(function(){
					$(this).toggleClass("opened");
					$(".visible_mobile_filter").slideToggle(333);
				});
			</script>
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
							<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'))?>" class="sort_btn <?=($sort == $key ? 'current' : '')?> <?=$sort_order?> <?=$key?>" rel="nofollow">
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
							<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('display='.$displayType, 	array('display'))?>" class="sort_btn <?=$displayType?> <?=($display == $displayType ? 'current' : '')?>"><i title="<?=GetMessage("SECT_DISPLAY_".strtoupper($displayType))?>"></i></a>
						<?endforeach;?>
					</div>
					<div class="clearfix"></div>
				<!--/noindex-->
			</div>
			<div class="ajax_load <?=$display;?>">
				<div class="catalog <?=$display;?> search">
					<?if($isAjax=="Y" && $isAjaxFilter != "Y"):?>
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
							"PROPERTY_CODE" => $arParams["PROPERTY_CODE"],

							"SHOW_ARTICLE_SKU" => $arParams["SHOW_ARTICLE_SKU"],
							"SHOW_MEASURE_WITH_RATIO" => $arParams["SHOW_MEASURE_WITH_RATIO"],

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
	</div>
	</div>

	<div class="left_block filter_ajax">
		<?$APPLICATION->ShowViewContent('filter_content');?>
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
