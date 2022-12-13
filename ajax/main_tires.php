<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

if(isset($request['TEMPLATE_PARAMS']) && isset($request['IBLOCK_ID']) && $request['TEMPLATE_PARAMS'] && $request['IBLOCK_ID']){
	global $arRegion;
	$arRegion = CTires2Regionality::getCurrentRegion();

	$arTmpParams = $request['TEMPLATE_PARAMS'];
	
	if(SITE_CHARSET !== 'UTF-8'){
		foreach($arTmpParams as $key => &$val){
			// $val = iconv('UTF-8', SITE_CHARSET, $val);
			$val = $GLOBALS["APPLICATION"]->ConvertCharset($val, 'UTF-8', SITE_CHARSET);
		}
		unset($val);
	}
	
	$arTemplateParams = $arTmpParams;
	
	if(is_array($arTemplateParams)){
		foreach($arTemplateParams as $key => $param){
			if(strpos($key, '~') !== false){
				unset($arTemplateParams[$key]);
			}
		}
	}
	
	$arTemplateParams['IBLOCK_ID'] = $request['IBLOCK_ID'];
	$arTemplateParams['FILTER_URL'] = $request['FILTER_URL'];
	$arTemplateParams['TYPE'] = $request['TYPE'];
	?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter", 
		$request['TEMPLATE_NAME'], 
		$arTemplateParams,
		false
	);?>
	<?
}
?>