<div class="top_inner_block_wrapper maxwidth-theme">
	<div class="page-top-wrapper grey v3">
		<section class="page-top maxwidth-theme <?CTires2::ShowPageProps('TITLE_CLASS');?>">
			<div class="page-top-main">
				<?=$APPLICATION->ShowViewContent('product_share')?>
				<div class="h-wrapper">
					<?=$APPLICATION->ShowViewContent('product_icons_flag')?>
					<h1 id="pagetitle"><?$APPLICATION->ShowTitle(false)?></h1>
					<?=$APPLICATION->ShowViewContent('product_icons')?>
				</div>
			</div>
			<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "tires2", array(
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => SITE_ID,
				"SHOW_SUBSECTIONS" => "N"
				),
				false
			);?>
		</section>
	</div>
</div>