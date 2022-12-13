<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
	'BLOCK_TITLE' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_BLOCK_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('T_BCSF_BLOCK_TITLE_VALUE'),
	),
	'FILTER_URL' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_FILTER_URL'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'TYPE' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'tires' => GetMessage('T_TYPE_TIRES'),
			'moto tires' => GetMessage('T_TYPE_MTIRES'),
			'truck tires' => GetMessage('T_TYPE_TTIRES'),
			'wheels' => GetMessage('T_TYPE_WHEELS'),
		),
		'DEFAULT' => 'tires',
	),
	'DISPLAY_ELEMENT_COUNT' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_DISPLAY_ELEMENT_COUNT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	),
);

$arTemplateParameters['SHOW_FILTER_TIRES'] = array(
	'SORT' => 600,
	"NAME" => GetMessage("T_BCSF_SHOW_FILTER_TIRES"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['SHOW_FILTER_TIRES'] == 'Y'){
	$arTemplateParameters['FILTER_TIRES_TITLE'] = array(
		'SORT' => 620,
		'NAME' => GetMessage('T_BCSF_FILTER_TIRES_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('FILTER_TIRES_TITLE_DEFAULT'),
	);
}

$arTemplateParameters['SHOW_FILTER_WHEELS'] = array(
	'SORT' => 700,
	"NAME" => GetMessage("T_BCSF_SHOW_FILTER_WHEELS"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['SHOW_FILTER_WHEELS'] == 'Y'){
	$arTemplateParameters['FILTER_WHEELS_TITLE'] = array(
		'SORT' => 620,
		'NAME' => GetMessage('T_BCSF_FILTER_WHEELS_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('FILTER_WHEELS_TITLE_DEFAULT'),
	);
}

$arTemplateParameters['SHOW_FILTER_AKB'] = array(
	'SORT' => 800,
	"NAME" => GetMessage("T_BCSF_SHOW_FILTER_AKB"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['SHOW_FILTER_AKB'] == 'Y'){
	$arTemplateParameters['FILTER_AKB_TITLE'] = array(
		'SORT' => 620,
		'NAME' => GetMessage('T_BCSF_FILTER_AKB_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('FILTER_AKB_TITLE_DEFAULT'),
	);
}

$arTemplateParameters['SHOW_FILTER_MOTO_TIRES'] = array(
	'SORT' => 600,
	"NAME" => GetMessage("T_BCSF_SHOW_FILTER_MOTO_TIRES"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['SHOW_FILTER_MOTO_TIRES'] == 'Y'){
	$arTemplateParameters['FILTER_MOTO_TIRES_TITLE'] = array(
		'SORT' => 620,
		'NAME' => GetMessage('T_BCSF_FILTER_MOTO_TIRES_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('FILTER_MOTO_TIRES_TITLE_DEFAULT'),
	);
}

$arTemplateParameters['SHOW_FILTER_TRUCK_TIRES'] = array(
	'SORT' => 600,
	"NAME" => GetMessage("T_BCSF_SHOW_FILTER_TRUCK_TIRES"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['SHOW_FILTER_TRUCK_TIRES'] == 'Y'){
	$arTemplateParameters['FILTER_TRUCK_TIRES_TITLE'] = array(
		'SORT' => 620,
		'NAME' => GetMessage('T_BCSF_FILTER_TRUCK_TIRES_TITLE'),
		'TYPE' => 'STRING',
		'DEFAULT' => GetMessage('FILTER_TRUCK_TIRES_TITLE_DEFAULT'),
	);
}
?>