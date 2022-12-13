<?define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!\Bitrix\Main\Loader::includeModule("sale") || !\Bitrix\Main\Loader::includeModule("catalog") || !\Bitrix\Main\Loader::includeModule("iblock") || !\Bitrix\Main\Loader::includeModule("aspro.tires2"))
{
	echo "failure";
	return;
}

$context=\Bitrix\Main\Application::getInstance()->getContext();
$request=$context->getRequest();

$bStoreBuy = (\Bitrix\Main\Config\Option::get('aspro.tires2', 'STORE_TYPE_CATALOG_DETAIL', 'ext') == 'ext' && $request["store_id"]);
if($bStoreBuy)
{
	$arStore = \CCatalogStore::GetList(array(), array("ID" => $request["store_id"]), false, false, array("TITLE", "ADDRESS"))->Fetch();
	$storeTitle = $arStore["TITLE"];
	$storeTitle =($storeTitle ? $storeTitle.", ".$arStore["ADDRESS"] : $arStore["ADDRESS"]);
}

if(!empty($request["add_item"]))
{
	if($request["add_item"] == "Y")
	{
		$quantity = $request["quantity"];
		if($quantity)
			$quantity = floatval($request["quantity"]);

		$product_properties=$arSkuProp=array();
		$successfulAdd = true;
		$strErrorExt='';

		$arBasketItems = array();
		$dbBasketItems = CSaleBasket::GetList(
			array("NAME" => "ASC", "ID" => "ASC"),
			array("PRODUCT_ID" => $request["item"], "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
			false, false, array("ID", "DELAY")
		);

		while($arBasketItem = $dbBasketItems->Fetch())
		{
			$arBasketItems[$arBasketItem["ID"]] = $arBasketItem;
		}

		if($bStoreBuy)
		{
			$bFindItem = false;
			$rsItems = CSaleBasket::GetPropsList(
				array(
					"SORT" => "ASC",
					"NAME" => "ASC"
				),
				array("BASKET_ID" => array_keys($arBasketItems), "CODE" => "STORES")
			);
			while($arItem = $rsItems->Fetch())
			{
				if($storeTitle == $arItem["VALUE"] && $arBasketItems[$arItem["BASKET_ID"]])
				{
					$dbBasketItems = $arBasketItems[$arItem["BASKET_ID"]];
					$bFindItem = true;
				}
			}
			if(!$bFindItem)
				$dbBasketItems = array();
		}
		else
		{
			$dbBasketItems = reset($arBasketItems);
		}

		if(!empty($dbBasketItems) && $dbBasketItems["DELAY"] == "Y")
		{
			$arFields = array("DELAY" => "N", "SUBSCRIBE" => "N");
			if($quantity)
				$arFields['QUANTITY'] = $quantity;
			CSaleBasket::Update($dbBasketItems["ID"], $arFields);
		}
		else
		{
			$intProductIBlockID = (int)CIBlockElement::GetIBlockByID($request["item"]);
			if(0 < $intProductIBlockID)
			{
				if($request["add_props"]=="Y"){
					$arSkuProp=json_decode($request["props"]);
					if ($intProductIBlockID == $request["iblockID"])
					{
						if($request["props"])
						{
							$product_properties = CIBlockPriceTools::CheckProductProperties(
								$request["iblockID"],
								$request["item"],
								$arSkuProp,
								$request["prop"],
								$request['part_props'] == 'Y'
							);
							if (!is_array($product_properties))
							{
								$strError = "CATALOG_PARTIAL_BASKET_PROPERTIES_ERROR";
								$successfulAdd = false;
							}
						}else
						{
							$strError = "CATALOG_EMPTY_BASKET_PROPERTIES_ERROR";
							$successfulAdd  = false;
						}
					}
					else
					{
						$skuAddProps = (isset($request['basket_props']) && !empty($request['basket_props']) ? $request['basket_props'] : '');
						if ($arSkuProp || !empty($skuAddProps))
						{
							$product_properties = CIBlockPriceTools::GetOfferProperties(
								$request["item"],
								$request["iblockID"],
								$arSkuProp,
								$skuAddProps
							);
						}
					}
				}
			}else
			{
				$strError = 'CATALOG_ELEMENT_NOT_FOUND';
				$successfulAdd = false;
			}
			if($successfulAdd)
			{
				if($request["store_id"])
				{
					$product_properties["STORES"] = array(
						"NAME" => \Bitrix\Main\Localization\Loc::getMessage("T_STORE_NAME_BUY"),
						"CODE" => "STORES",
						"VALUE" => $request["store_id"],
						"SORT" => 0,
					);
				}
				if($request["prices_id"])
				{
					$product_properties["PRICES"] = array(
						"NAME" => "PRICES",
						"CODE" => "PRICES",
						"VALUE" => $request["prices_id"],
						"SORT" => 0,
					);
				}
				if(!Add2BasketByProductID($request["item"], $quantity, $arRewriteFields, $product_properties))
				{
					if ($ex = $APPLICATION->GetException())
						$strErrorExt = $ex->GetString();

					$strError = "ERROR_ADD2BASKET";
					$successfulAdd = false;
				}
			}
		}
		if ($successfulAdd)
			$addResult = array('STATUS' => 'OK', 'MESSAGE' => 'CATALOG_SUCCESSFUL_ADD_TO_BASKET', 'MESSAGE_EXT' => $strErrorExt);
		else
			$addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $strError, 'MESSAGE_EXT' => $strErrorExt);

		if(class_exists('\Bitrix\Main\Web\Json'))
		{
			if(method_exists('\Bitrix\Main\Web\Json', 'encode'))
				echo \Bitrix\Main\Web\Json::encode($addResult);
			else
				echo json_encode($addResult);
		}
		else
		{
			echo json_encode($addResult);
		}
		die();
	}
}
elseif(!empty($_REQUEST["subscribe_item"]))
{
	if($_REQUEST["subscribe_item"] == "Y")
	{
		if(class_exists('\Bitrix\Catalog\Product\SubscribeManager')){
			global $USER, $DB;
			$itemID = intval($_REQUEST['item']);

			$bSubscribeProducts = (isset($_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID']) && $_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID']);
			$userId = (($USER && is_object($USER) && $USER->isAuthorized()) ? $USER->getId() : false);
			if($itemID && ($bSubscribeProducts || $userId))
			{
				$subscribeManager = new \Bitrix\Catalog\Product\SubscribeManager;
				$arSubscribeList = CTires2::getUserSubscribeList($userId);
				if(!$arSubscribeList[$itemID])
				{
					$contactTypes = $subscribeManager->contactTypes;
					$contactTypeId = key($contactTypes);
					$userContact = $userId ? ($userContact = ($contactTypeId == ($defaultContactTypeId = \Bitrix\Catalog\SubscribeTable::CONTACT_TYPE_EMAIL)) ? $USER->getEmail() : false) : false;

					if($userContact)
					{
						$subscribeData = array(
							'USER_CONTACT' => $userContact,
							'ITEM_ID' => $itemID,
							'SITE_ID' => SITE_ID,
							'CONTACT_TYPE' => $contactTypeId,
							'USER_ID' => $userId,
						);

						$subscribeId = $subscribeManager->addSubscribe($subscribeData);
					}
				}
				else
				{
					if($bSubscribeProducts && !$userId)
					{
						$filter = array(
							'=SITE_ID' => SITE_ID,
							'ITEM_ID' => $itemID,
							'USER_CONTACT' => $_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID'][$itemID],
							array(
								'LOGIC' => 'OR',
								array('=DATE_TO' => false),
								array('>DATE_TO' => date($DB->dateFormatToPHP(\CLang::getDateFormat('FULL')), time()))
							),
						);

						$resultObject = \Bitrix\Catalog\SubscribeTable::getList(
							array(
								'select' => array(
									'ID',
									'ITEM_ID',
								),
								'filter' => $filter,
							)
						);
						if($arItem = $resultObject->Fetch())
						{
							\Bitrix\Catalog\SubscribeTable::delete($arItem['ID']);
							unset($_SESSION['SUBSCRIBE_PRODUCT']['LIST_PRODUCT_ID'][$itemID]);
						}
					}
					else
					{
						$subscribeManager->deleteManySubscriptions($arSubscribeList[$itemID], $itemID);
					}
				}
			}
			die();
		}
		else{
			$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC", "ID" => "ASC"),
				array("PRODUCT_ID" => $_REQUEST["item"], "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
				false, false, array("ID", "PRODUCT_ID", "SUBSCRIBE", "CAN_BUY")
			)->Fetch();
			if(!empty($dbBasketItems) && $dbBasketItems["SUBSCRIBE"] == "N")
			{
				$arFields = array("SUBSCRIBE" => "Y", "CAN_BUY" => "N", "DELAY" => "N");
				CSaleBasket::Update($dbBasketItems["ID"], $arFields);
			}
			elseif(!empty($dbBasketItems) && $dbBasketItems["SUBSCRIBE"] == "Y")
			{
				CSaleBasket::Delete($dbBasketItems["ID"]);
			}
			else
			{
				$arRewriteFields = array("SUBSCRIBE" => "Y", "CAN_BUY" => "N", "DELAY" => "N");
				Add2BasketByProductID(intVal($_REQUEST["item"]), 1, $arRewriteFields, array());
			}
		}
	}
}
elseif(!empty($_REQUEST["wish_item"]))
{
	if($_REQUEST["wish_item"] == "Y")
	{

		if($_REQUEST["quantity"])
			$_REQUEST["quantity"] = floatval($_REQUEST["quantity"]);

		$successfulAdd = true;
		$strErrorExt = '';
		$bDeletedItems = false;

		$arBasketItems = array();
		$dbBasketItems = CSaleBasket::GetList(
			array("NAME" => "ASC", "ID" => "ASC"),
			array("PRODUCT_ID" => $_REQUEST["item"], "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "CAN_BUY" => "Y", "SUBSCRIBE" => "N"),
			false, false, array("ID", "PRODUCT_ID", "DELAY")
		);
		while($arBasketItem = $dbBasketItems->Fetch())
		{
			$arBasketItems[$arBasketItem["ID"]] = $arBasketItem;
		}
		if($bStoreBuy)
		{
			$bFindItem = false;
			$rsItems = CSaleBasket::GetPropsList(
				array(
					"SORT" => "ASC",
					"NAME" => "ASC"
				),
				array("BASKET_ID" => array_keys($arBasketItems), "CODE" => "STORES")
			);
			while($arItem = $rsItems->Fetch())
			{
				if($storeTitle == $arItem["VALUE"] && $arBasketItems[$arItem["BASKET_ID"]])
				{
					$dbBasketItems = $arBasketItems[$arItem["BASKET_ID"]];
					$bFindItem = true;
				}
			}
			if(!$bFindItem)
				$dbBasketItems = array();
		}
		else
		{
			if(count($arBasketItems) > 1)
				$bDeletedItems = true;
			$dbBasketItems = reset($arBasketItems);
		}

		if(!empty($dbBasketItems) && $dbBasketItems["DELAY"] == "N")
		{
			$arFields = array("DELAY" => "Y", "SUBSCRIBE" => "N");
			if($_REQUEST["quantity"]){
				$arFields['QUANTITY'] = $_REQUEST["quantity"];
			}
			CSaleBasket::Update($dbBasketItems["ID"], $arFields);
		}
		elseif(!empty($dbBasketItems) && $dbBasketItems["DELAY"] == "Y" && !$bDeletedItems)
		{
			CSaleBasket::Delete($dbBasketItems["ID"]);
		}
		elseif($bDeletedItems)
		{
			foreach($arBasketItems as $arBasketItem)
			{
				if($arBasketItem["DELAY"] == "Y")
				{
					CSaleBasket::Delete($arBasketItem["ID"]);
				}
			}
		}
		else
		{
			if($_REQUEST["offers"] == "Y" && $_REQUEST["iblockID"])
			{
				$product_properties = $arSkuProp = array();
				$arSkuProp = json_decode($_REQUEST["props"]);
				if($arSkuProp){
					$product_properties = CIBlockPriceTools::GetOfferProperties($_REQUEST["item"], $_REQUEST["iblockID"], $arSkuProp, $skuAddProps);
				}
				if($request["store_id"])
				{
					$product_properties["STORES"] = array(
						"NAME" => \Bitrix\Main\Localization\Loc::getMessage("T_STORE_NAME_BUY"),
						"CODE" => "STORES",
						"VALUE" => $request["store_id"],
						"SORT" => 0,
					);
				}
				if($request["prices_id"])
				{
					$product_properties["PRICES"] = array(
						"NAME" => "PRICES",
						"CODE" => "PRICES",
						"VALUE" => $request["prices_id"],
						"SORT" => 0,
					);
				}
				$id = Add2BasketByProductID($_REQUEST["item"], $_REQUEST["quantity"], array(), $product_properties);
			}
			else
			{
				$product_properties = array();
				if($request["store_id"])
				{
					$product_properties["STORES"] = array(
						"NAME" => \Bitrix\Main\Localization\Loc::getMessage("T_STORE_NAME_BUY"),
						"CODE" => "STORES",
						"VALUE" => $request["store_id"],
						"SORT" => 0,
					);
				}
				if($request["prices_id"])
				{
					$product_properties["PRICES"] = array(
						"NAME" => "PRICES",
						"CODE" => "PRICES",
						"VALUE" => $request["prices_id"],
						"SORT" => 0,
					);
				}
				$id = Add2BasketByProductID($_REQUEST["item"], $_REQUEST["quantity"], array(), $product_properties);
			}
			if(!$id)
			{
				if ($ex = $APPLICATION->GetException())
					$strErrorExt = $ex->GetString();
				$successfulAdd=false;
				$strError = "ERROR_ADD2BASKET";
			}

			$arFields = array("DELAY" => "Y", "SUBSCRIBE" => "N");
			CSaleBasket::Update($id, $arFields);
		}

		if($successfulAdd)
			$addResult = array('STATUS' => 'OK', 'MESSAGE' => 'CATALOG_SUCCESSFUL_ADD_TO_BASKET', 'MESSAGE_EXT' => $strErrorExt);
		else
			$addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $strError, 'MESSAGE_EXT' => $strErrorExt);

		if(class_exists('\Bitrix\Main\Web\Json'))
		{
			if(method_exists('\Bitrix\Main\Web\Json', 'encode'))
				echo \Bitrix\Main\Web\Json::encode($addResult);
			else
				echo json_encode($addResult);
		}
		else
		{
			echo json_encode($addResult);
		}
		die();
	}
}
elseif(!empty($_REQUEST["compare_item"]))
{
	$iblock_id = $_REQUEST["iblock_id"];
	$iblock_id = 0;
	if(!empty($_SESSION["CATALOG_COMPARE_LIST"]) && !empty($_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]) && array_key_exists($_REQUEST["item"], $_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"]))
	{
		unset($_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"][$_REQUEST["item"]]);
	}
	else
	{
		$_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"][$_REQUEST["item"]] = CIBlockElement::GetByID($_REQUEST["item"])->Fetch();
	}
}
elseif(!empty($_REQUEST["delete_item"]))
{
	$dbBasketItems = CSaleBasket::GetList(
		array("NAME" => "ASC", "ID" => "ASC"),
		array("PRODUCT_ID" => $_REQUEST["item"], "FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
		false, false, array("ID", "DELAY")
	)->Fetch();
	if(!empty($dbBasketItems))
		CSaleBasket::Delete($dbBasketItems["ID"]);
}

if(\Bitrix\Main\Loader::includeModule('aspro.tires2'))
	CTires2::clearBasketCounters();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>