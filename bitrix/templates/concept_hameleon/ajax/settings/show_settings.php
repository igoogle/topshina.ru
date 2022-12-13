<?$site_id = trim($_REQUEST["site_id"]);

if(strlen($site_id) > 0)
    define("SITE_ID", htmlspecialchars($site_id));

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if($_REQUEST["panel"])
{
	$panel = htmlspecialchars(trim($_REQUEST["panel"]));

    if($_REQUEST["currentSectionId"])
        $currentSectionId = htmlspecialchars(trim($_REQUEST["currentSectionId"]));
}


$APPLICATION->IncludeComponent(
	"concept:pages.list",
	"",
	Array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "N",
		"SITE_ID" => $site_id,
        "PANEL" => $panel,
        "CURRENT_SECTION_ID" => $currentSectionId
	)
);

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");