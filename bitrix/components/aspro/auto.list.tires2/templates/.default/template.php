<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$bAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && strpos($_SERVER['SCRIPT_NAME'], 'ajax/car_list.php') !== false);?>
<?use \Bitrix\Main\Localization\Loc;?>
<?if(!$bAjax):?>
	<div id="car_list_wrap">
<?endif;?>
<input type="hidden" name="type_filter" value="<?=$arParams["TYPE_FILTER"];?>">
<div class="filter-b selects">
	<div class="rows cars-list-mark">
		<label><?=Loc::getMessage("AUTO_LIST_MARKA");?></label>
		<select name="car" class="cars-list" id="CAR">
			<option value="" <?=!empty( $arParams["AUTO_MARK"] ) ? '' : 'selected="selected"'?>>-</option>
			<?foreach($arResult["CARS"] as $car):?>
				<option value="<?=$car["NAME"]?>" <?=$arParams["AUTO_MARK"] == $car["NAME"] ? 'selected="selected"' : ''?>><?=$car["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="rows cars-list-mod">
		<label><?=Loc::getMessage("AUTO_LIST_MODEL");?></label>
		<select name="model" class="cars-list" id="MODEL">
			<option value="" <?=!empty( $arParams["AUTO_MODEL"] ) ? '' : 'selected="selected"'?>>-</option>
			<?foreach($arResult["MODEL"] as $model):?>
				<option value="<?=$model["NAME"]?>" <?=$arParams["AUTO_MODEL"] == $model["NAME"] ? 'selected="selected"' : ''?>><?=$model["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="rows">
		<label><?=Loc::getMessage("AUTO_LIST_YEAR");?></label>
		<select name="year" class="cars-list" id="YEAR">
			<option value="" <?=!empty($arParams["AUTO_YEAR"]) ? '' : 'selected="selected"'?>>-</option>
			<?foreach($arResult["YEAR"] as $year):?>
				<option value="<?=$year["NAME"]?>" <?=$arParams["AUTO_YEAR"] == $year["NAME"] ? 'selected="selected"' : ''?>><?=$year["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
	<div class="rows">
		<label><?=Loc::getMessage("AUTO_LIST_COMPL");?></label>
		<select name="modification" class="cars-list" id="MODIFICATION">
			<option value="" <?=!empty($arParams["AUTO_COMPLECT"]) ? '' : 'selected="selected"'?>>-</option>
			<?foreach($arResult["MODIFICATION"] as $modification):?>
				<option value="<?=$modification["NAME"]?>" <?=$arParams["AUTO_COMPLECT"] == $modification["NAME"] ? 'selected="selected"' : ''?>><?=$modification["NAME"]?></option>
			<?endforeach;?>
		</select>
	</div>
</div>
<?if(!empty($arResult["TYPE"]) && $arResult["TYPE_T"] == 'tires'):?>
	<?foreach($arResult["TYPE"] as $name => $arType):?>
		<?if(!empty($arType)):?>
			<div class="filter-b inb">
				<div class="block-title">
					<?if($name == "DEFAULT")
						echo Loc::getMessage("AUTO_LIST_RECR");
					elseif($name == 'ALTERNATIVE')
						echo Loc::getMessage("AUTO_LIST_DOPR");
					elseif($name == 'TUNING')
						echo Loc::getMessage("AUTO_LIST_TUN");?>
				</div>
				<?if(!empty($arType["FRONT"]) && !empty($arType["BACK"])):?>
					<div class="block-title"><?=Loc::getMessage("AUTO_LIST_FRONT")?></div>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["FRONT"] as $arData):?>
								<div class="filter label_block radio">
									<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"]);?>" data-h="<?=crc32($arData["HEIGHT"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
					<div class="block-title"><?=Loc::getMessage("AUTO_LIST_BACK")?></div>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["BACK"] as $arData):?>
								<div class="filter label_block radio">
									<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"])?>" data-h="<?=crc32($arData["HEIGHT"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?elseif(!empty($arType["FRONT"])):?>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["FRONT"] as $arData):?>
								<div class="filter label_block radio">
									<input name="tyre_type" id="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" data-w="<?=crc32($arData["WIDTH"]);?>" data-h="<?=crc32($arData["HEIGHT"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" <?=isset( $_REQUEST["tyre_type"] ) && $arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name == $_REQUEST["tyre_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["HEIGHT"].$arData["DIAM"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>/<?=$arData["HEIGHT"]?> R<?=$arData["DIAM"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
	<?endforeach;?>
<?endif;?>

<?if(!empty($arResult["TYPE"]) && $arResult["TYPE_T"] == 'wheels'):?>
	<?foreach($arResult["TYPE"] as $name => $arType):?>
		<?if($arType):?>
			<div class="filter-b inb">
				<div class="block-title">
					<?if($name == "DEFAULT")
						echo Loc::getMessage("AUTO_LIST_RECR");
					elseif($name == 'ALTERNATIVE')
						echo Loc::getMessage("AUTO_LIST_DOPR");
					elseif($name == 'TUNING')
						echo Loc::getMessage("AUTO_LIST_TUN");?>
				</div>
				<?if(!empty($arType["FRONT"]) && !empty($arType["BACK"])):?>
					<div class="block-title"><?=Loc::getMessage("AUTO_LIST_FRONT")?></div>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["FRONT"] as $arData):?>
								<div class="filter label_block radio">
									<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" data-lz="<?=crc32($arData["LZ"]);?>" data-pcd="<?=crc32($arData["PCD"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>x<?=$arData["DIAM"]?> <?=$arData["LZ"]?>x<?=$arData["PCD"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
					
					<div class="block-title"><?=Loc::getMessage("AUTO_LIST_BACK")?></div>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["BACK"] as $arData):?>
								<div class="filter label_block radio">
									<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" data-lz="<?=crc32($arData["LZ"]);?>" data-pcd="<?=crc32($arData["PCD"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>x<?=$arData["DIAM"]?> <?=$arData["LZ"]?>x<?=$arData["PCD"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?elseif(!empty($arType["FRONT"])):?>
					<div class="bx_filter_block limited_block">
						<div class="bx_filter_parameters_box_container">
							<?foreach($arType["FRONT"] as $arData):?>
								<div class="filter label_block radio">
									<input name="disk_type" id="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" data-w="<?=crc32($arData["WIDTH"]);?>" data-d="<?=crc32($arData["DIAM"]);?>" data-lz="<?=crc32($arData["LZ"]);?>" data-pcd="<?=crc32($arData["PCD"]);?>" class="cars-list" type="radio" value="<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" <?=isset( $_REQUEST["disk_type"] ) && $arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name == $_REQUEST["disk_type"] ? 'checked="checked"' : ''?> />
									<label for="TYPE_<?=$arData["WIDTH"].$arData["DIAM"].$arData["LZ"].$arData["PCD"].$name?>" class="bx_filter_param_label"><span class="bx_filter_input_checkbox"><?=$arData["WIDTH"]?>x<?=$arData["DIAM"]?> <?=$arData["LZ"]?>x<?=$arData["PCD"]?></span></label>
								</div>
							<?endforeach;?>
						</div>
					</div>
				<?endif;?>
			</div>
		<?endif;?>
	<?endforeach;?>
<?endif;?>
<?if(!$bAjax):?>
	</div>
<?endif;?>