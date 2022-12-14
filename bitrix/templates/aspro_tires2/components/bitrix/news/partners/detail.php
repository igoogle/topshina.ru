<?if( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true ) die();?>
<?$this->setFrameMode(true);?>
<?
use \Bitrix\Main\Localization\Loc;
// get element
$arItemFilter = CTires2::GetCurrentElementFilter($arResult["VARIABLES"], $arParams);
$arElement = CTires2Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => CTires2Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "N")), $arItemFilter, false, false, array("ID", 'NAME', 'PREVIEW_TEXT', "IBLOCK_SECTION_ID", 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'PROPERTY_LINK_PROJECTS', 'PROPERTY_LINK_REVIEWS', 'PROPERTY_DOCUMENTS'));
?>
<?$bHideBackUrl = false;?>
<?if(!$arElement && $arParams['SET_STATUS_404'] !== 'Y'):?>
	<div class="alert alert-warning"><?=GetMessage("ELEMENT_NOTFOUND")?></div>
<?elseif(!$arElement && $arParams['SET_STATUS_404'] === 'Y'):?>
	<?CTires2::goto404Page();?>
<?else:?>
	<?// rss
	if($arParams['USE_RSS'] !== 'N'){
		CTires2::ShowRSSIcon($arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss']);
	}?>
	<?CTires2::AddMeta(
		array(
			'og:description' => $arElement['PREVIEW_TEXT'],
			'og:image' => (($arElement['PREVIEW_PICTURE'] || $arElement['DETAIL_PICTURE']) ? CFile::GetPath(($arElement['PREVIEW_PICTURE'] ? $arElement['PREVIEW_PICTURE'] : $arElement['DETAIL_PICTURE'])) : false),
		)
	);?>
	<?if($arParams["USE_SHARE"] == "Y" && $arElement):?>
		<div class="line_block share top <?=($arParams['USE_RSS'] !== 'N' ? 'rss-block' : '');?>">
			<?$APPLICATION->IncludeFile(SITE_DIR."include/share_buttons.php", Array(), Array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_SOC_BUTTON')));?>
		</div>
		<script>
			$(document).ready(function(){
				if ($('a.rss').length) {
					$('a.rss').after($('.share.top'));
				}
				else {
					$('.page-top .h-wrapper').before($('.share.top'));
				}
			})
		</script>
	<?endif;?>
	<?global $arTheme;?>
	<?//element?>
	<?$sViewElementTemplate = ($arParams["ELEMENT_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["PARTNERS_PAGE_DETAIL"]["VALUE"] : $arParams["ELEMENT_TYPE_VIEW"]);?>
	<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
	<?/*
	if(is_array($arElement["IBLOCK_SECTION_ID"]) && count($arElement["IBLOCK_SECTION_ID"]) > 1){
		CTires2::CheckAdditionalChainInMultiLevel($arResult, $arParams, $arElement);
	}*/
	?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animation/animate.min.css');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');?>
<?endif;?>
<div style="clear:both"></div>
<?if(!$bHideBackUrl):?>
	<hr class="bottoms" />
	<div class="row">
		<div class="col-md-6 share">
			<?if($arParams["USE_SHARE"] == "Y" && $arElement):?>
				<div class="line_block">
					<?$APPLICATION->IncludeFile(SITE_DIR."include/share_buttons.php", Array(), Array("MODE" => "html", "NAME" => GetMessage('CT_BCE_CATALOG_SOC_BUTTON')));?>
				</div>
			<?endif;?>
		</div>
		<div class="col-md-6">
			<a class="back-url url-block" href="<?=$arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']?>"><i class="fa fa-angle-left"></i><span><?=GetMessage('BACK_LINK')?></span></a>
		</div>
	</div>
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