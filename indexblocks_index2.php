<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?global $isShowReviewsIndex, $isBlog, $isHideLeftBlock, $isShowTopAdvBottomBanner, $isShowFloatBanner, $isShowTizers, $isShowSale,
$isShowBottomBanner, $isShowCompany, $isShowBrands, $isShowServicesIndex, $isShowCatalogSections, $isShowCatalogElements, $isShowFilter, $isShowIndexLeftBlock, $isShowMiddleAdvBottomBanner, $isShowBlog, $isShowTopBanner, $bInstagrammIndex, $isShowPromoBlockIndex, $arTheme;?>
<?global $bActiveTheme, $bShowFilterIndexClass, $bShowBrandsIndexClass, $bShowCatalogElementsIndexClass, $bShowTizersIndexClass, $bShowMiddleAdvIndexClass, $bShowSaleIndexClass,
$bShowBottomBannerIndexClass, $bShowCompanyIndexClass, $bShowBlogIndexClass, $bShowTopBannerIndexClass, $bShowInstagrammIndexClass, $bShowPromoBlockIndexClass, $bShowServicesIndexClass, $bShowReviewsIndexClass;?>

<?/*top banners*/?>
<div class="drag-block container TOP_BANNER" data-class="TOP_BANNER_drag" data-order="1">
	<div class="maxwidth-theme">
		<?$APPLICATION->IncludeComponent(
			"aspro:com.banners.tires2", 
			"top_big_banners", 
			array(
				"IBLOCK_TYPE" => "aspro_tires2_adv",
				"IBLOCK_ID" => "3",
				"TYPE_BANNERS_IBLOCK_ID" => "1",
				"SET_BANNER_TYPE_FROM_THEME" => "N",
				"NEWS_COUNT" => "10",
				"NEWS_COUNT2" => "4",
				"SORT_BY1" => "SORT",
				"SORT_ORDER1" => "ASC",
				"SORT_BY2" => "ID",
				"SORT_ORDER2" => "DESC",
				"PROPERTY_CODE" => array(
					0 => "TEXT_POSITION",
					1 => "TARGETS",
					2 => "TEXTCOLOR",
					3 => "URL_STRING",
					4 => "BUTTON1TEXT",
					5 => "BUTTON1LINK",
					6 => "BUTTON2TEXT",
					7 => "BUTTON2LINK",
					8 => "",
				),
				"CHECK_DATES" => "Y",
				"CACHE_GROUPS" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"SITE_THEME" => $SITE_THEME,
				"BANNER_TYPE_THEME" => "TOP",
				"BANNER_TYPE_THEME_CHILD" => "TOP_SMALL_BANNER",
			),
			false
		);?>
	</div>
</div>
	
<?/*catalog filter*/?>
<?if($isShowFilter):?>
	<div class="drag-block container FILTER <?=$bShowFilterIndexClass;?>" data-class="FILTER_drag" data-order="2">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_filter_main_".$arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_FILTER_TEMPLATE']['VALUE'].".php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
	</div>
<?endif;?>

<?/*tizers*/?>
<?if($isShowTizers):?>
	<div class="drag-block container TIZERS <?=$bShowTizersIndexClass;?>" data-class="TIZERS_drag" data-order="3">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_tizers.php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
	</div>
<?endif;?>

<?/*promo blocks*/?>
<?if($isShowPromoBlockIndex):?>
	<div class="drag-block container PROMO_BLOCK <?=$bShowPromoBlockIndexClass;?>" data-class="PROMO_BLOCK_drag" data-order="4">
		<hr>
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_catalog_promo.php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
	</div>
<?endif;?>

<?/*sale*/?>
<?if($isShowSale):?>
	<div class="drag-block container SALE <?=$bShowSaleIndexClass;?>" data-class="SALE_drag" data-order="5">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => SITE_DIR."include/mainpage/comp_news_akc.php",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);?>
	</div>
<?endif;?>

<?/*wide_banners*/?>
<?if($isShowBottomBanner):?>
	<div class="drag-block container BOTTOM_BANNERS <?=$bShowBottomBannerIndexClass;?>" data-class="BOTTOM_BANNERS_drag" data-order="6">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => SITE_DIR."include/mainpage/comp_bottom_banners.php",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);?>
	</div>
<?endif;?>

<?/*brands*/?>
<?if($isShowBrands):?>
	<div class="drag-block container BRANDS <?=$bShowBrandsIndexClass;?>" data-class="BRANDS_drag" data-order="7">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"PATH" => SITE_DIR."include/mainpage/comp_brands_".$arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_BRANDS_TEMPLATE']['VALUE'].".php",
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "",
				"AREA_FILE_RECURSIVE" => "Y",
				"EDIT_TEMPLATE" => "standard.php"
			),
			false
		);?>
	</div>
<?endif;?>

<?/*services*/?>
<?if($isShowServicesIndex):?>
	<div class="drag-block container SERVICES <?=$bShowServicesIndexClass;?>" data-class="SERVICES_drag" data-order="8">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_services_".$arTheme['TEMPLATE_PARAMS'][$arTheme['INDEX_TYPE']['VALUE']][$arTheme['INDEX_TYPE']['VALUE'].'_SERVICES_TEMPLATE']['VALUE'].".php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
	</div>
<?endif;?>

<?/*reviews*/?>
<?if($isShowReviewsIndex):?>
	<div class="drag-block container REVIEWS <?=$bShowReviewsIndexClass;?>" data-class="REVIEWS_drag" data-order="9">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_reviews.php",
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "",
					"AREA_FILE_RECURSIVE" => "Y",
					"EDIT_TEMPLATE" => "standard.php"
				),
				false
			);?>
		</div>
	</div>
<?endif;?>

<?/*instagramm*/?>
<div class="drag-block container INSTAGRAMM <?=$bShowInstagrammIndexClass;?>" data-class="INSTAGRAMM_drag" data-order="10">
	<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
		array(
			"COMPONENT_TEMPLATE" => ".default",
			"PATH" => SITE_DIR."include/mainpage/comp_instagramm.php",
			"AREA_FILE_SHOW" => "file",
			"AREA_FILE_SUFFIX" => "",
			"AREA_FILE_RECURSIVE" => "Y",
			"EDIT_TEMPLATE" => "standard.php"
		),
		false
	);?>
</div>
