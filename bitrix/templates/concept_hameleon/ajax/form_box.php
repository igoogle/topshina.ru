<?
$site_id = trim($_POST["site_id"]);

if(strlen($site_id) > 0)
    define("SITE_ID", htmlspecialchars($site_id));
else
    die();

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

CModule::IncludeModule('iblock');


    $code_forms = 'concept_hameleon_forms';
    $formId = 0;
    $sect = 0;
    $ib = 0;
    $btn_type = "";
    $element_id = 0;
    $element_type = "";
    $other_complect = -1;
    $box_form = "";

    if(trim($_POST["resVal"]>0))
        $formId = trim($_POST["resVal"]);

    if(trim($_POST["section"]>0))
        $sect = trim($_POST["section"]);

    if(trim($_POST["ib"])>0)
        $ib = trim($_POST["ib"]);

    if(strlen(trim($_POST["btn_type"]))>0)
        $btn_type = trim($_POST["btn_type"]);

    if(trim($_POST["element_id"])>0)
        $element_id = trim($_POST["element_id"]);

    if(strlen(trim($_POST["element_type"]))>0)
        $element_type = trim($_POST["element_type"]);

    if(strlen(trim($_POST["other_complect"])) > 0)
        $other_complect = trim($_POST["other_complect"]);


    if(strlen(trim($_POST["box_form"]))>0)
        $box_form = trim($_POST["box_form"]);

   
   
   
$APPLICATION->IncludeComponent(
    "concept:hameleon_form",
    "form_cart",
    Array(
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "CURRENT_FORM" => $formId,
        "CURRENT_LAND" => $sect,
        "IBLOCK_ID" => $ib,
        "IBLOCK_CODE" => "concept_hameleon_forms",
        "MESSAGE_404" => "",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "BTV_VIEW" => $btn_type,
        "ELEMENT_ID" => $element_id,
        "ELEMENT_TYPE" => $element_type,
        "OTHER_COMPLECT" => $other_complect,
        "FORM_ORDER" => $box_form
        
    )
);?>