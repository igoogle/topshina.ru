<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if(\Bitrix\Main\Loader::includeModule('aspro.tires2')):?>
	<?$APPLICATION->IncludeComponent("aspro:oneclickbuy.tires2", "shop", array(
		"BUY_ALL_BASKET" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000",
		"CACHE_GROUPS" => "N",
		"SHOW_LICENCE" => CTires2::GetFrontParametrValue('SHOW_LICENCE'),
		"SHOW_DELIVERY_NOTE" => COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_SHOW_DELIVERY_NOTE', 'N', SITE_ID),
			"PROPERTIES" => (strlen($tmp = COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_PROPERTIES', 'FIO,PHONE,EMAIL,COMMENT', SITE_ID)) ? explode(',', $tmp) : array()),
		"REQUIRED" => (strlen($tmp = COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_REQUIRED_PROPERTIES', 'FIO,PHONE', SITE_ID)) ? explode(',', $tmp) : array()),
		"DEFAULT_PERSON_TYPE" => COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_PERSON_TYPE', '1', SITE_ID),
		"DEFAULT_DELIVERY" => COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_DELIVERY', '2', SITE_ID),
		"DEFAULT_PAYMENT" => COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_PAYMENT', '1', SITE_ID),
		"DEFAULT_CURRENCY" => COption::GetOptionString('aspro.tires2', 'ONECLICKBUY_CURRENCY', 'RUB', SITE_ID),
		),
		false
	);?>
<?endif;?>