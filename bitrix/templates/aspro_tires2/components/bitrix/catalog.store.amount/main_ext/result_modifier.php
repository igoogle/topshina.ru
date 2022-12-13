<?$arParams = $APPLICATION->ConvertCharsetArray($arParams, 'UTF-8', LANG_CHARSET);?><?use \Bitrix\Main\Type\Collection;if(!isset($arProperty["NUM_AMOUNT"])){	$arSelect=array("ID", "PRODUCT_AMOUNT", 'ADDRESS', 'SORT', 'TITLE', "UF_ITEM_TYPE");	if($arParams["SHOW_GENERAL_STORE_INFORMATION"] != "Y")	{		foreach($arResult["STORES"] as $pid => $arProperty)		{			$arStore = CCatalogStore::GetList(array('TITLE' => 'ASC', 'ID' => 'ASC'), array("ACTIVE" => "Y", "PRODUCT_ID" => $arParams["ELEMENT_ID"], "ID" => $arProperty["ID"]), false, false, $arSelect)->Fetch();			$arResult["STORES"][$pid]["NUM_AMOUNT"] = $arStore["PRODUCT_AMOUNT"];			$arResult["STORES"][$pid]["ADDRESS"] = $arStore["ADDRESS"];			$arResult["STORES"][$pid]["SORT"] = $arStore["SORT"];			$arResult["STORES"][$pid]["TITLE"] = $arStore["TITLE"];		}	}	else	{		$filter = array( "ACTIVE" => "Y", "PRODUCT_ID" => $arParams["ELEMENT_ID"], "+SITE_ID" => SITE_ID, "ISSUING_CENTER" => 'Y' );		$rsProps = CCatalogStore::GetList( array('TITLE' => 'ASC', 'ID' => 'ASC'), $filter, false, false, $arSelect );		while ($prop = $rsProps->GetNext())		{			$amount = (is_null($prop["PRODUCT_AMOUNT"])) ? 0 : $prop["PRODUCT_AMOUNT"];			$quantity += $amount;			$arResult["STORES"][$prop['ID']]["ADDRESS"] = $prop["ADDRESS"];			$arResult["STORES"][$prop['ID']]["SORT"] = $prop["SORT"];			$arResult["STORES"][$prop['ID']]["TITLE"] = $prop["TITLE"];		}		unset($arResult["STORES"]);		$arResult["STORES"][0]["NUM_AMOUNT"] =$arResult["STORES"][0]["AMOUNT"] = $quantity;	}	$order = ($arParams["STORES_FILTER_ORDER"] == "SORT_ASC" ? SORT_ASC : SORT_DESC);	if ($arParams["STORES_FILTER"] == 'AMOUNT') {		$arParams["STORES_FILTER"] = 'NUM_AMOUNT';	}	if ($arParams["STORES_FILTER"] == "TITLE") {		Collection::sortByColumn($arResult["STORES"], array($arParams["STORES_FILTER"] => $order));	} else {		Collection::sortByColumn($arResult["STORES"], array($arParams["STORES_FILTER"] => array(SORT_NUMERIC, $order), 'TITLE' => $order));	}}if($arResult["STORES"]){	global $arRegion, $arRegions;	if(!$arRegions)		$arRegions = CTires2Regionality::getRegions(true);	if(!$arRegion)		$arRegion = CTires2Regionality::getCurrentRegion();	$arResult["REGIONS"] = $arRegions;	$arResult["REGION"] = $arRegion;	$arEnums = $arTmpStores = array();	$arProp = CUserTypeEntity::GetList(array($by=>$order), array("ENTITY_ID" => "CAT_STORE", "FIELD_NAME" => "UF_ITEM_TYPE"))->Fetch();	$bHasFilterProp = ($arProp && $arProp["USER_TYPE_ID"] == "enumeration");	if($bHasFilterProp && $arParams["STORES_FILTER_PARAM"])	{		$rsPropEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => $arProp["ID"]));		while($arEnum = $rsPropEnum->Fetch())		{			if(in_array($arEnum["XML_ID"], $arParams["STORES_FILTER_PARAM"]))				$arEnums[$arEnum["ID"]] = $arEnum["ID"];		}	}	foreach($arResult["STORES"] as $arStore)	{		if($arEnums)		{			$arUFProps = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("CAT_STORE",$arStore['ID']);			foreach($arUFProps as $key => $arUF)			{				if($key == "UF_ITEM_TYPE")				{					if(array_intersect($arUF["VALUE"], $arEnums))						$arTmpStores[$arStore["ID"]] = $arStore;				}			}		}		else			$arTmpStores[$arStore["ID"]] = $arStore;	}	unset($arResult["STORES"]);	if($arResult["REGIONS"])	{		if($arParams["SHOW_REGION_STORES"] == "Y")		{			$arResult["STORES"][$arRegion["ID"]]["TITLE"] = $arRegion["NAME"];			if($arRegion["LIST_STORES"][0] == "component")			{				if($arParams["STORES_PARAMS"])				{					foreach($arParams["STORES_PARAMS"] as $id)					{						if($arTmpStores[$id])							$arResult["STORES"][$arRegion["ID"]]["ITEMS"][$id] = $arTmpStores[$id];					}				}			}			else			{				foreach($arRegion["LIST_STORES"] as $id)				{					if($arTmpStores[$id])						$arResult["STORES"][$arRegion["ID"]]["ITEMS"][$id] = $arTmpStores[$id];				}			}		}		else		{			foreach($arResult["REGIONS"] as $arTmpRegion)			{				if($arTmpRegion["LIST_STORES"])				{					$arResult["STORES"][$arTmpRegion["ID"]]["TITLE"] = $arTmpRegion["NAME"];					if($arTmpRegion["LIST_STORES"][0] == "component")					{						if($arParams["STORES_PARAMS"])						{							foreach($arParams["STORES_PARAMS"] as $id)							{								if($arTmpStores[$id])									$arResult["STORES"][$arTmpRegion["ID"]]["ITEMS"][$id] = $arTmpStores[$id];							}						}					}					else					{						foreach($arTmpRegion["LIST_STORES"] as $id)						{							if($arTmpStores[$id])								$arResult["STORES"][$arTmpRegion["ID"]]["ITEMS"][$id] = $arTmpStores[$id];						}					}					if($arTmpRegion['LIST_PRICES'])					{						if(reset($arTmpRegion['LIST_PRICES']) != 'component')							$arResult["STORES"][$arTmpRegion["ID"]]['PRICE_CODE'] = array_keys($arTmpRegion['LIST_PRICES']);						else							$arResult["STORES"][$arTmpRegion["ID"]]['PRICE_CODE'] = $arParams['STORES_PARAMS_PRICE'];					}				}			}		}		$bHasAmount = false;		if($arResult["STORES"])		{			$bShowEmpty = ($arParams['SHOW_EMPTY_STORE'] == 'Y');			foreach ($arResult["STORES"] as $key => $arStores) {				if (!$arStores["ITEMS"]) {					unset($arResult["STORES"][$key]);				} else {					if ($arParams["STORES_FILTER"] == "TITLE") {						Collection::sortByColumn($arResult["STORES"][$key]["ITEMS"], array($arParams["STORES_FILTER"] => $order));					} else {						Collection::sortByColumn($arResult["STORES"][$key]["ITEMS"], array($arParams["STORES_FILTER"] => array(SORT_NUMERIC, $order), 'TITLE' => $order));					}				}			}			$arTmpRegionStores = [];			foreach ($arResult["STORES"] as $key => $arStores) {				foreach ($arStores["ITEMS"] as $key2 => $arStore) {					if ($arStore['NUM_AMOUNT']) {						$bHasAmount = true;						$arResult["STORES"][$key]["ACTIVE_STORE"] = $key2;						break;					}				}			}			foreach ($arResult["STORES"] as $key => $arStores) {				if ($arResult["REGION"] && $key == $arResult["REGION"]["ID"]) {					unset($arResult["STORES"][$key]);					$arTmpRegionStores[$key] = $arStores;				}			}			if ($arTmpRegionStores) {				$arTmpRegionStores += $arResult["STORES"];				$arResult["STORES"] = $arTmpRegionStores;				unset($arTmpRegionStores);			}		}		$arResult['HAS_AMOUNT_STORE'] = $bHasAmount;	}	else	{		if ($arTmpStores) {			if ($arParams["STORES_FILTER"] == "TITLE") {				Collection::sortByColumn($arResult["STORES"][$key]["ITEMS"], array($arParams["STORES_FILTER"] => $order));			} else {				Collection::sortByColumn($arResult["STORES"][$key]["ITEMS"], array($arParams["STORES_FILTER"] => array(SORT_NUMERIC, $order), 'TITLE' => $order));			}		}		$arResult["STORES"][$arTmpRegion["ID"]]["TITLE"] = "";		$arResult["STORES"][$arTmpRegion["ID"]]["ITEMS"] = $arTmpStores;	}	unset($arTmpStores);}?>