<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$frame = $this->createFrame()->begin();?>
<?
if(strlen($arResult["ERROR_MESSAGE"]) > 0)
{
	ShowError($arResult["ERROR_MESSAGE"]);
}
?>
<?if(count($arResult["STORES"]) > 0):?>
	<?
	// get shops
	$arShops = array();
	CModule::IncludeModule('iblock');
	$dbRes = CIBlock::GetList(array(), array('CODE' => 'aspro_tires2_shops', 'ACTIVE' => 'Y', 'SITE_ID' => SITE_ID));
	if($arShospIblock = $dbRes->Fetch())
	{
		$dbRes = CIBlockElement::GetList(array(), array('ACTIVE' => 'Y', 'IBLOCK_ID' => $arShospIblock['ID']), false, false, array('ID', 'DETAIL_PAGE_URL', 'PROPERTY_STORE_ID'));
		while($arShop = $dbRes->GetNext())
		{
			$arShops[$arShop['PROPERTY_STORE_ID_VALUE']] = $arShop;
		}
	}
	?>
	<div class="stores_block_wrap">
		<?$empty_count=0;
		$count_stores=count($arResult["STORES"]);?>
		<?foreach($arResult["STORES"] as $pid => $arProperty):
			$amount = (isset($arProperty['REAL_AMOUNT']) ? $arProperty['REAL_AMOUNT'] : $arProperty['AMOUNT']);
			if($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount <= 0)
				$empty_count++;?>
			<div class="stores_block <?=(isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"]) ? 'w_image' : 'wo_image')?>" <?=($arParams['SHOW_EMPTY_STORE'] == 'N' && $amount <= 0 ? 'style="display: none"' : '');?>>
				<?
				$totalCount = CTires2::CheckTypeCount($arProperty["NUM_AMOUNT"]);
				$arQuantityData = CTires2::GetQuantityArray($totalCount);
				?>
				<div class="quantity-wrapp-block cost prices pull-right">
					<?if(isset($arProperty["PHONE"])):?><span class="store_phone p10"><?=GetMessage('S_PHONE')?> <?=$arProperty["PHONE"]?></span><?endif;?>
					<?if(strlen($arQuantityData["TEXT"])):?>
						<?=$arQuantityData["HTML"]?>
					<?endif;?>
				</div>
				<div class="stores_text_wrapp <?=(isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"]) ? 'image_block' : '')?>">
					<?if (isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"])):?>
						<div class="imgs"><?=GetMessage('S_IMAGE')?> <?=CFile::ShowImage($arProperty["IMAGE_ID"], 100, 100, "border=0", "", true);?></div>
					<?endif;?>
					<div class="main_info">
						<?if (isset($arProperty["TITLE"])):?>
							<span>
								<a class="title_stores" href="<?=$arProperty["URL"]?>" data-storehref="<?=$arProperty["URL"]?>" data-iblockhref="<?=$arShops[$arProperty['ID']]['DETAIL_PAGE_URL']?>"> <?=$arProperty["TITLE"].(strlen($arProperty["ADDRESS"]) && strlen($arProperty["TITLE"]) ? ', ' : '').$arProperty["ADDRESS"]?></a>
							</span>
						<?endif;?>
					</div>
				</div>
				<div class="quantity-wrapp-block cost prices media">
					<?if(isset($arProperty["PHONE"])):?><span class="store_phone p10"><span><?=$arProperty["PHONE"]?></span></span><?endif;?>
				
					<?if(strlen($arQuantityData["TEXT"])):?>
						<?=$arQuantityData["HTML"]?>
					<?endif;?>
				</div>
			</div>
		<?endforeach;?>
		<?if($empty_count==$count_stores){?>
			<div class="stores_block">
				<div class="stores_text_wrapp"><?=GetMessage('NO_STORES')?></div>
			</div>
		<?}?>
	</div>
<?endif;?>