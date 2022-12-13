<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? $this->setFrameMode( true ); ?>
<?if( !empty( $arResult ) ){?>
	<ul class="menu top menu_top_block catalogfirst visible_on_ready">
		<?foreach( $arResult as $key => $arItem ){
			if(isset($arItem["PARAMS"]["NOT_VISIBLE"]) && $arItem["PARAMS"]["NOT_VISIBLE"]=="Y")
				continue;?>
			<li class="<?=($arItem["SELECTED"] ? "current" : "");?> <?=($arItem['PARAMS']['CLASS'] ? $arItem['PARAMS']['CLASS'] : "");?> <?=($arItem["CHILD"] ? "has-child" : "");?>">
				<a class="<?=($arItem["CHILD"] ? "icons_fa parent" : "");?>" href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a>
				<?if($arItem["CHILD"]){?>
					<ul class="dropdown">
						<?foreach($arItem["CHILD"] as $arChildItem){?>
							<li class="<?=($arChildItem["CHILD"] ? "has-child" : "");?> <?if($arChildItem["SELECTED"]){?> current <?}?>">
								<a class="<?=($arChildItem["CHILD"] ? "icons_fa parent" : "");?>" href="<?=$arChildItem["LINK"];?>"><?=$arChildItem["TEXT"];?></a>
								<?if($arChildItem["CHILD"]){?>
									<ul class="dropdown">
										<?foreach($arChildItem["CHILD"] as $arChildItem1){?>
											<li class="menu_item1 <?if($arChildItem1["SELECTED"]){?> current <?}?>">
												<a href="<?=$arChildItem1["LINK"];?>"><span class="text"><?=$arChildItem1["TEXT"];?></span></a>
											</li>
										<?}?>
									</ul>
								<?}?>
							</li>
						<?}?>
					</ul>
				<?}?>
			</li>
		<?}?>
		<li class="more">
			<a href="javascript:;" rel="nofollow"></a>
			<ul class="dropdown"></ul>
		</li>
	</ul>
<?}?>