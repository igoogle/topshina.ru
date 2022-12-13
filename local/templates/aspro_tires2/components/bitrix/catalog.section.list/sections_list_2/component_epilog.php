<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$count=ceil($templateData["COUNTS_ALL_SECTIONS"]/$arParams["SECTION_PAGE_ELEMENT"]);?>
<?if($count>1):?>
	<?$context=\Bitrix\Main\Application::getInstance()->getContext();
	$request=$context->getRequest();?>

	<?
	$count_item_between_cur_page = 2; // count numbers left and right from cur page
	$count_item_dotted = 2; // count numbers to end or start pages

	$nCurPage = ($templateData["PAGE"] ? $templateData["PAGE"] : 1);
	$nStartPage = $nCurPage - $count_item_between_cur_page;
	$nStartPage = $nStartPage <= 0 ? 1 : $nStartPage;
	$nEndPage = $nCurPage + $count_item_between_cur_page;
	$nEndPage = $nEndPage > $count ? $count : $nEndPage;
	?>
	<div class="bottom_nav block">
		<div class="bottom_nav_inner">
			<?if($nCurPage < $count && $nCurPage != $count):?>
				<div class="ajax_load_btn">
					<span class="more_text_ajax"><?=\Bitrix\Main\Localization\Loc::getMessage("SHOW_MORE_ITEM")?></span>
				</div>
			<?endif;?>
			<div class="module-pagination">
				<div class="nums">
					<ul class="flex-direction-nav">
						<?if($nCurPage > 1 && $nCurPage <= $count):?>
							<li class="flex-nav-prev "><a href="<?=$APPLICATION->GetCurPageParam(($nCurPage > 2 ? "PAGEN_2=".($nCurPage-1) : ""), array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="flex-prev"></a></li>
							<link rel="prev" href="<?=$APPLICATION->GetCurPageParam(($nCurPage > 2 ? "PAGEN_2=".($nCurPage-1) : ""), array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" />
							<link rel="canonical" href="<?=$APPLICATION->GetCurPageParam('', array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" />
						<?endif;?>
						<?if($nCurPage < $count && $nCurPage != $count):?>
							<?$page = ($nCurPage ? $nCurPage : 1);?>
							<li class="flex-nav-next "><a href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".($page+1), array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="flex-next"></a></li>
							<link rel="next" href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".($page+1), array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" />
						<?endif;?>
					</ul>
					<?if($nStartPage > 1):?>
						<a href="<?=$APPLICATION->GetCurPageParam("", array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="dark_link">1</a>
						<?if(($nStartPage - $count_item_dotted) > 1):?>
							<span class='point_sep'></span>
						<?elseif(($firstPage = $nStartPage-1) > 1 && $nStartPage !=2):?>
							<a href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".$firstPage, array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>"><?=$firstPage?></a>
						<?endif;?>
					<?endif;?>

					<?while($nStartPage <= $nEndPage):?>
						<?if($nStartPage == $nCurPage):?>
							<span class="cur"><?=$nStartPage?></span>
						<?elseif($nStartPage == 1):?>
							<a href="<?=$APPLICATION->GetCurPageParam("", array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="dark_link"><?=$nStartPage?></a>
						<?else:?>
							<a href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".$nStartPage, array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="dark_link"><?=$nStartPage?></a>
						<?endif;?>
						<?$nStartPage++;?>
					<?endwhile;?>

					<?if($nEndPage < $count):?>
						<?if(($nEndPage + $count_item_dotted) < $count):?>
							<span class='point_sep'></span>
						<?elseif(($lastPage = $nEndPage+1) < $count):?>
							<a href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".$lastPage, array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>"><?=$lastPage?></a>
						<?endif;?>
						<a href="<?=$APPLICATION->GetCurPageParam("PAGEN_2=".$count, array("PAGEN_2", "ajax_get", "AJAX_REQUEST", "bitrix_include_areas"))?>" class="dark_link"><?=$count?></a>
					<?endif;?>

				</div>
			</div>
		</div>
	</div>
<?endif;?>