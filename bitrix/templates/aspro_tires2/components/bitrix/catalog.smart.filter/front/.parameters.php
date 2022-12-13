<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arTemplateParameters = array(
	'BLOCK_TITLE_TIRES' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_BLOCK_TITLE_TIRES'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'BLOCK_TITLE_TIRES_MOTO' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_BLOCK_TITLE_TIRES_MOTO'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'BLOCK_TITLE_TIRES_TRUCK' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_BLOCK_TITLE_TIRES_TRUCK'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
	),
	'BLOCK_TITLE_TIRES_WHEELS' => array(
		'SORT' => 500,
		'NAME' => GetMessage('T_BCSF_BLOCK_TITLE_TIRES_WHEELS'),
		'TYPE' => 'STRING',
		'DEFAULT' => '',
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
?>