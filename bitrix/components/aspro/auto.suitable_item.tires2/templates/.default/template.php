<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?use \Bitrix\Main\Localization\Loc;?>

<?$frame = $this->createFrame()->begin(Loc::getMessage('ITEMS_PODBOR'));?>

<?if($arResult["CARS"]):?>
	<div class="row podbor">
		<div class="col-md-6 col-sm-6">
			<div><?=Loc::getMessage("AUTO_SELECT_CAR");?></div>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="filter-mark">
				<select name="car" class="car-mark">
					<?foreach($arResult["CARS"] as $key => $car):?>
						<option value="<?=$car["FORMAT_NAME"]?>" <?=(!$key ? 'selected="selected"' : '')?>><?=$car["NAME"]?></option>
					<?endforeach;?>
				</select>
			</div>
		</div>
	</div>
	<div id="js_response_sc"></div>
	<script type="text/javascript">
		BX.message({
			AJAX_PATH_SC: "<?=$this->__folder;?>",
			PARAMS_SC: <?=CUtil::PhpToJSObject($arParams);?>,
			SITE_ID: "<?=SITE_ID;?>"
		})
		BX.ready(function(){getSuitableModel();})
	</script>
<?else:?>
	<div class="row">
		<div class="col-md-12">
			<div><?=Loc::getMessage("NOT_ITEMS");?></div>
		</div>
	</div>
<?endif;?>

<?$frame->end();?>
