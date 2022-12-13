<?$bAjaxMode = (isset($_POST["AJAX_POST"]) && $_POST["AJAX_POST"] == "Y");
if($bAjaxMode)
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	global $APPLICATION;
	if(\Bitrix\Main\Loader::includeModule("aspro.tires2"))
	{
		$arRegion = CTires2Regionality::getCurrentRegion();
	}
}?>
<?if((isset($arParams["IBLOCK_IDS"]) && $arParams["IBLOCK_IDS"]) || $bAjaxMode):?>
	<?
	$arIncludeParams = ($bAjaxMode ? $_POST["AJAX_PARAMS"] : $arParamsTmp);
	$arGlobalFilter = ($bAjaxMode ? unserialize(urldecode($_POST["GLOBAL_FILTER"])) : array());
	$arComponentParams = unserialize(urldecode($arIncludeParams));
	?>
	
	<?
	if($bAjaxMode && (is_array($arGlobalFilter) && $arGlobalFilter))
		$GLOBALS[$arComponentParams["FILTER_NAME"]] = $arGlobalFilter;
	?>

	<?
	/* hide compare link from module options */
	if(CTires2::GetFrontParametrValue('CATALOG_COMPARE') == 'N')
		$arComponentParams["DISPLAY_COMPARE"] = 'N';
	/**/

	/* hide delay link from module options */
	if(CTires2::GetFrontParametrValue('CATALOG_DELAY') == 'N')
		$arComponentParams["DISPLAY_WISH_BUTTONS"] = 'N';
	/**/
	?>

	<?$APPLICATION->IncludeComponent(
		"aspro:catalog.section.tires2",
		"catalog_block",
		$arComponentParams,
		false, array("HIDE_ICONS"=>"Y")
	);?>
	
<?endif;?>