<?$bAjaxMode = (isset($_POST["AJAX_REQUEST_INSTAGRAM"]) && $_POST["AJAX_REQUEST_INSTAGRAM"] == "Y");
if($bAjaxMode)
{
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("");
	global $APPLICATION;
	\Bitrix\Main\Loader::includeModule("aspro.tires2");
	$bInstagrammIndex = (isset($_POST["SHOW_INSTAGRAM"]) && $_POST["SHOW_INSTAGRAM"] == 'Y');
}?>
<?global $bInstagrammIndex;?>
<?if($bInstagrammIndex):?>
	<?$APPLICATION->IncludeComponent(
		"aspro:instargam.tires2",
		"main",
		Array(
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"TITLE" => \Bitrix\Main\Config\Option::get("aspro.tires2", "INSTAGRAMM_TITLE_BLOCK", ""),
			"TOKEN" => \Bitrix\Main\Config\Option::get("aspro.tires2", "API_TOKEN_INSTAGRAMM", "1056017790.9b6cbfe.4dfb9d965b5c4c599121872c23b4dfd0")
		)
	);?>
<?endif;?>