<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?global $isShowReviewsIndex, $isBlog, $isHideLeftBlock, $isShowTopAdvBottomBanner, $isShowFloatBanner, $isShowTizers, $isShowSale,
$isShowBottomBanner, $isShowCompany, $isShowBrands, $isShowServicesIndex, $isShowCatalogSections, $isShowCatalogElements, $isShowFilter, $isShowIndexLeftBlock, $isShowMiddleAdvBottomBanner, $isShowBlog, $isShowTopBanner, $bInstagrammIndex, $isShowPromoBlockIndex, $arTheme;?>
<?global $bActiveTheme, $bShowFilterIndexClass, $bShowBrandsIndexClass, $bShowCatalogElementsIndexClass, $bShowTizersIndexClass, $bShowMiddleAdvIndexClass, $bShowSaleIndexClass,
$bShowBottomBannerIndexClass, $bShowCompanyIndexClass, $bShowBlogIndexClass, $bShowTopBannerIndexClass, $bShowInstagrammIndexClass, $bShowPromoBlockIndexClass, $bShowServicesIndexClass, $bShowReviewsIndexClass;?>

<?/*top banners*/?>
<?if($isShowTopBanner):?>
	<div class="drag-block container TOP_BANNER <?=$bShowTopBannerIndexClass;?>" data-class="TOP_BANNER_drag" data-order="1">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_banners_top_slider.php",
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

<?/*brands*/?>
<?if($isShowBrands):?>
	<div class="drag-block container BRANDS <?=$bShowBrandsIndexClass;?>" data-class="BRANDS_drag" data-order="3">
		<div class="brands-block-wr">
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
	</div>
<?endif;?>

<?/*catalog items*/?>
<?if($isShowCatalogElements):?>
	<div class="drag-block container CATALOG_TAB <?=$bShowCatalogElementsIndexClass;?>" data-class="CATALOG_TAB_drag" data-order="4">
		<hr>
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_catalog_hit.php",
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

<?/*middle banners*/?>
<?if($isShowMiddleAdvBottomBanner):?>
	<div class="drag-block container MIDDLE_ADV <?=$bShowMiddleAdvIndexClass;?>" data-class="MIDDLE_ADV_drag" data-order="5">
		<div class="maxwidth-theme">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
				array(
					"COMPONENT_TEMPLATE" => ".default",
					"PATH" => SITE_DIR."include/mainpage/comp_adv_middle.php",
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

<?/*about company*/?>
<?global $arRegion, $isShowCompany;?>
<?if($isShowCompany):?>
	<div class="drag-block container COMPANY_TEXT <?=$bShowCompanyIndexClass;?>" data-class="COMPANY_TEXT_drag" data-order="6">
		<div class="maxwidth-theme">
			<div class="company_bottom_block">
				<div class="row wrap_md">
					<div class="col-md-3 col-sm-3 hidden-xs img">
						<?$APPLICATION->IncludeFile(SITE_DIR."include/mainpage/company/front_img.php", Array(), Array( "MODE" => "html", "NAME" => GetMessage("FRONT_IMG") )); ?>
					</div>
					<div class="col-md-9 col-sm-9 big">
						<?if($arRegion):?>
							<?$frame = new \Bitrix\Main\Page\FrameHelper('text-regionality-block');?>
							<?$frame->begin();?>
								<?=$arRegion['DETAIL_TEXT'];?>
							<?$frame->end();?>
						<?else:?>
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "front", Array("AREA_FILE_SHOW" => "file","PATH" => SITE_DIR."include/mainpage/company/front_info.php","EDIT_TEMPLATE" => ""));?>
						<?endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?endif;?>
	
<?/*tizers*/?>
<?if($isShowTizers):?>
	<div class="drag-block container TIZERS <?=$bShowTizersIndexClass;?>" data-class="TIZERS_drag" data-order="7">
		<hr>
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

<?/*instagramm*/?>
<div class="drag-block container INSTAGRAMM <?=$bShowInstagrammIndexClass;?>" data-class="INSTAGRAMM_drag" data-order="8">
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