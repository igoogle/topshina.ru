<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?global $isShowMiddleAdvBottomBanner;?>
<?if($isShowMiddleAdvBottomBanner):?>
	<?$APPLICATION->IncludeComponent(
	"aspro:com.banners.tires2",
	"adv_middle",
	Array(
		"BANNER_TYPE_THEME" => "SMALL",
		"BANNER_TYPE_THEME_CHILD" => "20",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILTER_NAME" => "arRegionLink",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "aspro_tires2_adv",
		"NEWS_COUNT" => "10",
		"NEWS_COUNT2" => "20",
		"PROPERTY_CODE" => array("","URL",""),
		"SET_BANNER_TYPE_FROM_THEME" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"TYPE_BANNERS_IBLOCK_ID" => "1"
	)
);?>
<?endif;?>