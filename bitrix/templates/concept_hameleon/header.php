<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$moduleID = "concept.hameleon";?>

<?
global $hameleon_rights;
$hameleon_rights = $APPLICATION->GetGroupRight($moduleID);
?>

<?CModule::IncludeModule($moduleID);?>
<?include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/functions.php");?>
<?$OS = os();?>


<?$bIsMainPage = $APPLICATION->GetCurDir(false) == SITE_DIR;?>

<?
use \Bitrix\Main\Page\Asset as Asset; 
?>


<!DOCTYPE HTML>



<html lang="<?$APPLICATION->ShowViewContent('lang_id')?>" prefix="og: //ogp.me/ns#">

<head>

	<meta name="author" content="concept" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
    
    

    <title><?$APPLICATION->ShowTitle()?></title>
    
    <?$APPLICATION->ShowHead();?>
	<?$APPLICATION->ShowViewContent("service_head");?>
</head>

<?
if(CModule::IncludeModuleEx($moduleID) == 3)
{
    include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/expired.php");
    die();
}
    
?>


<body id="body">
	<?$APPLICATION->ShowViewContent("inputs_info");?>
	<?$APPLICATION->ShowPanel();?>

	<?require_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/styles_and_scripts.php");?>

	<?$APPLICATION->ShowViewContent("service_body");?>
