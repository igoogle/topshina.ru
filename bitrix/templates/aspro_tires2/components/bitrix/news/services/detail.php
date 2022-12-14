<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
// get element
$arItemFilter = CTires2::GetCurrentElementFilter($arResult['VARIABLES'], $arParams);

global $APPLICATION, $isHideLeftBlock;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animation/animate.min.css');

$arElement = CTires2Cache::CIblockElement_GetList(array('CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'N')), $arItemFilter, false, false, array('ID', 'PREVIEW_TEXT', 'IBLOCK_SECTION_ID', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'DETAIL_PAGE_URL', 'LIST_PAGE_URL', 'PROPERTY_LINK_PROJECTS', 'PROPERTY_LINK_GOODS', 'PROPERTY_LINK_REVIEWS', 'PROPERTY_LINK_STAFF', 'PROPERTY_LINK_SERVICES'));

if($arParams["SHOW_TIRES2_ELEMENT"] == "Y")
{
	$arSort=array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"], $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"]);
	$arElementNext = array();

	$arAllElements = CTires2Cache::CIblockElement_GetList(array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"], $arParams["SORT_BY2"] => $arParams["SORT_ORDER2"], 'CACHE' => array('TAG' => CTires2Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'MULTI' => 'Y')), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y", "SECTION_ID" => $arElement["IBLOCK_SECTION_ID"]/*, ">ID" => $arElement["ID"]*/ ), false, false, array('ID', 'DETAIL_PAGE_URL', 'IBLOCK_ID', 'SORT'));
	if($arAllElements)
	{
		$url_page = $APPLICATION->GetCurPage();
		$key_item = 0;
		foreach($arAllElements as $key => $arItemElement)
		{
			if($arItemElement["DETAIL_PAGE_URL"] == $url_page)
			{
				$key_item = $key;
				break;
			}
		}
		if(strlen($key_item))
		{
			$arElementNext = $arAllElements[$key_item+1];
		}
		if($arElementNext)
		{
			if($arElementNext["DETAIL_PAGE_URL"] && is_array($arElementNext["DETAIL_PAGE_URL"])){
				$arElementNext["DETAIL_PAGE_URL"]=current($arElementNext["DETAIL_PAGE_URL"]);
			}
		}
	}
}
?>
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
	<div class="detail <?=($templateName = $component->{'__template'}->{'__name'})?>">
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

		<?//element?>
		<?@include_once('page_blocks/'.$arParams["ELEMENT_TYPE_VIEW"].'.php');?>

	</div>
	<?/*
	if(is_array($arElement['IBLOCK_SECTION_ID']) && count($arElement['IBLOCK_SECTION_ID']) > 1){
		CTires2::CheckAdditionalChainInMultiLevel($arResult, $arParams, $arElement);
	}*/
	?>
<?endif;?>
<div style="clear:both"></div>
<?if($arParams["SHOW_TIRES2_ELEMENT"] == "Y"):?>
	<hr class="bottoms" />
	<div class="row links-block">
		<div class="col-md-<?=($isHideLeftBlock ? 9 : 12);?> links">
			<a class="back-url url-block" href="<?=$arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']?>"><i class="fa fa-angle-left"></i><span><?=($arParams["T_PREV_LINK"] ? $arParams["T_PREV_LINK"] : GetMessage('BACK_LINK'));?></span></a>
			<?if($arElementNext):?>
				<a class="tires2-url url-block" href="<?=$arElementNext['DETAIL_PAGE_URL']?>"><i class="fa fa-angle-right"></i><span><?=($arParams["T_TIRES2_LINK"] ? $arParams["T_TIRES2_LINK"] : GetMessage('TIRES2_LINK'));?></span></a>
			<?endif;?>
		</div>
	</div>
<?else:?>
	<?if($isHideLeftBlock):?>
	<div class="row">
		<div class="col-md-9">
	<?endif;?>
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
					<a class="back-url url-block" href="<?=$arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']?>"><i class="fa fa-angle-left"></i><span><?=($arParams["T_PREV_LINK"] ? $arParams["T_PREV_LINK"] : GetMessage('BACK_LINK'));?></span></a>
				</div>
			</div>
		<?if($isHideLeftBlock):?>
		</div>
	</div>
	<?endif;?>
<?endif;?>