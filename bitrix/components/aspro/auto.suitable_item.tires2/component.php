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

if(!$typeFilter)
	$typeFilter = 'tires';

use \Bitrix\Main\Localization\Loc;
global $APPLICATION;
$arResult = array();

$siteID = SITE_ID;
if($request['SITE_ID'])
	$siteID = $request['SITE_ID'];

$arShowPobdor = array(
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_TIRES_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_tires"][0], $siteID),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_WHEELS_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_wheels"][0], $siteID),
	\Bitrix\Main\Config\Option::get("aspro.tires2", "CATALOG_AKB_IBLOCK_ID", CTires2Cache::$arIBlocks[SITE_ID]["aspro_tires2_catalog"]["aspro_tires2_catalog_accumulators"][0], $siteID),
);

if(!in_array($arParams["IBLOCK_ID"], $arShowPobdor))
{
	echo ShowError(Loc::getMessage("ONLY_AKB_TYRES_DISK"));
	return ;
}

$arParams["COMPONENT_NAME"] = $componentName;
$arParams["TEMPLATE"] = $componentTemplate;

if(!$arParams["CACHE_TIME"])
	$arParams["CACHE_TIME"] = 604800;
// $arParams["CACHE_TYPE"] = "N";

if($typeFilter =='tires')
{
	if(!$arParams["TYRE_WIDTH"] && !$arParams["TYRE_PROFILE"] && !$arParams["TYRE_DIAMETER"])
		$arResult["ERROR"] = Loc::getMessage("NO_PARAMS");
}
elseif($typeFilter =='wheels')
{
	if(!$arParams["DISK_WIDTH"] && !$arParams["DISK_PCD"]  && !$arParams["DISK_LZ"] && !$arParams["DISK_DIAMETER"])
		$arResult["ERROR"] = Loc::getMessage("NO_PARAMS");
}
elseif($typeFilter =='akb')
{
	if(!$arParams["CAPACITY"])
		$arResult["ERROR"] = Loc::getMessage("NO_PARAMS");
}

if(!$arResult["ERROR"])
{

	/*get cars vendor*/
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
				$arResult["CARS"][] = array("NAME" => $car["vendor"], "FORMAT_NAME" => crc32($car["vendor"]));

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
	/**/

	if($request->isPost() && $arParams["SHOW_ITEM"] == "Y") //show items
	{
		if($this->StartResultCache())
		{
			global $DB;

			$arResult["HAS_YEAR"] = "Y";

			if(!$arParams["AUTO_MARK"])
				$arResult["ERROR"] = Loc::getMessage("NO_PARAMS");

			if(!$arResult["ERROR"])
			{
				foreach($arResult["CARS"] as $arCar)
				{
					if($arCar["FORMAT_NAME"] == $arParams["AUTO_MARK"])
						$arParams["AUTO_MARK"] = $arCar["NAME"];
				}

				if($typeFilter =='tires')
				{
					if(!$arResult["ERROR"])
					{
						$arParams["TYRE_WIDTH"] = round($arParams["TYRE_WIDTH"], 1);
						$arParams["TYRE_PROFILE"] = round($arParams["TYRE_PROFILE"], 1);
						$arParams["TYRE_DIAMETER"] = round($arParams["TYRE_DIAMETER"], 1);

						$strsql = 'SELECT DISTINCT car.id, car.model, car.year, car.modification
								FROM tx_tyrespecifications as tyre, tx_carmodels as car
								WHERE tyre.carmodel = car.id and tyre.front_width='.$arParams["TYRE_WIDTH"].' and tyre.front_profile='.$arParams["TYRE_PROFILE"].' and tyre.front_diameter='.$arParams["TYRE_DIAMETER"].' and car.id IN ((SELECT id FROM tx_carmodels WHERE vendor = "'.$arParams["AUTO_MARK"].'")) ORDER BY car.year ASC';

						$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
						while($arItem = $rsItems->Fetch())
						{
							$arResult["ITEMS"][$arItem["model"]][$arItem["modification"]][] = $arItem["year"];
						}
					}
				}
				elseif($typeFilter =='wheels')
				{
					if(!$arResult["ERROR"])
					{
						$arParams["DISK_WIDTH"] = round($arParams["DISK_WIDTH"], 1);
						$arParams["DISK_PCD"] = round($arParams["DISK_PCD"], 1);
						$arParams["DISK_LZ"] = round($arParams["DISK_LZ"], 1);
						$arParams["DISK_DIAMETER"] = round($arParams["DISK_DIAMETER"], 1);

						$strsql = 'SELECT DISTINCT car.id, car.model, car.year, car.modification
							FROM tx_wheelspecifications as wheel, tx_carmodels as car
							WHERE wheel.carmodel = car.id and wheel.front_width='.$arParams["DISK_WIDTH"].' and car.pcd='.$arParams["DISK_PCD"].'  and car.lz='.$arParams["DISK_LZ"].' and wheel.front_diameter='.$arParams["DISK_DIAMETER"].' and car.id IN ((SELECT id FROM tx_carmodels WHERE vendor = "'.$arParams["AUTO_MARK"].'")) ORDER BY car.year ASC';

						$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
						while($arItem = $rsItems->Fetch())
						{
							$arResult["ITEMS"][$arItem["model"]][$arItem["modification"]][] = $arItem["year"];
						}
					}
				}
				elseif($typeFilter =='akb')
				{
					if(!$arResult["ERROR"])
					{
						$strsql = 'SELECT DISTINCT car.id, car.model, car.year, car.modification
							FROM tx_akbspecifications as akb, tx_carmodels_akb as car
							WHERE akb.carmodel = car.id and (akb.capacity_from <='.$arParams["CAPACITY"].' and akb.capacity_to IN ((SELECT capacity_to FROM tx_akbspecifications WHERE capacity_to >='.$arParams["CAPACITY"].')))';
						if($arParams["AMPERAGE"])
							$strsql .= ' and (akb.amperage_from <='.$arParams["AMPERAGE"].' and akb.amperage_to IN ((SELECT amperage_to FROM tx_akbspecifications WHERE amperage_to >='.$arParams["AMPERAGE"].')))';
						if($arParams["AKB_WIDTH"])
							$strsql .= ' and (akb.width_from <='.$arParams["AKB_WIDTH"].' and akb.width_to IN ((SELECT width_to FROM tx_akbspecifications WHERE width_to >='.$arParams["AKB_WIDTH"].')))';
						if($arParams["AKB_LENGTH"])
							$strsql .= ' and (akb.len_from <='.$arParams["AKB_LENGTH"].' and akb.len_to IN ((SELECT len_to FROM tx_akbspecifications WHERE len_to >='.$arParams["AKB_LENGTH"].')))';
						if($arParams["AKB_HEIGHT"])
							$strsql .= ' and (akb.height_from <='.$arParams["AKB_HEIGHT"].' and akb.height_to IN ((SELECT height_to FROM tx_akbspecifications WHERE height_to >='.$arParams["AKB_HEIGHT"].')))';
						if($arParams["POLARITY"])
							$strsql .= ' and akb.polarity ='.$arParams["POLARITY"];
						if($arParams["TYPE"])
							$strsql .= ' and akb.type ='.$arParams["TYPE"];
						$strsql .= ' and car.id IN ((SELECT id FROM tx_carmodels_akb where vendor = "'.$arParams["AUTO_MARK"].'")) ORDER BY car.year ASC';

						$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
						while($arItem = $rsItems->Fetch())
						{
							$arResult["ITEMS"][$arItem["model"]][$arItem["modification"]][] = $arItem["year"];
						}
					}
				}
			}
			if(!$arResult["ITEMS"] || $arResult["ERROR"])
				$this->AbortResultCache();

			$this->IncludeComponentTemplate('item');
		}
	}
	else
	{
		if($arResult["CARS"])
		{
			if($this->StartResultCache())
			{
				$arCars = array();

				foreach($arResult["CARS"] as $arCar)
					$arCars[] = '"'.$arCar["NAME"].'"';
				unset($arResult["CARS"]);
				global $DB;
				if($typeFilter =='tires')
				{
					$arParams["TYRE_WIDTH"] = round($arParams["TYRE_WIDTH"], 1);
					$arParams["TYRE_PROFILE"] = round($arParams["TYRE_PROFILE"], 1);
					$arParams["TYRE_DIAMETER"] = round($arParams["TYRE_DIAMETER"], 1);

					$strsql = 'SELECT DISTINCT car.vendor
						FROM tx_tyrespecifications as tyre, tx_carmodels as car
						WHERE tyre.carmodel = car.id and tyre.front_width='.$arParams["TYRE_WIDTH"].' and tyre.front_profile='.$arParams["TYRE_PROFILE"].' and tyre.front_diameter='.$arParams["TYRE_DIAMETER"].' and car.id IN ((SELECT id FROM tx_carmodels WHERE vendor IN ('.implode(",", $arCars).'))) GROUP BY car.vendor ORDER BY car.vendor ASC';
					$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
					while($arItem = $rsItems->Fetch())
					{
						$arResult["CARS"][] = array("NAME" => $arItem["vendor"], "FORMAT_NAME" => crc32($arItem["vendor"]));
					}
				}
				elseif($typeFilter =='wheels')
				{
					$arParams["DISK_WIDTH"] = round($arParams["DISK_WIDTH"], 1);
					$arParams["DISK_PCD"] = round($arParams["DISK_PCD"], 1);
					$arParams["DISK_LZ"] = round($arParams["DISK_LZ"], 1);
					$arParams["DISK_DIAMETER"] = round($arParams["DISK_DIAMETER"], 1);

					$strsql = 'SELECT DISTINCT car.vendor
						FROM tx_wheelspecifications as wheel, tx_carmodels as car
						WHERE wheel.carmodel = car.id and wheel.front_width='.$arParams["DISK_WIDTH"].' and car.pcd='.$arParams["DISK_PCD"].'  and car.lz='.$arParams["DISK_LZ"].' and wheel.front_diameter='.$arParams["DISK_DIAMETER"].' and car.id IN ((SELECT id FROM tx_carmodels WHERE vendor IN ('.implode(",", $arCars).'))) GROUP BY car.vendor ORDER BY car.vendor ASC';

					$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
					while($arItem = $rsItems->Fetch())
					{
						$arResult["CARS"][] = array("NAME" => $arItem["vendor"], "FORMAT_NAME" => crc32($arItem["vendor"]));
					}

				}
				elseif($typeFilter =='akb')
				{
					$strsql = 'SELECT DISTINCT car.vendor, akb.*
						FROM tx_akbspecifications as akb, tx_carmodels_akb as car
						WHERE akb.carmodel = car.id and (akb.capacity_from <='.$arParams["CAPACITY"].' and akb.capacity_to IN ((SELECT capacity_to FROM tx_akbspecifications WHERE capacity_to >='.$arParams["CAPACITY"].')))';
					if($arParams["AMPERAGE"])
						$strsql .= ' and (akb.amperage_from <='.$arParams["AMPERAGE"].' and akb.amperage_to IN ((SELECT amperage_to FROM tx_akbspecifications WHERE amperage_to >='.$arParams["AMPERAGE"].')))';
					if($arParams["AKB_WIDTH"])
						$strsql .= ' and (akb.width_from <='.$arParams["AKB_WIDTH"].' and akb.width_to IN ((SELECT width_to FROM tx_akbspecifications WHERE width_to >='.$arParams["AKB_WIDTH"].')))';
					if($arParams["AKB_LENGTH"])
						$strsql .= ' and (akb.len_from <='.$arParams["AKB_LENGTH"].' and akb.len_to IN ((SELECT len_to FROM tx_akbspecifications WHERE len_to >='.$arParams["AKB_LENGTH"].')))';
					if($arParams["AKB_HEIGHT"])
						$strsql .= ' and (akb.height_from <='.$arParams["AKB_HEIGHT"].' and akb.height_to IN ((SELECT height_to FROM tx_akbspecifications WHERE height_to >='.$arParams["AKB_HEIGHT"].')))';
					if($arParams["POLARITY"])
						$strsql .= ' and akb.polarity ='.$arParams["POLARITY"];
					if($arParams["TYPE"])
						$strsql .= ' and akb.type ='.$arParams["TYPE"];
					$strsql .= ' and car.id IN ((SELECT id FROM tx_carmodels_akb WHERE vendor IN ('.implode(",", $arCars).'))) GROUP BY car.vendor ORDER BY car.vendor ASC';

					$rsItems = $DB->Query($strsql, false, $err_mess.__LINE__);
					while($arItem = $rsItems->Fetch())
					{
						$arResult["CARS"][] = array("NAME" => $arItem["vendor"], "FORMAT_NAME" => crc32($arItem["vendor"]));
					}
				}

				if(!$arResult["CARS"])
					$this->AbortResultCache();
				else
					$this->IncludeComponentTemplate();
			}
		}

		if(!$arResult["CARS"])
		{
			$this->AbortResultCache();
			$this->IncludeComponentTemplate();
		}

		return $arResult["CARS"];
	}
}
else
{
	$this->IncludeComponentTemplate();
}

?>