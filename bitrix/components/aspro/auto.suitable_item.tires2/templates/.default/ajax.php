<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);?>
<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");?>

<?
$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

if($request->isPost() && $request->get("AUTO_MARK")):?>
	<?
	$arParams = $request->getPostList()->toArray();
	foreach($arParams as $key => $arParam)
	{
		if(strpos($key, "~") !== false)
			unset($arParams[$key]);
	}
	$arParams["SHOW_ITEM"] = "Y";
	?>
	<?$APPLICATION->IncludeComponent(
		$arParams["COMPONENT_NAME"],
		$arParams["TEMPLATE"],
		$arParams
	);?>
<?endif;?>