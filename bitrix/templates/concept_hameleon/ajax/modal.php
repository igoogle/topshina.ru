<?$site_id = trim($_POST["site_id"]);

if(strlen($site_id) > 0)
    define("SITE_ID", htmlspecialchars($site_id));
else
    die();


require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');

$element_id = trim($_POST["element_id"]);
$name = trim($_POST["name"]);
$all_id = trim($_POST["all_id"]);
$land_id = trim($_POST["land_id"]);
$land_iblock_id = trim($_POST["land_iblock_id"]);
$catalog_id = trim($_POST["catalog_id"]);
$added = trim($_POST["added"]);

$res = CIBlockElement::GetByID($element_id);
$ar_res = $res->GetNext();

if(SITE_CHARSET == "windows-1251")
    $block_header = utf8win1251(trim($_POST["block_header"]));                

else
	$block_header = trim($_POST["block_header"]);
?>

<?	
	$arTemplate = Array();

	$arTemplate["catalog"] = Array();
	$arTemplate["catalog"]["TEMPLATE"] = "hameleon-catalog-detail";
    $arTemplate["catalog"]["CACHE"] = "N";
    
	$arTemplate["news"] = Array();
	$arTemplate["news"]["TEMPLATE"] = "hameleon-news-detail";
    $arTemplate["news"]["CACHE"] = "A";

	$arTemplate["tariff"] = Array();
	$arTemplate["tariff"]["TEMPLATE"] = "hameleon-tariff-detail";
    $arTemplate["tariff"]["CACHE"] = "A";

	$arTemplate["service"] = Array();
	$arTemplate["service"]["TEMPLATE"] = "hameleon-service-detail";
    $arTemplate["service"]["CACHE"] = "A";

?>
    <div class="modal-arrows hidden-xs">
        <div class="container">

        <?
            $APPLICATION->IncludeComponent(
			   "concept:next-last-element",
			   "id_arrows",
			   Array(
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "3600000",
					"CACHE_TYPE" => "N",
					"COMPONENT_TEMPLATE" => ".default",
					"ELEMENT_ID" => $element_id,
					"NAME" => $name,
					"ALL_ID" => $all_id,
					"LAND_ID" => $land_id,
					"SITE_ID" => SITE_ID,
					"ADDED" => $added,
					"CHAM_HEADER" => $block_header,
					"CATALOG_ID" => $catalog_id
			   )
    		);
		?>

        </div>
    </div>

    <div class="wrap-modal-outer">
        <div class="container mob-container">

        	<table class="wr-content">
        		<tbody>
        			<tr>
        				<td class="wr-content">
        
				            <div class="wrap-modal-inner">
				  			
								<?$APPLICATION->IncludeComponent(
									"bitrix:news.detail",
									$arTemplate[$name]["TEMPLATE"],
									Array(
										"ACTIVE_DATE_FORMAT" => "d.m.Y",
										"ADD_ELEMENT_CHAIN" => "N",
										"ADD_SECTIONS_CHAIN" => "N",
										"AJAX_MODE" => "N",
										"AJAX_OPTION_ADDITIONAL" => "",
										"AJAX_OPTION_HISTORY" => "N",
										"AJAX_OPTION_JUMP" => "N",
										"AJAX_OPTION_STYLE" => "Y",
										"BROWSER_TITLE" => "-",
										"CACHE_GROUPS" => "Y",
										"CACHE_TIME" => "36000000",
										"CACHE_TYPE" => $arTemplate[$name]["CACHE"],
										"CHECK_DATES" => "Y",
										"COMPONENT_TEMPLATE" => $arTemplate[$name]["TEMPLATE"],
										"COMPOSITE_FRAME_MODE" => "N",
										"COMPOSITE_FRAME_TYPE" => "AUTO",
										"DETAIL_URL" => "",
										"DISPLAY_BOTTOM_PAGER" => "N",
										"DISPLAY_DATE" => "N",
										"DISPLAY_NAME" => "Y",
										"DISPLAY_PICTURE" => "Y",
										"DISPLAY_PREVIEW_TEXT" => "Y",
										"DISPLAY_TOP_PAGER" => "N",
										"ELEMENT_CODE" => "",
										"ELEMENT_ID" => $element_id,
										"FIELD_CODE" => array(0=>"",1=>"",),
										"IBLOCK_ID" => $ar_res["IBLOCK_ID"],
										"IBLOCK_TYPE" => "concept_hameleon",
										"IBLOCK_URL" => "",
										"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
										"MESSAGE_404" => "",
										"META_DESCRIPTION" => "-",
										"META_KEYWORDS" => "-",
										"PAGER_BASE_LINK_ENABLE" => "N",
										"PAGER_SHOW_ALL" => "N",
										"PAGER_TEMPLATE" => ".default",
										"PAGER_TITLE" => "Страница",
										"PROPERTY_CODE" => array(),
										"SET_BROWSER_TITLE" => "N",
										"SET_CANONICAL_URL" => "N",
										"SET_LAST_MODIFIED" => "N",
										"SET_META_DESCRIPTION" => "N",
										"SET_META_KEYWORDS" => "N",
										"SET_STATUS_404" => "N",
										"SET_TITLE" => "N",
										"SHOW_404" => "N",
										"STRICT_SECTION_CHECK" => "N",
										"USE_PERMISSIONS" => "N",
										"USE_SHARE" => "N",
										"LAND_ID" => $land_id,
										"LAND_IBLOCK_ID" => $land_iblock_id,
										"CHAM_HEADER" => $block_header,
										"DATA_LINK" => $dataLink,
				                        "CATALOG_ID" => $catalog_id,
				                        "ADDED" => $added,
									)
								);?>

							</div>

						</td>
        			</tr>
        		</tbody>
        	</table>
        </div>
    </div>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
?>