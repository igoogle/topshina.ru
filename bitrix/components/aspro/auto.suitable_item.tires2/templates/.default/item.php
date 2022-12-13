<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?use \Bitrix\Main\Localization\Loc;?>
<?$frame = $this->createFrame()->begin(Loc::getMessage('ITEMS_LOAD'));?>

<?if($arResult["ERROR"]):?>
	<div class="error">
		<?if(is_array($arResult["ERROR"])):?>
			<?foreach($arResult["ERROR"] as $error):?>
				<?ShowError($error);?>
			<?endforeach;?>
		<?else:?>
			<?ShowError($arResult["ERROR"]);?>
		<?endif;?>
	</div>
<?elseif($arResult["ITEMS"]):?>
	<?$bShowYear = ($arResult["HAS_YEAR"] == "Y");?>
	<div class="items">
		<table class="colored_table">
			<thead>
				<tr>
					<td><?=Loc::getMessage('SUITABLE_CAR_MODEL');?></td>
					<td><?=Loc::getMessage('SUITABLE_CAR_MODIFICATION');?></td>
					<?if($bShowYear):?>
						<td><?=Loc::getMessage('SUITABLE_CAR_YEAR');?></td>
					<?endif;?>
				</tr>
			</thead>
			<tbody>
				<?foreach($arResult["ITEMS"] as $model => $arGroupItem):?>
					<?foreach($arGroupItem as $modification => $arYear):?>
						<tr>
							<td><?=$model;?></td>
							<td><?=$modification;?></td>
							<?if($bShowYear):?>
								<td><?=implode(", ", $arYear);?></td>
							<?endif;?>
						</tr>
					<?endforeach;?>
				<?endforeach;?>
			</tbody>
		</table>
	</div>
<?else:?>
	<div class="items empty_item"><div class="item"><?=Loc::getMessage("NOT_ITEMS");?></div></div>
<?endif;?>

<?$frame->end();?>