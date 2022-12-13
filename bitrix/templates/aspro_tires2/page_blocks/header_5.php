<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
global $arTheme, $arRegion;
$arRegions = CTires2Regionality::getRegions();
if($arRegion)
	$bPhone = ($arRegion['PHONES'] ? true : false);
else
	$bPhone = ((int)$arTheme['HEADER_PHONES'] ? true : false);
$logoClass = ($arTheme['COLORED_LOGO']['VALUE'] !== 'Y' ? '' : ' colored');
?>
<div class="top-block top-block-v1">
	<div class="maxwidth-theme">
		<div class="row">
			<div class="col-md-5">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
					array(
						"COMPONENT_TEMPLATE" => ".default",
						"PATH" => SITE_DIR."include/menu/menu.topest.php",
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "",
						"AREA_FILE_RECURSIVE" => "Y",
						"EDIT_TEMPLATE" => "include_area.php"
					),
					false
				);?>
			</div>
			<div class="top-block-item pull-right show-fixed top-ctrl">
				<div class="personal_wrap">
					<div class="personal top login twosmallfont">
						<?=CTires2::ShowCabinetLink(true, true);?>
					</div>
				</div>
			</div>
			<div class="top-block-item pull-right show-fixed top-ctrl">
				<button class="top-btn inline-search-show twosmallfont">
					<?=CTires2::showIconSvg("search", SITE_TEMPLATE_PATH."/images/svg/Search_black.svg");?>
					<span class="dark-color"><?=GetMessage('SEARCH_TITLE')?></span>
				</button>
			</div>
			<div class="top-block-item pull-right visible-lg adress">
				<?CTires2::showAddress('address twosmallfont inline-block');?>
			</div>
		</div>
	</div>
</div>
<div class="header-wrapper">
	<div class="logo_and_menu-row">
		<div class="logo-row">
			<div class="maxwidth-theme">
				<div class="row">
					<div class="logo-block col-md-2 col-sm-3">
						<div class="logo<?=$logoClass?>">
							<?=CTires2::ShowLogo();?>
						</div>
					</div>
					<div class="col-md-2 hidden-sm hidden-xs">
						<div class="top-description">
							<?$APPLICATION->IncludeFile(SITE_DIR."include/top_page/slogan.php", array(), array(
									"MODE" => "html",
									"NAME" => "Text in title",
									"TEMPLATE" => "include_area.php",
								)
							);?>
						</div>
					</div>
					<?if($arRegions):?>
						<div class="inline-block pull-left">
							<div class="top-description">
								<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
									array(
										"COMPONENT_TEMPLATE" => ".default",
										"PATH" => SITE_DIR."include/top_page/regionality.list.php",
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "",
										"AREA_FILE_RECURSIVE" => "Y",
										"EDIT_TEMPLATE" => "include_area.php"
									),
									false
								);?>
							</div>
						</div>
					<?endif;?>
					<div class="pull-right block-link">
						<?=CTires2::ShowBasketWithCompareLink('with_price', 'big', true, 'wrap_icon inner-table-block baskets big-padding');?>
					</div>
					<div class="right-icons pull-right">
						<div class="phone-block with_btn">
							<?if($bPhone):?>
								<div class="inner-table-block">
									<?CTires2::ShowHeaderPhones();?>
									<div class="schedule">
										<?$APPLICATION->IncludeFile(SITE_DIR."include/header-schedule.php", array(), array("MODE" => "html","NAME" => GetMessage('HEADER_SCHEDULE'),"TEMPLATE" => "include_area.php"));?>
									</div>
								</div>
							<?endif?>
							<?if($arTheme['SHOW_CALLBACK']['VALUE'] == 'Y'):?>
								<div class="inner-table-block">
									<span class="callback-block animate-load twosmallfont colored  white btn-default btn" data-event="jqm" data-param-form_id="CALLBACK" data-name="callback"><?=GetMessage("CALLBACK")?></span>
								</div>
							<?endif;?>
						</div>
					</div>
				</div>
			</div>
		</div><?// class=logo-row?>
	</div>
	<div class="menu-row middle-block bg<?=strtolower($arTheme["MENU_COLOR"]["VALUE"]);?>">
		<div class="maxwidth-theme">
			<div class="row">
				<div class="col-md-12">
					<div class="menu-only">
						<nav class="mega-menu sliced">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default",
								array(
									"COMPONENT_TEMPLATE" => ".default",
									"PATH" => SITE_DIR."include/menu/menu.top_catalog_wide.php",
									"AREA_FILE_SHOW" => "file",
									"AREA_FILE_SUFFIX" => "",
									"AREA_FILE_RECURSIVE" => "Y",
									"EDIT_TEMPLATE" => "include_area.php"
								),
								false, array("HIDE_ICONS" => "Y")
							);?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="line-row visible-xs"></div>
</div>