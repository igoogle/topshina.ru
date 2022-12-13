<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$bAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && strpos($_SERVER['SCRIPT_NAME'], 'ajax/car_list.php') !== false);?>
<?
use \Bitrix\Main\Localization\Loc;

$arParams["VYLET_DISKA_TYPE"] = ((isset($arParams["VYLET_DISKA_TYPE"]) && strlen($arParams["VYLET_DISKA_RANGE_MIN"])) ? $arParams["VYLET_DISKA_TYPE"] : "RANGE");
$arParams["DIAMETR_STUPITSY_TYPE"] = ((isset($arParams["DIAMETR_STUPITSY_TYPE"]) && strlen($arParams["VYLET_DISKA_RANGE_MIN"])) ? $arParams["DIAMETR_STUPITSY_TYPE"] : "RANGE");
if($arParams["VYLET_DISKA_TYPE"] == "RANGE"){
	$arParams["VYLET_DISKA_RANGE_MIN"] = ((isset($arParams["VYLET_DISKA_RANGE_MIN"]) && strlen($arParams["VYLET_DISKA_RANGE_MIN"])) ? abs($arParams["VYLET_DISKA_RANGE_MIN"]) : 3);
	$arParams["VYLET_DISKA_RANGE_MAX"] = ((isset($arParams["VYLET_DISKA_RANGE_MAX"]) && strlen($arParams["VYLET_DISKA_RANGE_MAX"])) ? abs($arParams["VYLET_DISKA_RANGE_MAX"]) : 3);
}
else{
	$arParams["VYLET_DISKA_RANGE_MIN"] = 0;
	$arParams["VYLET_DISKA_RANGE_MAX"] = 0;
}
if($arParams["DIAMETR_STUPITSY_TYPE"] == "RANGE"){
	$arParams["DIAMETR_STUPITSY_RANGE_MIN"] = ((isset($arParams["DIAMETR_STUPITSY_RANGE_MIN"]) && strlen($arParams["DIAMETR_STUPITSY_RANGE_MIN"])) ? abs($arParams["DIAMETR_STUPITSY_RANGE_MIN"]) : 0);
	$arParams["DIAMETR_STUPITSY_RANGE_MAX"] = ((isset($arParams["DIAMETR_STUPITSY_RANGE_MAX"]) && strlen($arParams["DIAMETR_STUPITSY_RANGE_MAX"])) ? abs($arParams["DIAMETR_STUPITSY_RANGE_MAX"]) : 1000);
}
else{
	$arParams["DIAMETR_STUPITSY_RANGE_MIN"] = 0;
	$arParams["DIAMETR_STUPITSY_RANGE_MAX"] = 0;
}
?>
<?if(!$bAjax):?>
	<div class="car_list_wrap <?=$arParams["TYPE_FILTER"];?>">
<?endif;?>
<input type="hidden" name="type_filter" value="<?=$arParams["TYPE_FILTER"];?>">
<div class="filter-b selects">
	<div class="rows cars-list-mark">
		<label><?=GetMessage("AUTO_LIST_MANUFACTURER")?></label>
		<div class="select">
			<select name="car" class="cars-list car">
				<option value="" <?=!empty( $arParams["AUTO_MARK"] ) ? '' : 'selected="selected"'?>>&mdash;</option>
				<?if($arResult["CARS"]):?>
					<?foreach( $arResult["CARS"] as $car ){?>
						<option value="<?=crc32($car["NAME"])?>" <?=$arParams["AUTO_MARK"] == $car["NAME"] ? 'selected="selected"' : ''?>><?=$car["NAME"]?></option>
					<?}?>
				<?endif;?>
			</select>
		</div>
	</div>
	<div class="rows">
		<label><?=GetMessage("AUTO_LIST_MODEL")?></label>
		<div class="select">
			<select name="model" class="cars-list model">
				<option value="" <?=!empty( $arParams["AUTO_MODEL"] ) ? '' : 'selected="selected"'?>>&mdash;</option>
				<?if($arResult["MODEL"]):?>
					<?foreach( $arResult["MODEL"] as $model ){?>
						<option value="<?=crc32($model["NAME"])?>" <?=$arParams["AUTO_MODEL"] == $model["NAME"] ? 'selected="selected"' : ''?>><?=$model["NAME"]?></option>
					<?}?>
				<?endif;?>
			</select>
		</div>
	</div>
	<div class="rows">
		<label><?=GetMessage("AUTO_LIST_YEAR")?></label>
		<div class="select">
			<select name="year" class="cars-list year">
				<option value="" <?=!empty( $arParams["AUTO_YEAR"] ) ? '' : 'selected="selected"'?>>&mdash;</option>
				<?if($arResult["YEAR"]):?>
					<?foreach( $arResult["YEAR"] as $year ){?>
						<option value="<?=crc32($year["NAME"])?>" <?=$arParams["AUTO_YEAR"] == $year["NAME"] ? 'selected="selected"' : ''?>><?=$year["NAME"]?></option>
					<?}?>
				<?endif;?>
			</select>
		</div>
	</div>
	<div class="rows">
		<label><?=GetMessage("AUTO_LIST_EQUIPMENT")?></label>
		<div class="select">
			<select name="modification" class="cars-list modification">
				<option value="" <?=!empty( $arParams["AUTO_COMPLECT"] ) ? '' : 'selected="selected"'?>>&mdash;</option>
				<?if($arResult["MODIFICATION"]):?>
					<?foreach( $arResult["MODIFICATION"] as $modification ){?>
						<option data-value="<?=crc32($modification["NAME"]);?>" value="<?=crc32($modification["NAME"])?>" <?=$arParams["AUTO_COMPLECT"] == $modification["FORMAT_NAME"] ? 'selected="selected"' : ''?>><?=$modification["NAME"]?></option>
					<?}?>
				<?endif;?>
			</select>
		</div>
	</div>
</div>
<?if(!empty($arResult["TYPE"])):?>
	<div class="filter_result">
		<?if($arResult["TYPE_T"] == 'tires'):?>
			<div class="title_items"><?=Loc::getMessage('TITLE_TIRES');?></div>
			<div class="items row">
				<?foreach($arResult["TYPE"] as $name => $arType):?>
					<?if(!empty($arType)):?>
						<div class="filter-b inb item col-md-6 col-sm-6">
							<div class="block-title"><?if( $name == "DEFAULT" ){ echo GetMessage("AUTO_LIST_RECOMENDED_SIZES"); }elseif( $name == 'ALTERNATIVE' ){ echo GetMessage("AUTO_LIST_ALLOWABLE_SIZES"); }elseif( $name == 'TUNING' ){ echo GetMessage("AUTO_LIST_ALLOWABLE_SIZES"); }elseif( $name == 'TUNING' ){ echo GetMessage("AUTO_LIST_TUNING"); }?></div>
							<?if( !empty( $arType["FRONT"] ) && !empty( $arType["BACK"] ) ){?>
								<div class="block-title"><?=GetMessage("AUTO_LIST_FRONT")?></div>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["FRONT"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-h="<?=crc32($arData["HEIGHT"])?>" data-d="<?=crc32($arData["DIAM"])?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
											</div>
										<?}?>
									</div>
								</div>
								
								<div class="block-title"><?=GetMessage("AUTO_LIST_REAR")?></div>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["BACK"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-h="<?=crc32($arData["HEIGHT"])?>" data-d="<?=crc32($arData["DIAM"])?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
											</div>
										<?}?>
									</div>
								</div>
							<?}elseif( !empty( $arType["FRONT"] ) ){?>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["FRONT"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-h="<?=crc32($arData["HEIGHT"])?>" data-d="<?=crc32($arData["DIAM"])?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
											</div>
										<?}?>
									</div>
								</div>
							<?}?>
						</div>
					<?endif;?>
				<?endforeach;?>
			</div>
		<?elseif($arResult["TYPE_T"] == 'wheels'):?>
			<div class="title_items"><?=Loc::getMessage('TITLE_WHEELS');?></div>
			<div class="items row">
				<?foreach($arResult["TYPE"] as $name => $arType):?>
					<?if(!empty($arType)):?>
						<div class="filter-b inb item col-md-6 col-sm-6">
							<div class="block-title"><?if( $name == "DEFAULT" ){ echo GetMessage("AUTO_LIST_RECOMENDED_SIZES"); }elseif( $name == 'ALTERNATIVE' ){ echo GetMessage("AUTO_LIST_ALLOWABLE_SIZES"); }elseif( $name == 'TUNING' ){ echo GetMessage("AUTO_LIST_TUNING"); }?></div>
							<?if( !empty( $arType["FRONT"] ) && !empty( $arType["BACK"] ) ){?>
								<div class="block-title"><?=GetMessage("AUTO_LIST_FRONT")?></div>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["FRONT"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-d="<?=crc32($arData["DIAM"])?>" data-lz="<?=crc32($arData["LZ"])?>" data-pcd="<?=crc32($arData["PCD"])?>" <?=($arData["ET"] ? "data-et='".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "")."'" : "")?> <?=($arData["DIA"] ? "data-dia='".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "")."'" : "")?> class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>&times;<?=$arData["DIAM"]?> <?=$arData["LZ"]?>&times;<?=$arData["PCD"]?> <?=($arData["ET"] ? "ET ".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "") : "")?> <?=($arData["DIA"] ? "DIA ".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "") : "")?></span></label>
											</div>
										<?}?>
									</div>
								</div>
								<div class="block-title"><?=GetMessage("AUTO_LIST_REAR")?></div>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["BACK"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-d="<?=crc32($arData["DIAM"])?>" data-lz="<?=crc32($arData["LZ"])?>" data-pcd="<?=crc32($arData["PCD"])?>" <?=($arData["ET"] ? "data-et='".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "")."'" : "")?> <?=($arData["DIA"] ? "data-dia='".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "")."'" : "")?> class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>&times;<?=$arData["DIAM"]?> <?=$arData["LZ"]?>&times;<?=$arData["PCD"]?> <?=($arData["ET"] ? "ET ".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "") : "")?> <?=($arData["DIA"] ? "DIA ".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "") : "")?></span></label>
											</div>
										<?}?>
									</div>
								</div>
							<?}elseif( !empty( $arType["FRONT"] ) ){?>
								<div class="bx_filter_block limited_block">
									<div class="bx_filter_parameters_box_container">
										<?foreach( $arType["FRONT"] as $arData ){?>
											<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
												<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-d="<?=crc32($arData["DIAM"])?>" data-lz="<?=crc32($arData["LZ"])?>" data-pcd="<?=crc32($arData["PCD"])?>" <?=($arData["ET"] ? "data-et='".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "")."'" : "")?> <?=($arData["DIA"] ? "data-dia='".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "")."'" : "")?> class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
												<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>&times;<?=$arData["DIAM"]?> <?=$arData["LZ"]?>&times;<?=$arData["PCD"]?> <?=($arData["ET"] ? "ET ".number_format($arData["ET"], (strlen(intval($arData["ET"])) === strlen($arData["ET"]) ? 0 : 1), ".", "") : "")?> <?=($arData["DIA"] ? "DIA ".number_format($arData["DIA"], (strlen(intval($arData["DIA"])) === strlen($arData["DIA"]) ? 0 : 1), ".", "") : "")?></span></label>
											</div>
										<?}?>
									</div>
								</div>
							<?}?>
						</div>
					<?endif;?>
				<?endforeach;?>
			</div>
		<?elseif($arResult["TYPE_T"] == 'akb'):?>		
			<div class="filter-b inb">
				<div class="block-title"><?=GetMessage("AUTO_LIST_RECOMENDED_SIZES");?></div>
				<div class="bx_filter_block limited_block">
					<div class="bx_filter_parameters_box_container">
						<?foreach($arResult["TYPE"] as $name => $arData):?>
							<?if(!empty($arData)):?>
								<?$value = $arData["len_from"].$arData["len_to"].$arData["width_from"].$arData["width_to"].$arData["height_from"].$arData["height_to"].$arData["polarity"].$arData["type"].$arData["capacity_from"].$arData["capacity_to"].$arData["amperage_from"].$arData["amperage_to"].$name;?>
								<div class="filter label_block radio <?=$arResult["TYPE_T"];?>">
									<input name="akb_type" id="TYPE_<?=$value?>" data-alen_from="<?=$arData["len_from"]?>" data-alen_to="<?=$arData["len_to"]?>" data-awidth_from="<?=$arData["width_from"]?>" data-awidth_to="<?=$arData["width_to"]?>" data-aheight_from="<?=$arData["height_from"]?>" data-aheight_to="<?=$arData["height_to"]?>" data-acapacity_from="<?=$arData["capacity_from"]?>" data-acapacity_to="<?=$arData["capacity_to"]?>" data-avolume_from="<?=$arData["amperage_from"]?>" data-avolume_to="<?=$arData["amperage_to"]?>" data-apolarity="<?=crc32($arData["polarity_lang"])?>" data-atype="<?=crc32($arData["type_lang"])?>" <?=isset( $_REQUEST["akb_type"] ) && $value == $_REQUEST["akb_type"] ? 'checked="checked"' : ''?> class="cars-list" type="radio" value="<?=$value?>" />
									<label for="TYPE_<?=$value?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["len_from"]?>-<?=$arData["len_to"]?>&times;<?=$arData["width_from"]?>-<?=$arData["width_to"]?>&times;<?=$arData["height_from"]?>-<?=$arData["height_to"]?>/<?=$arData["polarity_lang"]?>/<?=$arData["type_lang"]?>/<?=$arData["capacity_from"]?>-<?=$arData["capacity_to"]?> <?=GetMessage("CAPACITY_MEASURE");?>/<?=$arData["amperage_from"]?>-<?=$arData["amperage_to"]?> <?=GetMessage("AMPERAGE_MEASURE");?></span></label>
								</div>
							<?endif;?>
						<?endforeach;?>
					</div>
				</div>
			</div>
		<?endif;?>
	</div>
<?endif;?>
<?if(!$bAjax):?>
	</div>
<?endif;?>

<script>
	var obConfigTyreIndex = {
		et_type: "<?=$arParams["VYLET_DISKA_TYPE"]?>",
		et_range0: "<?=$arParams["VYLET_DISKA_RANGE_MIN"]?>",
		et_range1: "<?=$arParams["VYLET_DISKA_RANGE_MAX"]?>",
		dia_type: "<?=$arParams["DIAMETR_STUPITSY_TYPE"]?>",
		dia_range0: "<?=$arParams["DIAMETR_STUPITSY_RANGE_MIN"]?>",
		dia_range1: "<?=$arParams["DIAMETR_STUPITSY_RANGE_MAX"]?>",
	}
</script>