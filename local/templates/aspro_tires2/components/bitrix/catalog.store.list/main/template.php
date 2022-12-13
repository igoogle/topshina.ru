<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if(strlen($arResult["ERROR_MESSAGE"])>0) ShowError($arResult["ERROR_MESSAGE"]);?>
<?if($arResult["STORES"]):?>
	<?CTires2::drawShopsList($arResult["STORES"], $arParams);?>
<?else:?>
	<div class="wrapper_inner">
		<div class="alert alert-warning"><?=GetMessage("NOT_FOUND_ITEMS")?></div>
	</div>
<?endif;?>