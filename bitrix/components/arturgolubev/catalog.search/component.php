<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


$ag_module = 'arturgolubev.smartsearch';
if(!CModule::IncludeModule($ag_module))
{
	global $USER; if($USER->IsAdmin()){
		echo '<div style="color:red;">'.GetMessage("ARTURGOLUBEV_SMARTSEARCH_MODULE_UNAVAILABLE").'</div>';
	}
	return;
}


$arResult["THEME_COMPONENT"] = $this->getParent();
if(!is_object($arResult["THEME_COMPONENT"]))
	$arResult["THEME_COMPONENT"] = $this;

if (!isset($arParams['ELEMENT_SORT_FIELD2']))
	$arParams['ELEMENT_SORT_FIELD2'] = '';
if (!isset($arParams['ELEMENT_SORT_ORDER2']))
	$arParams['ELEMENT_SORT_ORDER2'] = '';
if (!isset($arParams['HIDE_NOT_AVAILABLE']))
	$arParams['HIDE_NOT_AVAILABLE'] = '';
if (!isset($arParams['OFFERS_SORT_FIELD2']))
	$arParams['OFFERS_SORT_FIELD2'] = '';
if (!isset($arParams['OFFERS_SORT_ORDER2']))
	$arParams['OFFERS_SORT_ORDER2'] = '';

$this->IncludeComponentTemplate();
?>