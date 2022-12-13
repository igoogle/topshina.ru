<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?
	$left = false;
	$right = false;
		
	if(strlen($arResult["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]["TEXT"]) > 0 || !empty($arResult["PROPERTIES"]["TARIFF_PRICES"]["VALUE"]) || !empty($arResult["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"]))
		$left = true;
	

	if(!empty($arResult["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arResult["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) || strlen($arResult["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0 || strlen($arResult["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0)
		$right = true;
	
?>

<div class="modal-body-content tariff-container <?if($left && $right):?>on-part<?endif;?> <?if(!$right):?>no-right<?endif;?> <?if(!$left):?>no-left<?endif;?>">
				
	<div class="content no-margin-top-bot">

        <div class="top-wrap">

		    <div class="info-table">

				<?if(strlen($arResult["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"]) > 0):?>

			        <div class="info-cell image-wrap hidden-xs">
			        	<?$img = CFile::ResizeImageGet($arResult["PROPERTIES"]["TARIFF_PICTURE"]["VALUE"], array('width'=>400, 'height'=>400), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);?>
			        	<img class="img-responsive" src="<?=$img["src"]?>" alt=""/>
			        </div>
			        
		        <?endif?>


		        <div class="info-cell text-wrap no-margin-top-bot">


		            <?if(strlen($arResult["PROPERTIES"]["TARIFF_NAME"]["VALUE"]) > 0):?>

			            <div class="name main1">
			                <?=$arResult["PROPERTIES"]["TARIFF_NAME"]["~VALUE"]?> <?if($arResult["PROPERTIES"]["TARIFF_HIT"]["VALUE"] =="Y"):?><span class="hit"></span><?endif;?>
			            </div>

					<?endif?>

					<?if(strlen($arResult["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["VALUE"]) > 0):?>

			            <div class="text">
			                <?=$arResult["PROPERTIES"]["TARIFF_PREVIEW_TEXT"]["~VALUE"]?>
			            </div>

					<?endif?>

					<?if(strlen($arResult["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>

		            	<div class="price-sm main1 visible-sm"><?=$arResult["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?> <?if(strlen($arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?><span class="old-price main2"><?=$arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></span><?endif?></div>

		            <?endif?>
		        </div>

				
		    </div>

		</div>

		<div class="bot-wrap">

			<div class="row">
				

				<div class="tariff-container-inner">

					<?if($left):?>

						<div class="<?if($right):?>col-sm-8 col-xs-12<?else:?>col-xs-12<?endif;?> tariff-container-inner-cell left">

							<div class="part-wrap">
						

								<?if(strlen($arResult["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["VALUE"]["TEXT"]) > 0):?>

							        <div class="text-content no-margin-top-bot">
							            <?=$arResult["PROPERTIES"]["TARIFF_DETAIL_TEXT"]["~VALUE"]["TEXT"]?>
							        </div>

						        <?endif;?>

						        <?if(!empty($arResult["PROPERTIES"]["TARIFF_PRICES"]["VALUE"])):?>
			                
			                        <div class="list-wrap">
			                        
			                            <?if(strlen($arResult["PROPERTIES"]["TARIFF_PRICES_TITLE"]["VALUE"]) > 0):?>
			                                <div class="name-list main1"><?=$arResult["PROPERTIES"]["TARIFF_PRICES_TITLE"]["~VALUE"]?></div>
			                            <?endif;?>


			                            <ul class="list-char">
			                                
			                                <?foreach($arResult["PROPERTIES"]["TARIFF_PRICES"]["~VALUE"] as $k=>$val):?>
			                                    <li class="clearfix">
			                                    
			                                        <table class="mobile-break">
			                                            <tr>
			                                                <td class="left">
			                                                    <div><?=$val?></div>
			                                                </td>
			                                                
			                                                <td class="dotted">
			                                                    <div></div>
			                                                </td>
			                                                
			                                                <td class="right">
			                                                    <div class="main1"><?=$arResult["PROPERTIES"]["TARIFF_PRICES"]["~DESCRIPTION"][$k]?></div>
			                                                </td>
			                                            </tr>
			                                        </table>
			                                    
			                                    </li>
			                                <?endforeach;?>

			                            </ul>
			                        </div>
			                    
			                    <?endif;?>

								<?if(!empty($arResult["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"])):?>

							        <div class="gallery <?if($arResult["PROPERTIES"]["TARIFF_GALLERY_BORDER"]["VALUE"] == "Y"):?>border-on<?endif;?>">
							        	<?if(strlen($arResult["PROPERTIES"]["TARIFF_GALLERY_TITLE"]["VALUE"]) > 0):?>
								            <div class="gallery-name main1">
								                <?=$arResult["PROPERTIES"]["TARIFF_GALLERY_TITLE"]["~VALUE"]?>
								            </div>
							            <?endif;?>


							            <div class="row clearfix">
							            	<?
					                            $arWaterMark = Array();
						    
					                            if($arResult["PROPERTIES"]["TARIFF_GALLERY_WATERMARK"]["VALUE"] > 0)
					                            {
					    
					                                $arWaterMark = Array(
					                                    array(
					                                        "name" => "watermark",
					                                        "position" => "center",
					                                        "type" => "image",
					                                        "size" => "big",
					                                        "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arResult["PROPERTIES"]["TARIFF_GALLERY_WATERMARK"]["VALUE"]), 
					                                        "fill" => "exact",
					                                    )
					                                );
					                            }

					                            $colls_gal = "col-sm-3 col-xs-4";
					                            if(!$right)
					                            	$colls_gal = "col-sm-2 col-xs-4";
						                             
					                        ?>
											
											<?foreach($arResult["PROPERTIES"]["TARIFF_GALLERY"]["VALUE"] as $k => $arImages):?>

												

												<?$file_big = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1600), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false, $arWaterMark, false, 90);?>

						                    	<?$file_min = CFile::ResizeImageGet($arImages, array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, 90);?>


								                <div class="<?=$colls_gal?>">
								                	<div class="img-wrap">

								                    	<a data-gallery="catalog<?=$arResult["ID"]?>" href="<?=$file_big["src"]?>" title="<?=Chameleon::prepareText($arResult["PROPERTIES"]["TARIFF_GALLERY"]["DESCRIPTION"][$k])?>" class="cursor-loop">

						                        		<img class="img-responsive" src="<?=$file_min["src"]?>" alt=""/></a>
								                    </div>
								                </div>

								                <?
								                if(!$right)
								                {
								                	if(($k+1) % 6 == 0)
								                		echo "<span class='clearfix hidden-xs'></span>";

								                	if(($k+1) % 3 == 0)
								                		echo "<span class='clearfix visible-xs'></span>";

								                }
								                else
								                {
								                	if(($k+1) % 4 == 0)
								                		echo "<span class='clearfix hidden-xs'></span>";

								                	if(($k+1) % 3 == 0)
								                		echo "<span class='clearfix visible-xs'></span>";
								                }
								                ?>


							                <?endforeach;?>

							            </div>
							        </div>

						        <?endif;?>

					        </div>

				        </div>

			        <?endif;?>

			        <?if($right):?>

				        <div class="col-sm-4 col-xs-12 tariff-container-inner-cell right">

				        	<div class="part-wrap">
				        	

					        	<?if(!empty($arResult["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) || !empty($arResult["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
				                                                    
				                    <ul class='adv-plus-minus'>
				                        
				                        <?if(is_array($arResult["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["TARIFF_INCLUDE"]["VALUE"])):?>
				                            
				                            <?foreach($arResult["PROPERTIES"]["TARIFF_INCLUDE"]["~VALUE"] as $val):?>
				                                <li class="point-green"><?=$val?></li>
				                            <?endforeach;?>
				                            
				                        <?endif;?>
				                        
				                        <?if(is_array($arResult["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"]) && !empty($arResult["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["VALUE"])):?>
				                            
				                            <?foreach($arResult["PROPERTIES"]["TARIFF_NOT_INCLUDE"]["~VALUE"] as $val):?>
				                                <li><?=$val?></li>
				                            <?endforeach;?>
				                            
				                        <?endif;?>
				                        
				                    </ul>
				                
				                <?endif;?>

				                <?if(strlen($arResult["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0 || strlen($arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>


						        	<div class="price-wrap">

						        		<?if(strlen($arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["VALUE"]) > 0):?>
							            	<div class="old-price main2"><?=$arResult["PROPERTIES"]["TARIFF_OLD_PRICE"]["~VALUE"]?></div>
							            <?endif?>

							        	<?if(strlen($arResult["PROPERTIES"]["TARIFF_PRICE"]["VALUE"]) > 0):?>


							            	<div class="price main1"><?=$arResult["PROPERTIES"]["TARIFF_PRICE"]["~VALUE"]?></div>

							            <?endif?>

							        </div>

						        <?endif?>


					        	<?if(strlen($arResult["PROPERTIES"]["TARIFF_BUTTON_NAME"]["VALUE"]) > 0):?>

									<?if(strlen($arResult["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
					                    <?$arResult["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
					                <?endif;?>

							
							        <div class="button-wrap">
							        	

							            <a

							            	<?
							            		if(strlen($arResult["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"])>0) 
                                                    echo "onclick='".$arResult["PROPERTIES"]["TARIFF_BUTTON_ONCLICK"]["VALUE"]."'";

                                                $b_options = array(
												    "MAIN_COLOR" => "primary",
												    "STYLE" => ""
												);

												if(strlen($arResult["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"]))
												{

												    $b_options = array(
												        "MAIN_COLOR" => "btn-bgcolor-custom",
												        "STYLE" => "background-color: ".$arResult["PROPERTIES"]["TARIFF_BUTTON_BG_COLOR"]["VALUE"].";"
												    );

												}

                                            ?>

							            	class="
								            	button-def
								            	<?=$b_options["MAIN_COLOR"]?> 
								            	big
								            	from-modal
								            	from-tariff
								            	more-modal-info
								            	<?=$arResult["SECTION_MAIN"]["ITEMS"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
								            	<?=ChamDB::hamButtonEditClass (
								            		$arResult["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
								            		$arResult["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
							            		$arResult["PROPERTIES"]["TARIFF_MODAL"]["VALUE"])?>"

							            	<?if(strlen($b_options["STYLE"])):?>
											    style = "<?=$b_options["STYLE"]?>"
											<?endif;?>

							            	data-element-type = "TRF"
							            	<?=ChamDB::hamButtonEditAttr(
							            		$arResult["PROPERTIES"]["TARIFF_BUTTON_TYPE"]["VALUE_XML_ID"],
							            		$arResult["PROPERTIES"]["TARIFF_BUTTON_FORM"]["VALUE"],
							            		$arResult["PROPERTIES"]["TARIFF_MODAL"]["VALUE"],
							            		$arResult["PROPERTIES"]["TARIFF_BUTTON_LINK"]["VALUE"],
							            		$arResult["PROPERTIES"]["TARIFF_BUTTON_BLANK"]["VALUE_XML_ID"],
							            		htmlspecialcharsEx(strip_tags(html_entity_decode($arParams["CHAM_HEADER"]))),
							            		$arResult["PROPERTIES"]["TARIFF_BUTTON_QUIZ"]["VALUE"],
							            		$arResult["ID"])?>>

							            	<?=$arResult["PROPERTIES"]["TARIFF_BUTTON_NAME"]["~VALUE"]?>
							            	
							            </a>

						
							        </div>
							 

						        <?endif?>
                                
                                <?if(!empty($arResult["PROPERTIES"]["TARIFF_COMMENT"]["VALUE"])):?>
                                    
                                    <div class="tariff-comment"><?=$arResult["PROPERTIES"]["TARIFF_COMMENT"]["~VALUE"]["TEXT"]?></div>
                                
                                <?endif;?>

					        </div>


				        </div>

			        <?endif;?>

			        <div class="clearfix"></div>

		        </div>
		    </div>

        </div>
    </div>
</div>