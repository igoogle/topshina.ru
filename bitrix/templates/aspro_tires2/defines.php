<?
global $is404, $isIndex, $isForm, $isShowReviewsIndex, $isWidePage, $isBlog, $isHideLeftBlock, $isShowTopAdvBottomBanner, $isShowFloatBanner, $isShowTizers, $isShowSale,
$isShowBottomBanner, $isShowCompany, $isShowBrands, $isShowServicesIndex, $isShowCatalogSections, $isShowCatalogElements, $isShowFilter, $isShowIndexLeftBlock, $isShowMiddleAdvBottomBanner, $isShowBlog, $isShowTopBanner, $bInstagrammIndex, $isShowPromoBlockIndex;

global $bActiveTheme, $bShowFilterIndexClass, $bShowBrandsIndexClass, $bShowCatalogElementsIndexClass, $bShowTizersIndexClass, $bShowMiddleAdvIndexClass, $bShowSaleIndexClass,
$bShowBottomBannerIndexClass, $bShowCompanyIndexClass, $bShowBlogIndexClass, $bShowTopBannerIndexClass, $bShowInstagrammIndexClass, $bShowPromoBlockIndexClass, $bShowServicesIndexClass, $bShowReviewsIndexClass;

$is404 = (defined("ERROR_404") && ERROR_404 === "Y");
$isIndex = CTires2::IsMainPage();
$isForm = CTires2::IsFormPage();
$isBlog = (CSite::inDir(SITE_DIR.'articles/') || $APPLICATION->GetProperty("BLOG_PAGE") == "Y");
$isWidePage = ($APPLICATION->GetProperty("WIDE_PAGE") == "Y");
$isHideLeftBlock = ($APPLICATION->GetProperty("HIDE_LEFT_BLOCK") == "Y");

$bActiveTheme = ($arTheme["THEME_SWITCHER"]["VALUE"] == 'Y');

$indexType = $arTheme["INDEX_TYPE"]["VALUE"];
$isShowIndexLeftBlock = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["WITH_LEFT_BLOCK"]["VALUE"] == "Y");

$isShowMiddleAdvBottomBanner = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["MIDDLE_ADV"]["VALUE"] != "N"));
$bShowMiddleAdvIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["MIDDLE_ADV"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowTizers = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["TIZERS"]["VALUE"] != "N"));
$bShowTizersIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["TIZERS"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowSale = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["SALE"]["VALUE"] != "N"));
$bShowSaleIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["SALE"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowBottomBanner = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BOTTOM_BANNERS"]["VALUE"] != "N"));
$bShowBottomBannerIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BOTTOM_BANNERS"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowCompany = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["COMPANY_TEXT"]["VALUE"] != "N"));
$bShowCompanyIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["COMPANY_TEXT"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowBrands = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BRANDS"]["VALUE"] != "N"));
$bShowBrandsIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BRANDS"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowCatalogElements = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["CATALOG_TAB"]["VALUE"] != "N"));
$bShowCatalogElementsIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["CATALOG_TAB"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowBlog = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BLOG"]["VALUE"] != "N"));
$bShowBlogIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["BLOG"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowFilter = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["FILTER"]["VALUE"] != "N"));
$bShowFilterIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["FILTER"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowTopBanner = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["TOP_BANNER"]["VALUE"] != "N"));
$bShowTopBannerIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["TOP_BANNER"]["VALUE"] == 'Y' ? '' : 'hidden');

$bInstagrammIndex = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["INSTAGRAMM"]["VALUE"] != "N"));
$bShowInstagrammIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["FILTER"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowPromoBlockIndex = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["PROMO_BLOCK"]["VALUE"] != "N"));
$bShowPromoBlockIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["PROMO_BLOCK"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowServicesIndex = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["SERVICES"]["VALUE"] != "N"));
$bShowServicesIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["SERVICES"]["VALUE"] == 'Y' ? '' : 'hidden');

$isShowReviewsIndex = ($bActiveTheme || (!$bActiveTheme && $arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["REVIEWS"]["VALUE"] != "N"));
$bShowReviewsIndexClass = ($arTheme["INDEX_TYPE"]["SUB_PARAMS"][$indexType]["REVIEWS"]["VALUE"] == 'Y' ? '' : 'hidden');

global $arRegion;
if($isIndex)
{
	$GLOBALS['arRegionLinkFront'] = array('PROPERTY_SHOW_ON_INDEX_PAGE_VALUE' => 'Y');
}

if($arRegion && $arTheme['USE_REGIONALITY']['DEPENDENT_PARAMS']['REGIONALITY_FILTER_ITEM']['VALUE'] == 'Y')
{
	$GLOBALS['arRegionLink'] = array('PROPERTY_LINK_REGION' => $arRegion['ID']);
	if($isIndex)
	{
		$GLOBALS['arRegionLinkFront']['PROPERTY_LINK_REGION'] = $arRegion['ID'];
	}
}
?>