<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);?>

<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

if($request['type_filter'])
	$typeFilter = $request['type_filter'];
elseif($arParams['TYPE_FILTER'])
	$typeFilter = $arParams['TYPE_FILTER'];

use \Bitrix\Main\Localization\Loc;
global $APPLICATION;
$arResult = array();

$cache = new CPHPCache();
$cache_time = 3600000;
$cache_path = 'auto_list.tires2/'.$typeFilter;


$bAkb = ($typeFilter == 'akb');
$baseName = ($bAkb ? 'tx_carmodels_akb' : 'tx_carmodels');
$cache_id = 'auto_list';

if($cache->InitCache($cache_time, $cache_id, $cache_path))
{
	$res = $cache->GetVars();
	$arResult = $res["arResult"];
}
else
{
	global $DB;
	
	$strsql = "show tables like '".$baseName."'";
	$res = $DB->Query($strsql, false, $err_mess.__LINE__);
	if($res->SelectedRowsCount())
	{
		$strsql = 'SELECT vendor FROM '.$baseName.' GROUP BY vendor ORDER BY vendor ASC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["CARS"][] = array( "NAME" => $car["vendor"], "FORMAT_NAME" => crc32($car["vendor"]) );

		if ($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
	else
	{
		echo Loc::getMessage("ERROR_TABLES_TYREINDEX");
		return;
	}
}
	
if(!empty($arParams["AUTO_MARK"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_car';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"];

	foreach($arResult["CARS"] as $key => $arValue)
	{
		if($arValue["FORMAT_NAME"] == $arParams["AUTO_MARK"])
			$arParams["AUTO_MARK"] = $arValue["NAME"];
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT model FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" GROUP BY model ORDER BY model ASC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["MODEL"][] = array( "NAME" => $car["model"], "FORMAT_NAME" => crc32($car["model"]) );

		if ($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_MARK"]) && !empty( $arParams["AUTO_MODEL"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_model';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"];

	foreach($arResult["MODEL"] as $key => $arValue)
	{
		if($arValue["FORMAT_NAME"] == $arParams["AUTO_MODEL"])
			$arParams["AUTO_MODEL"] = $arValue["NAME"];
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT year FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" AND model = "'.$arParams["AUTO_MODEL"].'" GROUP BY year ORDER BY year DESC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["YEAR"][] = array( "NAME" => $car["year"], "FORMAT_NAME" => crc32($car["year"]) );
		
		if($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_MARK"]) && !empty($arParams["AUTO_MODEL"]) && !empty($arParams["AUTO_YEAR"]))
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_year';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"].'_year_'.$arParams["AUTO_YEAR"];

	if(is_array($arResult["YEAR"])){
		foreach($arResult["YEAR"] as $key => $arValue)
		{
			if($arValue["FORMAT_NAME"] == $arParams["AUTO_YEAR"])
				$arParams["AUTO_YEAR"] = $arValue["NAME"];
		}
	}

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		$strsql = 'SELECT modification FROM '.$baseName.' WHERE vendor = "'.$arParams["AUTO_MARK"].'" AND model = "'.$arParams["AUTO_MODEL"].'" AND year = "'.$arParams["AUTO_YEAR"].'" GROUP BY modification ORDER BY modification ASC';
		$res = $DB->Query($strsql, false, $err_mess.__LINE__);
		while($car = $res->fetch())
			$arResult["MODIFICATION"][] = array( "NAME" => $car["modification"], "FORMAT_NAME" => crc32($car["modification"]) );
		
		if($cache_time > 0)
		{
			$cache->StartDataCache($cache_time, $cache_id, $cache_path);
			$cache->EndDataCache(
				array(
					"arResult" => $arResult,
				)
			);
		}
	}
}

if(!empty($arParams["AUTO_COMPLECT"]) && $typeFilter)
{
	$cache = new CPHPCache();
	$cache_time = 3600000;
	$cache_path .= '/_modification';

	$cache_id = 'auto_list_car_'.$arParams["AUTO_MARK"].'_model_'.$arParams["AUTO_MODEL"].'_year_'.$arParams["AUTO_YEAR"].'_mod_'.$arParams["AUTO_COMPLECT"].'_type_'.$typeFilter;
	

	$modification = $arParams["AUTO_COMPLECT"];
	
	if(is_array($arResult["MODIFICATION"])){
		foreach($arResult["MODIFICATION"] as $key => $arValue)
		{
			if($arValue["FORMAT_NAME"] == $arParams["AUTO_COMPLECT"])
				$modification = $arValue["NAME"];
		}
	}

	$modification = str_replace('\\', '\\\\', $modification);

	if($cache->InitCache($cache_time, $cache_id, $cache_path))
	{
		$res = $cache->GetVars();
		$arResult = $res["arResult"];
	}
	else
	{
		if($typeFilter == 'tires')
		{
			$strsql = 'select tyre.spectype, tyre.front_width, tyre.front_profile, tyre.front_diameter, tyre.back_width, tyre.back_profile, tyre.back_diameter
				from tx_tyrespecifications as tyre, tx_carmodels as car 
				where tyre.carmodel = car.id and car.id = ( select id from tx_carmodels where vendor = "'.$arParams["AUTO_MARK"].'" and model = "'.$arParams["AUTO_MODEL"].'" and year = "'.$arParams["AUTO_YEAR"].'" and modification = "'.$modification.'" )';
			$res = $DB->Query($strsql, false, $err_mess.__LINE__);
			
			$arResult["TYPE"]["DEFAULT"] = array();
			$arResult["TYPE"]["ALTERNATIVE"] = array();
			$arResult["TYPE"]["TUNING"] = array();
			
			while($car = $res->fetch())
			{
				if(!empty( $car["front_width"]) && !empty($car["front_profile"]) && !empty($car["front_diameter"]))
				{
					$arResult["TYPE"][$car["spectype"]]["FRONT"][$car["front_width"].$car["front_profile"].$car["front_diameter"]] = array( "WIDTH" => (float)$car["front_width"], "HEIGHT" => (float)$car["front_profile"], "DIAM" => (float)$car["front_diameter"] );
				}
				if(!empty($car["back_width"]) && !empty($car["back_profile"]) && !empty($car["back_diameter"]))
				{
					$arResult["TYPE"][$car["spectype"]]["BACK"][$car["back_width"].$car["back_profile"].$car["back_diameter"]] = array( "WIDTH" => (float)$car["back_width"], "HEIGHT" => (float)$car["back_profile"], "DIAM" => (float)$car["back_diameter"] );
				}
			}
			if(!$arResult["TYPE"]["DEFAULT"] && !$arResult["TYPE"]["ALTERNATIVE"] && !$arResult["TYPE"]["TUNING"])
			{
				// unset($arResult["TYPE"]);
				$arResult["TYPE"] = array();
			}
		}
		elseif($typeFilter == 'wheels')
		{
			$strsql = 'select wheel.spectype, wheel.front_width, wheel.front_diameter, wheel.front_et, wheel.back_width, wheel.back_diameter, wheel.back_et, car.lz, car.pcd, car.dia, car.bolt
					from tx_wheelspecifications as wheel, tx_carmodels as car 
					where wheel.carmodel = car.id and car.id = ( select id from tx_carmodels where vendor = "'.$arParams["AUTO_MARK"].'" and model = "'.$arParams["AUTO_MODEL"].'" and year = "'.$arParams["AUTO_YEAR"].'" and modification = "'.$modification.'" )';
			$res = $DB->Query($strsql, false, $err_mess.__LINE__);

			$arResult["TYPE"]["DEFAULT"] = array();
			$arResult["TYPE"]["ALTERNATIVE"] = array();
			$arResult["TYPE"]["TUNING"] = array();

			while($car = $res->fetch())
			{
				if(!empty($car["front_width"]) && !empty($car["front_diameter"]) && !empty($car["front_et"]) && !empty($car["pcd"]))
				{
					$car["front_width"] = number_format( $car["front_width"], 1, ',', '' );
					$car["front_width"] = str_replace( ',', '.', $car["front_width"] );
					$car["front_diameter"] = number_format( $car["front_diameter"], 1, ',', '' );
					$car["front_diameter"] = str_replace( ',0', '', $car["front_diameter"] );
					$car["front_et"] = number_format( $car["front_et"], 1, ',', '' );
					$car["front_et"] = str_replace( ',0', '', $car["front_et"] );
					$car["pcd"] = number_format( $car["pcd"], 1, '.', '' );
					$car["pcd"] = str_replace( '.0', '', $car["pcd"] );
					$arResult["TYPE"][$car["spectype"]]["FRONT"][$car["front_width"].$car["front_diameter"].$car["front_et"].$car["lz"].$car["pcd"]] = array( "WIDTH" => (float)$car["front_width"], "DIAM" => (float)$car["front_diameter"], "ET" => $car["front_et"], "LZ" => (float)$car['lz'], "PCD" => (float)$car['pcd'], "DIA" => $car['dia'], "BOLT" => $car['bolt'] );
				}
				if(!empty($car["back_width"]) && !empty($car["back_diameter"]) && !empty($car["back_et"]) && !empty($car["pcd"]))
				{
					$car["back_width"] = number_format( $car["back_width"], 1, ',', '' );
					$car["back_width"] = str_replace( ',', '.', $car["back_width"] );
					$car["back_diameter"] = number_format( $car["back_diameter"], 1, ',', '' );
					$car["back_diameter"] = str_replace( ',0', '', $car["back_diameter"] );
					$car["back_et"] = number_format( $car["back_et"], 1, ',', '' );
					$car["back_et"] = str_replace( ',0', '', $car["back_et"] );
					$car["pcd"] = number_format( $car["pcd"], 1, '.', '' );
					$car["pcd"] = str_replace( '.0', '', $car["pcd"] );
					$arResult["TYPE"][$car["spectype"]]["BACK"][$car["back_width"].$car["back_diameter"].$car["front_et"].$car["lz"].$car["pcd"]] = array( "WIDTH" => (float)$car["back_width"], "DIAM" => (float)$car["back_diameter"], "ET" => $car["back_et"], "LZ" => (float)$car['lz'], "PCD" => (float)$car['pcd'], "DIA" => $car['dia'], "BOLT" => $car['bolt'] );
				}
			}
			if(!$arResult["TYPE"]["DEFAULT"] && !$arResult["TYPE"]["ALTERNATIVE"] && !$arResult["TYPE"]["TUNING"])
			{
				// unset($arResult["TYPE"]);
				$arResult["TYPE"] = array();
			}
		}
		elseif($typeFilter == 'akb')
		{
			$sql = "select DISTINCT akb.*
				FROM tx_akbspecifications as akb, tx_carmodels_akb as car
				WHERE
					akb.carmodel = car.id and car.id IN (
						SELECT id
						FROM tx_carmodels_akb
						WHERE
							vendor = '".$arParams["AUTO_MARK"]."'
							and model = '".$arParams["AUTO_MODEL"]."'
							and modification = '".$modification."' 
							and year = '".$arParams["AUTO_YEAR"]."' 
					)";
			$rsItems = $DB->Query( $sql, false, __LINE__ );
			while($arItem = $rsItems->fetch())
			{
				$arItem["polarity_lang"] = ($arItem["polarity"] == 1 ? Loc::getMessage("POLARITY1") : Loc::getMessage("POLARITY2"));
				$arItem["type_lang"] = ($arItem["type"] == 1 ? Loc::getMessage("TYPE1") : ($arItem["type"] == 2 ? Loc::getMessage("TYPE2") : Loc::getMessage("TYPE3")));

				$arResult["TYPE"][] = $arItem;
			}
		}
		
		if($cache_time > 0)
		{
			$cache->StartDataCache( $cache_time, $cache_id, $cache_path );
			$cache->EndDataCache( 
				array(
					"arResult" => $arResult,
				) 
			);
		}
	}
}

$arResult["TYPE_T"] = $typeFilter;

$this->IncludeComponentTemplate();?>