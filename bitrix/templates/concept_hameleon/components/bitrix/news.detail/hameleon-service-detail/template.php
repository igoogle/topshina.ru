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
<div class="modal-body-content srv-container">
				
	<div class="content no-margin-top-bot">

        <div class="top-wrap">

		    <div class="info-table">

				<?if(strlen($arResult["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"]) > 0):?>

			        <div class="info-cell image-wrap hidden-xs">
			        	<?$img = CFile::ResizeImageGet($arResult["PROPERTIES"]["SERVICE_PICTURE"]["VALUE"], array('width'=>400, 'height'=>400), BX_RESIZE_IMAGE_EXACT, false, false, false, 85);?>
			        	<img class="img-responsive" src="<?=$img["src"]?>" alt=""/>
			        </div>
			        
		        <?endif?>


		        <div class="info-cell text-wrap no-margin-top-bot">

		        	<?if(strlen($arResult["PROPERTIES"]["SERVICE_SUBNAME"]["VALUE"]) > 0):?>
		            	<div class="top-name"><?=$arResult["PROPERTIES"]["SERVICE_SUBNAME"]["~VALUE"]?></div>
					<?endif?>

		            <?if(strlen($arResult["PROPERTIES"]["SERVICE_NAME"]["VALUE"]) > 0):?>

			            <div class="name main1">
			                <?=$arResult["PROPERTIES"]["SERVICE_NAME"]["~VALUE"]?> <?if($arResult["PROPERTIES"]["SERVICE_HIT"]["VALUE"] =="Y"):?><span class="hit"></span><?endif;?>
			            </div>

					<?endif?>

					<?if(strlen($arResult["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["VALUE"]) > 0):?>

			            <div class="text">
			                <?=$arResult["PROPERTIES"]["SERVICE_PREVIEW_TEXT"]["~VALUE"]?>
			            </div>

					<?endif?>

					<?if(strlen($arResult["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0):?>

		            	<div class="price-sm main1 visible-sm"><?=$arResult["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?> <?if(strlen($arResult["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?><span class="old-price main2"><?=$arResult["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span><?endif?></div>

		            <?endif?>
		        </div>

				<?if(strlen($arResult["PROPERTIES"]["SERVICE_PRICE"]["VALUE"]) > 0):?>
			        <div class="info-cell price-wrap main1 hidden-sm">

			            <?=$arResult["PROPERTIES"]["SERVICE_PRICE"]["~VALUE"]?>
						<?if(strlen($arResult["PROPERTIES"]["SERVICE_OLD_PRICE"]["VALUE"]) > 0):?>
			            	<span class="old-price main2"><?=$arResult["PROPERTIES"]["SERVICE_OLD_PRICE"]["~VALUE"]?></span>
			            <?endif?>
			        </div>
				<?endif?>
                
                <?if(strlen($arResult["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"]) <= 0):?>
                    <?$arResult["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"] = "form";?>
                <?endif;?>
                
				<?if(strlen($arResult["PROPERTIES"]["SERVICE_BUTTON_NAME"]["VALUE"]) > 0):?>
			

				    <div class="info-cell button-wrap">

				        <a 
				        	<?
				        		if(strlen($arResult["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"])>0)
                                    echo "onclick='".$arResult["PROPERTIES"]["SERVICE_BUTTON_ONCLICK"]["VALUE"]."'";

                                $b_options = array(
								    "MAIN_COLOR" => "primary",
								    "STYLE" => ""
								);

								if(strlen($arResult["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"]))
								{

								    $b_options = array(
								        "MAIN_COLOR" => "btn-bgcolor-custom",
								        "STYLE" => "background-color: ".$arResult["PROPERTIES"]["SERVICE_BUTTON_BG_COLOR"]["VALUE"].";"
								    );

								}
				        	?>
				        	class="
				        		button-def
				        		<?=$b_options["MAIN_COLOR"]?>
				        		from-modal
				        		from-tariff
				        		more-modal-info
				        		<?=$arResult["SECTION_MAIN"]["ITEMS"]["UF_CHAM_BUTTONS_TYPE_ENUM"]["XML_ID"]?>
				        		<?=ChamDB::hamButtonEditClass (
				        			$arResult["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
				        			$arResult["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
				        			$arResult["PROPERTIES"]["SERVICE_MODAL"]["VALUE"])?>"


				        	<?if(strlen($b_options["STYLE"])):?>
							    style = "<?=$b_options["STYLE"]?>"
							<?endif;?>

				        	data-element-type = "SRV"
				        	<?=ChamDB::hamButtonEditAttr(
				        		$arResult["PROPERTIES"]["SERVICE_BUTTON_TYPE"]["VALUE_XML_ID"],
				        		$arResult["PROPERTIES"]["SERVICE_BUTTON_FORM"]["VALUE"],
				        		$arResult["PROPERTIES"]["SERVICE_MODAL"]["VALUE"],
				        		$arResult["PROPERTIES"]["SERVICE_BUTTON_LINK"]["VALUE"],
				        		$arResult["PROPERTIES"]["SERVICE_BUTTON_BLANK"]["VALUE_XML_ID"],
				        		htmlspecialcharsEx(strip_tags(html_entity_decode($arParams["CHAM_HEADER"]))),
				        		$arResult["PROPERTIES"]["SERVICE_BUTTON_QUIZ"]["VALUE"],
				        		$arResult["ID"])?>>

				        	<?=$arResult["PROPERTIES"]["SERVICE_BUTTON_NAME"]["~VALUE"]?>
				        	
				        </a>


				    </div>
				  

				<?endif?>
		    </div>

		</div>

		<div class="bot-wrap">	

			<?if(!empty($arResult["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["VALUE"])):?>

		        <div class="text-content no-margin-top-bot">
		            <?=$arResult["PROPERTIES"]["SERVICE_DETAIL_TEXT"]["~VALUE"]["TEXT"]?>
		        </div>

	        <?endif;?>

			<?if(!empty($arResult["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"])):?>

		        <div class="gallery <?if($arResult["PROPERTIES"]["SERVICE_GALLERY_BORDER"]["VALUE"] == "Y"):?>border-on<?endif;?>">
		        	<?if(strlen($arResult["PROPERTIES"]["SERVICE_GALLERY_TITLE"]["VALUE"]) > 0):?>
			            <div class="gallery-name main1">
			                <?=$arResult["PROPERTIES"]["SERVICE_GALLERY_TITLE"]["~VALUE"]?>
			            </div>
		            <?endif;?>


		            <div class="row clearfix">
	                
	                    <?
	                     $arWaterMark = Array();

	                     if($arResult["PROPERTIES"]["SERVICE_GALLERY_WATERMARK"]["VALUE"] > 0){

	                        $arWaterMark = Array(
	                            array(
	                                "name" => "watermark",
	                                "position" => "center",
	                                "type" => "image",
	                                "size" => "real",
	                                "file" => $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arResult["PROPERTIES"]["SERVICE_GALLERY_WATERMARK"]["VALUE"]), 
	                                "fill" => "exact",
	                            )
	                        );
	                     }
	                        
	                     
	                    ?>

						<?foreach($arResult["PROPERTIES"]["SERVICE_GALLERY"]["VALUE"] as $k => $arImages):?>

							<?$file_big = CFile::ResizeImageGet($arImages, array('width'=>1600, 'height'=>1600), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arWaterMark);?>

	                    	<?$file_min = CFile::ResizeImageGet($arImages, array('width'=>300, 'height'=>300), BX_RESIZE_IMAGE_EXACT, false, false, false, 75);?>


			                <div class="col-sm-2 col-xs-4">
			                	<div class="img-wrap">

			                    	<a data-gallery="catalog<?=$arResult["ID"]?>" href="<?=$file_big["src"]?>" title="<?=Chameleon::prepareText($arResult["PROPERTIES"]["SERVICE_GALLERY"]["DESCRIPTION"][$k])?>" class="cursor-loop">

	                        		<img class="img-responsive" src="<?=$file_min["src"]?>" alt=""/></a>
			                    </div>
			                </div>

			                <?if(($k+1) % 6 == 0):?>
			                	<span class="clearfix hidden-xs"></span>
			                <?endif;?>
			                <?if(($k+1) % 3 == 0):?>
			                	<span class="clearfix visible-xs"></span>
			                <?endif;?>


		                <?endforeach;?>

		            </div>
		        </div>

	        <?endif;?>

        </div>

    </div>

</div>