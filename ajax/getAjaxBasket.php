<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header('Content-type: application/json');
if(!\Bitrix\Main\Loader::includeModule("sale") || !\Bitrix\Main\Loader::includeModule("catalog") || !\Bitrix\Main\Loader::includeModule("iblock") || !\Bitrix\Main\Loader::includeModule('aspro.tires2')){
	echo "failure";
	return;
}

$iblockID=(isset($_GET["iblockID"]) ? $_GET["iblockID"] : CTires2Cache::$arIBlocks[SITE_ID]['aspro_next_catalog']['aspro_next_catalog'][0] );
$arItems=CTires2::getBasketItems($iblockID);

echo json_encode($arItems);